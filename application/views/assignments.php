<!--assignments-->

<!--new assignment-->
<p>
<a href="/zenoir/index.php/ajax_loader/view/new_assignment" class="lightbox">Create New</a>
</p>

<?php 
$assignments = $table;
?>
<!--existing assignments both done, read, and not done-->
<?php if(!empty($table)){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>Date Created</th>
			<th>Deadline</th>
			<th>Edit</th><!--teacher & admin only-->
			<th>View</th><!--teacher and student-->
		</tr>
	</thead>
	<tbody>
		<?php foreach($assignments as $row){ ?>
		<tr>
			<td><?php echo $row['title']; ?></td>
			<td><?php echo $row['date']; ?></td>
			<td><?php echo $row['deadline']; ?></td>
			<td><a href="" class="ligtbox"><img src="/zenoir/img/update.png" class="icons"/></a></td>
			<td><a href="/zenoir/index.php/ajax_loader/view/view_assignment" data-id="<?php echo $row['assignment_id']; ?>" class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>