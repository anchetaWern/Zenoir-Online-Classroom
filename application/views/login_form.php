<?php
echo form_open('../login/validate_user');

$user_name = array(
	'name'=>'user_id',
	'placeholder'=>'User ID',
	'id'=>'user_id',
	'class'=>'login_form'
);

$password = array(
	'name'=>'password',
	'placeholder'=>'Password',
	'id'=>'password',
	'class'=>'login_form'
);
echo form_input($user_name);

echo form_input($password);
echo  form_submit('btn_login','Login');
echo form_close();
?>