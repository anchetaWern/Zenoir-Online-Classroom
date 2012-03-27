<!--class template-->
<link rel="stylesheet" href="/zenoir/libs/kickstart/css/kickstart.css"/><!--ui and overall layout style-->
<link rel="stylesheet" href="/zenoir/css/main.css"/><!--main style-->
<link rel="stylesheet" href="/zenoir/libs/dataTables/css/demo_page.css"/><!--table styles-->
<link rel="stylesheet" href="/zenoir/libs/jquery_ui/css/ui-lightness/jquery-ui-1.8.18.custom.css"/><!--ui style-->
<link rel="stylesheet" href="/zenoir/css/fileUploader.css"/><!--fileuploader style-->
<link rel="stylesheet" href="/zenoir/libs/noty/css/jquery.noty.css"/><!--notifications-->
<link rel="stylesheet" href="/zenoir/libs/noty/css/noty_theme_default.css"/><!--notifications-->

<script src="/zenoir/js/jquery171.js"></script><!--core-->
<script src="/zenoir/libs/kickstart/js/kickstart.js"></script><!--ui and overall layout script-->
<script src="/zenoir/libs/kickstart/js/prettify.js"></script>
<script src="/zenoir/libs/dataTables/js/jquery.dataTables.min.js"></script><!--table functionality-->
<script src="/zenoir/libs/jquery_ui/js/jquery-ui-1.8.18.custom.min.js"></script><!--ui script-->
<script src="/zenoir/js/jquery.fileUploader.js"></script><!--file uploader script-->
<script src="/zenoir/libs/jquery_ui/js/datetimepicker.js"></script><!--date and time picker script-->
<script src="/zenoir/libs/noty/js/jquery.noty.js"></script><!--notifications-->


<script>
$(function(){
	var noty_success = {
			"text":"Operation was successfully completed!",
			"layout":"top",
			"type":"success",
			"textAlign":"center",
			"easing":"swing",
			"animateOpen":{"height":"toggle"},
			"animateClose":{"height":"toggle"},
			"speed":500,
			"timeout":5000,
			"closable":true,
			"closeOnSelfClick":true
	}
	
	var noty_err = {
			"text":"An error occured, please try again",
			"layout":"top",
			"type":"error",
			"textAlign":"center",
			"easing":"swing",
			"animateOpen":{"height":"toggle"},
			"animateClose":{"height":"toggle"},
			"speed":500,
			"timeout":5000,
			"closable":true,
			"closeOnSelfClick":true
	}
	
	
	
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
		var updates	= 1;
		var password = $.trim($('#password').val()); 
		var fname = $.trim($('#fname').val());
		var mname = $.trim($('#mname').val());
		var lname = $.trim($('#lname').val());
		var auto_biography = $.trim($('#autobiography').val());
		
		var account_data = [fname, mname, lname];
		for(var x in account_data){
			if(account_data[x] == ''){
				updates = 0;
			}
		}
		
		if(updates==1){
			$.post('/zenoir/index.php/usert/update_user', {'pword' : password, 'fname' : fname, 'mname' : mname, 'lname' : lname, 'autobiography' : auto_biography},
				function(){
					$('#px-submit').click();
					noty_success.text = 'Account was successfully updated!';
					noty(noty_success);
				}
			);
		}else{
			noty_err.text = 'Firstname, Middlename and Lastname are required!';
			noty(noty_err);
		}
	});
	
	$('#create_assignment').live('click', function(){
		
		var as_title	= $.trim($('#as_title').val());
		var as_body		= $.trim($('#as_body').val());
		var as_deadline	= $.trim($('#deadline').val());
		var submits 	= 1;
		
		var assignment = [as_title, as_body, as_deadline];
		for(var x in assignment){
			if(assignment[x] == ''){
				submits = 0;
			}
		}
		
		if(submits == 1){
			$.post('/zenoir/index.php/assignments/create_assignment', {'as_title' : as_title, 'as_body' : as_body, 'as_deadline' : as_deadline},
				function(){
					$('#px-submit').click();
					$('#as_title, #as_body, #deadline').val('');
					noty_success.text = 'Assignment was successfully created!';
					noty(noty_success);
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});

	$('#create_handout').live('click', function(){
		var create		= 1;
		var ho_title	= $.trim($('#ho_title').val());
		var ho_body		= $.trim($('#ho_body').val());
		var handout		= [ho_title, ho_body];
		
		for(var x in handout){
			if(handout[x] == ''){
				create = 0;
			}
		}
		
		if(create == 1){
			$.post('/zenoir/index.php/handouts/create', {'ho_title' : ho_title, 'ho_body' : ho_body},
				function(){
					$('#px-submit').click();
					$('#ho_title, #ho_body').val('');
					noty_success.text = 'Handout was successfully created!';
					noty(noty_success);
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	$('#create_message').live('click', function(){
		var send		= 1;
		var receivers	= $.trim($('#receivers').val());
		var msg_title 	= $.trim($('#msg_title').val()); 
		var msg_body 	= $.trim($('#msg_body').val()); 
		
		var message		= [msg_title, msg_body];
		var receiver_len= $('#receivers :selected').length;
		
		for(var x in message){
			if(message[x] == ''){
				send = 0;
			}
		}
		
		if(send == 1 && receiver_len >= 1){
			$.post('/zenoir/index.php/messages/create', {'receivers' : receivers, 'msg_title' : msg_title, 'msg_body' : msg_body},
				function(data){
					$('#px-submit').click();
					$('#receivers, #msg_title, #msg_body').val('');
					noty_success.text = 'Message Sent!';
					noty(noty_success);
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	
	$('#reply_message').live('click', function(){
		var create		= 1;
		var msg_title 	= $.trim($('#msg_title').val()); 
		var msg_body 	= $.trim($('#msg_body').val()); 
		
		var reply = [msg_title, msg_body];
		for(var x in reply){
			if(reply[x] == ''){
				create = 0;
			}
		}
		
		if(create == 1){
			$.post('/zenoir/index.php/messages/reply', {'msg_title' : msg_title, 'msg_body' : msg_body},
				function(data){
					$('#px-submit').click();
					$('#msg_title, #msg_body').val('');
					noty_success.text = 'Message sent!';
					noty(noty_success);
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	
	$('#submit_assignmentreply').live('click', function(){
		var create		= 1;
		var reply_title	= $.trim($('#as_title').val());
		var reply_body	= $.trim($('#as_body').val());
		
		var reply		= [reply_title, reply_body];
		
		for(var x in reply){
			if(reply[x] == ''){
				create = 0;
			}
		}
		
		if(create == 1){
			$.post('/zenoir/index.php/assignments/reply', {'reply_title' : reply_title, 'reply_body' : reply_body},
				function(){
					$('#px-submit').click();
					$('#as_title, #as_body').val('');
					noty_success.text = 'Reply was successfully submitted!';
					noty(noty_success);
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	$('#next').live('click', function(){
		var create		= 1;
		var quiz_title	= $.trim($('#quiz_title').val());
		var quiz_body	= $.trim($('#quiz_body').val());
		var start_time	= $.trim($('#start_time').val());
		var end_time	= $.trim($('#end_time').val());
		
		var quiz		= [quiz_title, quiz_body, start_time, end_time];
		
		for(var x in quiz){
			if(quiz[x] == ''){
				create = 0;
			}
		}
		
		if(create == 1){
			//put the general quiz info on the session
			$.post('/zenoir/index.php/quizzes/cache', {'quiz_title' : quiz_title, 'quiz_body' : quiz_body, 'start_time' : start_time, 'end_time' : end_time},
				function(){
					
					window.location = "/zenoir/index.php/class_loader/view/quiz_items";
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	$('#create_quiz').live('click', function(){
		var create_quiz	= 1;
		var questions	= $('.qt').serializeArray();
		var a			= $('.ca').serializeArray();
		var b			= $('.cb').serializeArray();
		var c			= $('.cc').serializeArray();
		var d			= $('.cd').serializeArray();
		var answers		= $('.an').serializeArray();
	
		$('input[type=text]').each(function(){
			if($(this).attr('value') == ''){
				create_quiz = 0;
			}
		});
		
		if(create_quiz == 1){
		
			$.post('/zenoir/index.php/quizzes/create', {'questions' : questions, 'a' : a, 'b' : b, 'c' : c, 'd' : d, 'answers' : answers},
				function(data){
					noty_success.text = 'Quiz was successfully created!';
					noty(noty_success);
					setTimeout(function(){
						window.location = "/zenoir/index.php/class_loader/view/quizzes"
					}, 1000);
					
			});
		
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	$('#submit_quiz').live('click', function(){
		
		var quiz_items 	= $('select').length;
		var answered_all= 1;
		$('select').each(function(){
			if($(this).val() == '--'){
				answered_all = 0;
			}
		});
		
		if(answered_all == 1){
			var answers 	= $('.answers').serializeArray();
			
		noty(	
		{
			modal : true,
			text: 'Are you sure of your answers?',
			buttons: [
			  {type: 'button green', text: 'Ok', 
					click: function(){
						$.post('/zenoir/index.php/quizzes/submit', {'answers' : answers}, 
						function(){
							noty_success.text = 'Answers was successfully submitted!';
							noty(noty_success);
							 
							setTimeout(function(){
								window.location = "/zenoir/index.php/class_loader/view/quizzes";
							}, 1000);
						}
						);
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
			
		}else{
			noty_err.text = 'Please answer all of the quiz items!';
			noty(noty_err);
		}
		
	});
	
	$('#create_group').live('click', function(){
		var member_length 	= $('#class_users :selected').length;
		var group_name 		= $.trim($('#group_name').val());
		
		if(group_name != ''){
			if(member_length > 0){
					
					var group_members 	= $('#class_users').serializeArray();
					$.post('/zenoir/index.php/groups/create', {'group_name' : group_name, 'members' : group_members},
							function(){
								noty(noty_success);
								$('#fancybox-close').click();
							}
					);
			}else{
				noty_err.text = 'Please select atleast one co-member!';
				noty(noty_err);
			}
		}else{
			noty_err.text = 'Please enter a group name!';
			noty(noty_err);
		}
	});
	
	$('img[data-delmember]').live('click', function(){
		var member_id 	= $.trim($(this).data('delmember'));
		var member		= $.trim($(this).data('delmembername'));
		noty(	
		{
			modal : true,
			text: 'Are you sure you want to remove ' + member + ' from the group?',
			buttons: [
			  {type: 'button green', text: 'Ok', 
					click: function(){
						$.post('/zenoir/index.php/groups/delmember', {'member_id' : member_id}, 
						function(){
							noty_success.text = 'Group member successfully removed!';
							noty(noty_success);
							setTimeout($.noty.close(), 1000)
						}
						);
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
	});
	
	$('#update_group').live('click', function(){
		
		var group_name 		= $.trim($('#group_name').val());
		
		if(group_name != ''){
			
					
					var group_members 	= $('#class_users').serializeArray();
					$.post('/zenoir/index.php/groups/update', {'group_name' : group_name, 'members' : group_members},
							function(){
								noty_success.text = "Group successfully updated!";
								noty(noty_success);
								$('#fancybox-close').click();
							}
					);
			
		}else{
			noty_err.text = 'Please enter a group name!';
			noty(noty_err);
		}
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
		var create		= 1;
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
		
		var session = [title, ses_desc];
		if(infinite == 0){
			session = [title, ses_desc, time_from, time_to];
		}
		
		for(var x in session){
			if(session[x] == ''){
				create = 0;
			}
		}
		
		if($('#session_groups').length > 0 && $('#session_groups :selected').length == 0){
			create = 0;
		}
		
		if(create == 1){
			$.post('/zenoir/index.php/sessions/create', {'ses_title' : title, 'ses_body' : ses_desc, 'infinite' : infinite, 
															'time_from' : time_from, 'time_to' : time_to, 'members' : members},
															function(data){
																$('#fancybox-close').click();
																noty(noty_success);
															});
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	
	$('img[data-inviteid]').live('click', function(){//teacher invites student
		var invite_id	= $(this).data('inviteid');
		var invite_name = $(this).data('invitename');
		noty(	
		{
			modal : true,
			text: 'Are you sure you want to invite ' + invite_name + ' into this class?',
			buttons: [
			  {type: 'button green', text: 'Ok', 
					click: function(){
						$.post('/zenoir/index.php/classrooms/invites', {'student_id' : invite_id}, function(){
							$.noty.close();
							noty_success.text = 'Student was successfully invited to the classroom!';
							noty.force = true;
							noty(noty_success);
							setTimeout(function(){
								location.reload();
							},1000);
						});
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);

	});
	
	$('img[data-studentid]').live('click', function(){//student accepts teacher invite
		var student_id	= $(this).data('studentid');
		var class_id	= $(this).data('classid');
		
		noty(	
		{
			modal : true,
			text: 'Are you sure you want to join this class?',
			buttons: [
			  {type: 'button green', text: 'Yes', 
					click: function(){
						$.post('/zenoir/index.php/classrooms/accept', {'student_id' : student_id, 'class_id' : class_id}, function(){
							$.noty.close();
							noty_success.text = 'You can now login to this classroom!';
							noty.force = true;
							noty(noty_success);
							setTimeout(function(){
								location.reload();
							},1000);
						});
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
	});
	
	$('img[data-decline]').live('click', function(){
		var student_id 	= $(this).data('decline');
		var class_id	= $(this).data('classid');
		
		noty(	
		{
			modal : true,
			text: 'Are you sure you want to decline the invitation to join this class?',
			buttons: [
			  {type: 'button green', text: 'Yes', 
					click: function(){
						$.post('/zenoir/index.php/classrooms/decline', {'student_id' : student_id, 'class_id' : class_id}, function(){
							$.noty.close();
							noty_success.text = 'You have declined the request to join this classroom!';
							noty.force = true;
							noty(noty_success);
							setTimeout(function(){
								location.reload();
							},1000);
						});
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
	
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
		
		var classmodule_id = $(this).data('classmoduleid');
		if($(this).attr('checked')){
			$.post('/zenoir/index.php/classrooms/enable', {'cm_id' : classmodule_id}, function(data){console.log(data);});
		}else{
			$.post('/zenoir/index.php/classrooms/disable', {'cm_id' : classmodule_id});
		}
	});
	
	$('#btn_export').live('click', function(){
		var export_class = $('#export_to').val();

		noty(	
		{
			modal : true,
			text: 'This process cannot be undone are you sure you want to continue?',
			buttons: [
			  {type: 'button green', text: 'Yes', 
					click: function(){
					$('#export_group input[type=checkbox]').each(function(index){
						if($(this).attr('checked')){
							$.post('/zenoir/index.php/classrooms/export', {'export_class' : export_class, 'export_type' : index}, 
							function(){
								$.noty.close();
								noty_success.text = 'Classroom data was successfully exported!';
								noty.force = true;
								noty(noty_success);
								
							});
						}
					});
			  }},
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);

	});
	
	$('img[data-removename]').live('click', function(){
		var student_id 	= $.trim($(this).data('removeid'));
		var student		= $.trim($(this).data('removename'));
	
		noty(	
		{
			modal : true,
			text: 'Are you sure you want to remove '+ student +' from this class?',
			buttons: [
			  {type: 'button green', text: 'Yes', 
					click: function(){
							$.post('/zenoir/index.php/classrooms/remove', {'student_id' : student_id},
							function(){
								$.noty.close();
								noty_success.text = 'Student successfully removed from the classroom!';
								noty.force = true;
								noty(noty_success);
								setTimeout(function(){
								location.reload();
								},1000);
								
							});
					
			  }},
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
	
		
	});
	

});
</script>
<?php
//classroom information
$class_info = $this->session->userdata('classroom_info');
$class_code = $class_info['class_code'];
$class_desc = $class_info['class_desc'];
$teacher	= ucwords($class_info['fname'] . ' ' .$class_info['lname']);
$notes		= $class_info['notes'];
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
echo $class_desc . ' - '. $teacher.'<br/>'; 
echo $notes;
?>
</h6>
</div>