<?php
echo "asdasdsa";
exit("testexit");
$db = parse_url(getenv("DATABASE_URL"));

$db["path"] = ltrim($db["path"], "/");

$conn = pg_connect(getenv("DATABASE_URL"));
if (!$conn) {
  echo "An error occurred.No conenction\n";
  echo getenv("DATABASE_URL");
  exit("connection");
}


$query=$_GET["query"];
$result=pg_query ($conn,  $query );
  

?>
