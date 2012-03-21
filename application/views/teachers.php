<!--teachers class settings-->
<!--
1. invite existing students to the current classroom
2. enable/disable modules
3. remove students from the current classroom
-->

<?php 
$invites = $table;

if(!empty($invites)){ 
?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>ID</th>
			<th>Student</th>
			<th>Invite</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($invites as $row){ ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo strtoupper($row['lname']) .', '. ucwords($row['fname']) .' '. ucwords($row['mname']); ?></td>
			<td><img src="/zenoir/img/add.png" class="icons" data-invitename="<?php echo strtoupper($row['lname']) .', '. ucwords($row['fname']); ?>" data-inviteid="<?php echo $row['id']; ?>"/></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
