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
	//checking php version
	$php_version=phpversion(); //gets php version from server
	
	if($php_version<5){
		$php_status="PHP version is $php_version - too old!";
		$php_status_error=1; //sets a red flag
	}
	else{
		$php_status="$php_version - OK!";
		$php_status_error=0; //sets a green flag
	}
?>
<?php
	//checking mysql version
	// declare function to get mysql version
	function find_SQL_Version() { 
	  $output = @shell_exec('mysql -V');    
	  preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version); 
	  return @$version[0]?$version[0]:-1; 
	}

	$mysql_version=find_SQL_Version(); //gets mysql version from the function
	if($mysql_version<5){
		if($mysql_version==-1){
			$mysql_status="MySQL version will be checked at the next step.";
			$mysql_status_error=1; //sets a red flag
		}
		else{
			$mysql_status="MySQL version is $mysql_version. Version 5 or newer is required.";
			$mysql_status_error=1; //sets a red flag
		}
	}
	else{
		$mysql_status="$mysql_version - OK!";
		$mysql_status_error=0; //sets a green flag
	}
?>
<?php
	//checking mail function
	if(!function_exists('mail')){
		$mail_status="PHP Mail function is not enabled!";
		$mail_status_error=1; //sets a red flag
	}
	else{
		$mail_status="Looks enabled!";
		$mail_status_error=0; //sets a green flag
	}

?>
<?php
	//checking safe mode
	if( ini_get("safe_mode") ){
		$safeMode_status="Please switch off PHP Safe Mode (can be found in php.ini)";
		$safeMode_status_error=1; //sets a red flag
	}
	else{
		$safeMode_status="OK!";
		$safeMode_status_error=0; //sets a green flag
	}
?>
<?php
	//checking sessions
	$_SESSION['check_sessions_work']=1;
	if(empty($_SESSION['check_sessions_work'])){
		$session_status="Sessions must be enabled!";
		$session_status_error=1; //sets a red flag
	}
	else{
		$session_status="OK!";
		$session_status_error=0; //sets a green flag
	}
?>
<?php
	//checking HTML5 browser compatibility
	class Browser { 
            public static function detect() { 
                $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']); 
                if ((substr($_SERVER['HTTP_USER_AGENT'],0,6)=="Opera/") || (strpos($userAgent,'opera')) != false ){ 
                    $name = 'Opera';
                } 
                elseif ((strpos($userAgent,'chrome')) != false) { 
                    $name = 'Chrome'; 
                } 
                elseif ((strpos($userAgent,'safari')) != false && (strpos($userAgent,'chrome')) == false && (strpos($userAgent,'chrome')) == false){ 
                    $name = 'Safari'; 
                } 
                elseif (preg_match('/msie/', $userAgent)) { 
                    $name = 'Msie'; 
                } 
                elseif ((strpos($userAgent,'firefox')) != false) { 
                    $name = 'Firefox'; 
                } 
                else { 
                    $name = 'Unrecognized'; 
                }
				if (preg_match('/.+(?:me|ox|it|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches)) { 
					$version = $matches[1]; 
				}
				if (preg_match('/.+(?:me|ox|it|on|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches)) { 
					$version = $matches[1]; 
				}
                else { 
                    $version = 'Unknown!'; 
                } 

                return array( 
                    'name'      => $name, 
                    'version'   => $version,
                ); 
            } 
        } 
        $browser = Browser::detect();
		if($browser['name']=="Chrome"){
			$browser_status='You browser is ' .$browser['name'].' version '.$browser['version'].' - OK!';
			$browser_status_error=0; //sets a green flag
		}
		else{
			$browser_status='You browser is ' .$browser['name'].' version '.$browser['version'].' - less compatible! (upgrade to Chrome)';
			$browser_status_error=1; //sets a red flag
		}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Step 2: Requirements</title>
<link href="stylesheets/install_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/install.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Installation Requirements</h1>
<a href="index.php">Welcome</a> -> <a href="requirements.php">Requirements</a>
</div>
<div id="container">
	<fieldset><legend>Checking System Configuration</legend>
		<form action="connection.php">
		  <table width="930" border="1" align="center">
		  	<tr>
			  <th align="center">Feature</th>
			  <th align="center">Status</th>
			</tr>
			<tr>
			  <td>PHP Version (Must be 5 or better) </td>
			  <td><?php if($php_status_error==0) echo "<span style='color:green;'>$php_status</span>"; else echo "<span style='color:red;'>$php_status</span>";?></td>
			</tr>
			<tr>
			  <td>MySQL Version (Must be 5 or better) </td>
			  <td><?php if($mysql_status_error==0) echo "<span style='color:green;'>$mysql_status</span>"; else echo "<span style='color:red;'>$mysql_status</span>";?></td>
			</tr>
			<tr>
			  <td>PHP "mail" function must be enabled </td>
			  <td><?php if($mail_status_error==0) echo "<span style='color:green;'>$mail_status</span>"; else echo "<span style='color:red;'>$mail_status</span>";?></td>
			</tr>
			<tr>
			  <td>PHP "safe mode" must be off </td>
			  <td><?php if($safeMode_status_error==0) echo "<span style='color:green;'>$safeMode_status</span>"; else echo "<span style='color:red;'>$safeMode_status</span>";?></td>
			</tr>
			<tr>
			  <td>PHP sessions must work </td>
			  <td><?php if($session_status_error==0) echo "<span style='color:green;'>$session_status</span>"; else echo "<span style='color:red;'>$session_status</span>";?></td>
			</tr>
			<tr>
			  <td>Browser must be HTML5 compatible </td>
			  <td><?php if($browser_status_error==0) echo "<span style='color:green;'>$browser_status</span>"; else echo "<span style='color:red;'>$browser_status</span>";?></td>
			</tr>
			<tr>
			  <td colspan="4" align="center"><input type="submit" name="Submit" value="Only Click Here if EVERYTHING above is OK to Proceed" /></td>
			</tr>
		  </table>
		</form>
	</fieldset>
</div>
<div id="footer">
<div class="bottom_addr">&copy; 2012-2013 Food Plaza. All Rights Reserved</div>
</div>
</div>
</body>
</html>