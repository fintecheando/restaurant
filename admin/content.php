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
		$target = $target . basename( $_FILES['location']['name']);
		
		//Sanitize the POST values
		$primary = clean(1);
		$name = clean($_POST['name']);
		$title = clean($_POST['title']);
		$subtitle = clean($_POST['subtitle']);
		$about = clean($_POST['about']);
		$mission = clean($_POST['mission']);
		$vision = clean($_POST['vision']);
		$contacts = clean($_POST['contacts']);
		$location = clean($_FILES['location']['name']);
		$specials = clean($_POST['specials']);
		$account = clean($_POST['account']);
		$profile = clean($_POST['profile']);
		$inbox = clean($_POST['inbox']);
		$tables = clean($_POST['tables']);
		$partyhalls = clean($_POST['partyhalls']);
		$rating = clean($_POST['rating']);
		$billing = clean($_POST['billing']);
		$loggedout = clean($_POST['loggedout']);
		$accessdenied = clean($_POST['accessdenied']);

		// update query
		$result = mysql_query("UPDATE content SET display_name='$name',home_title='$title',home_subtitle='$subtitle',
		about_description='$about',about_mission='$mission',about_vision='$vision',contacts='$contacts',
		contact_location='$location',specials_description='$specials',myaccount_description='$account',
		myprofile_description='$profile',inbox_description='$inbox',tables_description='$tables',
		partyhalls_description='$partyhalls',rating_description='$rating',others_address='$billing',
		others_loggedout='$loggedout',others_accessdenied='$accessdenied' WHERE content_id='$primary'"); 

		if ($result){
			//Writes the photo to the server 
			 $moved = move_uploaded_file($_FILES['location']['tmp_name'], $target);
			 
			 if($moved){
				 //everything is okay
				 echo "The location ". basename( $_FILES['location']['name']). " has been uploaded successfully."; 
			 } else {  
				 //Gives an error if its not okay 
				 echo "Sorry, there was a problem uploading your restaurant location ... the actual error is "  . $_FILES["location"]["error"]; 
			 }
				// redirect back to content page
				header("Location: content.php");
				exit();
			}
		else{
			die("updating changes failed ... the MySql error is " . mysql_error());
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Content</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Content Management </h1>
<a href="index.php">Home</a> | <a href="categories.php">Categories</a> | <a href="foods.php">Foods</a> | <a href="accounts.php">Accounts</a> | <a href="orders.php">Orders</a> | <a href="reservations.php">Reservations</a> | <a href="specials.php">Specials</a> | <a href="allocation.php">Staff</a> | <a href="messages.php">Messages</a> | <a href="options.php">Options</a> | <a href="content.php"> > Content < </a> | <a href="template.php">Template</a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
	<form name="contentForm" id="contentForm" action="content.php" method="post" enctype="multipart/form-data" onsubmit="return contentValidate(this)">
		<fieldset><legend align="center">Manage Your Own Content</legend>
			<fieldset><legend>Restaurant Name</legend>
				<table width="410" border="0" cellpadding="2" cellspacing="0" align="center">
					<tr>
						<td>Display Name</td>
						<td><textarea name="name" class="textfield" rows="1" cols="30" maxlength="25" placeholder="your restaurant name" required><?php echo $name; ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Home</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<th>Title</th>
						<th>Subtitle</th>
					</tr>
					<tr>
						<td><textarea name="title" class="textfield" rows="3" cols="50" maxlength="100" placeholder="this is the title of your restaurant in the home page" required><?php echo $title; ?></textarea></td>
						<td><textarea name="subtitle" class="textfield" rows="3" cols="50" maxlength="1000" placeholder="this is the subtitle of your restaurant in the home page" required><?php echo $subtitle; ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>About</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<th>Description</th>
						<th>Mission</th>
						<th>Vision</th>
					</tr>
					<tr>
						<td><textarea name="about" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="description of your restaurant" required><?php echo $about; ?></textarea></td>
						<td><textarea name="mission" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="mission statement for your restaurant" required><?php echo $mission; ?></textarea></td>
						<td><textarea name="vision" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="vision statement for your restaurant" required><?php echo $vision; ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Contact</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<th>Contacts</th>
						<th></th>
						<th>Location</th>
					</tr>
					<tr>
						<td><textarea name="contacts" class="textfield" rows="5" cols="50" maxlength="250" placeholder="provide all your contacts information here" required><?php echo $contacts; ?></textarea></td>
						<td><?php echo '<img src=../images/'. $location. ' width="100" height="90">'; ?></td>
						<td><input type="file" name="location" id="location" required/></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Specials</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<td>Description</td>
						<td><textarea name="specials" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="a description on the specials page" required><?php echo $specials; ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>MyAccount</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<td>Description</td>
						<td><textarea name="account" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="a description on the home page in My Account" required><?php echo $account; ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>MyProfile</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<td>Description</td>
						<td><textarea name="profile" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="a description on the my profile page in My Account" required><?php echo $profile; ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Inbox</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<td>Description</td>
						<td><textarea name="inbox" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="a description on the inbox page in My Account" required><?php echo $inbox; ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Tables</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<td>Description</td>
						<td><textarea name="tables" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="a description on the tables page in My Account" required><?php echo $tables; ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Party-Halls</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<td>Description</td>
						<td><textarea name="partyhalls" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="a description on the party-halls page in My Account" required><?php echo $partyhalls; ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Rating</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<td>Description</td>
						<td><textarea name="rating" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="a description on the rate us page in My Account" required><?php echo $rating; ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend>Others</legend>
				<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
					<tr>
						<th>Billing Address</th>
						<th>Logged Out</th>
						<th>Access Denied</th>
					</tr>
					<tr>
						<td><textarea name="billing" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="description on the billing address page" required><?php echo $billing; ?></textarea></td>
						<td><textarea name="loggedout" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="description on the logged out page" required><?php echo $loggedout; ?></textarea></td>
						<td><textarea name="accessdenied" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="description on the access denied page" required><?php echo $accessdenied; ?></textarea></td>
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