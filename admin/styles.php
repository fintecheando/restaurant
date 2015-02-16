<?php
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
    //retrieving all records from template
    $template=mysql_query("SELECT * FROM template");
	if ($template){
		//fetch template into an array
		$template_active=mysql_fetch_array($template);
		//directly initializing variables with template values based on fields
		$logo = $template_active['site_logo'];
		$background = $template_active['site_background'];
		$header = $template_active['site_header'];
		$center = $template_active['site_center'];
		$footer = $template_active['site_footer'];
		$background_color = $template_active['site_background_color'];
		$center_color = $template_active['site_center_color'];
		$footer_color = $template_active['site_footer_color'];
			}
		else{
			die("Something went wrong while loading template ... the MySql error is " . mysql_error());
		}
?>