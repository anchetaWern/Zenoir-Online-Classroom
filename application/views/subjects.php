<!--subjects management-->
<h4>[Subjects]</h4>
<p>
<a href="<?php echo $this->config->item('ajax_base'); ?>new_subject" class="lightbox">Create New</a>
</p>
<?php
$subjects = $table;
?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Subject Code</th>
			<th>Description</th>
			<th>Edit</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($subjects as $k=>$v){ ?>
		<tr>
			<td><?php echo $v[0]; ?></td>
			<td><?php echo $v[1]; ?></td>
			<td><a href="<?php echo $this->config->item('ajax_base'); ?>edit_subject" class="lightbox" data-id="<?php echo $v[2]; ?>"><img class="icons" src="/zenoir/img/update.png" /></a></td>
			<td><a href="<?php echo $this->config->item('ajax_base'); ?>view_subjects" class="lightbox" data-id="<?php echo $v[2]; ?>"><img class="icons" src="/zenoir/img/view.png"/></a></td><!--view classes associated-->
		</tr>
		<?php } ?>
	</tbody>
</table>