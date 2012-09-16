<!--create new quiz-->

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
				'class'=>'time_picker',
				'readonly'=>'readonly'
				
			);

$end_time = array(
				'id'=>'end_time',
				'name'=>'end_time',
				'class'=>'time_picker',
				'readonly'=>'readonly'
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
echo form_label('Quiz Type', 'quiz_type');
?>
With quiz items
<input type="radio" name="quiz_type" id="with_choices" value="with_choices" checked/> 
Without quiz items
<input type="radio" name="quiz_type" id="no_choices" value="no_choices"/> 

<?php 
echo form_label('Quiz Title', 'quiz_title'); 
echo form_input($quiz_title);

echo form_label('Body', 'quiz_body'); 
echo form_textarea($quiz_body);

echo form_label('Start Time', 'start_time'); 
echo form_input($start_time);

echo form_label('End Time', 'end_time'); 
echo form_input($end_time);

?>
<div id="file_uploader">
<form action="/zenoir/index.php/upload/do_upload" method="post" enctype="multipart/form-data">
<input type="file" name="userfile" class="fileUpload" multiple>
		<div id="div_hide">		
		<button id="px-submit" type="submit" >Upload</button>
		<button id="px-clear" type="reset">Clear</button>
		</div>
</form>
</div>

<div id="action_button">
<?php echo form_button($next); ?>
</div>
</div><!--end of container-->
<script>
var page = document.referrer;

$('.fileUpload').fileUploader({		
			afterEachUpload: function(data, status, formContainer){
				$jsonData = $.parseJSON($(data).find('#upload_data').text());
				
			}
});
$('.px-buttons').hide();

$('#quiz_body').redactor();
</script>