<!--for editing user account information-->
<script>

$('.fileUpload').fileUploader({
			allowedExtension: 'jpg|jpeg|gif|png|zip|avi',
			afterEachUpload: function(data, status, formContainer){
				$jsonData = $.parseJSON( $(data).find('#upload_data').text() );
			}
});

$('.px-buttons').hide();
$('.ui-button-text span').text('Select Photo');
</script>
<div id="modal_header">
<h4>Edit Account Information</h4>
</div>


<div class="container">
<?php $file_id = $this->session->userdata('image_id'); ?>
<p>
<form action="/zenoir/index.php/upload/do_upload" method="post" enctype="multipart/form-data">
<input type="file" name="userfile" class="fileUpload">
		<div id="div_hide">		
		<button id="px-submit" type="submit" >Upload</button>
		<button id="px-clear" type="reset">Clear</button>
		</div>
</form>
</p>
<div id="pic">
<img width="200px" height="200px" src="/zenoir/index.php/ajax_loader/view/dl_file?fid=<?php echo $file_id; ?>"/>
</div>
<label for="password">Password</label>
<input type="password" id="password" name="password"/>


<label for="fname">Firstname</label>
<input type="text" id="fname" name="fname" value="<?php echo $user['fname']; ?>"/>

<label for="mname">Middlename</label>
<input type="text" id="mname" name="mname" value="<?php echo $user['mname']; ?>"/>

<label for="lname">Lastname</label>
<input type="text" id="lname" name="lname" value="<?php echo $user['lname']; ?>"/>

<label for="email">Email</label>
<input type="text" id="email" name="email" value="<?php echo $user['email']; ?>"/>

<label for="autobiography">Autobiography</label>
<textarea name="autobiography" id="autobiography">
<?php echo $user['auto_bio']; ?>
</textarea>

<input type="button" class="medium green" id="btn_update_account" value="Update Account">
</div>


