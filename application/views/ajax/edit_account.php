<!--for editing user account information-->
<div id="modal_header">
<h4>Edit Account Information</h4>
</div>

<form action="/zenoir/index.php/usert/update_user" method="post">
<label for="password">Password</label>
<input type="password" id="password" name="password"/>


<label for="fname">Firstname</label>
<input type="text" id="fname" name="fname" value="<?php echo $fname; ?>"/>

<label for="mname">Middlename</label>
<input type="text" id="mname" name="mname" value="<?php echo $mname; ?>"/>

<label for="lname">Lastname</label>
<input type="text" id="lname" name="lname" value="<?php echo $lname; ?>"/>

<label for="autobiography">Autobiography</label>
<textarea name="autobiography" id="autobiography">
<?php echo $auto_bio; ?>
</textarea>

<input type="button" id="btn_update_account" value="update">
</form>

