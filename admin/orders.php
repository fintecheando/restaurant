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
//selecting all records from almost all tables. Return an error if there are no records in the tables
$result=mysql_query("SELECT members.member_id, members.firstname, members.lastname, billing_details.Street_Address, billing_details.Mobile_No, orders_details.*, food_details.*, cart_details.*, quantities.* FROM members, billing_details, orders_details, quantities, food_details, cart_details WHERE members.member_id=orders_details.member_id AND billing_details.billing_id=orders_details.billing_id AND orders_details.cart_id=cart_details.cart_id AND cart_details.food_id=food_details.food_id AND cart_details.quantity_id=quantities.quantity_id LIMIT $startrow, 10")
or die("There are no records to display ... \n" . mysql_error()); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Orders</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page">
<div id="header">
<h1>Orders Management </h1>
<a href="index.php">Home</a> | <a href="categories.php">Categories</a> | <a href="foods.php">Foods</a> | <a href="accounts.php">Accounts</a> | <a href="orders.php"> > Orders < </a> | <a href="reservations.php">Reservations</a> | <a href="specials.php">Specials</a> | <a href="allocation.php">Staff</a> | <a href="messages.php">Messages</a> | <a href="options.php">Options</a> | <a href="content.php">Content</a> | <a href="template.php">Template</a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
<fieldset><legend>Orders List</legend>
	<table border="1" width="930" align="center">
	<tr>
		<td colspan="10" align="right">
			<?PHP
			//create a "Previous" link
			$prev = $startrow - 10;
			//only print a "Previous" link if a "Next" was clicked
			if ($prev >= 0)
			echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'"><-Previous</a>';
			
			if ($prev >= 0 AND $prev < 0)
			//create a separator
			echo ' | ';
			
			if ($prev < 0)
			//create a "Next" link
			echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+10).'">Next-></a>';
			?>
		</td>
	</tr>
	<tr>
	<th>Order ID</th>
	<th>Customer Names</th>
	<th>Food Name</th>
	<th>Food Price</th>
	<th>Quantity</th>
	<th>Total Cost</th>
	<th>Delivery Date</th>
	<th>Delivery Address</th>
	<th>Mobile No</th>
	<th>Actions(s)</th>
	</tr>

	<?php
	//loop through all tables rows
	while ($row=mysql_fetch_assoc($result)){
	echo "<tr>";
	echo "<td>" . $row['order_id']."</td>";
	echo "<td>" . $row['firstname']."\t".$row['lastname']."</td>";
	echo "<td>" . $row['food_name']."</td>";
	echo "<td>" . $row['food_price']."</td>";
	echo "<td>" . $row['quantity_value']."</td>";
	echo "<td>" . $row['total']."</td>";
	echo "<td>" . $row['delivery_date']."</td>";
	echo "<td>" . $row['Street_Address']."</td>";
	echo "<td>" . $row['Mobile_No']."</td>";
	echo '<td><a href="delete-order.php?id=' . $row['order_id'] . '">Remove</a></td>';
	echo "</tr>";
	}
	mysql_free_result($result);
	mysql_close($link);
	?>
		<tr>
			<td colspan="10" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $startrow - 10;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+10).'">Next-></a>';
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