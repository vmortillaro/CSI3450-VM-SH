<?php
session_start();

$user = $_POST['username'];
$pass = $_POST['password'];

//check password
if ($user == 'user' and $pass == 'pass'){ //find a way to use real user and pass
  $_SESSION['user'] = 'user';
  echo "Validated";
  $goto = "home.php";
} else if ($user == 'admin' and $pass == 'pass'){ //find a way to use real user and pass
  $_SESSION['user'] = 'admin';
  echo "Validated";
  $goto = "home.php";
} else {
  $_SESSION['user'] = '';
  echo "Not Validated";
  $goto = "login.html";
}

header("Location: {$goto}");

 ?>
