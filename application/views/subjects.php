<!--subjects management-->
<h6>[Subjects]</h6>
<p>
<a href="/zenoir/index.php/ajax_loader/view/new_subject" class="lightbox">Create New</a>
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
			<td><a href="/zenoir/index.php/ajax_loader/view/edit_subject" class="lightbox" data-id="<?php echo $v[2]; ?>"><img class="icons" src="/zenoir/img/update.png" /></a></td>
			<td><a href="/zenoir/index.php/ajax_loader/view/view_subjects" class="lightbox" data-id="<?php echo $v[2]; ?>"><img class="icons" src="/zenoir/img/view.png"/></a></td><!--view classes associated-->
		</tr>
		<?php } ?>
	</tbody>
</table>