<!--add people to a class-->
<div id="modal_header">
<h4>Add People - <?php echo $page['class_code']; ?></h4>
<select name="user_ids" id="user_ids" multiple>
<?php foreach($page['users'] as $v){ ?>
	<?php if($v[3] !=  "Administrator"){ ?><!--admin is not tied to any specific class-->
	<option value="<?php echo $v[4]; ?>"><?php echo strtoupper($v[3]) . ', ' . ucwords($v[1]) . ' ' . ucwords($v[0]); ?></option>
	<?php } ?>
<?php } ?>
</select>

<button name="add_people" id="add_people" value="Add People">Add People</button>
</div>
