<!--class template-->
<link rel="stylesheet" href="/zenoir/libs/kickstart/css/kickstart.css"/><!--ui and overall layout style-->
<link rel="stylesheet" href="/zenoir/css/main.css"/><!--main style-->
<link rel="stylesheet" href="/zenoir/libs/dataTables/css/demo_page.css"/><!--table styles-->
<link rel="stylesheet" href="/zenoir/libs/jquery_ui/css/ui-lightness/jquery-ui-1.8.18.custom.css"/><!--ui style-->
<link rel="stylesheet" href="/zenoir/css/fileUploader.css"/><!--fileuploader style-->


<script src="/zenoir/js/jquery171.js"></script><!--core-->
<script src="/zenoir/libs/kickstart/js/kickstart.js"></script><!--ui and overall layout script-->
<script src="/zenoir/libs/kickstart/js/prettify.js"></script>
<script src="/zenoir/libs/dataTables/js/jquery.dataTables.min.js"></script><!--table functionality-->
<script src="/zenoir/libs/jquery_ui/js/jquery-ui-1.8.18.custom.min.js"></script><!--ui script-->
<script src="/zenoir/js/jquery.fileUploader.js"></script><!--file uploader script-->
<script src="/zenoir/libs/jquery_ui/js/datetimepicker.js"></script><!--date and time picker script-->



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
		$.post('/zenoir/index.php/data_setter/sets', {'current_id' : current_id}, function(data){console.log(data);});
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
	
	$('#create_group').live('click', function(){
		console.log('created group');
		var group_name 		= $.trim($('#group_name').val());
		var group_members 	= $('#class_users').serializeArray();
		$.post('/zenoir/index.php/groups/create', {'group_name' : group_name, 'members' : group_members},
				function(){
				
				}
		);
	});
	
	$('#ses_validity').live('click', function(){
		if($(this).attr('checked')){
			$('#time_setter').hide();
		}else{
			$('#time_setter').show();
		}
	});
	
	$('a[data-sestype]').live('hover', function(){
		var session_type 	= $(this).data('sestype');
		$.post('/zenoir/index.php/data_setter/set_sessiontype', {'session_type' : session_type});
	});
	
	$('a[data-sestype]').live('click', function(){
		var session_type 	= $(this).data('sestype');
		$.post('/zenoir/index.php/data_setter/set_sessiontype', {'session_type' : session_type});
	});
	
	$('#create_mcsession').live('click', function(){
		var title		= $.trim($('#ses_title').val());
		var ses_desc	= $.trim($('#ses_body').val());
		var infinite	= 0;
		
		if($('#ses_validity').attr('checked')){
			infinite = 1;
		}
		
		var time_from	= $.trim($('#time_from').val());
		var time_to		= $.trim($('#time_to').val());
		
		if($('#session_groups').length){//team session
			var members	= $('#session_groups').serializeArray();
			
		}else{//class and masked session
			var members	= 0;
		}
		
		$.post('/zenoir/index.php/sessions/create', {'ses_title' : title, 'ses_body' : ses_desc, 'infinite' : infinite, 
														'time_from' : time_from, 'time_to' : time_to, 'members' : members},
														function(data){
															console.log(data);
														});
		
	});
	
	
	$('img[data-inviteid]').live('click', function(){//teacher invites student
		var invite_id	= $(this).data('inviteid');
		var invite_name = $(this).data('invitename');
		var answer = confirm('Are you sure you want to invite ' + invite_name + ' into this class?');
		if(answer){
			$.post('/zenoir/index.php/classrooms/invites', {'student_id' : invite_id}, function(){
				alert('Student successfully invited to the classroom!');
			});
		}
	});
	
	$('img[data-studentid]').live('click', function(){//student accepts teacher invite
		var student_id	= $(this).data('studentid');
		var class_id	= $(this).data('classid');
		var answer = confirm('Are you sure you want to join this class?');
		if(answer){
			$.post('/zenoir/index.php/classrooms/accept', {'student_id' : student_id, 'class_id' : class_id}, function(){
				alert('You can now enter the classroom!');
			});
		}
	});
	
	$('#enter_session').live('click', function(){
		var masked_name = $.trim($('#alias').val());
		if(masked_name != ''){//for masked session
			$.post('/zenoir/index.php/data_setter/set_mask', {'masked_name' : masked_name});
		}else{//for team and class session
			$.post('/zenoir/index.php/data_setter/set_name');
		}
	});
	
	$('.endis_module').live('click', function(){
		console.log($(this).data('classmoduleid'));
		var classmodule_id = $(this).data('classmoduleid');
		if($(this).attr('checked')){
			$.post('/zenoir/index.php/classrooms/enable', {'cm_id' : classmodule_id}, function(data){console.log(data);});
		}else{
			$.post('/zenoir/index.php/classrooms/disable', {'cm_id' : classmodule_id});
		}
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
<span class="spacer">
<a href="/zenoir/index.php/ajax_loader/view/edit_account" class="lightbox"><?php echo $this->session->userdata('user_name'); ?></a>
</span>
<span class="spacer">
<a href="/zenoir/index.php/ajax_loader/view/groups" class="lightbox">Groups</a>
</span>
<span class="spacer">
<a href="/zenoir/index.php/class_loader/destroy_userdata">[Logout]</a>
</span>
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