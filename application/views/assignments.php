<!--assignments-->
<h6>[Assignments]</h6>
<?php if($this->session->userdata('usertype') != 3){ ?>
<p>
<a href="/zenoir/index.php/ajax_loader/view/new_assignment" class="lightbox">Create New</a>
</p>
<?php } ?>

<?php 
$assignments = $table;
?>
<!--existing assignments both done, read, and not done-->
<?php if(!empty($table)){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>Date Created</th>
			<th>Deadline</th>
			<th>View</th><!--teacher and student-->
		</tr>
	</thead>
	<tbody>
		<?php foreach($assignments as $row){ ?>
		<tr>
			<td>
			<?php echo $row['title']; ?>
			<?php
			$combined_status = $row['student_status'];
			?>
			<?php if($combined_status >= 1){ ?>
			<span class="red_star">*</span>
			<?php } ?>
			</td>
			<td><?php echo $row['date']; ?></td>
			<td><?php echo $row['deadline']; ?></td>
			<td><a href="/zenoir/index.php/ajax_loader/view/view_assignment" data-id="<?php echo $row['assignment_id']; ?>" class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>