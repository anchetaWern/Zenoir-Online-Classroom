<!--new assignment-->
<script>
$(".date_picker").datepicker({ dateFormat: 'yy-mm-dd' });
$('.fileUpload').fileUploader({
			
			afterEachUpload: function(data, status, formContainer){
				$jsonData = $.parseJSON($(data).find('#upload_data').text());
				
			}
});

$('.px-buttons').hide();
</script>
<div id="modal_header">
<h4>Create New Assignment</h4>
</div>

<?php
$title 	= array(
			'name'=>'as_title',
			'id'=>'as_title'
		);

$body	= array(
			'name'=>'as_body',
			'id'=>'as_body'
		);

$deadline=array(
			'name'=>'deadline',
			'id'=>'deadline',
			'class'=>'date_picker'
		);

$create	= array(
			'id'=>'create_assignment',
			'name'=>'create_assignment',
			'value'=>'Create Assignment',
			'content'=>'Create Assignment',
			'class'=>'medium green'
		);

?>

<div class="container">

<?php
echo form_label('Title', 'as_title');
echo form_input($title);	

echo form_label('Body', 'as_body');
echo form_textarea($body);

echo form_label('Deadline', 'deadline');	
echo form_input($deadline);
?>
<form action="/zenoir/index.php/upload/do_upload" method="post" enctype="multipart/form-data">
<input type="file" name="userfile" class="fileUpload" multiple>
		<div id="div_hide">		
		<button id="px-submit" type="submit" >Upload</button>
		<button id="px-clear" type="reset">Clear</button>
		</div>
</form>
<p>
<?php
echo form_button($create);
?>
</p>

</div>
