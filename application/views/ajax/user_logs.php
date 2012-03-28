<!--user logs-->

<?php
$user = $page['user_info'];
$logs = $page['logs'];
?>
<div id="modal_header">
<h4>View User Logs - <?php echo strtoupper($user[2]) .', '. ucwords($user[0]) . ' ' . ucwords($user[1]);  ?></h4>
</div>

<div class="container">
<?php if(!empty($logs)){ ?>
<div id="scrolls">
<p>
	<table>
		<thead>
			<tr>
				<th>Activity</th>
				<th>Date</th>
				<th>Time</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($logs as $row){ ?>
			<tr>
				<td><?php echo $row['act']; ?></td>
				<td><?php echo date('Y-m-d', strtotime($row['datetime'])); ?></td>
				<td><?php echo date('g:i:s A', strtotime($row['datetime'])); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</p>
</div>
<?php } ?>
</div>
<script>
$('#scrolls').jScrollPane({autoReinitialise: true});
</script>