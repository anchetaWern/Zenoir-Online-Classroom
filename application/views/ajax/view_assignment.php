<!--viewing of assignment-->
<?php
$assignment = $page['details']['assignment'];
$files 		= $page['details']['files'];
$response	= $page['response'];//response by the current student if any

$reply	= array(
			'id'=>'reply_assignment',
			'name'=>'reply_assignment',
			'value'=>'Reply',
			'content'=>'Reply',
			'class'=>'medium orange'
		);
		
$viewreply=array(
			'id'=>'view_assignment',
			'name'=>'view_assignment',
			'value'=>'View Reply',
			'content'=>'View Reply',
			'class'=>'medium orange'
		);
		
		
$view	= array(
			'id'=>'view_assignmentreplies',
			'name'=>'view_assignmentreplies',
			'value'=>'View Responses',
			'content'=>'View Responses',
			'class'=>'medium orange'
		);

$view_no	= array(
			'id'=>'view_noreply',
			'name'=>'view_noreply',
			'value'=>'View No Response',
			'content'=>'View No Response',
			'class'=>'medium red'
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
	<li><a href="/zenoir/index.php/ajax_loader/view/view_file?fid=<?php echo $row['file_id']; ?>" class="lightbox"><?php echo $row['filename']; ?></a></li>
<?php } ?>
</div>


<?php if($this->session->userdata('usertype') == 3){ ?>
<?php if($response == 0){ ?>
<!--reply button for student-->
<a href="/zenoir/index.php/ajax_loader/view/assignment_reply" data-id="<?php echo $assignment['as_id']; ?>" class="lightbox">
<?php echo form_button($reply); ?>
</a>
<?php }else{ ?>
<!--view reply if current student has already replied-->
<a href="/zenoir/index.php/ajax_loader/view/view_assignmentreply" data-id="<?php echo $response; ?>" class="lightbox">
<?php echo form_button($viewreply); ?>
</a>
<?php } ?>
<?php } ?>

<!--assignment responses-->
<?php if($this->session->userdata('usertype') == 1 || $this->session->userdata('usertype') == 2){ ?>
<a href="/zenoir/index.php/ajax_loader/view/list_assignmentreplies" data-id="<?php echo $assignment['as_id']; ?>" class="lightbox">
<?php echo form_button($view); ?>
</a>
<a href="/zenoir/index.php/ajax_loader/view/view_nohw" class="lightbox"><?php echo form_button($view_no); ?></a>
<?php } ?>
</div><!--end of container-->
