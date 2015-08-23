<!doctype html>
<html>
    <head>
        <script src='http://<?php echo $_SERVER['HTTP_HOST']; ?>:3000/socket.io/socket.io.js'></script>
    </head>
    <body>
        <div id="status">
            
        </div>
        <ul id='messages'>
        </ul>
        
        <script>
            var socket = io('http://<?php echo $_SERVER['HTTP_HOST']; ?>:3000');
            
            var dash = {
                addGraphData: function addGraphData(messageArray) {
                    var messages = document.getElementById('messages'); 
                    var len = messageArray.length;
                    for(var i = 0; i < len; i++) {
                        var text = document.createTextNode(JSON.stringify(messageArray[i]));
                        var el = document.createElement('li').appendChild(text);
                        messages.appendChild(el);
                    }
                },
                id: undefined
            }
            
            socket.on('dash_connect', function(data) {
                document.getElementById('status').appendChild(document.createTextNode('Connected'));
                window.dash.id = data.id;
                
                // Respond with a message including this clients' id sent from the server
                socket.emit('dash_connected', {data: 'dash_client', id: data.id});
            });
            
            socket.on('update', function(data) {
                window.dash.addGraphData(data.message);
            });
            
            socket.on('error', console.error.bind(console));
            socket.on('message', console.log.bind(console));
            
        </script>        
    </body>
</html>