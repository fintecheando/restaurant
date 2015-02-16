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
	require_once('admin/locale.php');
?>
<?php
	//Start session
	session_start();
	
	if(@$_SESSION['SESS_FIRST_NAME'] && $_SESSION['SESS_LAST_NAME'] && $_SESSION['SESS_EMAIL'] != ''){
		$sess_fname = $_SESSION['SESS_FIRST_NAME'];
		$sess_lname = $_SESSION['SESS_LAST_NAME'];
		$sess_email = $_SESSION['SESS_EMAIL'];
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $name ?>:Contacts</title>
<script type="text/javascript" src="swf/swfobject.js"></script>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page">
  <div id="menu"><ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="foodzone.php">Food Zone</a></li>
  <li><a href="specialdeals.php">Special Deals</a></li>
  <li><a href="member-index.php">My Account</a></li>
  <li><a href="contactus.php">Contact Us</a></li>
  </ul>
  </div>
<div id="header">
  <div id="logo"> <a href="index.php" class="blockLink"></a></div>
  <div id="company_name"><?php echo $name ?></div>
</div>
<div id="center">

  <h1>Contact Us</h1>
  
  <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
	<table>
		<tr>
			<td align="left">
				<?php echo $contacts ?>
				<?php echo '<img src=images/'. $location. ' width="400" height="400">'; ?>
			</td>
			<td align="right">
				<form id="messageForm" name="messageForm" method="post" action="message-exec.php" onsubmit="return messageValidate(this)">
					<table width="485" border="1" cellpadding="2" cellspacing="0" align="center">
						<tr>
						  <th width="200">First Name</th>
						  <td width="168"><input type="text" name="fname" id="fname" value="<?php echo @$sess_fname ?>" class="textfield" maxlength="45" placeholder="enter your first name" required/></td>
						</tr>
						<tr>
						  <th width="200">Last Name</th>
						  <td width="168"><input type="text" name="lname" id="lname" value="<?php echo @$sess_lname ?>" class="textfield" maxlength="45" placeholder="enter your last name" required/></td>
						</tr>
						<tr>
						  <th width="200">Email</th>
						  <td width="168"><input type="email" name="email" id="email" value="<?php echo @$sess_email ?>" class="textfield" maxlength="45" placeholder="enter your email address" required/></td>
						</tr>
						<tr>
						  <th width="200">Subject</th>
						  <td width="168"><input type="text" name="subject" id="subject" class="textfield" maxlength="65" placeholder="subject for the message" required/></td>
						</tr>
						<tr>
						  <th width="200">Message Box</th>
						  <td width="168"><textarea name="txtmessage" class="textfield" rows="23" cols="45" maxlength="250" placeholder="Write your message here to send to one of our support staff. Allow up to 48 hours to receive a response. Your message and personal details will be treated as confidential and will not be shared to third party without your consent." required></textarea></td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						  <td align="center"><input type="submit" name="Submit" value="Send Message" />
						  <input type="reset" name="Reset" value="Clear Fields" /></td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
  </div>
</div>
<div id="footer">
    <div class="bottom_menu"><a href="index.php">Home Page</a>  |  <a href="aboutus.php">About Us</a>  |  <a href="specialdeals.php">Special Deals</a>  |  <a href="foodzone.php">Food Zone</a>  |  <a href="#">Affiliate Program</a><br>
  | <a href="admin/index.php" target="_blank">Administrator</a> |</div>
  
  <div class="bottom_addr">&copy; <?php echo date("Y") . " " . $name ?>. All Rights Reserved</div>
</div>
</div>
</body>
</html>
<?php
	if(isset($_GET['sent'])){
		echo "<script language='JavaScript'>alert('Thank you for your message.')</script>";
	}
?>