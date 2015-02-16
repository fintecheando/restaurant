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
	require_once('admin/locale.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $name ?>:Alternative Billing</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
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
<h1>Billing Address</h1>
<hr>
<?php echo $billing ?>
  <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
<form id="billingForm" name="billingForm" method="post" action="billing-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return billingValidate(this)">
  <table width="520" border="1" align="center" cellpadding="2" cellspacing="0">
  <CAPTION><h3>ADD DELIVERY/BILLING ADDRESS</h3></CAPTION>
    <tr>
        <td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Required fields</td>
    </tr>
    <tr>
      <th>Street Address </th>
	  <td><font color="#FF0000">* </font><textarea name="sAddress" id="sAddress" class="textfield" rows="4" cols="30" maxlength="100" placeholder="enter physical address using the standard format" required></textarea></td>
    </tr>
    <tr>
      <th>P.O. Box No/Zip/Post Code </th>
      <td><font color="#FF0000">* <input name="box" type="text" class="textfield" id="box" maxlength="15" placeholder="enter box/zip/post code" required/></td>
    </tr>
    <tr>
      <th>City </th>
      <td><font color="#FF0000">* </font><input name="city" type="text" class="textfield" id="city" maxlength="15" placeholder="enter your city" required/></td>
    </tr>
    <tr>
      <th width="124">Mobile No</th>
      <td width="168"><font color="#FF0000">* </font><input name="mNumber" type="tel" class="textfield" id="mNumber" maxlength="15" placeholder="enter your mobile no" required/></td>
    </tr>
    <tr>
      <th>Landline No</th>
      <td>&nbsp;&nbsp;&nbsp;<input name="lNumber" type="tel" class="textfield" id="lNumber" maxlength="15" placeholder="enter your landline no"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Add" /></td>
    </tr>
</table>
</form>
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
