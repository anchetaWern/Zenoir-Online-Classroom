<!--reports-->
<h4>[Reports]</h4>
<?php 
$students = $table;
?>

<?php if(!empty($table)){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>ID</th>
			<th>Student</th>
			<th>View Info</th>
			
		</tr>
	</thead>
	<tbody>
	<?php foreach($students as $row){ ?>
		<tr>
			
			<td><?php echo $row['id']; ?></td>
			<td><?php echo strtoupper($row['lname']) . ', ' . ucwords($row['fname']) . ' ' . $row['mname']; ?></td>
			<td><a href="/zenoir/index.php/ajax_loader/view/view_user" data-id="<?php echo $row['id']; ?>" class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
			
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
