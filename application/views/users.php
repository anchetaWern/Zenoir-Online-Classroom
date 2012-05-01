<!--teacher management-->
<h4>[Users]</h4>
<p>
<a href="<?php echo $this->config->item('ajax_base'); ?>new_user" class="lightbox">Create New</a>
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
			<th>Enable</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $k=>$v){?>
		<tr>
			<td><?php echo strtoupper($v[2]) . ',  ' .  ucwords($v[0]) . ' ' . ucwords($v[1]); ?></td>
			<td><?php echo $v[3]; ?></td>
			<td><a href="<?php echo $this->config->item('ajax_base'); ?>view_user" data-id="<?php echo $v[4]; ?>" class="lightbox"><img class="icons" src="/zenoir/img/view.png"/></a></td><!--view user info and logs-->
			<td><a href="#"><img src="/zenoir/img/confirm.gif" class="icons" data-enable="<?php echo $v[4]; ?>"/></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>