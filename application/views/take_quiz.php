<!--take quiz for students-->
<?php
$quiz = $table['quiz'];
$quiz_items = $table['quiz_items'];

$choices = array('A','B','C','D');

$submit	= array(
			'id'=>'submit_quiz',
			'name'=>'submit_quiz',
			'value'=>'Submit Answers',
			'content'=>'Submit Answers',
			'class'=>'medium green'
		);
?>
<div id="modal_header">
<h4>Take Quiz - <?php echo $quiz['title']; ?></h4>
</div>
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
<?php
echo form_button($submit);
?>