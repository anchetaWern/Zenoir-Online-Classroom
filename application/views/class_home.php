<!--home page for teacher and students-->
<?php
$user_type = $this->session->userdata('usertype');
$unread = $table;
?>

<ul class="tabs left">
	<li><a href="#main">Menu</a></li>
</ul>

<div id="main" class="tab-content">
	<table>
		<tbody>
			<tr>
				<td><a href="/zenoir/index.php/class_loader/view/assignments"><button class="large orange">Assignments(<?php echo $unread['assignment'] + $unread['assignment_response'];  ?>)</button></a></td>
				<td><a href="/zenoir/index.php/class_loader/view/messages"><button class="large blue">Messages(<?php echo $unread['message']; ?>)</button></a></td>
				<td>
				<?php if($user_type == 2 || $user_type == 1){?>
				<a href="/zenoir/index.php/class_loader/view/reports"><button class="large">Reports</button></a>
				<?php } ?>
				</td><!--teacher & admin accessible-->
			</tr>
			<tr>
				<td><a href="/zenoir/index.php/class_loader/view/quizzes"><button class="large green">Quizzes(<?php echo $unread['quiz'] + $unread['quiz_response'];  ?>)</button></a></td>
				<td><a href="/zenoir/index.php/class_loader/view/sessions"><button class="large">Sessions(<?php echo $unread['session'];  ?>)</button></a></td>
				<td>
				<?php if($user_type == 2 || $user_type == 1){?>
				<a href="/zenoir/index.php/class_loader/view/teachers"><button class="large">Teacher</button></a>
				<?php } ?>
				</td><!--teacher & admin accessible-->
			</tr>
			<tr>
				<td><a href="/zenoir/index.php/class_loader/view/handouts"><button class="large red">Handouts(<?php echo $unread['handout'];  ?>)</button></a></td>
				<td><a href="/zenoir/index.php/class_loader/view/land"><button class="large pink">Dashboard</button></a></td>
				<td>
			
				</td><!--admin accessible-->
			</tr>
			
			
		
		</tbody>
	</table>
</div>


