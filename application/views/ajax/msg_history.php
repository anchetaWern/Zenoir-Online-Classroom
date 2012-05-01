<!--view conversation history-->
<?php 
$history = $page;

$back		= array(
				'id'=>'back',
				'name'=>'back',
				'value'=>'Back to Message',
				'content'=>'Back to Message',
				'class'=>'medium red'
			);
?>
<div id="modal_header">
<h4>Conversation History</h4>
</div>
<div class="container">
<div id="msghistory">
<p>
<?php foreach($history as $row){ ?>
	<div id="msg_title">
		<?php echo $row['msg_title']; ?>
	</div>
	
	<div id="from">
		From:
		<?php echo $row['sender']; ?>
	</div>
	
	<div id="date">
		Date:
		<?php echo date('Y-m-d g:i:s A', strtotime($row['date'])); ?>
	</div>
	
	<div id="msg_body">
	<pre>
		<?php echo $row['msg_body']; ?>
	</pre>
	</div>
<?php } ?>
</p>
</div>
<p>
<a href="<?php echo $this->config->item('ajax_base'); ?>view_message" class="lightbox"><?php echo form_button($back); ?></a>
</p>
</div><!--end of container-->
<script>
$('#msghistory').jScrollPane({autoReinitialise: true});
</script>