<!--view quiz for teacher & admin-->
<?php 
$quiz = $table['quiz'];
$quiz_items = $table['quiz_items'];
$quiz_files = $table['files'];

//scores-for quiz with items
$response	= array(
			'id'=>'view_scores',
			'name'=>'view_scores',
			'value'=>'View Scores',
			'content'=>'View Scores',
			'class'=>'medium green'
		);
		
//replies-for quiz without items		
$replies	= array(
			'id'=>'view_replies',
			'name'=>'view_replies',
			'value'=>'View replies',
			'content'=>'View Replies',
			'class'=>'medium green'
		);
		
$no_quiz	= array(
			'id'=>'view_noquiz',
			'name'=>'view_noquiz',
			'value'=>'View No Quiz',
			'content'=>'View No Quiz',
			'class'=>'medium red'
		);
		
$no_reply	= array(
			'id'=>'view_noreply',
			'name'=>'view_noreply',
			'value'=>'View No Quiz',
			'content'=>'View No Quiz',
			'class'=>'medium red'
		);		
?>
<div id="modal_header">
<h4>View Quiz - <?php echo $quiz['title']; ?></h4>
</div>
<div class="contents">
	<div id="date_created">
		Date Created:
		<?php echo $quiz['date']; ?>
	</div>
	
	<div id="quiz_date">
		Quiz Date:
		<?php echo $quiz['quiz_date']; ?>
	</div>
	
	<div id="start">
		Start Time:
		<?php echo date('g:i:s A', strtotime($quiz['start_time'])); ?>
	</div>
	
	<div id="end">
		End Time:
		<?php echo date('g:i:s A', strtotime($quiz['end_time'])); ?>
	</div>

	<div id="quiz_body">
		<pre>
		<?php echo $quiz['body'];?>
		</pre>
	</div>
	
	<?php if(!empty($quiz_items)){ ?>
	<div id="quiz_items">
	<table>
		<thead>
			<tr>
				<th>Question</th>
				<th>A</th>
				<th>B</th>
				<th>C</th>
				<th>D</th>
				<th>Answer</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($quiz_items as $items){ ?>
			<tr>
				<td><?php echo $items['question']; ?></td>
				<td><?php echo $items['a']; ?></td>
				<td><?php echo $items['b']; ?></td>
				<td><?php echo $items['c']; ?></td>
				<td><?php echo $items['d']; ?></td>
				<td><?php echo $items['answer']; ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	</div><!--end of quiz items-->
	
	<p>
	<a href="/zenoir/index.php/class_loader/view/view_scores">
	<?php echo form_button($response); ?>
	</a>
	
	<a href="/zenoir/index.php/class_loader/view/view_noquiz">
	<?php echo form_button($no_quiz); ?>
	</a>
	</p>
	
	<?php }else{ ?>
	
	
	<div id="quiz_files">
	<?php if(!empty($quiz_files)){ ?>
		Attached Files:
		<?php foreach($quiz_files as $row){ ?>
			<li><a href="/zenoir/index.php/ajax_loader/view/view_file?fid=<?php echo $row['file_id']; ?>" class="lightbox"><?php echo $row['filename']; ?></a></li>
		<?php } ?>
	<?php } ?>	
	</div>
	
	<p></p>
	<a href="/zenoir/index.php/class_loader/view/list_quizreplies">
	<?php echo form_button($replies); ?>
	</a>
	
	<a href="/zenoir/index.php/class_loader/view/view_noquizresponse">
	<?php echo form_button($no_reply); ?>
	</a>
	
	<?php } ?>
	
		
	
	
	
	

</div><!--end of container-->