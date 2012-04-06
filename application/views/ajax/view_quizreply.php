<!--view quiz reply for student-->
<?php
$quiz_response = $page;
?>
<div id="modal_header">
<h4>View Quiz Reply - <?php echo $quiz_response['res_title']; ?></h4>
</div>
<div class="container">

</div>
<p>
Quiz: <?php echo $quiz_response['quiz_title']; ?>
</p>
<p>
Submitted by: <?php echo strtoupper($quiz_response['lname']) . ', ' . ucwords($quiz_response['fname']) . ' ' . ucwords($quiz_response['mname']); ?>
</p>
<p>
Time submitted: <?php echo date('Y-m-d g:i:s A', strtotime($quiz_response['datetime'])); ?>
</p>
<p>
<pre>
<?php echo $quiz_response['body']; ?>
</pre>
</p>
</div>