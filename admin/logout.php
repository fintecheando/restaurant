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
	//Start session
	session_start();
	
	//Unset the variables stored in session
	unset($_SESSION['SESS_ADMIN_ID']);
	unset($_SESSION['SESS_ADMIN_NAME']);
?>
<?php
	require_once('locale.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Logged Out</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page">
<div id="header">
<h1>Logout </h1>
<p align="center">&nbsp;</p>
</div>
<h4 align="center" class="err">You have been logged out.</h4>
<p align="center"><a href="login-form.php">Click Here</a> to Login</p>
<div id="footer">
<div class="bottom_addr">&copy; <?php echo date("Y") . " " . $name ?>. All Rights Reserved</div>
</div>
</div>
</body>
</html>
