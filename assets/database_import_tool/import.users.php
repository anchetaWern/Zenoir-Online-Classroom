<h1>User Information Import Tool</h1>
<?php
require_once('conn.php');

$account_query	= $_POST['accounts'];
$detail_query	= $_POST['details'];

$insert_accounts  = $db->query("$account_query"); 
$insert_details  = $db->query("$detail_query");

echo "Successfully imported user information!";
?>