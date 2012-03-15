<!--new assignment-->
<script>
$(".date_picker").datepicker({ dateFormat: 'yy-mm-dd' });
$('#file_upload').uploadify({
    'uploader'  : '/zenoir/libs/uploadify/uploadify.swf',
    'script'    : '/zenoir/libs/uploadify/uploadify.php',
    'cancelImg' : '/zenoir/libs/uploadify/cancel.png',
    'folder'    : 'uploads',
	'fileExt'     : '*.jpg;*.gif;*.png; *.doc; *.html; *.htm; *.docx; *.xls; *.xlsx; *.mp3; *.ppt; *.pptx; *.txt',
	'fileDesc'    : 'Valid Files',
	'sizeLimit'   : 102400,
    'auto'      : false,
	'multi' : true,
	'buttonImg'   : '/zenoir/libs/uploadify/browse.png'
});
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

<div id="container_newassignment">
<?php
echo form_label('Title', 'as_title');
echo form_input($title);	

echo form_label('Body', 'as_body');
echo form_textarea($body);

echo form_label('Deadline', 'deadline');	
echo form_input($deadline);
?>

<input id="file_upload" type="file" name="file_upload" />

<p>
<?php
echo form_button($create);
?>
</p>
</div>
