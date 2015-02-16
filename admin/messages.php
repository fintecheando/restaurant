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
if (!isset($_GET['sent_startrow']) or !is_numeric($_GET['sent_startrow'])) {
  //we give the value of the starting row to 0 because nothing was found in URL
  $sent_startrow = 0;
//otherwise we take the value from the URL
} else {
  $sent_startrow = (int)$_GET['sent_startrow'];
}
?>
<?PHP
//check if the starting row variable was passed in the URL or not
if (!isset($_GET['received_startrow']) or !is_numeric($_GET['received_startrow'])) {
  //we give the value of the starting row to 0 because nothing was found in URL
  $received_startrow = 0;
//otherwise we take the value from the URL
} else {
  $received_startrow = (int)$_GET['received_startrow'];
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
//selecting all records from the messages table. Return an error if there is a problem
$sent_flag=0; //return sent messages only
$received_flag=1; //return received messages only
$sent=mysql_query("SELECT * FROM messages WHERE message_flag='$sent_flag' LIMIT $sent_startrow, 5")
or die("There are no records to display ... \n" . mysql_error()); 
$received=mysql_query("SELECT * FROM messages WHERE message_flag='$received_flag' LIMIT $received_startrow, 5")
or die("There are no records to display ... \n" . mysql_error()); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Messages</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Messages Management </h1>
<a href="index.php">Home</a> | <a href="categories.php">Categories</a> | <a href="foods.php">Foods</a> | <a href="accounts.php">Accounts</a> | <a href="orders.php">Orders</a> | <a href="reservations.php">Reservations</a> | <a href="specials.php">Specials</a> | <a href="allocation.php">Staff</a> | <a href="messages.php"> > Messages < </a> | <a href="options.php">Options</a> | <a href="content.php">Content</a> | <a href="template.php">Template</a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
<fieldset><legend>Send Messages</legend>
<form id="messageForm" name="messageForm" method="post" action="message-exec.php" onsubmit="return messageValidate(this)">
  <table width="540" border="0" cellpadding="2" cellspacing="0" align="center">
    <tr>
      <th width="200">Subject</th>
      <td width="168"><input type="text" name="subject" id="subject" class="textfield" maxlength="45" placeholder="subject for the message" required/></td>
    </tr>
    <tr>
      <th width="200">Message Box</th>
      <td width="168"><textarea name="txtmessage" class="textfield" rows="5" cols="60" maxlength="250" placeholder="write your message here to send to all your customers" required></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center"><input type="submit" name="Submit" value="Send Message" />
	  <input type="reset" name="Reset" value="Clear Fields" /></td>
    </tr>
  </table>
</form>
</fieldset>
<hr>
<fieldset><legend>Sent Messages</legend>
<table border="1" width="940" align="center">
		<tr>
			<td colspan="6" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $sent_startrow - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?sent_startrow='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?sent_startrow='.($sent_startrow+5).'">Next-></a>';
				?>
			</td>
		</tr>
<tr>
<th>ID</th>
<th>Date Sent</th>
<th>Time Sent</th>
<th>Subject</th>
<th>Message</th>
<th>Action(s)</th>
</tr>

<?php
//loop through all table rows
while ($row=mysql_fetch_array($sent)){
echo "<tr>";
echo "<td>" . $row['message_id']."</td>";
echo "<td>" . $row['message_date']."</td>";
echo "<td>" . $row['message_time']."</td>";
echo "<td>" . $row['message_subject']."</td>";
echo "<td width='300' align='left'>" . $row['message_text']."</td>";
echo '<td><a href="delete-message.php?id=' . $row['message_id'] . '">Remove</a></td>';
echo "</tr>";
}
mysql_free_result($sent);
?>
		<tr>
			<td colspan="6" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $sent_startrow - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?sent_startrow='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?sent_startrow='.($sent_startrow+5).'">Next-></a>';
				?>
			</td>
		</tr>
</table>
</fieldset>
<fieldset><legend>Received Messages</legend>
<table border="1" width="940" align="center">
		<tr>
			<td colspan="8" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $received_startrow - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?received_startrow='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?received_startrow='.($received_startrow+5).'">Next-></a>';
				?>
			</td>
		</tr>
<tr>
<th>ID</th>
<th>Date Received</th>
<th>Time Received</th>
<th>From</th>
<th>Email</th>
<th>Subject</th>
<th>Message</th>
<th>Action(s)</th>
</tr>

<?php
//loop through all table rows
while ($row=mysql_fetch_array($received)){
echo "<tr>";
echo "<td>" . $row['message_id']."</td>";
echo "<td>" . $row['message_date']."</td>";
echo "<td>" . $row['message_time']."</td>";
echo "<td>" . $row['message_from']."</td>";
echo "<td>" . $row['message_email']."</td>";
echo "<td>" . $row['message_subject']."</td>";
echo "<td width='300' align='left'>" . $row['message_text']."</td>";
echo '<td><a href="delete-message.php?id=' . $row['message_id'] . '">Remove</a></td>';
echo "</tr>";
}
mysql_free_result($received);
mysql_close($link);
?>
		<tr>
			<td colspan="8" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $received_startrow - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?received_startrow='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?received_startrow='.($received_startrow+5).'">Next-></a>';
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