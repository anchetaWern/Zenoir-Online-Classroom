<!--no quiz-->
<?php
$noquiz = $table;
?>
<div id="modal_header">
<h4>Students without a quiz</h4>
</div>
<div class="content">
<?php if(!empty($noquiz)){ ?>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Student</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($noquiz as $row){ ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo strtoupper($row['lname']) . ', ' .ucwords($row['fname']) . ' ' .ucwords($row['mname']); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<?php } ?>
</div>