/**
 * Created by Looper on 26-04-2017.
 */
// TODO : create new port for http traffic of node and proxy from apache or rum directly from that port

const express = require('express');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "*"}
});

//init Database
let mysql = require('mysql');
let conn = mysql.createConnection({
    host     : 'localhost',
    user     : 'admin',
    password : '123',
    database : 'crm'
});

..a
let users = [];
let connections = [];

io.on('connection', (socket) => {
    connections.push(socket.id);
    console.log('user connected');

    socket.on('disconnect', function (data) {
        connections.splice(connections.indexOf(socket), 1);
        console.log("Sockets still Connected: %s", connections.length);
        let offline_user = users.indexOf(socket.id)
        users[offline_user] = false;
        io.sockets.emit('user_offline', {
            'offline_user': offline_user
        });
    });

    socket.on('user_online', function (data) {
        let user_id = parseInt(data);
        users[user_id] = socket.id ;
        io.sockets.emit('online_users', {
            'users': users
        });
        console.log(users);
    });

    // setInterval(function (){
    //     socket.emit('test', 'test');
    // }, 100)
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
