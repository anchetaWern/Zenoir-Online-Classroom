<!--view session history-->
<?php
$conversation = $page;
if(!empty($conversation)){ 
?>
<h4><?php echo $_SESSION['ses']['title']; ?></h4>
<div id="conversation">
<p>
<table>
	<tbody>
	<?php foreach($conversation as $row){ ?>
		<tr>
			<td><?php echo $row['mask'] .': '. $row['msg']; ?></td>
			<td class="td_hidden"><?php echo date('Y-m-d g:i:s A', strtotime($row['time'])); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
</p>
</div>
<?php }else{ ?>
No conversation history yet
<?php } ?>
<script>
$('tr:even').addClass('alt');
$('#conversation').jScrollPane({autoReinitialise: true});
</script>