<!--create new quiz-->
<script>

$('.fileUpload').fileUploader({
			allowedExtension: 'jpg|jpeg|gif|png|zip|avi',
			afterEachUpload: function(data, status, formContainer){
				$jsonData = $.parseJSON( $(data).find('#upload_data').text() );
			}
});

$('.px-buttons').hide();
</script>
<div id="modal_header">
<h4>Create New Quiz</h4>
</div>
<?php
$quiz_title	= array(
				'id'=>'quiz_title',
				'name'=>'quiz_title',
			);

$quiz_body	= array(
				'id'=>'quiz_body',
				'name'=>'quiz_body'
			);

$start_time = array(
				'id'=>'start_time',
				'name'=>'start_time',
				'class'=>'time_picker'
				
			);

$end_time = array(
				'id'=>'end_time',
				'name'=>'end_time',
				'class'=>'time_picker'
			);
		
$next		= array(
				'id'=>'next',
				'name'=>'next',
				'value'=>'Next',
				'content'=>'Next',
				'class'=>'medium green'
			);
?>

<div class="container">
<?php 

echo form_label('Quiz Title', 'quiz_title'); 
echo form_input($quiz_title);

echo form_label('Body', 'quiz_body'); 
echo form_textarea($quiz_body);

echo form_label('Start Time', 'start_time'); 
echo form_input($start_time);

echo form_label('End Time', 'end_time'); 
echo form_input($end_time);

echo form_button($next);
?>
</div><!--end of container-->