<!--assignments-->
<h4>[Assignments]</h4>
<?php if($this->session->userdata('usertype') != 3){ ?>
<p>
<a href="<?php echo $this->config->item('ajax_base'); ?>new_assignment" class="lightbox">Create New</a>
</p>
<?php } ?>

<?php 
$assignments = $table;
?>
<div class="tbl_view">
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
			if($this->session->userdata('usertype') == 3){//student
				if($row['student_status'] == 1){
			?>
				<span class="red_star" id="<?php echo $row['assignment_id']; ?>">*</span>
			<?php
				}
			}else if($this->session->userdata('usertype') == 2){//teacher
				if($row['teacher_status'] > 0){
			?>		
				<span class="red_star" id="<?php echo $row['assignment_id']; ?>">*</span>	
			<?php		
				}
			}
			?>
			
			</td>
			<td><?php echo $row['date']; ?></td>
			<td><?php echo date('Y-m-d g:i:s A', strtotime($row['deadline'])); ?></td>
			<td><a href="<?php echo $this->config->item('ajax_base'); ?>view_assignment/<?php echo $row['assignment_id']; ?>" data-id="<?php echo $row['assignment_id']; ?>" class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
</div>