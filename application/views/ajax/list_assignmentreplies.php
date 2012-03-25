<!--list of responses to a specific assignment-->
<?php 
$replies = $page;

$back	= array(
			'id'=>'back',
			'name'=>'back',
			'value'=>'Back to Assignment',
			'content'=>'Back to Assignment',
			'class'=>'medium orange'
		);
?>
<div id="modal_header">
<h4>Assignment Replies - <?php echo $replies['as_title']; ?></h4>
</div>
<div class="container">
<?php if(!empty($replies['replies'])){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>Date</th>
			<th>Sender</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($replies['replies'] as $row){ ?>
		<tr>
			<td>
			<?php echo $row['res_title']; ?>
			<?php if($row['status']){ ?>
			<span class="red_star">*</span>
			<?php } ?>
			</td>
			<td><?php echo date('Y-m-d g:i:s A', strtotime($row['res_date'])); ?></td>
			<td><?php echo $row['sender']; ?></td>
			<td><a href="/zenoir/index.php/ajax_loader/view/view_assignmentreply" data-id="<?php echo $row['res_id']; ?>" class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
<p>
<a href="/zenoir/index.php/ajax_loader/view/view_assignment" data-id="<?php echo $replies['as_id']; ?>" class="lightbox">
<?php
echo form_button($back);
?>
</a>
</p>
</div>