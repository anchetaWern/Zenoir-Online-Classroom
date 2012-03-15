<script>

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
<h4>Create New Handout</h4>
</div>

<?php
$ho_title	= array(
				'id'=>'ho_title',
				'name'=>'ho_title',
			);

$ho_body	= array(
				'id'=>'ho_body',
				'name'=>'ho_body'
			);
	
$create		= array(
				'id'=>'create_handout',
				'name'=>'create_handout',
				'value'=>'Create Handout',
				'content'=>'Create Handout',
				'class'=>'medium green'
			);
?>
<div id="container_newhandout">
<?php
echo form_label('Title', 'ho_title');
echo form_input($ho_title);	

echo form_label('Body', 'ho_body');
echo form_textarea($ho_body);
?>
<p>
<input id="file_upload" type="file" name="file_upload" />
</p>
<?php
echo form_button($create);
?>
</div>