<!--list of quiz response-->
<?php
$quiz	= $table['quiz'];
$replies= $table['replies'];


$back	= array(
			'id'=>'back',
			'name'=>'back',
			'value'=>'Back to Quiz',
			'content'=>'Back to Quiz',
			'class'=>'medium blue'
		);
?>
<div id="modal_header">
<h4>View Quiz Replies - <?php echo $quiz['quiz_title']; ?></h4>
</div>
<?php if(!empty($replies)){ ?>
<table>
	<thead>
		<tr>
			<th>Title</th>
			<th>Time Submitted</th>
			<th>Student</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($replies as $row){ ?>
		<tr>
			<td>
			<?php echo $row['title']; ?>
			<?php if($row['status']){ ?>
			<span class="red_star" id="<?php echo $row['id']; ?>">*</span>
			<?php } ?>
			</td>
			<td><?php echo date('Y-m-d g:i:s A', strtotime($row['datetime'])); ?></td>
			<td><?php echo strtoupper($row['lname']) . ', ' . ucwords($row['fname']) . ' ' . ucwords($row['mname']); ?></td>
			<td><a href="/zenoir/index.php/class_loader/view/view_quizreply" data-id="<?php echo $row['id']; ?>" data-sid="<?php echo $row['status_id']; ?>"><img src="/zenoir/img/view.png" class="icons"/></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
<a href="/zenoir/index.php/class_loader/view/view_quiz" data-id="<?php echo $quiz['quiz_id']; ?>">
<?php
echo form_button($back);
?>
</a>

