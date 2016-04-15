<?php
$hostname = "127.0.0.1";
$username = "root";
$password ="12345678";
$connection = mysql_connect($hostname, $username, $password) or die("Could not open connection to database");
mysql_select_db("membership", $connection) or die("Could not select database");


/* set out document type to text/javascript instead of text/html */
header("Content-type: text/javascript");

/* our multidimentional php array to pass back to javascript via ajax */
$arr = array();
$sql = "select * from thread";
$result=mysql_query($sql);


while ($row = mysql_fetch_assoc($result)){
	$array = array(
		"threadid" => $row['threadid'],
		"creator" => $row['creator'],
		"topic" => $row['topic'],
		"content" => $row['content']	
	);
	array_push($arr, $array);
}


/* encode the array as json. this will output [{"first_name":"Darian","last_name":"Brown","age":"28","email":"darianbr@example.com"},{"first_name":"John","last_name":"Doe","age":"47","email":"john_doe@example.com"}] */
echo json_encode($arr);
?>