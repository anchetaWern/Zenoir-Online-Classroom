<!--view handout-->
<?php
$handout = $page;
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
		Attached Files:
		<?php foreach($handout['handout_files'] as $row){ ?>
			<li><a href="/zenoir/index.php/ajax_loader/view/view_file?fid=<?php echo $row['file_id']; ?>" class="lightbox"><?php echo $row['filename']; ?></a></li>
		<?php } ?>
	</div>
</div><!--end of container-->