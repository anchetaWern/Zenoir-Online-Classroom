<!--groups-->
<div id="modal_header">
<h4>Groups</h4>
</div>
<?php 

$groups 	= $page;
?>
<div class="container">
<p>
<a href="/zenoir/index.php/ajax_loader/view/new_group" class="lightbox">Create New</a>
</p>
<?php if(!empty($groups)){ ?>
<table>
	<thead>
		<tr>
			<th>Group Name</th>
			<th>Creator</th>
			<th>Update</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($groups as $row){ ?>
		<tr>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['creator']; ?></td>
			<td><a href="/zenoir/index.php/ajax_loader/view/edit_group" class="lightbox" data-id="<?php echo $row['group_id']; ?>"><img src="/zenoir/img/update.png" class="icons"/></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
</div>