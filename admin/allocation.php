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
    
    //selecting all records from the staff table. Return an error if there are no records in the tables
    $staff=mysql_query("SELECT * FROM staff LIMIT $startrow, 5")
    or die("There are no records to display ... \n" . mysql_error()); 
?>
<?php
    //get order ids from the orders_details table based on flag=0
    $flag_0 = 0;
    $orders=mysql_query("SELECT * FROM orders_details WHERE flag='$flag_0'")
    or die("There are no records to display ... \n" . mysql_error()); 
?>
<?php
    //get reservation ids from the reservations_details table based on flag=0
    $flag_0 = 0;
    $reservations=mysql_query("SELECT * FROM reservations_details WHERE flag='$flag_0'")
    or die("There are no records to display ... \n" . mysql_error()); 
?>
<?php
    //selecting all records from the staff table. Return an error if there are no records in the tables
    $staff_1=mysql_query("SELECT * FROM staff")
    or die("There are no records to display ... \n" . mysql_error());
?>
<?php
    //selecting all records from the staff table. Return an error if there are no records in the tables
    $staff_2=mysql_query("SELECT * FROM staff")
    or die("There are no records to display ... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Staff</title>
	<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="validation/admin.js">
	</script>
</head>
	<body>
		<div id="page">
			<div id="header">
				<h1>Staff Allocation </h1>
				<a href="index.php">Home</a> | <a href="categories.php">Categories</a> | <a href="foods.php">Foods</a> | <a href="accounts.php">Accounts</a> | <a href="orders.php">Orders</a> | <a href="reservations.php">Reservations</a> | <a href="specials.php">Specials</a> | <a href="allocation.php"> > Staff < </a> | <a href="messages.php">Messages</a> | <a href="options.php">Options</a> | <a href="content.php">Content</a> | <a href="template.php">Template</a> | <a href="logout.php">Logout</a>
			</div>
			<div id="container">
				<fieldset><legend>Staff List</legend>
					<table border="1" width="600" align="center">
						<tr>
							<td colspan="5" align="right">
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
					<th>Staff ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Street Address</th>
					<th>Action(s)</th>
					</tr>

					<?php
					//loop through all table rows
					while ($row=mysql_fetch_array($staff)){
					echo "<tr>";
					echo "<td>" . $row['StaffID']."</td>";
					echo "<td>" . $row['firstname']."</td>";
					echo "<td>" . $row['lastname']."</td>";
					echo "<td>" . $row['Street_Address']."</td>";
					echo '<td><a href="delete-staff.php?id=' . $row['StaffID'] . '">Remove</a></td>';
					echo "</tr>";
					}
					mysql_free_result($staff);
					mysql_close($link);
					?>
						<tr>
							<td colspan="5" align="right">
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
			<table align="center">
			<tr>
				<td>
					<fieldset><legend>Orders Allocation</legend>
						<form id="ordersAllocationForm" name="ordersAllocationForm" method="post" action="orders-allocation.php" onsubmit="return ordersAllocationValidate(this)">
							  <table width="350" border="0" cellpadding="2" cellspacing="0">
								<tr>
									<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Required fields</td>
								</tr>
								<tr>
								  <th width="124">Order ID</th>
								  <td width="168"><font color="#FF0000">* </font><select name="orderid" id="orderid">
									<option value="select">- select order id -
									<?php 
									//loop through orders_details table rows
									while ($row=mysql_fetch_array($orders)){
									echo "<option value=$row[order_id]>$row[order_id]"; 
									}
									?>
									</select></td>
								</tr>
								<tr>
								  <th>Staff ID</th>
								  <td><font color="#FF0000">* </font><select name="staffid" id="staffid">
									<option value="select">- select staff id -
									<?php 
									//loop through staff table rows
									while ($row=mysql_fetch_array($staff_1)){
									echo "<option value=$row[StaffID]>$row[StaffID]"; 
									}
									?>
									</select></td>
								</tr>
								<tr>
								  <td>&nbsp;</td>
								  <td><input type="submit" name="Submit" value="Allocate Staff" /></td>
								</tr>
							  </table>
						</form>
					</fieldset>
				</td>
			<td>
				<fieldset><legend>Reservations Allocation</legend>
					<form id="reservationsAllocationForm" name="reservationsAllocationForm" method="post" action="reservations-allocation.php" onsubmit="return reservationsAllocationValidate(this)">
						<table width="350" border="0" align="center" cellpadding="2" cellspacing="0">
							<tr>
								<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Required fields</td>
							</tr>
							<tr>
							  <th>Reservation ID </th>
							  <td><font color="#FF0000">* </font><select name="reservationid" id="reservationid">
								<option value="select">- select reservation id -
								<?php 
								//loop through reservations_details table rows
								while ($row=mysql_fetch_array($reservations)){
								echo "<option value=$row[ReservationID]>$row[ReservationID]"; 
								}
								?>
								</select></td>
							</tr>
							<tr>
							  <th>Staff ID </th>
							  <td><font color="#FF0000">* </font><select name="staffid" id="staffid">
								<option value="select">- select staff id -
								<?php 
								//loop through staff table rows
								while ($row=mysql_fetch_array($staff_2)){
								echo "<option value=$row[StaffID]>$row[StaffID]"; 
								}
								?>
								</select></td>
							</tr>
							<tr>
							  <td>&nbsp;</td>
							  <td><input type="submit" name="Submit" value="Allocate Staff" /></td>
							</tr>
						</table>
					</form>
				</fieldset>
			</td>
			</tr>
			</table>
			<p>&nbsp;</p>
			<hr>
			</div>
			<div id="footer">
				<div class="bottom_addr">&copy; <?php echo date("Y") . " " . $name ?>. All Rights Reserved</div>
			</div>
		</div>
	</body>
</html>