<!--viewing of assignment-->
<?php
$assignment = $page['assignment'];
$files 		= $page['files'];

$reply	= array(
			'id'=>'reply_assignment',
			'name'=>'reply_assignment',
			'value'=>'Reply',
			'content'=>'Reply',
			'class'=>'medium orange'
		);
		
$view	= array(
			'id'=>'view_assignmentreplies',
			'name'=>'view_assignmentreplies',
			'value'=>'View Response',
			'content'=>'View Response',
			'class'=>'medium'
		);
?>
<div id="modal_header">
<h4>View Assignment - <?php echo $assignment['as_title']; ?></h4>
</div>
<div class="container">
<div id="as_date">
Date: <?php echo $assignment['date']; ?>
</div>

<div id="as_deadline">
Deadline : <?php echo $assignment['deadline']; ?>
</div>

<div id="as_body">
	<pre>
	<?php echo $assignment['as_body']; ?>
	</pre>
</div>

<div id="files">

<?php foreach($files as $row){ ?>
	<li><a href="/zenoir/assets/downloader/" data-dl="<?php echo $row['file_id']; ?>"><?php echo $row['filename']; ?></a></li>
<?php } ?>
</div>

<a href="/zenoir/index.php/ajax_loader/view/assignment_reply" data-id="<?php echo $assignment['as_id']; ?>" class="lightbox">
<?php echo form_button($reply); ?>
</a>
<a href="/zenoir/index.php/ajax_loader/view/list_assignmentreplies" data-id="<?php echo $assignment['as_id']; ?>" class="lightbox">
<?php echo form_button($view); ?>
</a>
</div><!--end of container-->
