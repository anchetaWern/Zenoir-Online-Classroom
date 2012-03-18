<!--view message-->
<?php 
$message = $page['message'];
$message_files = $page['files'];
$message_receiver = $page['receivers'];


$history 	= array(
				'id'=>'history',
				'name'=>'history',
				'value'=>'History',
				'content'=>'History',
				'class'=>'medium orange'
			);

$reply		= array(
				'id'=>'reply',
				'name'=>'reply',
				'value'=>'Reply',
				'content'=>'Reply',
				'class'=>'medium green'
			);

?>

<div id="modal_header">
<h4>View Message</h4>
</div>
<div class="container">
<div id="from">
<?php if(empty($message_receiver)){ ?>
From: <?php echo $message['from']; ?>
<?php }else{ ?>
To: 
<?php foreach($message_receiver as $receiver){ ?>
	<li><?php echo $receiver['receiver']; ?></li>
<?php } ?>
<?php } ?>
</div>

<div id="date">
Date: <?php echo date('Y-m-d g:i:s A', strtotime($message['date'])); ?>
</div>

<div id="msg_title">
<?php echo $message['msg_title']; ?>
</div>

<div id="msg_body">
<pre>
<?php echo $message['msg_body']; ?>
</pre>
</div>

<!--attached files-->
<?php if(!empty($message_files)){ ?>
Attached Files:
<?php foreach($message_files as $files){ ?>
	<li><a href="/zenoir/assets/downloader.php?fid=<?php echo $files['file_id']; ?>"><?php echo $files['filename']; ?></a></li>
<?php } ?>
<?php } ?>

<p>
<?php 
if(empty($message_receiver)){
?>
<a href="/zenoir/index.php/ajax_loader/view/reply" data-id="<?php echo $message['msg_id']; ?>" class="lightbox"><?php echo form_button($reply); ?></a>
<?php
}
?>
<a href="/zenoir/index.php/ajax_loader/view/msg_history" data-id="<?php echo $message['root_msg_id']; ?>" class="lightbox"><?php echo form_button($history); ?></a>
</p>
</div><!--end of container-->

