<?php
//host, user, password, database
$db = new Mysqli("localhost", "root", "1234", "zenoir"); 

if ($db->connect_errno) {
    die('Connect Error: ' . $db->connect_errno);
}
?>