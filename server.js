/**
 * Created by Looper on 26-04-2017.
 */
// TODO : create new port for http traffic of node and proxy from apache or rum directly from that port

const express = require('express');
const fs = require('fs');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "*"}
});

//init Database
let mysql = require('mysql2');
let conn = mysql.createConnection({
    host     : 'localhost',
    user     : 'danish',
    password : 'AdminProd@123$',
    database : 'crm'
});

let users = [];
let connections = [];

io.on('connection', (socket) => {
    connections.push(socket.id);
    console.log('user connected');
    console.log(socket.handshake.query);
    let user_id = parseInt(socket.handshake.query.user_id);
    users[user_id] = socket.id ;
    io.sockets.emit('online_users', {
        'users': users
    });
    console.log(users);
    socket.on('disconnect', function (data) {
        connections.splice(connections.indexOf(socket), 1);
        console.log("Sockets still Connected: %s", connections.length);
        let offline_user = users.indexOf(socket.id)
        users[offline_user] = false;
        io.sockets.emit('user_offline', {
            'offline_user': offline_user
        });
    });

    //Get Broadcast
    socket.on('get_alerts', function (data) {
        conn.execute(
            "SELECT group_chats.*,DATE_FORMAT(group_chats.added_on,'%H:%i %d-%m-%X') as dateTime,users.full_name,chat_group.title FROM `group_chats` JOIN chat_group on group_chats.group_id = chat_group.group_id JOIN users on users.user_id = group_chats.from_user WHERE group_chats.group_id IN (SELECT chat_group.group_id FROM `chat_group` where LOCATE(CONCAT(',', ? ,','),CONCAT(',',group_members,',')) > 0 AND chat_group.type = 2)",
            [data.user_id],
            function(err, results, fields) {
                socket.emit('my_alerts',{ alerts: results });
            }
        );
    });

    // socket.on('user_online', function (data) {
    //     let user_id = parseInt(data);
    //     users[user_id] = socket.id ;
    //     io.sockets.emit('online_users', {
    //         'users': users
    //     });
    //     console.log(users);
    // });

    socket.on('get_one_to_one_chats', function (data) {
        conn.execute(
            'UPDATE `chats` SET `msg_read`= 1 WHERE (chats.to_user = ? AND chats.from_user = ?)',
            [data.from_user,data.to_user],
            function(err,results) {
                if(results.affectedRows >= 0){
                    conn.execute(
                        "SELECT *,DATE_FORMAT(chats.added_on,'%H:%i %d-%m-%X') as dateTime FROM `chats` WHERE (`to_user`= ? AND `from_user`= ? ) OR (`to_user`= ? AND `from_user`= ? ) ORDER by chat_id DESC LIMIT 20",
                        [data.to_user, data.from_user,data.from_user, data.to_user],
                        function(err, results, fields) {
                            // console.log(results);
                            // console.log(fields);
                            // console.log(err);
                            socket.emit('chat_history',{ chat: results });
                        }
                    );
                }
            }
        );
    });

    socket.on('send_one_to_one_msg', (data) => {
        conn.execute(
            'INSERT INTO `chats` ( `to_user`, `from_user`, `msg`, `attachment`, `added_by`) VALUES (?,?,?,?,?)',
            [data.to_user, data.from_user,data.msg,null,data.from_user],
            function(err, results) {
                if(results.affectedRows > 0){
                    conn.execute(
                        'SELECT *,DATE_FORMAT(chats.added_on,"%H:%i %d-%m-%X") as dateTime FROM `chats` WHERE (`chat_id`=?)',
                        [results.insertId],
                        function(err, results) {
                            io.sockets.emit('recieve_one_to_one_msg', results );
                        }
                    );
                }

            }
        );
    });

    socket.on('send_one_to_one_img', function (data) {
        conn.execute(
            'UPDATE `chats` SET `msg_read`= 1 WHERE (chats.chat_id = ?)',
            [data.chat_id],
            function(err,results) {
                if(results.affectedRows >= 0){
                    conn.execute(
                        'SELECT *,DATE_FORMAT(chats.added_on,"%H:%i %d-%m-%X") as dateTime FROM `chats` WHERE (`chat_id`=?)',
                        [data.chat_id],
                        function(err, results) {
                            // console.log(results);
                            // console.log(err);
                            io.sockets.emit('receive_one_to_one_img',{ results });
                        }
                    );
                }
            }
        );
    });

    //Select all chat groups for a user
    socket.on('Get_chat_groups',function(data){
        conn.execute(
            "SELECT * FROM `chat_group` where LOCATE(CONCAT(',', ? ,','),CONCAT(',',group_members,',')) > 0",
            [data.user_id],
            function(err, results, fields) {
                io.sockets.emit('list_chat_groups',{ results });
            }
        );
    });

    //Forward msg to selected USERs
    socket.on('forwarded_msg',function(data){
        conn.execute(
            'SELECT `msg`, `attachment` FROM `chats` WHERE (`chat_id`=?)',
            [data.forwarded_msg_id],
            function(err, results) {
                if(results.length > 0){
                    data.to_users.forEach(user => {
                        conn.execute(
                            'INSERT INTO `chats` ( `to_user`, `from_user`, `msg`, `attachment`, `added_by`) VALUES (?,?,?,?,?)',
                            [user,data.from_user,results[0].msg,results[0].attachment,data.from_user],
                            function(err, results) {
                                if(results.affectedRows > 0){
                                    conn.execute(
                                        'SELECT *,DATE_FORMAT(chats.added_on,"%H:%i %d-%m-%X") as dateTime FROM `chats` WHERE (`chat_id`=?)',
                                        [results.insertId],
                                        function(err, results) {
                                            if(results[0].attachment){
                                                io.sockets.emit('receive_one_to_one_img',{ results });
                                            }
                                            else {
                                                io.sockets.emit('recieve_one_to_one_msg', results);
                                            }

                                        }
                                    );
                                }
                            }
                        );
                    });
                }

            }
        );
    });

    //Send group msg
    socket.on('send_group_msg', (data) => {
        if(data.chat_id == null){
            conn.execute(
                'INSERT INTO `group_chats` ( `from_user`,`group_id`, `msg`) VALUES (?,?,?)',
                [data.from_user,data.group_id,data.msg],
                function(err, results) {
                    if(results.affectedRows > 0){
                        conn.execute(
                            'SELECT group_chats.*,chat_group.type,DATE_FORMAT(group_chats.added_on,"%H:%i %d-%m-%X") as dateTime,users.full_name,users.image as user_image FROM `group_chats` JOIN users on users.user_id = group_chats.from_user JOIN chat_group on chat_group.group_id = group_chats.group_id WHERE (`group_chat_id`=?)',
                            [results.insertId],
                            function(err, results) {
                                io.sockets.emit('receive_group_msg', results );
                            }
                        );
                    }

                }
            );
        }
        else{
            conn.execute(
                'SELECT * FROM `group_chats` WHERE (`group_chat_id`=?)',
                [data.chat_id],
                function(err, results) {
                    io.sockets.emit('receive_group_msg', results );
                }
            );
        }

    });

    //Get Group Chats
    socket.on('get_group_chats', (data) => {
        conn.execute(
            "SELECT group_chats.*, DATE_FORMAT(group_chats.added_on,'%H:%i %d-%m-%X') as dateTime,users.full_name,users.image as user_image FROM `group_chats` JOIN users on users.user_id = group_chats.from_user WHERE group_id = ?  ORDER by group_chat_id desc LIMIT 20",
            [data.group_id],
            function(err, results, fields) {
                socket.emit('receive_group_chats',{ chat: results });
            }
        );
    });

    // setInterval(function (){
    //     socket.emit('test', 'test');
    // }, 100);

    //Returning Agent Call Queue
    socket.on('get_call_queue', function (data) {
        // console.log(data);
        conn.execute(
            "select call_recordings.*,call_recordings.added_on AS call_date,call_dispostions_did_numbers.*,call_dispositions_did.title FROM `call_recordings` LEFT OUTER JOIN call_dispostions_did_numbers ON call_dispostions_did_numbers.number_id = call_recordings.to_number LEFT OUTER JOIN call_dispositions_did ON call_dispostions_did_numbers.did_id = call_dispositions_did.did_id where `disposed` is null AND agent_id = ? and rec_id > ? ORDER BY `call_recordings`.`rec_id` ASC limit 500",
            [data.user,data.max_id],
            function(err, results, fields) {
                // console.log(results);
                // console.log(fields);
                // console.log(err);
                socket.emit('get_call_list',{ call_queue: results });
            }
        );
    });
});

server.listen(3000, () => {
    console.log('Server is running');
});


// const httpServer = require("http");
//
// const host = '127.24.7.240';
// const port = 3000;
//
// const requestListener = function (req, res) {};
//
// const server = httpServer.createServer(requestListener);
// server.listen(port, host, () => {
//     console.log(`Server is running on http://${host}:${port}`);
// });
//
// const options = { cors: {orign:'*'} };
//
// const io = require("socket.io")(httpServer, options);
//
//
// io.on('connection', (socket) => {
//     console.log('user connected');
//
//     // on disconnect
//     socket.on('disconnect', (socket) => {
//         console.log('user disconnected');
//     })
// });

//init Database
// let mysql = require('mysql');
// let conn = mysql.createConnection({
//     host     : 'localhost',
//     user     : 'admin',
//     password : '123',
//     database : 'crm'
// });
//
// let users = [];
// let connections = [];
//
// // Initializing Socket and events..
// io.sockets.on('connection', function (socket) {
//     connections.push(socket.id);
//
//     socket.on('disconnect', function (data) {
//         connections.splice(connections.indexOf(socket), 1);
//         console.log("Sockets still Connected: %s", connections.length);
//         let offline_user = users.indexOf(socket.id)
//         users[offline_user] = false;
//         io.sockets.emit('user offline', {
//             'offline_user': offline_user
//         });
//     });
//
//     //on send msg ....
//     socket.on('send message', function (data) {
//         conn.query('INSERT INTO chat SET ?', data, function (error, results, fields) {
//             if (error) throw error;
//             let sql = "SELECT * FROM `chat` WHERE id='"+results.insertId+"'";
//             let query = conn.query(sql),
//                 chat = []; // this array will contain the result of our db query
//             query
//                 // error handling...
//                 .on('error', function (err) { console.log(err); })
//                 //result handling....
//                 .on('result', function (row) { chat.push(row); })
//                 //sending chat....
//                 .on('end', function () {
//                     io.sockets.emit('new message',{ chat: chat });
//                 });
//         });
//     });
//
//     //on connecting users....
//     socket.on('get_connected', function (data) {
//         let user_id = parseInt(data);
//         users[user_id] = socket.id ;
//         io.sockets.emit('online users', {
//             'users': users
//         });
//     });
//
//     //connect chat......
//     socket.on('connect chat', function (data) {
//         let sql = "SELECT * FROM `chat` WHERE (`to_user`='"+data.to+"' AND `from_user`='"+data.me+"') " +
//             "OR (`to_user`='"+data.me+"' AND `from_user`='"+data.to+"') LIMIT 20";
//         let query = conn.query(sql),
//             chat = []; // this array will contain the result of our db query
//         query
//             // error handling...
//             .on('error', function (err) { console.log(err); })
//             //result handling....
//             .on('result', function (row) { chat.push(row); })
//             //sending chat....
//             .on('end', function () {
//                 socket.emit('chat',{ chat: chat });
//             });
//     });
// });
