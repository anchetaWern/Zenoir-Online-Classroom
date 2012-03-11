<!--admin template-->
<link rel="stylesheet" href="/zenoir/libs/kickstart/css/kickstart.css"/>
<link rel="stylesheet" href="/zenoir/css/main.css"/>
<script src="/zenoir/js/jquery171.js"></script>
<script src="/zenoir/libs/kickstart/js/kickstart.js"></script>
<script src="/zenoir/libs/kickstart/js/prettify.js"></script>
<script>
$(function(){
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
<a href="/zenoir/index.php/adminloader/destroy_userdata">[Logout]</a>
<div id="container">
	<div id="app_name"><h2>Zenoir</h2></div>
