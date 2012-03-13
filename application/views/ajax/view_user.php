<!--view user info including logs, and classes handled for teachers-->
<div id="modal_header">
<h4>View User Information</h4>
</div>
<!--USER NAME-->
<?php echo strtoupper($page[2]) .', '. ucwords($page[0]) . ' ' . ucwords($page[1]);  ?>

<!--USER INFO-->
<pre>
<?php echo $page[3]; ?>
</pre>

<!--CLASSES HANDLED(IF TEACHER)-->

<!--ACTIVITY LOG-->
