<!--sessions-->
<!--sessions home-->
<?php
$sessions = $table;
?>
<div class="content">
<p>
Create New:
</p>
<p>
<span class="spacer"><a href="/zenoir/index.php/ajax_loader/view/new_classsession" data-sestype="1" class="lightbox">Masked Session</a></span>
<span class="spacer"><a href="/zenoir/index.php/ajax_loader/view/new_classsession" data-sestype="2" class="lightbox">Class Session</a></span>
<span class="spacer"><a href="/zenoir/index.php/ajax_loader/view/new_classsession" data-sestype="3" class="lightbox">Team Session</a></span>
</p>

<?php if(!empty($sessions)){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>Description</th>
			<th>Date</th>
			<th>Always Open</th>
			<th>From</th>
			<th>To</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($sessions as $row){ ?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>

</div>

