<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Inventory</title>
</head>


<body>

<?php
session_start();

//authenticate session
if (! $_SESSION['user'] == 'user' || ! $_SESSION['user'] == 'admin')
{
  header("Location: login.html");
}

//did a button get pressed to go to another page?
if ($_POST['process'] == 'Catalog'){
	header("Location: home.php");
} else if ($_POST['process'] == 'Edit Inventory'){
	header("Location: manageinventory.php");
} else if ($_POST['process'] == 'Manage Invoice'){
	header("Location: addinvoiceitem.php");
} else if ($_POST['process'] == 'Logout'){
	$_SESSION['user'] = '';
	header("Location: login.html");
}

//initiate database connection
require "connect.php";

//create navigation bar
$navbar = <<<navbar
<form action='home.php' method='POST'>
	<input type='submit' value='Catalog' name='process'>
	<input type='submit' value='Edit Inventory' name='process'>
	<input type='submit' value='Manage Invoice' name='process'>
	<input type='submit' value='Logout' name='process'>
</form>
navbar;
//output navigation bar
echo $navbar;



//create search menu
//$searchbar = <<<searchbar
//searchbar;
//display search menu
//echo searchbar;

//assemble sql query based on
$sql = "select * from item_info left join systems on item_info.sys_id = systems.sys_id";
//submit query and gather results into $result
$result = $conn->query($sql);


//display results

echo "<h3>Search Results:</h3>";
//"Found n results"
if ($result->num_rows > 0)
{
  echo "Found " . $result->num_rows . " results <br />";
}
else {
  echo "No results found <br />";
}

//start while loop
//fetch one row
while($row = $result->fetch_assoc()){
	//dump row contents into variables
  $eSKU = $row['sku_num'];
  $eItemnum = $row['item_num'];
	$eItemname = $row['item_name'];
	$eDesc = $row['description'];
	$ePrice = $row['price'];
	$eType = $row['item_type'];
	$eSysID = $row['sys_id'];
	$eSystem = $row['sys_name'];
	$eURL = $row['image_url'];
	$eGenre = $row['genre'];
	$eESRB = $row['ESRB'];
	$eQOH = $row['qoh'];

	//create display to output row contents
	$searchresult = <<<searchresult
		<div class="container">
			<hr/>
			<h3>$eItemname</h3>
			system: $eSystem <br/><br/>
			Item num:	$eItemnum<br/>
			SKU: $eSKU<br/>
			<hr/>
			Description: $eDesc <br/>
			<hr/>
			QOH: $eQOH <br/>
			Price: $ePrice<br/>
			<hr/>
		</div>
	searchresult;
	//output search result
	echo $searchresult;
}
//end while loop


 ?>
</body>
</html>
