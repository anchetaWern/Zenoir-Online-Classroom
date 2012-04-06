<!--view quiz response-->
<?php
$quiz_response = $table;

$back	= array(
			'id'=>'back',
			'name'=>'back',
			'value'=>'Back to Quiz Replies',
			'content'=>'Back to Quiz Replies',
			'class'=>'medium orange'
		);
?>
<div id="modal_header">
<h4>View Quiz Reply - <?php echo $quiz_response['res_title']; ?></h4>
</div>
<p>
Quiz: <?php echo $quiz_response['quiz_title']; ?>
</p>
<p>
Submitted by: <?php echo strtoupper($quiz_response['lname']) . ', ' . ucwords($quiz_response['fname']) . ' ' . ucwords($quiz_response['mname']); ?>
</p>
<p>
Time submitted: <?php echo date('Y-m-d g:i:s A', strtotime($quiz_response['datetime'])); ?>
</p>
<p>
<pre>
<?php echo $quiz_response['body']; ?>
</pre>
</p>
<p>
<p>
<a href="/zenoir/index.php/class_loader/view/list_quizreplies" data-id="<?php echo $quiz_response['quiz_id']; ?>">
<?php
echo form_button($back);
?>
</a>
</p>