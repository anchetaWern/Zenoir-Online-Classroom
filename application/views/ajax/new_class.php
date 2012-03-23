<!--creation of new classes-->
<script>
$(".date_picker").datepicker({ dateFormat: 'yy-mm-dd' });
</script>
<div id="modal_header">
<h4>Create New Class</h4>
</div>

<?php
$subjects = $page['subjects'];
$teachers = $page['users'];
$courses  = $page['courses'];

//inputs
$class_code	= array(
				'id'=>'class_code',
				'name'=>'class_code'
			);

$class_desc = array(
				'id'=>'class_desc',
				'name'=>'class_desc'
			);			

if($_GET['dl'] == 1){//browser has datalist support			
	$subject	= array(
					'id'=>'subject',
					'name'=>'subject',
					'list'=>'subjects'
				);
	$teacher	=array(
					'id'=>'teacher',
					'list'=>'teachers',
					'name'=>'teachers'
				);
	$course		= array(
					'id'=>'course',
					'name'=>'course',
					'list'=>'courses',
					'placeholder'=>'Eg. BSCS/4-3'
				);
}	
		
$date		= array(
				'id'=>'date_created',
				'name'=>'date_created',
				'class'=>'date_picker'
			);
			
$date_to	= array(
				'id'=>'date_to',
				'name'=>'date_to',
				'class'=>'date_picker'
			);

$addl		= array(
				'id'=>'addl_details',
				'name'=>'addl_details',
				'placeholder'=>'Eg. Semester, Class Notes'
			);			

$create 	= array(
				'id'=>'create_class',
				'name'=>'create_class',
				'value'=>'Create Class',
				'content'=>'Create Class',
				'class'=>'medium green'
			);
?>

<div class="container">
<?php
echo form_label('Class Code', 'class_code');
echo form_input($class_code);

echo form_label('Class Description', 'class_desc');
echo form_input($class_desc);
?>

<?php echo form_label('Subject', 'subject'); ?>

<?php
if($_GET['dl'] == 1){
	echo form_input($subject); 
}else{
?>
	<select name="subject" id="subject">
	<?php foreach($subjects as $row){ ?>
		<option value="<?php echo $row[2]; ?>"><?php echo $row[1]; ?></option>
	<?php } ?>	
	</select>
<?php } ?>


<?php echo form_label('Teacher', 'teacher'); ?>
<?php
if($_GET['dl'] == 1){
echo form_input($teacher);
}else{
?>
	<select name="teacher" id="teacher">
	<?php foreach($teachers as $row){ ?>
		<?php if($row[3] == 'Teacher'){ ?>
		<option value="<?php echo $row[4]; ?>"><?php echo strtoupper($row[2])  . ', ' . ucwords($row[0]) .' '. $row[1]; ?></option>
		<?php } ?>	
	<?php } ?>
	</select>
<?php } ?>


<?php echo form_label('Course/Yr/Section', 'course'); ?>
<?php
if($_GET['dl'] == 1){
echo form_input($course);
}else{
?>
	<select name="course" id="course">
	<?php foreach($courses as $row){ ?>
		<option value="<?php echo $row[2]; ?>"><?php echo $row[1]; ?></option>
	<?php } ?>
	</select>
<?php } ?>

<?php
echo form_label('Start Date', 'date_created');
echo form_input($date);

echo form_label('Lock Date', 'date_to');
echo form_input($date_to);

echo form_label('Additional Details', 'addl_details');
echo form_input($addl);

echo form_button($create);
?>








<?php if($_GET['dl'] == 1){//browser supports datalist ?>
	<datalist id="subjects">
	<?php foreach($subjects as $v){ ?>
			<option data-subjectid="<?php echo $v[2]; ?>" value="<?php echo ucwords($v[1]); ?>"><?php echo ucwords($v[1]); ?></option>
	<?php } ?>
	</datalist>

	<datalist id="teachers">
	<?php foreach($teachers as $v){ ?>
		<?php if($v[3] == 'Teacher'){ ?>
			<option data-teacherid="<?php echo $v[4]; ?>" value="<?php echo strtoupper($v[2])  . ', ' . ucwords($v[0]) .' '. $v[1]; ?>"><?php echo strtoupper($v[2])  . ', ' . ucwords($v[0]) .' '. $v[1]; ?></option>
		<?php } ?>		
	<?php } ?>
	</datalist>

	<datalist id="courses">
	<?php foreach($courses as $v){ ?>
		<option data-courseid="<?php echo $v[2]; ?>" value="<?php echo ucwords($v[1]); ?>"><?php echo ucwords($v[1]); ?></option>
	<?php } ?>
	</datalist>

<?php }else{//browser does not support datalist ?>
	
	

<?php } ?>
</div><!--end of container-->