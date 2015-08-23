var fs = require('fs');
var http = require('http');
var io = require('socket.io')();
var net = require('net');

if (fs.existsSync('/tmp/node_socket')) {  
    fs.unlinkSync('/tmp/node_socket');
}

var tradeMessages = [];

// A server to listen for incoming php data
var server = net.createServer(function(con) {  
  con.on('data', function(data) {
    if(typeof data !== 'undefined' && data !== null) {
      var obj = JSON.parse(data.toString());
      console.log('Data received by socket.');
      tradeMessages.push(obj);
    }
  });
});

// TODO: take action if server fails
server.listen('/tmp/node_socket');

// Quick hack to allow node and php access to the files, ideally this would be done with user groups 
fs.chmodSync('/tmp/node_socket', 666);

// Send messages to all connected clients
function sendMessagesToDashboard() {
	if (tradeMessages.length) {
		console.log('emitting update', tradeMessages);
    io.emit('update', { message: tradeMessages });
    tradeMessages = [];
	}
}

// Send messages every 5 secs
var sender = setInterval(sendMessagesToDashboard, 5000);

io.on('connection', function(socket) {
    // Use socket to communicate with this particular client only, sending it it's own id
    socket.emit('dash_connect', { message: 'Connected', id: socket.id });
    socket.on('dash_connected', function(data){
    	// register the client_id or do smething else with connection confirmation
    });
});

io.listen(3000);
