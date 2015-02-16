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
	require_once('styles.php');
	require_once('locale.php');
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
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
		if (isset($_POST['Submit'])){
		//setup a directory where location will be saved 
		$target = "../images/";
		$target = $target . basename( $_FILES['site_logo']['name']);
		
		//Sanitize the POST values
		$primary = clean(1);
		$logo = clean($_FILES['site_logo']['name']);
		$background = clean($_FILES['site_background']['name']);
		$header = clean($_FILES['site_header']['name']);
		$center = clean($_FILES['site_center']['name']);
		$footer = clean($_FILES['site_footer']['name']);
		$background_color = clean($_POST['background_color']);
		$center_color = clean($_POST['center_color']);
		$footer_color = clean($_POST['footer_color']);

		// update query
		$result = mysql_query("UPDATE template SET site_logo='$logo',site_background='$background',site_header='$header',
		site_center='$center',site_footer='$footer',site_background_color='$background_color',site_center_color='$center_color',
		site_footer_color='$footer_color' WHERE template_id='$primary'"); 

		if ($result){
			//Writes the photo to the server 
			 $moved_logo = move_uploaded_file($_FILES['site_logo']['tmp_name'], $target);
			 
			 if($moved_logo){
				 //everything is okay
				 echo "The location ". basename( $_FILES['site_logo']['name']). " has been uploaded successfully."; 
			 } else {  
				 //Gives an error if its not okay 
				 echo "Sorry, there was a problem uploading your restaurant logo ... the actual error is "  . $_FILES["site_logo"]["error"]; 
			 }
				// redirect back to content page
				header("Location: template.php");
				exit();
			}
		else{
			die("updating changes failed ... the MySql error is " . mysql_error());
		}
	}
?>
<?php
	if($logo=="" && $background=="" && $header=="" && $center=="" && $footer==""){
		$logo=$background=$header=$center=$footer="default";
	}
	else{
		
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Template</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Template Management </h1>
<a href="index.php">Home</a> | <a href="categories.php">Categories</a> | <a href="foods.php">Foods</a> | <a href="accounts.php">Accounts</a> | <a href="orders.php">Orders</a> | <a href="reservations.php">Reservations</a> | <a href="specials.php">Specials</a> | <a href="allocation.php">Staff</a> | <a href="messages.php">Messages</a> | <a href="options.php">Options</a> | <a href="content.php">Content</a> | <a href="template.php"> > Template < </a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
	<form name="templateForm" id="templateForm" action="template.php" method="post" enctype="multipart/form-data" onsubmit="return templateValidate(this)">
		<fieldset><legend align="center">Manage Site Appearance</legend>
			<fieldset><legend>Site Logo</legend>
				<table width="810" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<th></th>
						<th>Logo</th>
					</tr>
					<tr>
						<td><?php echo '<img src=../images/'. $logo. ' width="100" height="90">'; ?></td>
						<td><input type="file" name="site_logo" id="site_logo"/></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Site Background</legend>
				<table width="810" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<th></th>
						<th>Background</th>
					</tr>
					<tr>
						<td><?php echo '<img src=../images/'. $background. ' width="100" height="90">'; ?></td>
						<td><input type="file" name="site_background" id="site_background"/></td>
						<td>set background color: <input type="color" name="background_color" id="background_color"/></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Site Header</legend>
				<table width="810" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<th></th>
						<th>Header</th>
					</tr>
					<tr>
						<td><?php echo '<img src=../images/'. $header. ' width="100" height="90">'; ?></td>
						<td><input type="file" name="site_header" id="site_header"/></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Site Center</legend>
				<table width="810" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<th></th>
						<th>Center</th>
					</tr>
					<tr>
						<td><?php echo '<img src=../images/'. $center. ' width="100" height="90">'; ?></td>
						<td><input type="file" name="site_center" id="site_center"/></td>
						<td>set background color: <input type="color" name="center_color" id="center_color"/></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Site Footer</legend>
				<table width="810" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<th></th>
						<th>Footer</th>
					</tr>
					<tr>
						<td><?php echo '<img src=../images/'. $footer. ' width="100" height="90">'; ?></td>
						<td><input type="file" name="site_footer" id="site_footer"/></td>
						<td>set background color: <input type="color" name="footer_color" id="footer_color"/></td>
					</tr>
				</table>
			</fieldset>
			<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td colspan="2" align="center">Actions</td>
				</tr>
				<tr>
					<td><input type="reset" value="Clear Fields"/></td>
					<td><input type="submit" name="Submit" value="Update Changes" /></td>
				</tr>
			</table>
		</fieldset>
	</form>	
</div>
<div id="footer">
<div class="bottom_addr">&copy; <?php echo date("Y") . " " . $name ?>. All Rights Reserved</div>
</div>
</div>
</body>
</html>