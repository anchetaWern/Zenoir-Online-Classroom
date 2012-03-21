<!--sessions-->
<!--sessions home-->
<?php
$sessions = $table;
$session_types = array('Class', 'Masked', 'Team');
?>
<div class="content">
<p>
Create New:
</p>
<p>

<?php if($this->session->userdata('usertype') != 3){//only teacher can create masked and class session ?>
<span class="spacer"><a href="/zenoir/index.php/ajax_loader/view/new_classsession" data-sestype="1" class="lightbox">Masked Session</a></span>
<span class="spacer"><a href="/zenoir/index.php/ajax_loader/view/new_classsession" data-sestype="2" class="lightbox">Class Session</a></span>
<?php } ?>
<span class="spacer"><a href="/zenoir/index.php/ajax_loader/view/new_classsession" data-sestype="3" class="lightbox">Team Session</a></span>
</p>

<?php if(!empty($sessions)){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>Description</th>
			<th>Type</th>
			<th>Date</th>
			<th>Always Open</th>
			<th>From</th>
			<th>To</th>
			<th>Join</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($sessions as $row){ ?>
		<tr>
			<td><?php echo $row['title']; ?></td>
			<td><?php echo $row['description']; ?></td>
			<td><?php echo $session_types[$row['type'] - 1]; ?></td>
			<td><?php echo $row['date']; ?></td>
			<td>
			<?php 
			if($row['infinite'] == 1){ 
				echo "YES";
			}else{
				echo "NO";
			} 
			?>
			</td>
			<td><?php echo date('g:i:s A', strtotime($row['from'])); ?></td>
			<td><?php echo date('g:i:s A', strtotime($row['to'])); ?></td>
			<td><a href="/zenoir/index.php/ajax_loader/view/join_session" class="lightbox" data-sestype="<?php echo $row['type']; ?>" data-id="<?php echo $row['id']; ?>"><img src="/zenoir/img/take.png" class="icons"/></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>

</div>
