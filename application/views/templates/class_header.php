<!--admin template-->
<link rel="stylesheet" href="/zenoir/libs/kickstart/css/kickstart.css"/>
<link rel="stylesheet" href="/zenoir/css/main.css"/>
<link rel="stylesheet" href="/zenoir/libs/dataTables/css/demo_page.css"/>

<link rel="stylesheet" href="/zenoir/libs/jquery_ui/css/ui-lightness/jquery-ui-1.8.18.custom.css"/>

<link href="/zenoir/css/fileUploader.css" rel="stylesheet"/>


<script src="/zenoir/js/jquery171.js"></script>

<script src="/zenoir/libs/kickstart/js/kickstart.js"></script>
<script src="/zenoir/libs/kickstart/js/prettify.js"></script>

<!--awesome tables functions-->
<script src="/zenoir/libs/dataTables/js/jquery.dataTables.min.js"></script>

<script src="/zenoir/libs/jquery_ui/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="/zenoir/js/jquery.fileUploader.js"></script>


<script src="/zenoir/libs/jquery_ui/js/datetimepicker.js"></script>


<script>
$(function(){
$('.time_picker').datetimepicker({
	ampm: true,
	dateFormat: 'yy-mm-dd'
});
	
	$('.tbl_classes').dataTable();
	
	$('a[data-classid]').live('hover', function(){//creates a session for the class
		var class_id = $.trim($(this).data('classid'));
		
		$.post('/zenoir/index.php/data_setter/set_class', {'class_id' : class_id});
	});
	
	$('a[data-id]').live('hover', function(){
		var current_id = $(this).data('id');
		$.post('/zenoir/index.php/data_setter/sets', {'current_id' : current_id});
	});
	
	
	$('a[data-msgid]').live('hover', function(){
		var msg_id = $(this).data('msgid');
		$.post('/zenoir/index.php/data_setter/set_message', {'msg_id' : msg_id});
	});
	
	$('#btn_update_account').live('click',function(){
		var password = $.trim($('#password').val()); 
		var fname = $.trim($('#fname').val());
		var mname = $.trim($('#mname').val());
		var lname = $.trim($('#lname').val());
		var auto_biography = $.trim($('#autobiography').val());
		$.post('/zenoir/index.php/usert/update_user', {'pword' : password, 'fname' : fname, 'mname' : mname, 'lname' : lname, 'autobiography' : auto_biography},
			function(){
				$('#px-submit').click();
			}
		);
	});
	
	$('#create_assignment').live('click', function(){
		
		var as_title	= $.trim($('#as_title').val());
		var as_body		= $.trim($('#as_body').val());
		var as_deadline	= $.trim($('#deadline').val());
		$.post('/zenoir/index.php/assignments/create_assignment', {'as_title' : as_title, 'as_body' : as_body, 'as_deadline' : as_deadline},
			function(){
				$('#px-submit').click();
			}
		);
	});

	$('#create_handout').live('click', function(){
		
		var ho_title	= $.trim($('#ho_title').val());
		var ho_body		= $.trim($('#ho_body').val());
		$.post('/zenoir/index.php/handouts/create', {'ho_title' : ho_title, 'ho_body' : ho_body},
			function(){
				$('#px-submit').click();
			}
		);
	});
	
	$('#create_message').live('click', function(){
		var receivers	= $.trim($('#receivers').val());
		var msg_title 	= $.trim($('#msg_title').val()); 
		var msg_body 	= $.trim($('#msg_body').val()); 
	
		$.post('/zenoir/index.php/messages/create', {'receivers' : receivers, 'msg_title' : msg_title, 'msg_body' : msg_body},
			function(data){
				
				$('#px-submit').click();
			}
		);
	});
	
	
	$('#reply_message').live('click', function(){
		var msg_title 	= $.trim($('#msg_title').val()); 
		var msg_body 	= $.trim($('#msg_body').val()); 
		
		$.post('/zenoir/index.php/messages/reply', {'msg_title' : msg_title, 'msg_body' : msg_body},
			function(data){
				
				$('#px-submit').click();
			}
		);
	});
	
	
	$('#submit_assignmentreply').live('click', function(){
		var reply_title	= $.trim($('#as_title').val());
		var reply_body	= $.trim($('#as_body').val());
		
		$.post('/zenoir/index.php/assignments/reply', {'reply_title' : reply_title, 'reply_body' : reply_body},
			function(){
				$('#px-submit').click();
			}
		);
	});
	
	$('#next').live('click', function(){
		var quiz_title	= $.trim($('#quiz_title').val());
		var quiz_body	= $.trim($('#quiz_body').val());
		var start_time	= $.trim($('#start_time').val());
		var end_time	= $.trim($('#end_time').val());
		
		//put the general quiz info on the session
		$.post('/zenoir/index.php/quizzes/cache', {'quiz_title' : quiz_title, 'quiz_body' : quiz_body, 'start_time' : start_time, 'end_time' : end_time},
			function(){
				window.location = "/zenoir/index.php/class_loader/view/quiz_items";
			}
		);
	});
	
	$('#create_quiz').live('click', function(){
		var questions	= $('.qt').serializeArray();
		var a			= $('.ca').serializeArray();
		var b			= $('.cb').serializeArray();
		var c			= $('.cc').serializeArray();
		var d			= $('.cd').serializeArray();
		var answers		= $('.an').serializeArray();
		$.post('/zenoir/index.php/quizzes/create', {'questions' : questions, 'a' : a, 'b' : b, 'c' : c, 'd' : d, 'answers' : answers},
			function(data){
				console.log(data);
			});
	});
	
	$('#submit_quiz').live('click', function(){
		var answers 	= $('.answers').serializeArray();
		$.post('/zenoir/index.php/quizzes/submit', {'answers' : answers}, function(data){console.log(data);});
	});

});
</script>
<?php
//classroom information
$class_info = $this->session->userdata('classroom_info');
$class_code = $class_info['class_code'];
$class_desc = $class_info['class_desc'];
$teacher	= ucwords($class_info['fname'] . ' ' .$class_info['lname']);
?>
<title><?php echo $title; ?></title>
<!--user id-->
<a href="/zenoir/index.php/ajax_loader/view/edit_account" class="lightbox"><?php echo $this->session->userdata('user_name'); ?></a>
<a href="/zenoir/index.php/class_loader/destroy_userdata">[Logout]</a>
<div id="container">
	<div id="app_name"><img src="/zenoir/img/zenoir.png"/><h2><a id="app_title" href="/zenoir/index.php/class_loader/view/class_home">Zenoir</a></h2></div>

<div id="class_title">
<h6>
<?php 
echo $class_code.'<br/>'; 
echo $class_desc . ' - '. $teacher; 
?>
</h6>
</div>