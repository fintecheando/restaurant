<?
	/*****************************************************
	Developer: macdonaldgeek
	Email: admin@restaurantmis.tk
	Phone: +255-657-567401/+254-717-667201/+44-744-0579061
	Twitter: @macdonaldgeek

	COPYRIGHT �2014 RESTAURANT SCRIPT. ALL RIGHTS RESERVED
	******************************************************/
?>
<?php
    //Start session
    session_start();
    
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
    
    // check if Delete is set in POST
     if (isset($_POST['Delete'])){
         // get id value of quantity and Sanitize the POST value
         $quantity_id = clean($_POST['quantity']);
         
         // delete the entry
         $result = mysql_query("DELETE FROM quantities WHERE quantity_id='$quantity_id'")
         or die("There was a problem while deleting the quantity ... \n" . mysql_error()); 
         
         // redirect back to options
         header("Location: options.php");
     }
     
         else
            // if id isn't set, redirect back to options
         {
            header("Location: options.php");
         }
?>