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
//selecting all records from the members table. Return an error if there are no records in the tables
$result=mysql_query("SELECT * FROM members LIMIT $startrow, 10")
or die("There are no records to display ... \n" . mysql_error()); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Members</title>
	<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
</head>
	<body>
		<div id="page">
		<div id="header">
		<h1>Customers Management </h1>
		<a href="index.php">Home</a> | <a href="categories.php">Categories</a> | <a href="foods.php">Foods</a> | <a href="accounts.php"> > Accounts < </a> | <a href="orders.php">Orders</a> | <a href="reservations.php">Reservations</a> | <a href="specials.php">Specials</a> | <a href="allocation.php">Staff</a> | <a href="messages.php">Messages</a> | <a href="options.php">Options</a> | <a href="content.php">Content</a> | <a href="template.php">Template</a> | <a href="logout.php">Logout</a>
		</div>
		<div id="container">
			<fieldset><legend>Customers List</legend>
				<table border="1" width="930" align="center">
					<tr>
						<td colspan="5" align="right">
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
					<th>Customer ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Action(s)</th>
					</tr>

					<?php
					//loop through all table rows
					while ($row=mysql_fetch_array($result)){
					echo "<tr>";
					echo "<td>" . $row['member_id']."</td>";
					echo "<td>" . $row['firstname']."</td>";
					echo "<td>" . $row['lastname']."</td>";
					echo "<td>" . $row['login']."</td>";
					echo '<td><a href="delete-member.php?id=' . $row['member_id'] . '">Remove</a></td>';
					echo "</tr>";
					}
					mysql_free_result($result);
					mysql_close($link);
					?>
					<tr>
						<td colspan="5" align="right">
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