<!--message reply-->
<script>
var page = "<?php echo $_SESSION['user_page']; ?>";
$('.fileUpload').fileUploader({
			
			afterEachUpload: function(data, status, formContainer){
				$jsonData = $.parseJSON( $(data).find('#upload_data').text() );
			}
});

$('.px-buttons').hide();
</script>
<?php
$message = $page['message'];

$class_users = $page;

$msg_title	= array(
				'id'=>'msg_title',
				'name'=>'msg_title',
			);

$msg_body	= array(
				'id'=>'msg_body',
				'name'=>'msg_body'
			);
	
$reply		= array(
				'id'=>'reply_message',
				'name'=>'reply_message',
				'value'=>'Send Message',
				'content'=>'Send Message',
				'class'=>'medium green'
			);
			
$back		= array(
				'id'=>'back_message',
				'name'=>'back_message',
				'value'=>'Back to Message',
				'content'=>'Back to Message',
				'class'=>'medium orange'
			);
?>
<div id="modal_header">
<h4>Reply to Message - <?php echo $message['msg_title']; ?></h4>
</div>

<div id="send_to">
Reply to: <?php echo $message['sender']; ?>
</div>

<div class="container">
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
echo form_button($reply);
?>
<a href="<?php echo $this->config->item('ajax_base'); ?>view_message/<?php echo $this->uri->segment(4); ?>" class="lightbox">
<?php echo form_button($back); ?>
</a>
</p>
</div>

<script>
	$('#msg_body').redactor();
</script>