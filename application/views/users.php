<!--teacher management-->
<p>
<a href="/zenoir/index.php/ajax_loader/view/new_user" class="lightbox">Create New</a>
</p>
<?php 
$users = $table;
?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>User</th>
			<th>User Type</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $k=>$v){?>
		<tr>
			<td><?php echo strtoupper($v[2]) . ',  ' .  ucwords($v[0]) . ' ' . ucwords($v[1]); ?></td>
			<td><?php echo $v[3]; ?></td>
			<td><a href="" class="lightbox"><img class="icons" src="/zenoir/img/view.png"/></a></td><!--view user info and logs-->
		</tr>
		<?php } ?>
	</tbody>
</table>