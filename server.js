/**
 * Created by Looper on 26-04-2017.
 */
const express = require('express');
const fs = require('fs');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "*"}
});//init Database
let mysql = require('mysql2');
let conn = mysql.createPool({
    host     : 'localhost',
    user     : 'danish',
    password : 'AdminProd@123$',
    database : 'crm'
});
let users = [];
let connections = [];
io.on('connection', (socket) => {
    connections.push(socket.id);
    let user_id = parseInt(socket.handshake.query.user_id);
    users[user_id] = socket.id ;
    io.sockets.emit('online_users', {
        'users': users
    });
    socket.on('disconnect', function (data) {
        connections.splice(connections.indexOf(socket), 1);
        let offline_user = users.indexOf(socket.id)
        users[offline_user] = false;
        io.sockets.emit('user_offline', {
            'offline_user': offline_user
        });
    });
    //Get Broadcast
    socket.on('get_alerts', function (data) {
        try {
            conn.execute(
                "SELECT group_chats.*,DATE_FORMAT(group_chats.added_on,'%H:%i %d-%m-%X') as dateTime,users.full_name,chat_group.title FROM `group_chats` JOIN chat_group on group_chats.group_id = chat_group.group_id JOIN users on users.user_id = group_chats.from_user WHERE  group_chats.added_on >= ( CURDATE() - INTERVAL 2 DAY )  AND group_chats.group_id IN (SELECT chat_group.group_id FROM `chat_group` where LOCATE(CONCAT(',', ? ,','),CONCAT(',',group_members,',')) > 0 AND chat_group.type = 2)",
                [data.user_id],
                function (err, results, fields) {
                    socket.emit('my_alerts', {alerts: results});
                }
            );
        }
        catch (e) {
            console.log("get_alerts",e);
        }
    });
    socket.on('get_one_to_one_chats', function (data) {
        try {
            conn.execute(
                'UPDATE `chats` SET `msg_read`= 1 WHERE (chats.to_user = ? AND chats.from_user = ?)',
                [data.from_user, data.to_user],
                function (err, results) {
                    if (results.affectedRows >= 0) {
                        conn.execute(
                            "SELECT c.*,DATE_FORMAT(c.added_on,'%H:%i %d-%m-%X') as dateTime,r.msg as reply_msg,r.attachment as reply_attachment FROM `chats` c LEFT JOIN chats r on r.chat_id = c.referenced WHERE (c.to_user = ? AND c.from_user = ? ) OR (c.to_user= ? AND c.from_user = ? ) ORDER by chat_id DESC LIMIT 20",
                            [data.to_user, data.from_user, data.from_user, data.to_user],
                            function (err, results, fields) {
                                socket.emit('chat_history', {chat: results});
                            }
                        );
                    }
                }
            );
        }
        catch (e) {
            console.log("get_one_to_one_chats",e);
        }
    });
    socket.on('send_one_to_one_msg', (data) => {
        if(data.referenced){
            try {
                conn.execute(
                    'INSERT INTO `chats` ( `to_user`, `from_user`, `msg`, `attachment`, `referenced`, `added_by`) VALUES (?,?,?,?,?,?)',
                    [data.to_user, data.from_user, data.msg, null, data.referenced, data.from_user],
                    function (err, results) {
                        if (results.affectedRows > 0) {
                            conn.execute(
                                'SELECT c.*,DATE_FORMAT(c.added_on,"%H:%i %d-%m-%X") as dateTime,r.msg as reply_msg,r.attachment as reply_attachment FROM `chats` c LEFT JOIN chats r on r.chat_id = c.referenced WHERE (c.chat_id=?)',
                                [results.insertId],
                                function (err, results) {
                                    io.sockets.emit('recieve_one_to_one_msg', results);
                                }
                            );
                        }
                    }
                );
            }
            catch (e) {
                console.log("send_one_to_one_msg 1 ",e);
            }
        } else {
            try {
                conn.execute(
                    'INSERT INTO `chats` ( `to_user`, `from_user`, `msg`, `attachment`, `added_by`) VALUES (?,?,?,?,?)',
                    [data.to_user, data.from_user, data.msg, null, data.from_user],
                    function (err, results) {
                        if (results.affectedRows > 0) {
                            conn.execute(
                                'SELECT *,DATE_FORMAT(chats.added_on,"%H:%i %d-%m-%X") as dateTime FROM `chats` WHERE (`chat_id`=?)',
                                [results.insertId],
                                function (err, results) {
                                    io.sockets.emit('recieve_one_to_one_msg', results);
                                }
                            );
                        }
                    }
                );
            }
            catch (e) {
                console.log("send_one_to_one_msg 2 ",e);
            }
        }
    });
    socket.on('send_one_to_one_img', function (data) {
        try {
            conn.execute(
                'UPDATE `chats` SET `msg_read`= 1 WHERE (chats.chat_id = ?)',
                [data.chat_id],
                function (err, results) {
                    if (results.affectedRows >= 0) {
                        conn.execute(
                            'SELECT *,DATE_FORMAT(chats.added_on,"%H:%i %d-%m-%X") as dateTime FROM `chats` WHERE (`chat_id`=?)',
                            [data.chat_id],
                            function (err, results) {
                                io.sockets.emit('receive_one_to_one_img', {results});
                            }
                        );
                    }
                }
            );
        }
        catch (e) {
            console.log("send_one_to_one_img ",e);
        }
    });
    //Select all chat groups for a user
    socket.on('Get_chat_groups',function(data){
        try {
            conn.execute(
                "SELECT * FROM `chat_group` where LOCATE(CONCAT(',', ? ,','),CONCAT(',',group_members,',')) > 0 OR department_id = ?",
                [data.user_id, data.department_id],
                function (err, results, fields) {
                    io.sockets.emit('list_chat_groups', {results});
                }
            );
        }
        catch (e) {
            console.log("Get_chat_groups ",e);
        }
    });
    //Forward msg to selected USERs
    socket.on('forwarded_msg',function(data){
        try{
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
                                            } else {
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
        }
        catch (e) {
            console.log("forwarded_msg ",e);
        }
    });
    //Send group msg
    socket.on('send_group_msg', (data) => {
        if(data.referenced){
            try {
                conn.execute(
                    'INSERT INTO `group_chats` ( `from_user`, `group_id`, `msg`, `referenced`) VALUES (?,?,?,?)',
                    [data.from_user, data.group_id, data.msg, data.referenced],
                    function (err, results) {
                        if (results.affectedRows > 0) {
                            conn.execute(
                                'SELECT c.*,DATE_FORMAT(c.added_on,"%H:%i %d-%m-%X") as dateTime,r.msg as reply_msg,r.attachment as reply_attachment FROM `group_chats` c LEFT JOIN group_chats r on r.group_chat_id = c.referenced WHERE (c.group_chat_id=?)',
                                [results.insertId],
                                function (err, results) {
                                    io.sockets.emit('receive_group_msg', results);
                                }
                            );
                        }

                    }
                );
            }
            catch (e) {
                console.log("send_group_msg 1 ",e);
            }

        }
        else if(data.chat_id == null){
            try {
                conn.execute(
                    'INSERT INTO `group_chats` ( `from_user`,`group_id`, `msg`) VALUES (?,?,?)',
                    [data.from_user, data.group_id, data.msg],
                    function (err, results) {
                        if (results.affectedRows > 0) {
                            conn.execute(
                                'SELECT group_chats.*,chat_group.type,DATE_FORMAT(group_chats.added_on,"%H:%i %d-%m-%X") as dateTime,users.full_name,users.image as user_image FROM `group_chats` JOIN users on users.user_id = group_chats.from_user JOIN chat_group on chat_group.group_id = group_chats.group_id WHERE (`group_chat_id`=?)',
                                [results.insertId],
                                function (err, results) {
                                    io.sockets.emit('receive_group_msg', results);
                                }
                            );
                        }
                    }
                );
            }
            catch (e) {
                console.log("send_group_msg 2 ",e);
            }
        } else{
            try {
                conn.execute(
                    'SELECT * FROM `group_chats` WHERE (`group_chat_id`=?)',
                    [data.chat_id],
                    function (err, results) {
                        io.sockets.emit('receive_group_msg', results);
                    }
                );
            }
            catch (e) {
                console.log("send_group_msg 3 ",e);
            }
        }
    });
    //Get Group Chats
    socket.on('get_group_chats', (data) => {
        try {
            conn.execute(
                "SELECT g.*, DATE_FORMAT(g.added_on,'%H:%i %d-%m-%X') as dateTime,users.full_name,users.image as user_image,r.msg as reply_msg,r.attachment as reply_attachment FROM `group_chats` g LEFT JOIN group_chats r on r.group_chat_id = g.referenced JOIN users on users.user_id = g.from_user WHERE g.group_id = ? ORDER by g.group_chat_id desc LIMIT 20",
                [data.group_id],
                function (err, results, fields) {
                    socket.emit('receive_group_chats', {chat: results});
                }
            );
        }
        catch (e) {
            console.log("get_group_chats ",e);
        }
    });
    //Returning Agent Call Queue
    socket.on('get_call_queue', function (data) {
      try {
          conn.execute(
              "select call_recordings.*,call_recordings.added_on AS call_date,call_dispostions_did_numbers.*,call_dispositions_did.title FROM `call_recordings` LEFT OUTER JOIN call_dispostions_did_numbers ON call_dispostions_did_numbers.number_id = call_recordings.to_number LEFT OUTER JOIN call_dispositions_did ON call_dispostions_did_numbers.did_id = call_dispositions_did.did_id where `disposed` is null AND agent_id = ? and rec_id > ? ORDER BY `call_recordings`.`rec_id` ASC limit 500",
              [data.user, data.max_id],
              function (err, results, fields) {
                  socket.emit('get_call_list', {call_queue: results});
              }
          );
      }
      catch (e) {
          console.log("get_call_queue ",e);
      }

    });
});
server.listen(3000, () => {
    console.log('Server is running');
});
