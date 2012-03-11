<!-- Tabs Left -->
<ul class="tabs left">
<li><a href="#tabr1">Login</a></li>
</ul>

<div id="tabr1" class="tab-content">
<?php
echo form_open('../login/validate_user');
?>
<div id="form_div">
<?php
$user_name = array(
	'name'=>'user_id',
	'placeholder'=>'User ID',
	'id'=>'user_id',
	'class'=>'login_form',
	'autocomplete'=>'off'
);

$password = array(
	'name'=>'password',
	'placeholder'=>'Password',
	'id'=>'password',
	'class'=>'login_form'
);
echo form_input($user_name);

echo form_password($password);
echo  form_submit('btn_login','Login');
?>

</div><!--end of form div-->
<?php
echo form_close();
?>
</div>