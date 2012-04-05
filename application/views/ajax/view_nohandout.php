<!--no handout-->
<?php
$nohandout = $page;
?>
<div id="modal_header">
<h4>Students without handout</h4>
</div>
<?php if(!empty($nohandout)){ ?>
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
	<?php foreach($nohandout as $row){ ?>
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