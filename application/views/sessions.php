<!--sessions-->
<h4>[Sessions]</h4>
<!--sessions home-->
<?php
$sessions = $table;
$session_types = array('Class', 'Masked', 'Team');
$yes_no = array('NO', 'YES');
?>
<div class="content">

<p>
<?php if($this->session->userdata('usertype') != 3){//only teacher can create masked and class session ?>
<span class="spacer"><a href="/zenoir/index.php/ajax_loader/view/new_classsession" data-sestype="2" class="lightbox">Masked Session</a></span>
<span class="spacer"><a href="/zenoir/index.php/ajax_loader/view/new_classsession" data-sestype="1" class="lightbox">Class Session</a></span>
<?php } ?>
<span class="spacer"><a href="/zenoir/index.php/ajax_loader/view/new_classsession" data-sestype="3" class="lightbox">Team Session</a></span>
</p>

<div class="tbl_view">
<?php if(!empty($sessions)){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>Description</th>
			<th>Type</th>
			<th>Always Open</th>
			<th>Date</th>
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
			<td>
			<?php echo $yes_no[$row['infinite']]; ?>
			</td>
			<?php if($row['infinite'] != 1){ ?>
			<td><?php echo $row['date']; ?></td>
			<td><?php echo date('g:i:s A', strtotime($row['from'])); ?></td>
			<td><?php echo date('g:i:s A', strtotime($row['to'])); ?></td>
			<?php }else{ ?>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<?php } ?>
			<td>
			<?php if($row['status'] == 1){ ?>
			<a href="/zenoir/index.php/ajax_loader/view/join_session?sesid=<?php echo $row['id']; ?>" class="lightbox" data-sestype="<?php echo $row['type']; ?>" data-id="<?php echo $row['id']; ?>">
			<img src="/zenoir/img/take.png" class="icons"/>
			</a>
			<?php }else{ ?>
			<img src="/zenoir/img/lock.png"/>
			<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
</div><!--end of tbl_view-->
</div><!--end of content-->