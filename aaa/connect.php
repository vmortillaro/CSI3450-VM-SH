<?php

$hostname="35.188.105.248";
$username="root";
$password="root";
$dbname="mydb";
//port of mysql database, NOT of the apache server
$port="3306";

$conn = new mysqli($hostname, $username, $password, $dbname, $port);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected <br />";
 ?>
