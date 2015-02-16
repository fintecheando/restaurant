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
	require_once('locale.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Login Form</title>
	<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="validation/admin.js">
	</script>
</head>
	<body>
		<div id="page">
		<div id="header">
			<h1>Administrator Login </h1>
			<p align="center">&nbsp;</p>
		</div>
		<fieldset><legend>Administrator Credentials</legend>
			<form id="loginForm" name="loginForm" method="post" action="login-exec.php" onsubmit="return loginValidate(this)">
			  <table width="300" border="1" align="center">
				<tr>
				  <td width="112"><b>Username</b></td>
				  <td width="188"><input name="login" type="text" class="textfield" id="login" maxlength="15" placeholder="enter your username" required/></td>
				</tr>
				<tr>
				  <td><b>Password</b></td>
				  <td><input name="password" type="password" class="textfield" id="password" maxlength="25" placeholder="enter your password" required/></td>
				</tr>
				<tr>
				  <td><input type="reset" value="Clear Fields" /></td>
				  <td><input type="submit" name="Submit" value="Login" /></td>
				</tr>
			  </table>
			</form>
		</fieldset>
		<div id="footer">
		<div class="bottom_addr">&copy; <?php echo date("Y") . " " . $name ?>. All Rights Reserved</div>
		</div>
		</div>
	</body>
</html>
