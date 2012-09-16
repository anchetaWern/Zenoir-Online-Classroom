<!--create new group-->
<div id="modal_header">
<h4>Create New Group</h4>
</div>
<?php 
$members= $page;
$group	= array(
			'name'=>'group_name',
			'id'=>'group_name'
		);
		
$group_description	= array(
			'name'=>'group_description',
			'id'=>'group_description'
		);
		
$create	= array(
			'id'=>'create_group',
			'name'=>'create_group',
			'value'=>'Create Group',
			'content'=>'Create Group',
			'class'=>'medium green'
		);
?>
<div class="container">
<?php
echo form_label('Group Name' , 'group_name');
echo form_input($group);

echo form_label('Group Description', 'group_description');
echo form_textarea($group_description);
?>
<?php echo form_label('Select Members', 'class_users'); ?>
<?php if(!empty($members)){ ?>
<select name="class_users" id="class_users" multiple>
	<?php foreach($members as $row){ ?>
	<option value="<?php echo $row['id']; ?>"><?php echo strtoupper($row['lname']) .', '. ucwords($row['fname']); ?></option>
	<?php } ?>
</select>
<?php } ?>
<p>
<?php
echo form_button($create);
?>
</p>
</div>