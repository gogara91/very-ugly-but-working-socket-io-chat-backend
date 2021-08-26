const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const io = require('socket.io')(server);
const Redis = require('ioredis');

const redis = new Redis();

redis.psubscribe('*', function(err, count) {
});

redis.on('pmessage', function(subscribed, channel, message) {
    io.emit(channel, JSON.parse(message));
});

server.listen(8000);