<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
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

echo "<h3>Create New Invoice:</h3>";

$invform = <<<invform
<form action='addinvoiceitem.php' method='POST'>
<label style="flex-grow: 1">Invoice Number: </label>
<input style="flex-grow: 1" type='text' id="jInv" name='eInv' /> <br />
<label style="flex-grow: 1">Sale Date: </label>
<input type="date" id="jDate" name="eDate"><br />
<label style="flex-grow: 1">Employee ID: </label>
<input style="flex-grow: 1" type='text' id="jEID" name='eEID' /> <br />
<input type='submit' value='Create Invoice' name='process'>
</form>
invform;

echo $invform;

echo "<h3>Add Item To Invoice:</h3>";

$itemform = <<<itemform
<form action='addinvoiceitem.php' method='POST'>
<label style="flex-grow: 1">Invoice Number: </label>
<input style="flex-grow: 1" type='text' id="jInv" name='eInv' /> <br />
<label style="flex-grow: 1">SKU Number: </label>
<input style="flex-grow: 1" type='text' id="jSKU" name='eSKU' /> <br />
<label style="flex-grow: 1">Quantity Sold: </label>
<input style="flex-grow: 1" type='text' id="jQty" name='eQty' /> <br />
<label style="flex-grow: 1">Sold Price: </label>
<input style="flex-grow: 1" type='text' id="jPrice" name='ePrice' /> <br />
<input type='submit' value='Add Item' name='process'>
</form>
itemform;

echo $itemform;

if ($_POST['process'] == 'Create Invoice'){
  $eInv = $_POST['eInv'];
  $eDate = $_POST['eDate'];
  $eEID = $_POST['eEID'];
  $sql = "insert into invoice(invoice_num, sale_date, EMP_ID) values ('$eInv', '$eDate', '$eEID')";
  echo $sql;
	echo "<br />";
  if ($conn->query($sql) == TRUE)
  {
    echo "Invoice was created";
  }
  else {
    echo "Error: $conn->error";
  }
}else if ($_POST['process'] == 'Add Item'){
  $eInv = $_POST['eInv'];
  $eSKU = $_POST['eSKU'];
  $eQty = $_POST['eQty'];
	$ePrice = $_POST['ePrice'];
  $sql = "insert into sold_items(invoice_num, sku_num, qty_sold, sold_price) values ('$eInv', '$eSKU', '$eQty', '$ePrice')";
  echo $sql;
	echo "<br />";
  if ($conn->query($sql) == TRUE)
  {
    echo "Item was added to the invoice";
  }
  else {
    echo "Error: $conn->error";
  }
}


 ?>
</body>
</html>
