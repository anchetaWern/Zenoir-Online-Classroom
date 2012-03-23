<!--teachers class settings-->
<!--
1. invite existing students to the current classroom
2. enable/disable modules
3. remove students from the current classroom
-->
<h4>[Classroom Settings]</h4>
<ul class="tabs left">
	<li><a href="#invite_students">Invite Students</a></li>
	<li><a href="#modules">Enable/Disable Modules</a></li>
</ul>
<div id="invite_students" class="tab-content">
<?php 
$invites = $table['invited'];
$modules = $table['modules'];
if(!empty($invites)){ 
?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>ID</th>
			<th>Student</th>
			<th>Invite</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($invites as $row){ ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo strtoupper($row['lname']) .', '. ucwords($row['fname']) .' '. ucwords($row['mname']); ?></td>
			<td><img src="/zenoir/img/add.png" class="icons" data-invitename="<?php echo strtoupper($row['lname']) .', '. ucwords($row['fname']); ?>" data-inviteid="<?php echo $row['id']; ?>"/></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
</div><!--end of invite students-->

<div id="modules" class="tab-content">
<?php if(!empty($modules)){ ?>
<table>
	<thead>
		<tr>
			<th>Module</th>
			<th>Description</th>
			<th>Enable/Disable</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($modules as $row){ ?>
		<tr>
			<td><?php echo $row['mod_title']; ?></td>
			<td><?php echo $row['mod_description']; ?></td>
			<td>
			<?php if($row['status'] == 1){ ?>
			<input type="checkbox" class="endis_module" data-classmoduleid="<?php echo $row['classmodule_id']; ?>" checked/>
			<?php }else{ ?>
			<input type="checkbox" class="endis_module" data-classmoduleid="<?php echo $row['classmodule_id']; ?>"/>
			<?php } ?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
</div><!--end of modules-->
