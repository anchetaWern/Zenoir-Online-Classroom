<!--view quiz for teacher & admin-->
<?php 
$quiz = $table['quiz'];
$quiz_items = $table['quiz_items'];

$response	= array(
			'id'=>'view_scores',
			'name'=>'view_scores',
			'value'=>'View Scores',
			'content'=>'View Scores',
			'class'=>'medium orange'
		);
		
$no_quiz	= array(
			'id'=>'view_noquiz',
			'name'=>'view_noquiz',
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
	<a href="/zenoir/index.php/class_loader/view/view_scores">
	<?php echo form_button($response); ?>
	</a>
	<a href="/zenoir/index.php/class_loader/view/view_noquiz">
	<?php echo form_button($no_quiz); ?>
	</a>
</div><!--end of container-->