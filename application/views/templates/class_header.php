<!--admin template-->
<link rel="stylesheet" href="/zenoir/libs/kickstart/css/kickstart.css"/>
<link rel="stylesheet" href="/zenoir/css/main.css"/>
<link rel="stylesheet" href="/zenoir/libs/dataTables/css/demo_page.css"/>

<script src="/zenoir/js/jquery171.js"></script>
<script src="/zenoir/libs/kickstart/js/kickstart.js"></script>
<script src="/zenoir/libs/kickstart/js/prettify.js"></script>
<script src="/zenoir/libs/dataTables/js/jquery.dataTables.min.js"></script>

<script>
$(function(){
	$('a[data-classid]').live('hover', function(){//creates a session for the class
		var class_id = $.trim($(this).data('classid'));
		
		$.post('/zenoir/index.php/data_setter/set_class', {'class_id' : class_id}, function(data){console.log(data);});
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
});
</script>

<title><?php echo $title; ?></title>
<!--user id-->
<a href="/zenoir/index.php/ajax_loader/view/edit_account" class="lightbox"><?php echo $this->session->userdata('user_name'); ?></a>
<a href="/zenoir/index.php/class_loader/destroy_userdata">[Logout]</a>
<div id="container">
	<div id="app_name"><h2><a id="app_title" href="/zenoir/index.php/class_loader/view/class_home">Zenoir</a></h2></div>
