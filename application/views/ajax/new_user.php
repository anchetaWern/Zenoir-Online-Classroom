<div id="modal_header">
<h4>Create New User</h4>
</div>

<?php
/*
user code:
	1-Admin
	2-Teacher
	3-Student
*/

$user_id	= array(
				'id'=>'user_id',
				'name'=>'user_id'
			);

$fname		= array(
				'id'=>'user_fname',
				'name'=>'user_fname'
			);
			
$mname 		= array(
				'id'=>'user_mname',
				'name'=>'user_mname'
			);

$lname 		= array(
				'id'=>'user_lname',
				'name'=>'user_lname'
			);			

$user_types = array(
				'1'=>'Admin',
				'2'=>'Teacher',
				'3'=>'Student'
			);

$create		= array(
				'id'=>'create_user',
				'name'=>'create_user',
				'value'=>'Create User',
				'content'=>'Create User',
				'class'=>'medium green'
			);	

echo form_label('User Type', 'user_types');
echo form_dropdown('user_types', $user_types, '3' , 'id="user_type"');		

echo form_label('User ID', 'user_id');
echo form_input($user_id);

echo form_label('Firstname' , 'fname'); 
echo form_input($fname);

echo form_label('Middlename', 'mname');
echo form_input($mname);

echo form_label('Lastname', 'lname');
echo form_input($lname);

echo form_button($create);
?>