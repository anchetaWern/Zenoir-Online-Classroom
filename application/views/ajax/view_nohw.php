<!--no assignment-->
<?php 
$noassignment = $page; 
?>
<div id="modal_header">
<h4>Students without assignment</h4>
</div>
<?php if(!empty($noassignment)){ ?>
<div id="scrolls">
<p>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Student</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($noassignment as $row){ ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo strtoupper($row['lname']) . ', ' .ucwords($row['fname']) . ' ' .ucwords($row['mname']); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
</p>
</div>
<?php } ?>
<script>
$('#scrolls').jScrollPane({autoReinitialise: true});
</script>