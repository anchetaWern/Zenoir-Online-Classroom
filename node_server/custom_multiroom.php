<!--customized multi-room-->

<!DOCTYPE html>
<!-- 
(c) Copyright 2011 Aditya Ravi Shankar (www.adityaravishankar.com). All Rights Reserved. 
NowJS and Node.js Tutorial – Creating a multi room chat client
http://www.adityaravishankar.com/2011/10/nowjs-node-js-tutorial-creating-multi-room-chat-server/

-->
<html lang="en">
<head>
<title>nowjs Multi Room Chat Server</title>
<style>
#messages {
    width: 500px;
    border: 1px solid black;
    height: 200px;
}
#text-input {
    width: 500px;
}
#messages {
    overflow-y: auto;
}
</style>
<script type="text/javascript" src="jquery171.js"></script>
<script src="http://localhost:8081/nowjs/now.js"></script>

<script>
$(document).ready(function(){
	now.receiveMessage = function(name, message){
		$("#messages").append("<tr><td>" + name + ": " + message +"</td></tr>");
	}

	// Send message to people in the same group
	$('#text-input').keydown(function(e){
		if(e.keyCode == 13){
			$('#send-button').click();
			myscroll = $('#messages');
			myscroll.scrollTop(myscroll.get(0).scrollHeight);
		}
	});
	
	$("#send-button").click(function(){
		now.distributeMessage($("#text-input").val());
		$("#text-input").val("");
	});

	now.name 	= $('#user_name').val();
	now.user_id	= $('#user_id').val();

	// on establishing 'now' connection, set server room and allow message sending
	now.ready(function(){
		// By default pick the first chatroom 
		now.changeRoom($('#session_room').val());
		// Connection established and room set; allow user to start sending messages
		$("#send-button").removeAttr('disabled');
	});

});

function scrollIntoView(element, container) {
  var containerTop = $(container).scrollTop(); 
  var containerBottom = containerTop + $(container).height(); 
  var elemTop = element.offsetTop;
  var elemBottom = elemTop + $(element).height(); 
  if (elemTop < containerTop) {
    $(container).scrollTop(elemTop);
  } else if (elemBottom > containerBottom) {
    $(container).scrollTop(elemBottom - $(container).height());
  }
}
	
</script>

</head>

<body>
  <input type="hidden" id="user_id" value="<?php echo $_SESSION['user_id']; ?>"/><!--id-->
  <input type="hidden" id="user_name" value="<?php echo $_SESSION['user_name']; ?>"/><!--name-->
  <input type="hidden" id="session_room" value="<?php echo $_SESSION['session_id']; ?>"/><!--session room-->
  
  <div id="messages"><table id="tbl"></table></div>
  <input type="text" id="text-input">
  <input type="submit" value="Send" disabled id="send-button">
 
</body>
</html>