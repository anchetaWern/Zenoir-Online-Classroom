<!--no assignment-->
<?php 
$students = $page['students']['students'];//students with no assignment 
$details	= $page['details'];

$back	= array(
			'id'=>'back',
			'name'=>'back',
			'value'=>'Back to Assignment',
			'content'=>'Back to Assignment',
			'class'=>'medium orange'
		);
?>
<div id="modal_header">
<h4>Students without assignment - <?php echo $details['title']; ?></h4>
</div>
<?php if(!empty($students)){ ?>
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
	<?php foreach($students as $row){ ?>
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

<p>
<a href="/zenoir/index.php/ajax_loader/view/view_assignment" data-id="<?php echo $details['id']; ?>" class="lightbox">
<?php
echo form_button($back);
?>
</a>
</p>
<script>
$('#scrolls').jScrollPane({autoReinitialise: true});
</script>