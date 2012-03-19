<!--view student scores for a specific quiz-->
<?php 

$quiz_details = $table['details'];
$quiz_results = $table['result'];
?>
<div id="modal_header">
<h4>View Quiz Results - <?php echo $quiz_details['title']; ?></h4>
</div>
<div class="content">
<div id="quiz_date">
Quiz Date:
<?php echo $quiz_details['date']; ?>
</div>

<?php if(!empty($quiz_results)){ ?>
<table>
	<thead>
		<tr>
			<th>Student</th>
			<th>Score</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($quiz_results as $result){ ?>
		<tr>
			<td><?php echo $result['student']; ?></td>
			<td><?php echo $result['score']; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
</div>