<div id="modal_header">
<h4>Create New Subject</h4>
</div>

<?php
//New Subject

$subject_code		= array(
						'name'=>'subject_code',
						'id'=>'subject_code',
						'placeholder'=>'Eg. COMPRO 1'
					);

$subject_description = array(
						'name'=>'subject_desc',
						'id'=>'subject_desc',
						'placeholder'=>'Eg. Computer Programming 1'
					);
					
$create 	= array(
				'id'=>'create_subject',
				'name'=>'create_subjectSubject',
				'value'=>'Create Subject',
				'content'=>'Create Subject'
			);					
					
echo form_label('Subject Code','subject_code');
echo form_input($subject_code);

echo form_label('Description', 'subject_desc');
echo form_input($subject_description);	

echo form_button($create);
?>