<?php



$conn = pg_connect(getenv("DATABASE_URL"));
if (!$conn) {
  echo "An error occurred.No conenction\n";
  echo getenv("DATABASE_URL") . "\n";
  exit("connection");
}


$query=$_GET["query"];
$result=pg_query ($conn,  $query );
  

  if (!$result) {
  echo "Error:
  Query:" . $query . "
  
  Error:
  " .  pg_result_error ( $result ) . "\n";
 
  exit("result");
}

while(TRUE)
{
  $res=pg_fetch_result($result,1);
  if(!$res)break;
  echo $res . "\n";
}

?>
