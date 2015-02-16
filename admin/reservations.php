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
if (!isset($_GET['startrow_tables']) or !is_numeric($_GET['startrow_tables'])) {
  //we give the value of the starting row to 0 because nothing was found in URL
  $startrow_tables = 0;
//otherwise we take the value from the URL
} else {
  $startrow_tables = (int)$_GET['startrow_tables'];
}
?>
<?PHP
//check if the starting row variable was passed in the URL or not
if (!isset($_GET['startrow_partyhalls']) or !is_numeric($_GET['startrow_partyhalls'])) {
  //we give the value of the starting row to 0 because nothing was found in URL
  $startrow_partyhalls = 0;
//otherwise we take the value from the URL
} else {
  $startrow_partyhalls = (int)$_GET['startrow_partyhalls'];
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
//selecting all records from the reservations_details table based on table ids. Return an error if there are no records in the table
$tables=mysql_query("SELECT members.firstname, members.lastname, reservations_details.ReservationID, reservations_details.table_id, reservations_details.Reserve_Date, reservations_details.Reserve_Time, tables.table_id, tables.table_name FROM members, reservations_details, tables WHERE members.member_id = reservations_details.member_id AND tables.table_id=reservations_details.table_id LIMIT $startrow_tables, 5")
or die("There are no records to display ... \n" . mysql_error()); 

//selecting all records from the reservations_details table based on partyhall ids. Return an error if there are no records in the table
$partyhalls=mysql_query("SELECT members.firstname, members.lastname, reservations_details.ReservationID, reservations_details.partyhall_id, reservations_details.Reserve_Date, reservations_details.Reserve_Time, partyhalls.partyhall_id, partyhalls.partyhall_name FROM members, reservations_details, partyhalls WHERE members.member_id = reservations_details.member_id AND partyhalls.partyhall_id=reservations_details.partyhall_id LIMIT $startrow_partyhalls, 5")
or die("There are no records to display ... \n" . mysql_error()); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reservations</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page">
<div id="header">
<h1>Reservations Management </h1>
<a href="index.php">Home</a> | <a href="categories.php">Categories</a> | <a href="foods.php">Foods</a> | <a href="accounts.php">Accounts</a> | <a href="orders.php">Orders</a> | <a href="reservations.php"> > Reservations < </a> | <a href="specials.php">Specials</a> | <a href="allocation.php">Staff</a> | <a href="messages.php">Messages</a> | <a href="options.php">Options</a> | <a href="content.php">Content</a> | <a href="template.php">Template</a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
<fieldset><legend>Tables Reserved</legend>
	<table border="1" width="930" align="center">
		<tr>
			<td colspan="7" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $startrow_tables - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_tables='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_tables='.($startrow_tables+5).'">Next-></a>';
				?>
			</td>
		</tr>
	<tr>
	<th>Reservation ID</th>
	<th>First Name</th>
	<th>Last Name</th>
	<th>Table Name</th>
	<th>Reserved Date</th>
	<th>Reserved Time</th>
	<th>Action(s)</th>
	</tr>

	<?php
	//loop through all table rows
	while ($row=mysql_fetch_array($tables)){
	echo "<tr>";
	echo "<td>" . $row['ReservationID']."</td>";
	echo "<td>" . $row['firstname']."</td>";
	echo "<td>" . $row['lastname']."</td>";
	echo "<td>" . $row['table_name']."</td>";
	echo "<td>" . $row['Reserve_Date']."</td>";
	echo "<td>" . $row['Reserve_Time']."</td>";
	echo '<td><a href="delete-reservation.php?id=' . $row['ReservationID'] . '">Delete</a></td>';
	echo "</tr>";
	}
	mysql_free_result($tables);
	//mysql_close($link);
	?>
		<tr>
			<td colspan="7" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $startrow_tables - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_tables='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_tables='.($startrow_tables+5).'">Next-></a>';
				?>
			</td>
		</tr>
	</table>
</fieldset>
<hr>
<fieldset><legend>Party-Halls Reserved</legend>
	<table border="1" width="930" align="center">
		<tr>
			<td colspan="7" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $startrow_partyhalls - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_partyhalls='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_partyhalls='.($startrow_partyhalls+5).'">Next-></a>';
				?>
			</td>
		</tr>
	<tr>
	<th>Reservation ID</th>
	<th>First Name</th>
	<th>Last Name</th>
	<th>PartyHall Name</th>
	<th>Reserved Date</th>
	<th>Reserved Time</th>
	<th>Action(s)</th>
	</tr>

	<?php
	//loop through all table rows
	while ($row=mysql_fetch_array($partyhalls)){
	echo "<tr>";
	echo "<td>" . $row['ReservationID']."</td>";
	echo "<td>" . $row['firstname']."</td>";
	echo "<td>" . $row['lastname']."</td>";
	echo "<td>" . $row['partyhall_name']."</td>";
	echo "<td>" . $row['Reserve_Date']."</td>";
	echo "<td>" . $row['Reserve_Time']."</td>";
	echo '<td><a href="delete-reservation.php?id=' . $row['ReservationID'] . '">Delete</a></td>';
	echo "</tr>";
	}
	mysql_free_result($partyhalls);
	mysql_close($link);
	?>
		<tr>
			<td colspan="7" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $startrow_partyhalls - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_partyhalls='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow_partyhalls='.($startrow_partyhalls+5).'">Next-></a>';
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