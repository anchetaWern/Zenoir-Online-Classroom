<?php
header("Content-Type: ". $page['mime']);
header("Content-Disposition: attachment; filename=". $page['filename']);
echo $page['filedata'];
?>