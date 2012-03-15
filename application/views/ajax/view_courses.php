
<div id="modal_header">
<h4>Associated Classes</h4>
</div>
<?php if(!empty($page)){ ?>
<table class="tbl_classes">
<thead>
	<tr>
		<th>Class Code</th>
		<th>Class Description</th>
		<th>Subject</th>
		<th>Teacher</th>
	</tr>
</thead>
<tbody>
<?php foreach($page as $v){ ?>
	<tr>
		<td><?php echo $v[4]; ?></td>
		<td><?php echo $v[3]; ?></td>
		<td><?php echo $v[5]; ?></td>
		<td><?php echo strtoupper($v[2]) . ',  '. ucwords($v[0]) . ' ' . ucwords($v[1]);  ?></td>
	</tr>
<?php } ?>
</tbody>
</table>
<?php } ?>