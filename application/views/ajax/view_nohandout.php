<!--no handout-->
<?php
$students = $page['students']['students'];
$handout = $page['details'];

$back	= array(
			'id'=>'back',
			'name'=>'back',
			'value'=>'Back to Handout',
			'content'=>'Back to Handout',
			'class'=>'medium blue'
		);
?>
<div id="modal_header">
<h4>Students without handout - <?php echo $handout['title']; ?></h4>
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
<a href="<?php echo $this->config->item('ajax_base'); ?>view_handout" data-id="<?php echo $handout['id']; ?>" class="lightbox">
<?php
echo form_button($back);
?>
</a>
</p>
<script>
$('#scrolls').jScrollPane({autoReinitialise: true});
</script>