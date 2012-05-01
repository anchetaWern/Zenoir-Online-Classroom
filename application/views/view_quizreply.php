<!--view quiz response-->
<?php

$quiz_response = $table['reply'];
$files = $table['files'];

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
<div id="quizresponse_files">
	<?php if(!empty($files)){ ?>
		Attached Files:
		<?php foreach($files as $row){ ?>
			<li><a href="<?php echo $this->config->item('ajax_base'); ?>view_file?fid=<?php echo $row['file_id']; ?>" class="lightbox"><?php echo $row['filename']; ?></a></li>
		<?php } ?>
	<?php } ?>	
</div><!--end of quizresponse_files-->
<p>
<a href="<?php echo $this->config->item('page_base'); ?>list_quizreplies/<?php echo $quiz_response['quiz_id']; ?>" data-id="<?php echo $quiz_response['quiz_id']; ?>">
<?php
echo form_button($back);
?>
</a>
</p>