<!--new message-->
<script>
$('.fileUpload').fileUploader({
			allowedExtension: 'gif|jpg|png|zip|avi|rar|7z|mp3|pdf|jpeg|pdf|ogv|mp4|ogg|webm|html|htm|ppt|pptx|doc|docx|xls|xlsx',
			afterEachUpload: function(data, status, formContainer){
				$jsonData = $.parseJSON($(data).find('#upload_data').text());
			}
});

$('.px-buttons').hide();
</script>
<div id="modal_header">
<h4>Create New Message</h4>
</div>

<?php
$class_users = $page;

$msg_title	= array(
				'id'=>'msg_title',
				'name'=>'msg_title',
			);

$msg_body	= array(
				'id'=>'msg_body',
				'name'=>'msg_body'
			);
	
$create		= array(
				'id'=>'create_message',
				'name'=>'create_message',
				'value'=>'Send Message',
				'content'=>'Send Message',
				'class'=>'medium green'
			);
?>
<div class="container">

<?php echo form_label('Send To', 'receivers'); ?>
<?php if(!empty($class_users)){ ?>
<select name="receivers[]" id="receivers" multiple>
	<?php foreach($class_users as $user){ ?>
		<option value="<?php echo $user['id']; ?>"><?php echo strtoupper($user['lname']) .', '. ucwords($user['fname']); ?></option>
	<?php } ?>
</select>
<?php } ?>

<?php
echo form_label('Title', 'ho_title');
echo form_input($msg_title);	

echo form_label('Body', 'ho_body');
echo form_textarea($msg_body);
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