<!--view user info including logs, and classes handled for teachers-->
<?php
print_r($user_info);
$user_page =  $_SESSION['user_page'];

$logs	= array(
			'id'=>'view_logs',
			'name'=>'view_logs',
			'value'=>'View Logs',
			'content'=>'View Logs',
			'class'=>'medium orange'
		);
?>
<div id="modal_header">
<h4>View User Information - <?php echo strtoupper($page[2]) .', '. ucwords($page[0]) . ' ' . ucwords($page[1]);  ?></h4>
</div>

<div class="container">

<div id="pic">
<img width="200px" height="200px" src="<?php echo $this->config->item('ajax_base'); ?>dl_file?fid=<?php echo $page[5]; ?>"/>
</div>
<!--USER INFO-->
<p>
<pre>
<?php echo $page[3]; ?>
</pre>
</p>




<!--CLASSES HANDLED(IF TEACHER)-->
<?php if($this->session->userdata('usertype') != 3 && $user_page == '/zenoir/class_loader/view/reports'){ ?>
<p>
<a href="<?php echo $this->config->item('ajax_base'); ?>user_logs/<?php echo $page[4]; ?>" data-classid="<?php echo $_SESSION['current_class']; ?>" data-id="<?php echo $page[4]; ?>" class="lightbox"><?php echo form_button($logs); ?></a>
</p>
<?php } ?>
</div>