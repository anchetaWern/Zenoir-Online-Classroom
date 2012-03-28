<!--messages-->
<h4>[Messages]</h4>
<p>
<a href="/zenoir/index.php/ajax_loader/view/new_message" class="lightbox">Create New</a>
</p>

<ul class="tabs left">
	<li><a href="#inbox">Inbox</a></li>
	<li><a href="#outbox">Outbox</a></li>
</ul>
<div id="inbox" class="tab-content">

<?php 
$inbox 	= $table['inbox'];
$outbox	= $table['outbox'];
?>
<div class="tbl_view">
<?php if(!empty($inbox)){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>From</th>	
			<th>Date</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($inbox as $row){ ?>
		<tr>
			<td>
			<?php echo $row['msg_title']; ?>
			<?php if($row['status'] == 1){ ?>
			<span class="red_star" id="<?php echo $row['msg_id']; ?>">*</span>
			<?php } ?>
			</td>
			<td><?php echo strtoupper($row['lname']) . ', ' . ucwords($row['fname']); ?></td>
			<td><?php echo date('Y-m-d g:i:s A', strtotime($row['date_sent'])); ?></td>
			<td><a href="/zenoir/index.php/ajax_loader/view/view_message" data-id="<?php echo $row['msg_id']; ?>" data-msgid="<?php echo $row['msg_id']; ?>" class="lightbox"><img class="icons" src="/zenoir/img/view.png"/></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
</div><!--end of tbl_view-->
</div><!--end of inbox-->

<div id="outbox" class="tab-content">
<div class="tbl_view">
<?php if(!empty($outbox)){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>To</th>	
			<th>Date</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($outbox as $row){ ?>
		<tr>
			<td><?php echo $row['msg_title']; ?></td>
			<td><?php echo strtoupper($row['lname']) . ', ' . ucwords($row['fname']); ?></td>
			<td><?php echo date('Y-m-d g:i:s A', strtotime($row['date_sent'])); ?></td>
			<td><a href="/zenoir/index.php/ajax_loader/view/view_message" data-id="<?php echo $row['msg_id']; ?>" data-msgid="<?php echo $row['msg_id']; ?>" class="lightbox"><img class="icons" src="/zenoir/img/view.png"/></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
</div><!--end of tbl_view-->
</div><!--end of outbox-->