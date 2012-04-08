<!--take quiz for students-->
<?php
$quiz = $table['quiz'];
$quiz_items = $table['quiz_items'];
$quiz_files = $table['files'];

$choices = array('A','B','C','D');

$res_title	= array(
			'name'=>'res_title',
			'id'=>'res_title'
		);

$res_body	= array(
			'name'=>'res_body',
			'id'=>'res_body'
		);


$reply	= array(
			'id'=>'reply_quiz',
			'name'=>'reply_quiz',
			'value'=>'Submit Answer',
			'content'=>'Submit Answer',
			'class'=>'medium green'
		);
		
$submit	= array(
			'id'=>'submit_quiz',
			'name'=>'submit_quiz',
			'value'=>'Submit Answer',
			'content'=>'Submit Answer',
			'class'=>'medium green'
		);
?>
<div id="modal_header">
<h4>Take Quiz - <?php echo $quiz['title']; ?></h4>
</div>

<div id="quiz_files">
	Attached Files:
	<?php foreach($quiz_files as $row){ ?>
		<li><a href="/zenoir/index.php/ajax_loader/view/view_file?fid=<?php echo $row['file_id']; ?>" class="lightbox"><?php echo $row['filename']; ?></a></li>
	<?php } ?>
</div>

<?php if(!empty($quiz_items)){ ?>
<table>
<?php foreach($quiz_items as $index=>$items){ ?>
<tr>
	<td>
	<?php echo $index + 1 . ') ' .$items['question']; ?>
	</td>
</tr>
<tr>
	<td>
	<select name="answer" class="answers">
	<option value="--">--</option>
	<?php foreach($choices as $choice){ ?>
	<option value="<?php echo $choice; ?>"><?php echo $choice; ?></option>
	<?php } ?>
	</select>
	</td>
</tr>

<tr class="choices">
	<td><?php echo 'A. ' .$items['a'];  ?></td>
</tr>
<tr class="choices">
	<td><?php echo 'B. ' .$items['b']; ?></td>
</tr>
<tr class="choices">
	<td><?php echo 'C. ' .$items['c']; ?></td>
</tr>
<tr class="choices">
	<td><?php echo 'D. ' .$items['d']; ?></td>
</tr>	
</tr>
<?php } ?>
</table>
<?php }else{ ?>
<?php
echo form_label('Title' , 'res_title');
echo form_input($res_title);

echo form_label('Body' , 'res_body');
echo form_textarea($res_body);
?>

<form action="/zenoir/index.php/upload/do_upload" method="post" enctype="multipart/form-data">
<input type="file" name="userfile" class="fileUpload" multiple>
		<div id="div_hide">		
		<button id="px-submit" type="submit" >Upload</button>
		<button id="px-clear" type="reset">Clear</button>
		</div>
</form>
<?php } ?>
<p>
<?php
if(!empty($quiz_items)){
	echo form_button($submit);
}else{
	echo form_button($reply);
}
?>
</p>
<script>
var page = document.referrer;
$('.fileUpload').fileUploader({
			afterEachUpload: function(data, status, formContainer){
				$jsonData = $.parseJSON($(data).find('#upload_data').text());		
			}
});
$('.px-buttons').hide();
</script>