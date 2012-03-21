<!--teacher and student landing page-->
<!--Selection of class to enter-->
<!--only classes where the teacher or student belong will show up here-->
<?php
$user_type 	= $this->session->userdata('usertype');
$classes 	= $table['classes'];
$invites	= $table['invites'];
?>
<ul class="tabs left">
	<li><a href="#classes">Classes</a></li>
	<?php if($user_type == 3){ ?>
	<li><a href="#notifications">Invites</a></li>
	<?php } ?>
</ul>

<div id="classes" class="tab-content">
<table>
	<thead>
		<tr>
			<th>Class Code</th>
			<th>Description</th>
			<th>Subject</th>
			<th>Course</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($classes as $v){ ?>
		<tr>
			<td><a href="/zenoir/index.php/class_loader/view/class_home" data-classid="<?php echo $v[5]; ?>"><?php echo $v[0]; ?></a></td><!--enter class-->
			<td><?php echo $v[1]; ?></td>
			<td><?php echo $v[2]; ?></td>
			<td><?php echo $v[3]; ?></td>
			<td><?php echo $v[4]; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</div><!--end of classes-->

<?php if($user_type == 3){ ?>
<div id="notifications" class="tab-content">
<?php if(!empty($invites)){ ?>
<table>
	<thead>
		<tr>
			<th>Class Code</th>
			<th>Description</th>
			<th>Teacher</th>
			<th>Accept</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($invites as $row){ ?>
		<tr>
			<td><?php echo $row['class_code']; ?></td>
			<td><?php echo $row['class_description']; ?></td>
			<td><?php echo strtoupper($row['lname']) .', '. ucwords($row['fname']);  ?></td>
			<td><a href="#"><img src="/zenoir/img/confirm.gif" class="icons" data-studentid="<?php echo $row['student_id']; ?>" data-classid="<?php echo $row['class_id']; ?>"/></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
</div><!--end of notifications-->
<?php } ?>



