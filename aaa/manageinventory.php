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

//before displaying, if you just updated a listing...
/*if ($_POST['process'] == 'Update'){
	//gather the returned data
	$newSKU = $_POST['newSKU'];
	$newItemnum = $_POST['newItemnum'];
	$newItemname = $_POST['newItemname'];
	$newDesc = $_POST['newDesc'];
	$newPrice = $_POST['newPrice'];
	$newType = $_POST['newType'];
	$newSysID = $_POST['newSysID'];
	$newURL = $_POST['newURL'];
	$newGenre = $_POST['newGenre'];
	$newESRB = $_POST['newESRB'];
	$newQOH = $_POST['newQOH'];
    //update item_info(item_num, item_name, description, price, item_type, sys_id, genre, esrb, qoh) values ('$eItemnum', '$eItemname', '$eDesc', '$ePrice', '$eType', '$eSysID', '$eGenre', '$eESRB', '$eQOH')";
    $sql = "update item_info set item_num = '$newItemnum' where sku_num = '$newSKU'";
    echo $sql;
} // end if ($_POST['process'] == 'Update') */


//title
echo "<h3>Manage Inventory:</h3>";

//create display to prompt user to enter a sku
$skuform = <<<skuform
<form action='manageinventory.php' method='POST'>
<label style="flex-grow: 1">Enter the SKU of the item you want to edit or create: </label>
<input style="flex-grow: 1" type='text' name='searchSKU'> <br />
<input type='submit' value='Check SKU' name='process'>
</form>
skuform;
//output display
echo $skuform;

echo "8";

if ($_POST['process'] == 'Check SKU'){
	//check database for if sku exists, then if it does output and prompt to edit, if not, ask to create

	//return the sku that user is searching for
  $searchSKU = $_POST['searchSKU'];

	//pull a list of all sku nums that exist in database
  $sql = "select sku_num from item_info where sku_num = " . $searchSKU . ";";
  $result = $conn->query($sql);

	//if there is exactly one match...
  if(1 == $result->num_rows){
		//gather the full data from the matching row
    $sql = "select * from item_info left join systems on item_info.sys_id = systems.sys_id where sku_num = " . $searchSKU . ";";
    $result = $conn->query($sql);
		$row = mysql_fetch_row($result);

			//put individual data points into variables
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
echo $eItemnum;
		//create display showing the item info and prompt user to edit it
    $displayolditem = <<<displayolditem
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
		displayolditem;
		//display the info
		echo $displayolditem;
		/*
		$editingprompt = <<<editingprompt
      <form action='manageinventory.php' method='POST'>
          <label style="flex-grow: 1">Do you want to edit this item?</label>
          <input type='hidden' value=$eSKU name='oldSKU'>
          <input type='hidden' value=$eItemnum name='oldItemnum'>
          <input type='hidden' value=$eItemname name='oldItemname'>
          <input type='hidden' value=$eDesc name='oldDesc'>
          <input type='hidden' value=$ePrice name='oldPrice'>
          <input type='hidden' value=$eType name='oldType'>
          <input type='hidden' value=$eSysID name='oldSysID'>
					<input type='hidden' value=$eSystem name='oldSystem'>
					<input type='hidden' value=$eURL name='oldURL'>
          <input type='hidden' value=$eGenre name='oldGenre'>
          <input type='hidden' value=$eESRB name='oldESRB'>
          <input type='hidden' value=$eQOH name='oldQOH'>
          <input type='submit' value='Edit Item' name='process'>
      </form>
			editingprompt;
			//display theprompt
			echo $editingprompt;
*/
	} else if($count > 1) {
		echo "There was an error: There are multiple items matching that SKU. SKU should be unique. count = " . $count;
	} else if($count < 1) {
		echo "There are no items with that SKU number.";
	} else {
		echo "There was an error in locating the item.";
	}//end "if($count == 1)"
} //end "if ($_POST['process'] == 'Check SKU')"


/*if($_POST['process'] == 'Edit Item'){
	//fetch old data for item
	$editSKU = $_POST['oldSKU'];
	$editItemnum = $_POST['oldItemnum'];
	$editItemname = $_POST['oldItemname'];
	$editDesc = $_POST['oldDesc'];
	$editPrice = $_POST['oldPrice'];
	$editType = $_POST['oldType'];
	$editSysID = $_POST['oldSysID'];
	$editSystem = $_POST['oldSystem'];
	$editURL = $_POST['oldURL'];
	$editGenre = $_POST['oldGenre'];
	$editESRB = $_POST['oldESRB'];
	$editQOH = $_POST['oldQOH'];

	//create display that allows users to edit the current data
  $editfields = <<<editfields
  <form action='manageinventory.php' method='POST'>
    <label style="flex-grow: 1">SKU: </label>
    <label style="flex-grow: 1"> $editSKU </label>
		<input type='hidden' value=$editSKU name='newSKU'> <br />
		<label style="flex-grow: 1">Item Image URL: </label>
    <input style="flex-grow: 1" type='text' name='newURL' value=$editURL> <br />
		<label style="flex-grow: 1">Item number: </label>
    <input style="flex-grow: 1" type='text' name='newItemnum' value=$editItemnum> <br />
    <label style="flex-grow: 1">Item name: </label>
    <input style="flex-grow: 1" type='text' name='newItemname' value=$editItemname> <br />
    <label style="flex-grow: 1">Description: </label>
    <input style="flex-grow: 1" type='text' name='newDesc' value=$editDesc> <br />
    <label style="flex-grow: 1">Price: </label>
    <input style="flex-grow: 1" type='text' name='newPrice' value=$editPrice> <br />
    <label style="flex-grow: 1">Type: </label>
    <input style="flex-grow: 1" type='text' name='newType' value=$editType> <br />
    <label style="flex-grow: 1">System ID: </label>
    <input style="flex-grow: 1" type='text' name='newSysID' value=$editSysID> <br />
    <label style="flex-grow: 1">Genre: </label>
    <input style="flex-grow: 1" type='text' name='newGenre' value=$editGenre> <br />
    <label style="flex-grow: 1">ESRB: </label>
    <input style="flex-grow: 1" type='text' name='newESRB' value=$editESRB> <br />
    <label style="flex-grow: 1">Quantity On Hand: </label>
    <input style="flex-grow: 1" type='text' name='newQOH' value=$editQOH> <br />
    <input type='submit' value='Update' name='process'>
    </form>
  editfields;
	//output the display
	echo $editfields;
} // end if ($_POST['process'] == 'Edit Item')*/
 ?>
</body>
</html>
