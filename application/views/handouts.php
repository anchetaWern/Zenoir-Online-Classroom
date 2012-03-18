<!--handouts-->
<p>
<a href="/zenoir/index.php/ajax_loader/view/new_handout" class="lightbox">Create New</a>
</p>

<?php 
$handouts = $table;
?>
<!--existing assignments both done, read, and not done-->
<?php if(!empty($handouts)){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>Date Created</th>	
			<th>Edit</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($handouts as $row){ ?>
		<tr>
			<td><?php echo $row['ho_title']; ?></td>
			<td><?php echo $row['date_posted']; ?></td>
			<td><a href="" class="ligtbox"><img src="/zenoir/img/update.png" class="icons"/></a></td>
			<td><a href="/zenoir/index.php/ajax_loader/view/view_handout" data-id="<?php echo $row['handout_id']; ?>" class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>