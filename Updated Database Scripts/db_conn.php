<?php
$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "imageboard_db";

if (!$conn = mysqli_connect($sname, $uname, $password, $db_name)){
echo "Connection failed!";

}
?>
