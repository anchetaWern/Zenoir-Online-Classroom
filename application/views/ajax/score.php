<!--view quiz score-->
<?php 
$quiz = $page;
?>
<div id="modal_header">
<h4>View Quiz Score - <?php echo $quiz['title']; ?></h4>
</div>
<div class="container">
<?php
echo $quiz['score'] . ' / ' . $quiz['itemcount']; 
?>

</div>