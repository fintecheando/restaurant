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
	if(isset($_POST['Submit'])){
		//check for connection errors
		$db_error=false;
		// try to connect to the DB, if not display error
		if(!@mysql_connect ($_POST['dbHost'],$_POST['dbUser'],$_POST['dbPass'])){
			$db_error=true;
			$error_msg="Sorry, these details are not correct. 
			Here is the exact error: ".mysql_error();
		}
		 
		if(!$db_error and !@mysql_select_db($_POST['dbName'])){
			$db_error=true;
			$error_msg="The host, username and password are correct. 
			But something is wrong with the given database.
			Here is the MySQL error: ".mysql_error();
		}
	}
?>
<?php
	if(isset($_POST['Submit']) AND $db_error==false){
		//Function to sanitize values received from the form. Prevents SQL injection
		function clean($str) {
			$str = @trim($str);
			if(get_magic_quotes_gpc()) {
				$str = stripslashes($str);
			}
			return mysql_real_escape_string($str);
		}
	}
?>
<?php
	if(isset($_POST['Submit']) AND $db_error==false){
		//create a connection handler if connection was successful
		$connect_code="<?php
		define('DB_HOST', '".clean($_POST['dbHost'])."');
		define('DB_USER', '".clean($_POST['dbUser'])."');
		define('DB_PASSWORD', '".clean($_POST['dbPass'])."');
		define('DB_DATABASE', '".clean($_POST['dbName'])."');
		?>";
	}
?>
<?php
	$write_success=false; //tests this later in code
	if(isset($_POST['Submit']) AND !empty($connect_code) AND $db_error==false){
		//check write permissions and write the connection handler into config.php files for both user and admin	
		if(!is_writable("../connection/config.php") AND !is_writable("../admin/connection/config.php")){
			$error_msg="<p>Sorry, the installer can't write to <b>../connection/config.php or ../admin/connection/config.php or 
			both files</b>. You will have to edit the file(s) yourself or chmod permissions to 644 for the file(s) 
			and repeat this step. Here is what you need to insert in that file(s):<br /><br />
			<textarea rows='5' cols='50' onclick='this.select();'>$connect_code</textarea></p>";
		}
		else{
			//write on user config file
			$fp_user = fopen('../connection/config.php', 'wb');
			fwrite($fp_user,$connect_code);
			fclose($fp_user);
			chmod('../connection/config.php', 0666); //prevent write permission from everyone
			
			//write on admin config file
			$fp_admin = fopen('../admin/connection/config.php', 'wb');
			fwrite($fp_admin,$connect_code);
			fclose($fp_admin);
			chmod('../admin/connection/config.php', 0666); //prevent write permission from everyone
			
			//write on install config file
			$fp_install = fopen('connection/config.php', 'wb');
			fwrite($fp_install,$connect_code);
			fclose($fp_install);
			chmod('connection/config.php', 0666); //prevent write permission from everyone
			
			$write_success=true; //sets to true
		}
	}

?>
<?php
	if(isset($_POST['Submit']) AND !empty($connect_code) AND $write_success==true AND $db_error==false){
		//if connection was established successfully, import tables into the database
		$mysqlDatabaseName =clean($_POST['dbName']);
		$mysqlUserName =clean($_POST['dbUser']);
		$mysqlPassword =clean($_POST['dbPass']);
		$mysqlHostName =clean($_POST['dbHost']);
		$mysqlImportFilename ='database/rs.sql';
		
		//DONT EDIT BELOW THIS LINE
		//Import the database and output only if there was an error
		//$command="mysql -h {$mysqlHostName} -u '{$mysqlUserName}' -p '{$mysqlPassword}' '{$mysqlDatabaseName}' <  '{$mysqlImportFilename}'";
		$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
		$output=array();
		@shell_exec($command,$output,$worked);
		
		switch($worked){
			case 0:
				$okay_msg="<p>Import file <b>$mysqlImportFilename</b> successfully imported to database <b>$mysqlDatabaseName</b>.</p>";
				@header("Location: database/rs.php");
				break;
			case 1:
				$error_msg="<p>There was an error when the installer attempted to populate the database. 
				Please repeat this step carefully with appropriate connection details.</p>";
				break;
		}
	}
	
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Step 3: Connection</title>
<link href="stylesheets/install_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/install.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Database Connection </h1>
<a href="index.php">Welcome</a> -> <a href="requirements.php">Requirements</a> -> <a href="connection.php">Connection</a>
</div>
<div id="container">
	<fieldset><legend>Connection Details</legend>
		<form id="conForm" name="conForm" method="post" action="connection.php" onsubmit="return conValidate(this)">
		  <table width="930" border="1" align="center">
			<tr>
				<td colspan="2" style="text-align:center;"><?php if(!empty($error_msg) AND $db_error==true) echo "<span style='color:red;'>$error_msg</span>"; else if(!empty($error_msg)) echo "<span style='color:red;'>$error_msg</span>";?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Required fields</td>
			</tr>
			<tr>
			  <th>Database Name </th>
			  <td><font color="#FF0000">* </font><input name="dbName" type="text" class="textfield" id="dbName" maxlength="25" placeholder="enter database name" required/></td>
			</tr>
			<tr>
			  <th>Database Host </th>
			  <td><font color="#FF0000">* </font><input name="dbHost" type="text" class="textfield" id="dbHost" maxlength="25" placeholder="enter database host name" required/></td>
			</tr>
			<tr>
			  <th>Database User </th>
			  <td><font color="#FF0000">* </font><input name="dbUser" type="text" class="textfield" id="dbUser" maxlength="25" placeholder="enter database user name" required/></td>
			</tr>
			<tr>
			  <th>Database Password </th>
			  <td><font color="#FF0000">* </font><input name="dbPass" type="password" class="textfield" id="dbPass" maxlength="25" placeholder="enter database password"/><input name="local" type="checkbox" class="" id="local"/>Local use</td>
			</tr>
			<tr>
			  <td colspan="4" align="center"><input type="reset" value="Clear Fields" /></td>
			</tr>
			<tr>
			  <td colspan="4" align="center"><input type="submit" name="Submit" value="Click Here to Establish Connection and Proceed" /></td>
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