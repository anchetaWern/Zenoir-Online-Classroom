<!--assignment reply-->
<script>
var page = "<?php echo $_SESSION['user_page']; ?>";
$('.fileUpload').fileUploader({
			afterEachUpload: function(data, status, formContainer){
				$jsonData = $.parseJSON($(data).find('#upload_data').text());
			}
});

$('.px-buttons').hide();
</script>
<?php
$assignment = $page;
$title 	= array(
			'name'=>'as_title',
			'id'=>'as_title'
		);

$body	= array(
			'name'=>'as_body',
			'id'=>'as_body',
			'value'=>$assignment['as_body']
		);

$reply	= array(
			'id'=>'submit_assignmentreply',
			'name'=>'submit_assignmentreply',
			'value'=>'Submit Reply',
			'content'=>'Submit Reply',
			'class'=>'medium green'
		);


?>
<div id="modal_header">
<h4>Reply to Assignment - <?php echo $assignment['as_title']; ?></h4>
</div>
<div class="container">

<?php
echo form_label('Title', 'as_title');
echo form_input($title);	

echo form_label('Body', 'as_body');
echo form_textarea($body);
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
</p>

</div>