<!--new masked and class session-->
<script>
$('.time_picker').datetimepicker({
	ampm: true,
	dateFormat: 'yy-mm-dd'
});
</script>
<?php
$session_title = $page['title'];

$title	= array(
			'name'=>'ses_title',
			'id'=>'ses_title'
		);

$body	= array(
			'name'=>'ses_body',
			'id'=>'ses_body'
		);
		
$date 	= array(
			'name'=>'ses_date',
			'id'=>'ses_date'
		);
		
$infinite= array(
			'name'=>'ses_validity',
			'id'=>'ses_validity'
		);

$time_from= array(
			'name'=>'time_from',
			'id'=>'time_from',
			'class'=>'time_picker',
			'readonly'=>'readonly'
		);
		
$time_to= array(
			'name'=>'time_to',
			'id'=>'time_to',
			'class'=>'time_picker',
			'readonly'=>'readonly'
		);

$create	= array(
			'id'=>'create_mcsession',
			'name'=>'create_mcsession',
			'value'=>'Create Session',
			'content'=>'Create Session',
			'class'=>'medium green'
		);
?>

<div id="modal_header">
<h4>Create New <?php echo $session_title; ?> Session</h4>
</div>
<div class="container">
<?php
echo form_label('Title', 'ses_title');
echo form_input($title);

echo form_label('Description', 'ses_body');
echo form_input($body);

echo form_label('Always Accessible', 'ses_validity');
echo form_checkbox($infinite);
?>

<div id="time_setter">
<?php
echo form_label('Time From', 'time_from');
echo form_input($time_from);

echo form_label('Time To', 'time_to');
echo form_input($time_to);
?>
</div>

<?php 
if(!empty($page['groups'])){
echo form_label('Session Members', 'session_groups');
?>
<select name="session_groups" id="session_groups" multiple>
	<?php foreach($page['groups'] as $groups){ ?>
		<option value="<?php echo $groups['group_id']; ?>"><?php echo $groups['name']; ?></option>
	<?php } ?>
</select>
<?php } ?>
<p>
<?php
echo form_button($create);
?>
</p>
</div>