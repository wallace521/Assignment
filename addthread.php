<?php 
$hostname = "127.0.0.1";
$username = "root";
$password ="12345678";
$connection = mysql_connect($hostname, $username, $password) or die("Could not open connection to database");

// GET the POST variable assign to username and pwd field

/* 
$username=$post_vars['userid'];
$pwd=$post_vars['password'];
*/

// GET the method that the method used in client side
$method = $_SERVER["REQUEST_METHOD"];

$num_row = 0;
mysql_select_db("membership", $connection) or die("Could not select database");

switch ($method) {
// ====================================GET METHOD==========================================================================
  case 'GET':
	$username=$_GET['userid'];
	$pwd=$_GET['password'];	
	$result = mysql_query("select * from members where login='$username' and password='$pwd' ") or die("Could not issue MySQL query");
	$num_row = mysql_num_rows($result);

// ====================================PUT METHOD==========================================================================
	
  case 'PUT':
	parse_str(file_get_contents("php://input"),$post_vars);
	$username=$post_vars['userid'];
	$pwd=$post_vars['password'];
	//echo $username;
	//echo "select * from members where login='$username' and password='$pwd' ";
	$result = mysql_query("select * from members where login='$username' and password='$pwd' ") or die("Could not issue MySQL query");
	$num_row = mysql_num_rows($result);
	
// ====================================POST METHOD==========================================================================	
	
  case 'POST':
    // $_POST['xxx'];
	$topic = $_POST['topic'];
	$content = $_POST['content'];
	$session = $_POST['session'];
	$sql = "insert into thread (creator,topic,content) values ('$session','$topic','$content') ";
	$result = mysql_query($sql) or die("Could not issue MySQL query");
	
	
// ====================================DELETE METHOD==========================================================================	
	
  case 'DELETE':
  $username1=$post_vars['userid'];
	$pwd=$post_vars['password'];
	parse_str(file_get_contents("php://input"),$post_vars);
	$result = mysql_query("select * from members where login='$username' and password='$pwd' ") or die("Could not issue MySQL query");
	$num_row = mysql_num_rows($result);
	
}
echo $result;


/*
mysql_select_db("membership", $connection) or die("Could not select database");
$result = mysql_query("select * from members where login='$username' and password='$pwd' ") or die("Could not issue MySQL query");

$num_row=mysql_num_rows($result);
echo $num_row;














// --------------------------------------------------------




// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
 
// connect to the mysql database
$link = mysqli_connect('localhost', 'user', 'pass', 'dbname');
mysqli_set_charset($link,'utf8');
 
// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$key = array_shift($request)+0;
 
// escape the columns and values from the input object
$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
$values = array_map(function ($value) use ($link) {
  if ($value===null) return null;
  return mysqli_real_escape_string($link,(string)$value);
},array_values($input));
 
// build the SET part of the SQL command
$set = '';
for ($i=0;$i<count($columns);$i++) {
  $set.=($i>0?',':'').'`'.$columns[$i].'`=';
  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
}
 
// create SQL based on HTTP method
switch ($method) {
  case 'GET':
    $sql = "select * from `$table`".($key?" WHERE id=$key":''); break;
  case 'PUT':
    $sql = "update `$table` set $set where id=$key"; break;
  case 'POST':
    $sql = "insert into `$table` set $set"; break;
  case 'DELETE':
    $sql = "delete `$table` where id=$key"; break;
}
 
// excecute SQL statement
$result = mysqli_query($link,$sql);
 
// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}
 
// print results, insert id or affected row count
if ($method == 'GET') {
  if (!$key) echo '[';
  for ($i=0;$i<mysqli_num_rows($result);$i++) {
    echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
  }
  if (!$key) echo ']';
} elseif ($method == 'POST') {
  echo mysqli_insert_id($link);
} else {
  echo mysqli_affected_rows($link);
}
 
// close mysql connection
mysqli_close($link);
*/
?>