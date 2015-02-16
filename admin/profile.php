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
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Profile</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Profile </h1>
<a href="index.php">Home</a> | <a href="categories.php">Categories</a> | <a href="foods.php">Foods</a> | <a href="accounts.php">Accounts</a> | <a href="orders.php">Orders</a> | <a href="reservations.php">Reservations</a> | <a href="specials.php">Specials</a> | <a href="allocation.php">Staff</a> | <a href="messages.php">Messages</a> | <a href="options.php">Options</a> | <a href="content.php">Content</a> | <a href="template.php">Template</a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
<table align="center">
<tr>
<td>
	<fieldset><legend>Update Admin Password</legend>
		<form id="updateForm" name="updateForm" method="post" action="update-exec.php?id=<?php echo $_SESSION['SESS_ADMIN_ID'];?>" onsubmit="return updateValidate(this)">
		  <table width="400" border="1">
			<tr>
				<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Required fields</td>
			</tr>
			<tr>
			  <th width="124">Current Password</th>
			  <td width="168"><font color="#FF0000">* </font><input name="opassword" type="password" class="textfield" id="opassword" maxlength="15" placeholder="provide admin current password" required/></td>
			</tr>
			<tr>
			  <th>New Password</th>
			  <td><font color="#FF0000">* </font><input name="npassword" type="password" class="textfield" id="npassword" maxlength="15" placeholder="provide admin new password" required/></td>
			</tr>
			<tr>
			  <th>Confirm New Password</th>
			  <td><font color="#FF0000">* </font><input name="cpassword" type="password" class="textfield" id="cpassword" maxlength="15" placeholder="repeat admin new password" required/></td>
			</tr>
			<tr>
			  <td><input type="reset" value="Clear Fields" /></td>
			  <td><input type="submit" name="Submit" value="Update" /></td>
			</tr>
		  </table>
		 </form>
	</fieldset>
</td>
<td>
	<fieldset><legend>New Staff</legend>
		<form id="staffForm" name="staffForm" method="post" action="staff-exec.php" onsubmit="return staffValidate(this)">
		  <table width="320" border="1" align="center">
			<tr>
				<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Required fields</td>
			</tr>
			<tr>
			  <th>First Name </th>
			  <td><font color="#FF0000">* </font><input name="fName" type="text" class="textfield" id="fName" maxlength="15" placeholder="enter first name" required/></td>
			</tr>
			<tr>
			  <th>Last Name </th>
			  <td><font color="#FF0000">* </font><input name="lName" type="text" class="textfield" id="lName" maxlength="15" placeholder="enter surname" required/></td>
			</tr>
			 <tr>
			  <th>Street Address </th>
			  <td><font color="#FF0000">* </font><textarea name="sAddress" id="sAddress" class="textfield" rows="4" cols="30" maxlength="100" placeholder="enter physical address using the standard format" required></textarea></td>
			</tr>
			<tr>
			  <th>Mobile/Tel </th>
			  <td><font color="#FF0000">* </font><input name="mobile" type="tel" class="textfield" id="mobile" maxlength="10" placeholder="0715000000" required/></td>
			</tr>
			<tr>
			  <td><input type="reset" value="Clear Fields" /></td>
			  <td><input type="submit" name="Submit" value="Add" /></td>
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
