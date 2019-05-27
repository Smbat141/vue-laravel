var http = require('http').Server();
var io = require('socket.io')(http);
var Redis = require('ioredis');

var redis = new Redis();
redis.psubscribe('laravel_database_new-connect.*');
redis.on("pmessage",function (pattern,channel,message) {
    console.log(channel);
    console.log(message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event,message.data)
});

http.listen(3000,function () {
    console.log('listen 3000');
});


