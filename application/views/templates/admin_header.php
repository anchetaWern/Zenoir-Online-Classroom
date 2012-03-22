<!--admin template-->
<link rel="stylesheet" href="/zenoir/libs/kickstart/css/kickstart.css"/><!--ui and overall layout style-->
<link rel="stylesheet" href="/zenoir/css/main.css"/><!--main style-->
<link rel="stylesheet" href="/zenoir/libs/dataTables/css/demo_page.css"/><!--table styles-->
<link rel="stylesheet" href="/zenoir/libs/jquery_ui/css/ui-lightness/jquery-ui-1.8.18.custom.css"/><!--ui style-->
<link rel="stylesheet" href="/zenoir/css/fileUploader.css"/><!--fileuploader style-->
<link rel="stylesheet" href="/zenoir/libs/wysihtml5/src/bootstrap-wysihtml5.css"/><!--text formatting style-->

<script src="/zenoir/js/jquery171.js"></script><!--core-->
<script src="/zenoir/libs/kickstart/js/kickstart.js"></script><!--ui and overall layout script-->
<script src="/zenoir/libs/kickstart/js/prettify.js"></script>
<script src="/zenoir/libs/dataTables/js/jquery.dataTables.min.js"></script><!--table functionality-->
<script src="/zenoir/libs/jquery_ui/js/jquery-ui-1.8.18.custom.min.js"></script><!--ui script-->
<script src="/zenoir/js/jquery.fileUploader.js"></script><!--file uploader script-->
<script src="/zenoir/libs/jquery_ui/js/datetimepicker.js"></script><!--date and time picker script-->
<script src="/zenoir/libs/wysihtml5/src/bootstrap-wysihtml5.js"></script><!--text formatting script-->

<script>
$(function(){
	$('.tbl_classes').dataTable();
	
	
	
	$('a[data-classid]').live('hover', function(){//creates a session for the class
		var class_id = $.trim($(this).data('classid'));
		
		$.post('/zenoir/index.php/data_setter/set_class', {'class_id' : class_id});
	});
	
	$('#btn_update_account').live('click',function(){
		var password = $.trim($('#password').val()); 
		var fname = $.trim($('#fname').val());
		var mname = $.trim($('#mname').val());
		var lname = $.trim($('#lname').val());
		var auto_biography = $.trim($('#autobiography').val());
		$.post('/zenoir/index.php/usert/update_user', {'pword' : password, 'fname' : fname, 'mname' : mname, 'lname' : lname, 'autobiography' : auto_biography},
			function(){
				$('#fancybox-close').click();
			});
	});
	
	$('#create_user').live('click', function(){
		var user_id 	= $.trim($('#user_id').val());
		var user_type	= $.trim($('#user_type').val());
		var fname		= $.trim($('#user_fname').val());
		var mname		= $.trim($('#user_mname').val());
		var lname		= $.trim($('#user_lname').val());
		$.post('/zenoir/index.php/usert/create_user', {'user_id' : user_id, 'user_type' : user_type, 'fname' : fname, 'mname' : mname, 'lname' : lname}, 
			function(){
				$('#fancybox-close').click();
			}
		);
	});
	
	$('#create_subject').live('click', function(){
		var subject_code	= $.trim($('#subject_code').val()); 
		var description		= $.trim($('#subject_desc').val()); 	
		$.post('/zenoir/index.php/subjects/create_subject', {'subject_code' : subject_code, 'description' : description},
			function(){
				$('#fancybox-close').click();
			}
		);
	});
	
	$('#create_course').live('click', function(){
		var course_code		= $.trim($('#course_code').val());
		var description		= $.trim($('#course_desc').val());
		$.post('/zenoir/index.php/courses/create_course', {'course_code' : course_code, 'course_desc' : description},
			function(){
				$('#fancybox-close').click();
			}
		);
	});
	
	$('#create_class').live('click', function(){
		var class_code 		= $.trim($('#class_code').val());
		var class_desc 		= $.trim($('#class_desc').val());
		var teacher			= $.trim($('#teacher').val());
		var subject			= $.trim($('#subject').val());
		var course			= $.trim($('#course').val());
		
		//additional details
		var date_created	= $.trim($('#date_created').val());
		var addl_details	= $.trim($('#addl_details').val());
		
		var teacher_id		= 0;
		var subject_id		= 0;
		var course_id		= 0;
		
		$('#teachers option').each(function(){
			var current_teacher = $(this).val();
			var current_teacherid = $(this).data('teacherid');
			if(current_teacher == teacher){
				teacher_id = current_teacherid;
				
			}
		});
		
		$('#subjects option').each(function(){
			var current_subject = $(this).val();
			var current_subjectid = $(this).data('subjectid');
			if(current_subject == subject){
				subject_id = current_subjectid;
				
			}
		});
		
		$('#courses option').each(function(){
			var current_course = $(this).val();
			var current_courseid = $(this).data('courseid');
			if(current_course == course){
				course_id = current_courseid;
				
			}
		});
		
		$.post('/zenoir/index.php/classrooms/create_class', 
			{'class_code' : class_code, 'subject_id' : subject_id, 'teacher_id' : teacher_id, 'course_id' : course_id,
			'class_desc' : class_desc, 'date_created' : date_created, 'details' : addl_details},
			function(){
				$('#fancybox-close').click();
			}
		);
	});
	
	$('a[data-id]').live('hover', function(){
		
		var current_id = $(this).data('id');
		$.post('/zenoir/index.php/data_setter/sets', {'current_id' : current_id});
		
	});
	
	$('#add_people').live('click', function(){
		var user_ids = $('#user_ids').val();
		$.post('/zenoir/index.php/classrooms/add_people', {'user_id' : user_ids}, 
			function(data){
				$('#fancybox-close').click();
			}
		);
	});
	
	$('#update_subject').live('click', function(){
		var subj_code	= $.trim($('#subject_code').val());
		var subj_desc	= $.trim($('#subject_desc').val());
		$.post('/zenoir/index.php/subjects/update_subject', {'subj_code' : subj_code, 'subj_desc' : subj_desc}, 
			function(){
				$('#fancybox-close').click();
			}
		);
	});
	
	$('#edit_course').live('click', function(){
		var course_code	= $.trim($('#course_code').val()); 
		var course_desc	= $.trim($('#course_desc').val()); 	
		$.post('/zenoir/index.php/courses/update_course', {'course_code' : course_code, 'course_desc' : course_desc},
			function(){
				$('#fancybox-close').click();
			}
		);
	});

});
</script>
<title><?php echo $title; ?></title>
<!--user id-->
<a href="/zenoir/index.php/ajax_loader/view/edit_account" class="lightbox"><?php echo $this->session->userdata('user_name'); ?></a>
<a href="/zenoir/index.php/adminloader/destroy_userdata">[Logout]</a>
<div id="container">
	<div id="app_name"><img src="/zenoir/img/zenoir.png"/><h2><a id="app_title" href="/zenoir/index.php/adminloader/view/admin_home">Zenoir</a></h2></div>
	

