<?php
header('Content-type: text/html');
echo(file_get_contents($_GET["url"]));
?>