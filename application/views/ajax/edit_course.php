<!--edit course-->
<div id="modal_header">
<h4>Update Course</h4>
</div>
<?php
$course = $page;

$course_code		= array(
						'name'=>'course_code',
						'id'=>'course_code',
						'placeholder'=>'Eg. BSCS',
						'value'=>$course['course_code']
					);

$course_description = array(
						'name'=>'course_desc',
						'id'=>'course_desc',
						'placeholder'=>'Eg. Computer Science',
						'value'=>$course['course_desc']
					);
					
$update 	= array(
				'id'=>'edit_course',
				'name'=>'edit_course',
				'value'=>'Update Course',
				'content'=>'Update Course',
				'class'=>'medium green'
			);	
					
echo form_label('Course Code','course_code');
echo form_input($course_code);

echo form_label('Description', 'course_desc');
echo form_input($course_description);	

echo form_button($update);
?>