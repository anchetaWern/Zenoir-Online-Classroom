<!--view handout-->
<?php
$handout = $page;

$view	= array(
			'id'=>'view_opened',
			'name'=>'view_opened',
			'value'=>'Who did not open?',
			'content'=>'Who did not open?',
			'class'=>'medium red'
		);

?>
<div id="modal_header">
<h4>View Handout - <?php echo $handout['ho_title']; ?></h4>
</div>

<div class="container">
	<div id="handout_date">
		Date:
		<?php echo $handout['ho_date']; ?>
	</div>

	<div id="handout_body">
		<pre>
		<?php echo $handout['ho_body']; ?>
		</pre>
	</div>

	<div id="handout_files">
	<?php if(!empty($handout['handout_files'])){ ?>
		Attached Files:
		<?php foreach($handout['handout_files'] as $row){ ?>
			<li><a href="<?php echo $this->config->item('ajax_base'); ?>view_file?fid=<?php echo $row['file_id']; ?>" class="lightbox"><?php echo $row['filename']; ?></a></li>
		<?php } ?>
	<?php } ?>	
	</div>
	<p>
	<?php if($this->session->userdata('usertype') <= 2){//view a list of students who opened the current handout
	?>
	<a href="<?php echo $this->config->item('ajax_base'); ?>view_nohandout" class="lightbox">
	<?php	echo form_button($view); ?>
	</a>
	<?php
	}
	?>
	</p>
</div><!--end of container-->