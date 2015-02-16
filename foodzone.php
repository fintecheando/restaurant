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

//selecting all records from the food_details table. Return an error if there are no records in the table
$result=mysql_query("SELECT * FROM food_details,categories WHERE food_details.food_category=categories.category_id LIMIT $startrow, 5")
or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 
?>
<?php
    //retrive categories from the categories table
    $categories=mysql_query("SELECT * FROM categories")
    or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 
?>
<?php
    //retrive a currency from the currencies table
    //define a default value for flag_1
    $flag_1 = 1;
    $currencies=mysql_query("SELECT * FROM currencies WHERE flag='$flag_1'")
    or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 
?>
<?php
    if(isset($_POST['Submit'])){
        //Function to sanitize values received from the form. Prevents SQL injection
        function clean($str) {
            $str = @trim($str);
            if(get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            return mysql_real_escape_string($str);
        }
        //get category id
        $id = clean($_POST['category']);
        
        //selecting all records from the food_details and categories tables based on category id. Return an error if there are no records in the table
        $result=mysql_query("SELECT * FROM food_details,categories WHERE food_category='$id' AND food_details.food_category=categories.category_id LIMIT $startrow, 5")
        or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $name ?>:Foods</title>
<script type="text/javascript" src="swf/swfobject.js"></script>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css">
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
 <h1>CHOOSE YOUR FOOD</h1>
 <hr>
 <h3>Note: limit the food zone by selecting a category below:</h3>
 <form name="categoryForm" id="categoryForm" method="post" action="foodzone.php" onsubmit="return categoriesValidate(this)">
     <table width="360" border="1" align="center">
     <tr>
        <td>Category</td>
        <td width="168"><select name="category" id="category">
        <option value="select">- select category -
        <?php 
        //loop through categories table rows
        while ($row=mysql_fetch_array($categories)){
        echo "<option value=$row[category_id]>$row[category_name]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Submit" value="Show Foods" /></td>
     </tr>
     </table>
 </form>
  <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
      <table width="900" border="1" height="auto" align="center" style="text-align:center;">
		<tr>
			<td colspan="6" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $startrow - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+5).'">Next-></a>';
				?>
			</td>
		</tr>
        <tr>
                <th>Food Photo</th>
                <th>Food Name</th>
                <th>Food Description</th>
                <th>Food Category</th>
                <th>Food Price</th>
                <th>Action(s)</th>
        </tr>
        <?php
            $count = mysql_num_rows($result);
            if(isset($_POST['Submit']) && $count < 1){
                echo "<html><script language='JavaScript'>alert('There are no foods under the selected category at the moment. Please check back later.')</script></html>";
            }
            else{
                //loop through all table rows
                //$counter = 3;
                $symbol=mysql_fetch_assoc($currencies); //gets active currency
                while ($row=mysql_fetch_assoc($result)){
                    echo "<tr>";
                    echo '<td><a href=images/'. $row['food_photo']. ' alt="click to view full image" target="_blank"><img src=images/'. $row['food_photo']. ' width="80" height="70"></a></td>';
                    echo "<td>" . $row['food_name']."</td>";
                    echo "<td>" . $row['food_description']."</td>";
                    echo "<td>" . $row['category_name']."</td>";
                    echo "<td>" . $symbol['currency_symbol']. "" . $row['food_price']."</td>";
                    echo '<td><a href="cart-exec.php?id=' . $row['food_id'] . '">Add To Cart</a></td>';
                    echo "</td>";
                    echo "</tr>";
                    }      
                }
            mysql_free_result($result);
            mysql_close($link);
        ?>
		<tr>
			<td colspan="6" align="right">
				<?PHP
				//create a "Previous" link
				$prev = $startrow - 5;
				//only print a "Previous" link if a "Next" was clicked
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'"><-Previous</a>';
				
				if ($prev >= 0 AND $prev < 0)
				//create a separator
				echo ' | ';
				
				if ($prev < 0)
				//create a "Next" link
				echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+5).'">Next-></a>';
				?>
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