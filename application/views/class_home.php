<!--home page for teacher and students-->
<?php
$user_type = $this->session->userdata('usertype');
$unread = $table['posts'];
$active_sessions = $table['sessions'];//number of active sessions
?>

<ul class="tabs left">
	<li><a href="#main">Menu</a></li>
</ul>

<div id="main" class="tab-content">
	<table>
		<tbody>
			<tr>
				<td><a href="<?php echo $this->config->item('page_base'); ?>assignments"><button class="large orange">Assignments(<?php echo $unread['assignment'] + $unread['assignment_response'];  ?>)</button></a></td>
				<td><a href="<?php echo $this->config->item('page_base'); ?>messages"><button class="large blue">Messages(<?php echo $unread['message']; ?>)</button></a></td>
				<td>
				<?php if($user_type == 2 || $user_type == 1){?>
				<a href="<?php echo $this->config->item('page_base'); ?>reports"><button class="large">Reports</button></a>
				<?php } ?>
				</td><!--teacher & admin accessible-->
			</tr>
			<tr>
				<td><a href="<?php echo $this->config->item('page_base'); ?>quizzes"><button class="large green">Quizzes(<?php echo $unread['quiz'] + $unread['quiz_response'];  ?>)</button></a></td>
				<td><a href="<?php echo $this->config->item('page_base'); ?>sessions"><button class="large">Sessions(<?php echo $active_sessions;  ?>)</button></a></td>
				<td>
				<?php if($user_type == 2 || $user_type == 1){?>
				<a href="<?php echo $this->config->item('page_base'); ?>teachers"><button class="large">Settings</button></a>
				<?php } ?>
				</td><!--teacher & admin accessible-->
			</tr>
			<tr>
				<td><a href="<?php echo $this->config->item('page_base'); ?>handouts"><button class="large red">Handouts(<?php echo $unread['handout'];  ?>)</button></a></td>
				<td><a href="<?php echo $this->config->item('page_base'); ?>land"><button class="large pink">Dashboard</button></a></td>
				<td>
			
				</td><!--admin accessible-->
			</tr>
			
			
		
		</tbody>
	</table>
</div>