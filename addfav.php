<?php
$hostname = "127.0.0.1";
$username = "root";
$password ="12345678";
$connection = mysql_connect($hostname, $username, $password) or die("Could not open connection to database");
mysql_select_db("membership", $connection) or die("Could not select database");


/* set out document type to text/javascript instead of text/html */
header("Content-type: text/javascript");

$username=$_GET['username'];
$selection=$_GET['selection'];

$arr = array();
$sql = "select artname from favlist where username = '$username' and artname = '$selection'";
$result=mysql_query($sql);


while ($row = mysql_fetch_assoc($result)){
	$array = array(
			"artname" => $row['artname'],
	);
	array_push($arr, $array);
}

if (empty($arr)) {
	$sql = "insert into favlist (artname,username) values ('$selection','$username') ";
	$result = mysql_query($sql) or die("Could not issue MySQL query");
	header("Location: druglist.html");
}
else
echo ("Article is already added in favourite list!");
?>