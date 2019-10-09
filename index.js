const http = require('http').createServer()
const io = require('socket.io')(http);

const port = process.env.port || 8008;

http.listen(port, function () {
    console.log("Running at Port " + port);
});

io.on("connection", function (socket) {

    socket.on("comment", function (comment) {
        io.emit("getComment", comment)
    });

    socket.on("like", function (like) {
        io.emit("getLike", like);
    });

    socket.on("textType", function (data) {
        io.emit("isTyping", data);
    });

    socket.on("messageSent", function (message) {
        io.emit("getMessage", message);
    });

    socket.on("setNotification", function (data) {
        io.emit("getNotification", data);
    });
});

