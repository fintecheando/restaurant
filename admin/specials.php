<?
	/*****************************************************
	Developer: macdonaldgeek
	Email: admin@restaurantmis.tk
	Phone: +255-657-567401/+254-717-667201/+44-744-0579061
	Twitter: @macdonaldgeek

	COPYRIGHT ©2014 RESTAURANT SCRIPT. ALL RIGHTS RESERVED
	******************************************************/
?>
<?php
	require_once('auth.php');
	require_once('locale.php');
?>
<?PHP
//check if the starting row variable was passed in the URL or not
if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
  //we give the value of the starting row to 0 because nothing was found in URL
  $startrow = 0;
//otherwise we take the value from the URL
} else {
  $startrow = (int)$_GET['startrow'];
}
?>
<?php
//checking connection and connecting to a database
require_once('connection/config.php');
//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
//retrive promotions from the specials table
$result=mysql_query("SELECT * FROM specials LIMIT $startrow, 5")
or die("There are no records to display ... \n" . mysql_error()); 
?>
<?php
    //retrive a currency from the currencies table
    //define a default value for flag_1
    $flag_1 = 1;
    $currencies=mysql_query("SELECT * FROM currencies WHERE flag='$flag_1'")
    or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Specials</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Specials Management </h1>
<a href="index.php">Home</a> | <a href="categories.php">Categories</a> | <a href="foods.php">Foods</a> | <a href="accounts.php">Accounts</a> | <a href="orders.php">Orders</a> | <a href="reservations.php">Reservations</a> | <a href="specials.php"> > Specials < </a> | <a href="allocation.php">Staff</a> | <a href="messages.php">Messages</a> | <a href="options.php">Options</a> | <a href="content.php">Content</a> | <a href="template.php">Template</a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
<fieldset><legend>New Promotion</legend>
	<table width="930" align="center">
	<form name="specialsForm" id="specialsForm" action="specials-exec.php" method="post" enctype="multipart/form-data" onsubmit="return specialsValidate(this)">
	<tr>
		<th>Name</th>
		<th>Description</th>
		<th>Price</th>
		<th>Start Date</th>
		<th>End Date</th>
	</tr>
	<tr>
		<td><input type="text" name="name" id="name" class="textfield" maxlength="15" placeholder="name the promo" required/></td>
		<td><textarea name="description" id="description" class="textfield" rows="2" cols="15" maxlength="45" placeholder="describe the promo" required></textarea></td>
		<td><input type="number" name="price" id="price" class="textfield" maxlength="5" placeholder="price the promo" required/></td>
		<td><input type="date" name="start_date" id="start_date" class="textfield" required/></td>
		<td><input type="date" name="end_date" id="end_date" class="textfield" required /></td>
	</tr>
	<tr>
		<th>Photo</th>
		<th>Action(s)</th>
	</tr>
	<tr>
		<td><input type="file" name="photo" id="photo" required/></td>
		<td><input type="submit" name="Submit" value="Add" /></td>
	</tr>
	</form>
	</table>
</fieldset>
<hr>
<fieldset><legend>Created Promotions</legend>
	<table width="930" align="center" border="1">
		<tr>
			<td colspan="7" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $startrow - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+5).'">Next-></a>';
				?>
			</td>
		</tr>
	<tr>
	<th>Promo Photo</th>
	<th>Promo Name</th>
	<th>Promo Description</th>
	<th>Promo Price</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>Action(s)</th>
	</tr>

	<?php
	//loop through all table rows
	$symbol=mysql_fetch_assoc($currencies); //gets active currency
	while ($row=mysql_fetch_array($result)){
	echo "<tr>";
	echo '<td><img src=../images/'. $row['special_photo']. ' width="80" height="70"></td>';
	echo "<td>" . $row['special_name']."</td>";
	echo "<td width='180' align='left'>" . $row['special_description']."</td>";
	echo "<td>" . $symbol['currency_symbol']. "" . $row['special_price']."</td>";
	echo "<td>" . $row['special_start_date']."</td>";
	echo "<td>" . $row['special_end_date']."</td>";
	echo '<td><a href="delete-special.php?id=' . $row['special_id'] . '">Remove</a></td>';
	echo "</tr>";
	}
	mysql_free_result($result);
	mysql_close($link);
	?>
		<tr>
			<td colspan="7" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $startrow - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+5).'">Next-></a>';
				?>
			</td>
		</tr>
	</table>
</fieldset>
<hr>
</div>
<div id="footer">
<div class="bottom_addr">&copy; <?php echo date("Y") . " " . $name ?>. All Rights Reserved</div>
</div>
</div>
</body>
</html>