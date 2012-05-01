<!--no quiz response-->
<?php
$noquizresponse = $table['students']['students'];//students with no quiz response
$quiz = $table['details'];

$back	= array(
			'id'=>'back',
			'name'=>'back',
			'value'=>'Back to Quiz',
			'content'=>'Back to Quiz',
			'class'=>'medium orange'
		);
?>
<div id="modal_header">
<h4>Students without a quiz - <?php echo $quiz['title']; ?></h4>
</div>
<div class="content">
<?php if(!empty($noquizresponse)){ ?>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Student</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($noquizresponse as $row){ ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo strtoupper($row['lname']) . ', ' .ucwords($row['fname']) . ' ' .ucwords($row['mname']); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<?php } ?>

<p>
<a href="<?php echo $this->config->item('page_base'); ?>view_quiz" data-id="<?php echo $quiz['id']; ?>">
<?php
echo form_button($back);
?>
</a>
</p>
</div>

