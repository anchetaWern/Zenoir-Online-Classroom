<!--teacher and student landing page-->
<!--Selection of class to enter-->
<!--only classes where the teacher or student belong will show up here-->
<h4>[Dashboard]</h4>
<?php
$user_type 	= $this->session->userdata('usertype');
$classes 	= $table['classes'];
$people		= $table['people'];
$invites	= $table['invites'];
$grp_invites= $table['grp_invites'];
$expired	= $table['expired'];
$unreads	= $table['unreads'];
$old_classes=$table['old_classes'];
?>

<ul class="tabs left">
	<li><a href="#classes">Classes</a></li>
	<li><a href="#notifications">Notifications</a></li>
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
			<th>Subject</th>
			<th>Course</th>
			
		</tr>
	</thead>
	<tbody>
		<?php foreach($classes as $v){ ?>
		<tr>
			<td><a href="/zenoir/index.php/class_loader/view/class_home" data-classid="<?php echo $v[5]; ?>"><?php echo $v[0] .' - '.$v[1]; ?></a></td><!--enter class-->
			<td><?php echo $v[2]; ?></td>
			<td><?php echo $v[3]; ?></td>
			
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
</div><!--end of classes-->


<div id="notifications" class="tab-content">
<!--for the student-->
<?php if(!empty($invites)){ ?>
<p>
Classroom invites
</p>
<table>
	<thead>
		<tr>
			<th>Class</th>
			<th>Teacher</th>
			<th>Accept</th>
			<th>Decline</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($invites as $row){ ?>
		<tr>
			<td><?php echo $row['class_code'] .' - '. $row['class_description']; ?></td>
			<td><?php echo strtoupper($row['lname']) .', '. ucwords($row['fname']);  ?></td>
			<td><a href="#"><img src="/zenoir/img/confirm.gif" class="icons" data-studentid="<?php echo $row['student_id']; ?>" data-classid="<?php echo $row['class_id']; ?>"/></a></td>
			<td><a href="#"><img src="/zenoir/img/decline.png" class="icons" data-decline="<?php echo $row['student_id']; ?>" data-classid="<?php echo $row['class_id']; ?>"/></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>

<!--for the teacher - classes that has expired-->
<?php if(!empty($expired)){ ?>
<p>
Classes to lock
</p>
<table>
	<thead>
		<tr>
			<th>Class</th>
			<th>Lock Date</th>
			<th>Lock</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($expired as $row){ ?>
		<tr>
			<td><?php echo $row['class_code'] .' - '.$row['class_description']; ?></td>
			<td><?php echo $row['date_lock']; ?></td>
			<td><a href="#"><img src="/zenoir/img/unlock.png" data-lock="<?php echo $row['class_id']; ?>"></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>

<!--group invites-->
<?php if(!empty($grp_invites)){ ?>
<p>
Group Invites
</p>
<table>
	<thead>
		<tr>
			<th>Group</th>
			<th>Creator</th>
			<th>Class</th>
			<th>Accept</th>
			<th>Decline</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($grp_invites as $row){ ?>
		<tr>
			<td><?php echo $row['group_name']; ?></td>
			<td><?php echo strtoupper($row['lname']) .', '. ucwords($row['fname']);  ?></td>
			<td><?php echo $row['class_code'] .' - '. $row['class_description']; ?></td>
			<td><a href="#"><img src="/zenoir/img/confirm.gif" class="icons" data-grpaccept="<?php echo $row['user_id']; ?>" data-groupid="<?php echo $row['group_id']; ?>"/></a></td>
			<td><a href="#"><img src="/zenoir/img/decline.png" class="icons" data-grpdecline="<?php echo $row['user_id']; ?>" data-groupid="<?php echo $row['group_id']; ?>"/></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
</div><!--end of notifications-->


<div id="people" class="tab-content"><!--list of all people from all the classes that you are part of previously or currently-->
<?php if(!empty($people)){ ?>
	<table class="tbl_classes">
		<thead>
			<tr>
				<th>Fullname</th>
				<th>Class</th>
				<th>View</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($people as $row){ ?>
			<tr>
				<td>
				<?php $online = $row['online']; ?>
				<?php echo strtoupper($row['lname']) . ', ' . ucwords($row['fname']) . ' ' . ucwords($row['mname']);  ?>
				<?php if($online == 1){ ?>
				<img src="/zenoir/img/online.png"/>
				<?php } ?>
				</td>
				<td><?php echo $row['class_code'] .' - '. $row['class_description'];  ?></td>
				<td><a href="/zenoir/index.php/ajax_loader/view/view_user" class="lightbox" data-id="<?php echo $row['id']; ?>"><img src="/zenoir/img/view.png" class="icons"/></a></td>
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
				<th>Timestamp</th>
				<th>Class</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($unreads as $row){ ?>
			<tr>
				<td><?php echo $row['post_title']; ?></td>
				<td><?php echo $row['post_type']; ?></td>
				<td><?php echo date('Y-m-d', strtotime($row['post_time'])) . ' ' . date('g:i:s A', strtotime($row['post_time'])); ?></td>
				<td><?php echo $row['class_code'] .' - '. $row['class_description']; ?></td>
				
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
			<th>Class</th>
			<th>Subject</th>
			<th>Course</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($old_classes as $v){ ?>
		<tr>
			<td><a href="/zenoir/index.php/class_loader/view/class_home" data-classid="<?php echo $v[5]; ?>"><?php echo $v[0] .' - '. $v[1]; ?></a></td><!--enter class-->
			<td><?php echo $v[2]; ?></td>
			<td><?php echo $v[3]; ?></td>
			<td><?php echo $v[4]; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
</div><!--end of previous-->



