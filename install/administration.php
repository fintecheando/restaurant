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
	//checking connection and connecting to a database
	require_once('../connection/config.php');
	$db_error=false;
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		$db_error=true;
		$error_msg="Failed to connect to server: " . mysql_error();
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		$db_error=true;
		$error_msg="Unable to select database: " . mysql_error();
		}
?>
<?php
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
?>
<?php
	if(isset($_POST['Submit']) AND $db_error==false){
		//fetch admin details from the form and sanitize the POST values
		$adminName = clean($_POST['adminName']);
		$adminPass = clean($_POST['adminPass']);
		

		//Create INSERT query
		$qry = "INSERT INTO pizza_admin(Username,Password) VALUES('$adminName','".md5($adminPass)."')";
		$result = @mysql_query($qry);
		
		//Check whether the query was successful or not and only print if it failed
		if($result) {
			$okay_msg= "<p>Admin account created successfully.</p>";
			header("location: done.php");
			exit();
		}else {
			$error_msg="<p>Creating the admin account failed! Something went wrong somewhere. 
			Here is the MySQL error: </p>" . mysql_error();
		}
	}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Step 4: Administration</title>
<link href="stylesheets/install_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/install.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Admin Login Credentials </h1>
<a href="index.php">Welcome</a> -> <a href="requirements.php">Requirements</a> -> <a href="connection.php">Connection</a> -> <a href="administration.php">Administration</a>
</div>
<div id="container">
	<fieldset><legend>Administrator Details</legend>
		<form id="adminForm" name="adminForm" method="post" action="administration.php" onsubmit="return adminValidate(this)">
		  <table width="930" border="1" align="center">
		  	<tr>
				<td colspan="2" style="text-align:center;"><?php if(!empty($error_msg) AND $db_error==true) echo "<span style='color:red;'>$error_msg</span>"; else if(!empty($error_msg)) echo "<span style='color:red;'>$error_msg</span>";?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Required fields</td>
			</tr>
			<tr>
			  <th>Admin Username </th>
			  <td><font color="#FF0000">* </font><input name="adminName" type="text" class="textfield" id="adminName" maxlength="25" placeholder="enter admin username" required/></td>
			</tr>
			<tr>
			  <th>Admin Password </th>
			  <td><font color="#FF0000">* </font><input name="adminPass" type="password" class="textfield" id="adminPass" maxlength="25" placeholder="enter admin password" required/></td>
			</tr>
			<tr>
			  <td colspan="4" align="center"><input type="reset" value="Clear Fields" /></td>
			</tr>
			<tr>
			  <td colspan="4" align="center"><input type="submit" name="Submit" value="Click Here to Create Administrator Account and Proceed" /></td>
			</tr>
		  </table>
		</form>
	</fieldset>
</div>
<div id="footer">
<div class="bottom_addr">&copy; 2012-2013 Food Plaza. All Rights Reserved</div>
</div>
</div>
</body>
</html>