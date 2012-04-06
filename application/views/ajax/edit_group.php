<!--update groups - adding new members, remove existing members-->
<?php
$group_data = $page['members']['group'];
if(!empty($page['members']['members'])){
$group_members = $page['members']['members'];
}
if(!empty($page['pendings'])){ 
$pending_members = $page['pendings'];
}
$group_invited = $page['members']['invited'];
$group_id	= $group_data['group_id'];
$group_name	= $group_data['group_name'];

?>
<div id="modal_header">
<h4>Update Group</h4>
</div>
<?php
$group	= array(
			'name'=>'group_name',
			'id'=>'group_name',
			'value'=>$group_name
		);
		
$edit	= array(
			'id'=>'update_group',
			'name'=>'update_group',
			'value'=>'Update Group',
			'content'=>'Update Group',
			'class'=>'medium green'
		);
?>
<div class="container">
<?php
echo form_label('Group Name' , 'group_name');
echo form_input($group);
?>
<?php if(!empty($group_members)){ ?>
<p>
Current Members
</p>
<table>
	<thead>
		<tr>
			<th>Member ID</th>
			<th>Fullname</th>
			<th>Remove</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($group_members as $row){ ?>
	<?php
	$member_name = strtoupper($row['lname']) . ', ' . ucwords($row['fname']) . ' ' . ucwords($row['mname']);
	?>
		<tr>
			<td><?php echo $row['member_id']; ?></td>
			<td><?php echo $member_name; ?></td>
			<td><img src="/zenoir/img/decline.png" class="icons" data-delmember="<?php echo $row['group_people_id']; ?>" delmembername="<?php echo $member_name; ?>"/></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
<?php if(!empty($pending_members)){ ?>
<p>
Pending Members
</p>
<table>
	<thead>
		<tr>
			<th>User ID</th>
			<th>Fullname</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($pending_members as $row){ ?>
		<tr>
			<td><?php echo $row['user_id']; ?></td>
			<td><?php echo strtoupper($row['lname']) . ', ' . ucwords($row['fname']); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>

<?php echo form_label('Select Members', 'class_users'); ?>
<?php if(!empty($group_invited )){ ?>
<select name="class_users" id="class_users" multiple>
	<?php foreach($group_invited  as $row){ ?>
	<option value="<?php echo $row['user_id']; ?>"><?php echo strtoupper($row['lname']) .', '. ucwords($row['fname']); ?></option>
	<?php } ?>
</select>
<?php } ?>
<p>
<?php
echo form_button($edit);
?>
</p>
</div>