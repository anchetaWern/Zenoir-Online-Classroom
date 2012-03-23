// (c) Copyright 2011 Aditya Ravi Shankar (www.adityaravishankar.com). All Rights Reserved. 
// NowJS and Node.js Tutorial – Creating a multi room chat client
// http://www.adityaravishankar.com/2011/10/nowjs-node-js-tutorial-creating-multi-room-chat-server/
var mysql = require('mysql');
var TEST_DATABASE = 'zenoir';
var TEST_TABLE = 'tbl_sessions';
var client = mysql.createClient({
  user: 'root',
  password: '1234',
});


client.query('USE '+TEST_DATABASE);


var html = require('fs').readFileSync(__dirname+'/custom_multiroom.php');
var server = require('http').createServer(function(req, res){
    res.end(html);
});
server.listen(8081);

var nowjs = require("now");
var everyone = nowjs.initialize(server);



// Send message to everyone on the users group
everyone.now.distributeMessage = function(message){
    //console.log('Received message from '+this.now.name +' in serverroom '+this.now.serverRoom);
    var group = nowjs.getGroup(this.now.serverRoom);
	
    group.now.receiveMessage(this.now.name, message);
	
	//store the message into the database
	client.query(
	'INSERT INTO tbl_sessioncontent SET session_id = ?, user_id = ?, mask_name=?, message = ?', 
	[this.now.serverRoom, this.now.user_id, this.now.name, message]
	);
};

everyone.now.changeRoom = function(newRoom){
    var oldRoom = this.now.serverRoom;
    console.log('Changed user '+this.now.name + ' from '+oldRoom + ' to '+newRoom);
    //if old room is not null; then leave the old room
    if(oldRoom){
        var oldGroup = nowjs.getGroup(oldRoom);
        oldGroup.removeUser(this.user.clientId);
        // Tell everyone he left :)
        oldGroup.now.receiveMessage(this.now.name , ' has left the session and gone to '+newRoom);
    }
	
	
    var newGroup = nowjs.getGroup(newRoom);
    newGroup.addUser(this.user.clientId);
    
	//load previous messages here
	client.query(
	  'SELECT message, mask_name FROM tbl_sessioncontent WHERE session_id=' + newRoom,
		  function selectCb(err, results, fields){
			if (err) {
			  throw err;
			}
			
			for(var x in results){
				newGroup.now.receiveMessage(results[x]['mask_name'], results[x]['message']);
			}

			
		  }
	);
	
	
	// Tell everyone he joined
    //newGroup.now.receiveMessage(this.now.name , ' has joined the session');

    this.now.serverRoom = newRoom;
};



