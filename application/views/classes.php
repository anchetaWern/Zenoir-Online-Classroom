<!--class management-->

<h4>[Classes]</h4>
<p>
<a id="nc" href="" class="lightbox">Create New</a>
</p>
<?php
$img = array('lock.png', 'unlock.png');
$act = array('data-lock', 'data-unlock');
?>

<table class="tbl_classes">
	<thead>
		<tr>
			<th>Class Code</th>
			<th>Description</th>
			<th>Subject</th>
			<th>Course</th>
			<th>Teacher</th>
			<th>Unlock/Lock</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($table as $row){ ?>
		<tr>
			<td><?php echo $row['class_code']; ?></td>
			<td><?php echo $row['description']; ?></td>
			<td><?php echo $row['subject_description']; ?></td>
			<td><?php echo $row['course_yr_section']; ?></td>
			<td><?php echo strtoupper($row['lname']) .',  '. ucwords($row['fname']) . ' ' . ucwords($row['mname']); ?></td>
			<td>
			<a href="#">
			<img src="/zenoir/img/<?php echo $img[$row['status']]; ?>" <?php echo $act[$row['status']]; ?>="<?php echo $row['class_id']; ?>">
			</a>
			</td>
			<td><a href="/zenoir/index.php/class_loader/view/class_home" data-classid="<?php echo $row['class_id']; ?>"><img class="icons" src="/zenoir/img/view.png"/></a></td>
			
		</tr>
		<?php } ?>
	</tbody>
</table>
<script>
var datalist = 'options' in document.createElement('datalist');
if(datalist){
	$('#nc').attr('href', '/zenoir/index.php/ajax_loader/view/new_class?dl=1');
}else{
	$('#nc').attr('href', '/zenoir/index.php/ajax_loader/view/new_class?dl=2');
}
</script>