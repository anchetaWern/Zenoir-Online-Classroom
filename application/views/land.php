<!--teacher and student landing page-->
<!--Selection of class to enter-->
<!--only classes where the teacher or student belong will show up here-->
<h4>[Dashboard]</h4>
<?php
$user_type 	= $this->session->userdata('usertype');
$classes 	= $table['classes'];
$people		= $table['people'];
$invites	= $table['invites'];
$unreads	= $table['unreads'];
$old_classes=$table['old_classes'];
?>

<ul class="tabs left">
	<li><a href="#classes">Classes</a></li>
	<?php if($user_type == 3){ ?>
	<li><a href="#notifications">Invites</a></li>
	<?php } ?>
	<li><a href="#people">People</a></li>
	<li><a href="#unreads">Unread Posts</a></li>
	<li><a href="#previous">Previous Classes</a></li>
</ul>

<div id="classes" class="tab-content">
<?php if(!empty($classes)){ ?>
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
<?php } ?>
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
			<th>Decline</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($invites as $row){ ?>
		<tr>
			<td><?php echo $row['class_code']; ?></td>
			<td><?php echo $row['class_description']; ?></td>
			<td><?php echo strtoupper($row['lname']) .', '. ucwords($row['fname']);  ?></td>
			<td><a href="#"><img src="/zenoir/img/confirm.gif" class="icons" data-studentid="<?php echo $row['student_id']; ?>" data-classid="<?php echo $row['class_id']; ?>"/></a></td>
			<td><a href="#"><img src="/zenoir/img/decline.png" class="icons" data-decline="<?php echo $row['student_id']; ?>" data-classid="<?php echo $row['class_id']; ?>"/></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
</div><!--end of notifications-->
<?php } ?>

<div id="people" class="tab-content"><!--list of all people from all the classes that you are part of previously or currently-->
<?php if(!empty($people)){ ?>
	<table class="tbl_classes">
		<thead>
			<tr>
				<th>Fullname</th>
				<th>Class Code</th>
				<th>Description</th>
				<th>View</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($people as $row){ ?>
			<tr>
				<td><?php echo strtoupper($row['lname']) . ', ' . ucwords($row['fname']) . ' ' . ucwords($row['mname']);  ?></td>
				<td><?php echo $row['class_code']; ?></td>
				<td><?php echo $row['class_description']; ?></td>
				<td><a href="#" class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
<?php } ?>
</div><!--end of people-->

<div id="unreads" class="tab-content">

<?php if(!empty($unreads)){ ?>
	<table>
		<thead>
			<tr>
				<th>Title</th>
				<th>Post Type</th>
				<th>Class Code</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($unreads as $row){ ?>
			<tr>
				<td><?php echo $row['post_title']; ?></td>
				<td><?php echo $row['post_type']; ?></td>
				<td><?php echo $row['class_code']; ?></td>
				<td><?php echo $row['class_description']; ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
<?php } ?>
</div><!--end of unreads-->



<div id="previous" class="tab-content">
<?php if(!empty($old_classes)){ ?>
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
		<?php foreach($old_classes as $v){ ?>
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
<?php } ?>
</div><!--end of previous-->



