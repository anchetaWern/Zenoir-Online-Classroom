<div id="modal_header">
<h4>Create New Course</h4>
</div>
<?php
//new course
$course_code		= array(
						'name'=>'course_code',
						'id'=>'course_code',
						'placeholder'=>'Eg. BSCS'
					);

$course_description = array(
						'name'=>'course_desc',
						'id'=>'course_desc',
						'placeholder'=>'Eg. Computer Science'
					);
					
$create 	= array(
				'id'=>'create_course',
				'name'=>'create_course',
				'value'=>'Create Course',
				'content'=>'Create Course',
				'class'=>'medium green'
			);	
?>
<div class="container">
<?php					
echo form_label('Course Code','course_code');
echo form_input($course_code);

echo form_label('Description', 'course_desc');
echo form_input($course_description);	

echo form_button($create);
?>
</div>