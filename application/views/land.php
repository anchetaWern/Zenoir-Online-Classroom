<!--teacher and student landing page-->
<!--Selection of class to enter-->
<!--only classes where the teacher or student belong will show up here-->

<table class="tbl_classes">
	<thead>
		<tr>
			<th>Class Code</th>
			<th>Description</th>
			<th>Subject</th>
			<th>Course</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($table as $v){ ?>
		<tr>
			<td><a href="/zenoir/index.php/class_loader/view/class_home" data-classid="<?php echo $v[5]; ?>"><?php echo $v[0]; ?></a></td><!--enter class-->
			<td><?php echo $v[1]; ?></td>
			<td><?php echo $v[2]; ?></td>
			<td><?php echo $v[3]; ?></td>
			<td><?php echo $v[4]; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

