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
    //Include database connection details
    require_once('connection/config.php');
    
    //Connect to mysql server
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
    if(!$link) {
        die('Failed to connect to server  ... The MySql error is ' . mysql_error());
    }
    
    //Select database
    $db = mysql_select_db(DB_DATABASE);
    if(!$db) {
        die("Unable to select database ... The MySql error is " . mysql_error());
    }
?>
<?php
    //retrieving all records from content
    $content=mysql_query("SELECT * FROM content");
	if ($content){
		//fetch content into an array
		$content_active=mysql_fetch_array($content);
		//directly initializing variables with content values based on fields
		$name = $content_active['display_name'];
		$title = $content_active['home_title'];
		$subtitle = $content_active['home_subtitle'];
		$about = $content_active['about_description'];
		$mission = $content_active['about_mission'];
		$vision = $content_active['about_vision'];
		$contacts = $content_active['contacts'];
		$location = $content_active['contact_location'];
		$specials = $content_active['specials_description'];
		$account = $content_active['myaccount_description'];
		$profile = $content_active['myprofile_description'];
		$inbox = $content_active['inbox_description'];
		$tables = $content_active['tables_description'];
		$partyhalls = $content_active['partyhalls_description'];
		$rating = $content_active['rating_description'];
		$billing = $content_active['others_address'];
		$loggedout = $content_active['others_loggedout'];
		$accessdenied = $content_active['others_accessdenied'];
			}
		else{
			die("Something went wrong while loading content ... the MySql error is " . mysql_error());
		}
?>