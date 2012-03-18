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
			<li><a href="/zenoir/assets/downloader?id=<?php echo $row['file_id']; ?>"><?php echo $row['filename']; ?></a></li>
		<?php } ?>
	</div>
</div><!--end of container-->