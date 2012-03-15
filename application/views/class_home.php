<!--home page for teacher and students-->
<?php
$user_type = $this->session->userdata('usertype');

//classroom information
$class_info = $this->session->userdata('classroom_info');
$class_code = $class_info['class_code'];
$class_desc = $class_info['class_desc'];
$teacher	= ucwords($class_info['fname'] . ' ' .$class_info['lname']);


?>

<div id="class_title">
<h6>
<?php 
echo $class_code.'<br/>'; 
echo $class_desc . ' - '. $teacher; 
?>
</h6>
</div>
<ul class="tabs left">
	<li><a href="#main">Menu</a></li>
</ul>
<div id="main" class="tab-content">
	<table>
		<tbody>
			<tr>
				<td><a href="/zenoir/index.php/class_loader/view/assignments"><button class="large orange">Assignments</button></a></td>
				<td><a href=""><button class="large blue">Messages</button></a></td>
				<?php if($user_type == 2 || $user_type == 1){?>
				<td><a href=""><button class="large">Reports</button></a></td><!--teacher & admin accessible-->
				<?php } ?>
			</tr>
			<tr>
				<td><a href=""><button class="large green">Quizzes</button></a></td>
				<td><a href=""><button class="large">Sessions</button></a></td>
				<?php if($user_type == 2 || $user_type == 1){?>
				<td><a href=""><button class="large">Teacher</button></a></td><!--teacher & admin accessible-->
				<?php } ?>
			</tr>
			<tr>
				<td><a href="/zenoir/index.php/class_loader/view/handouts"><button class="large red">Handouts</button></a></td>
				<td><a href="/zenoir/index.php/class_loader/view/land"><button class="large pink">Dashboard</button></a></td>
				<?php if($user_type == 1){ ?>
				<td><a href=""><button class="large">Admin</button></a></td><!--admin accessible-->
				<?php } ?>
			</tr>
			
			
		
		</tbody>
	</table>
</div>


