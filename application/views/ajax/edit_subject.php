<!--editing subject information-->
<div id="modal_header">
<h4>Update Subject</h4>
</div>

<?php
$subject = $page;

$subject_code		= array(
						'name'=>'subject_code',
						'id'=>'subject_code',
						'placeholder'=>'Eg. COMPRO 1',
						'value'=>$subject['subj_code']
					);

$subject_description = array(
						'name'=>'subject_desc',
						'id'=>'subject_desc',
						'placeholder'=>'Eg. Computer Programming 1',
						'value'=>$subject['subj_desc']
					);
					
$edit 	= array(
				'id'=>'update_subject',
				'name'=>'update_subject',
				'value'=>'Update Subject',
				'content'=>'Update Subject',
				'class'=>'medium green'
			);					
?>

<div class="container">
<?php					
echo form_label('Subject Code','subject_code');
echo form_input($subject_code);

echo form_label('Description', 'subject_desc');
echo form_input($subject_description);	

echo form_button($edit);
?>
</div>