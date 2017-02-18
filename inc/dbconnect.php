<?php

//define connection specifications
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "dynweb_inl3");

//make a variable that can be used throughout the pages
$conn = mysqli_connect("localhost", "root", "", "dynweb_inl3");

//connect to database
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($mysqli->connect_errno) {
	echo "fail";
}



?>