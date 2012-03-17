<?php 
header("Content-Type: image/png"); 
require_once('zenoir_config.php');

$oyeah = $db->get_row("SELECT * FROM tbl_files WHERE file_id=1");
echo $oyeah->file_data;
?>
