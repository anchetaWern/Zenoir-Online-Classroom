<!--current session-->
<script src="/zenoir/node_server/nowjs.js"></script>

<script>
$(document).ready(function(){
	
	now.receiveMessage = function(name, message){
		
		$("#tbl_messages").append("<tr><td>" + name + ": " + message +"</td></tr>");
		$('#tbl_messages tr:even').addClass('alt');
	}

	// Send message to people in the same group
	$('#text-input').keydown(function(e){
		if(e.keyCode == 13){
			$('#send-button').click();
			$('#tbl_messages tr:even').addClass('alt');
			$('#chatbox').animate({scrollTop: $('#tbl_messages').height()}, 800);
		}
	});
	
	$("#send-button").click(function(){
		now.distributeMessage($("#text-input").val());
		$("#text-input").val("");
	});

	now.name = $('#user_name').val();
	now.user_id	= $('#user_id').val();

	// on establishing 'now' connection, set server room and allow message sending
	now.ready(function(){
		// By default pick the first chatroom 
		now.changeRoom($('#session_room').val());
		
		// Connection established and room set; allow user to start sending messages
		$("#send-button").removeAttr('disabled');
	});

});
</script>
<?php
$session_title 	= $_SESSION['ses']['title'];
$time_from		= date('Y-m-d g:i:s A', strtotime($_SESSION['ses']['from']));
$time_to		= date('Y-m-d g:i:s A', strtotime($_SESSION['ses']['to']));
echo "Session:<a href='/zenoir/index.php/ajax_loader/view/session' class='lightbox'> ". $session_title ."</a><br/>";
echo "From:    ".$time_from."<br/>";
echo "To:      ".$time_to."<br/>";
?>
<input type="hidden" id="user_id" value="<?php echo $_SESSION['user_id']; ?>"/><!--id-->
<input type="hidden" id="user_name" value="<?php echo $_SESSION['user_name']; ?>"/><!--name-->
<input type="hidden" id="session_room" value="<?php echo $_GET['sid']; ?>"/><!--session room-->

<div id="chatbox">
	<table class="striped" id="tbl_messages"></table>
</div><!--end of chatbox-->
<div id="message_box">
	<input type="text" id="text-input" class="col_12">
	<input type="button" value="Send" disabled id="send-button">
</div>