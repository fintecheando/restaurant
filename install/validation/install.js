
	/*****************************************************
	Developer: macdonaldgeek
	Email: admin@restaurantmis.tk
	Phone: +255-657-567401/+254-717-667201/+44-744-0579061
	Twitter: @macdonaldgeek

	COPYRIGHT ©2014 RESTAURANT SCRIPT. ALL RIGHTS RESERVED
	******************************************************/

//function to handle conForm validation
function conValidate(conForm){

var validationVerified=true;
var errorMessage="";

if (conForm.dbName.value=="")
{
errorMessage+="Database Name not filled!\n";
validationVerified=false;
}
if(conForm.dbHost.value=="")
{
errorMessage+="Database Host name not filled!\n";
validationVerified=false;
}
if (conForm.dbUser.value=="")
{
errorMessage+="Database User name not filled!\n";
validationVerified=false;
}
if(conForm.dbPass.value=="" && conForm.local.checked==false)
{
errorMessage+="Database Password not filled! It is not advisable to leave your database unprotected! If you're running the script locally and password is null then check the local use checkbox to ignore this warning.\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle adminForm validation
function adminValidate(adminForm){

var validationVerified=true;
var errorMessage="";

if (adminForm.adminName.value=="")
{
errorMessage+="Admin Username not filled!\n";
validationVerified=false;
}
if(adminForm.adminPass.value=="")
{
errorMessage+="Admin Password not filled!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}