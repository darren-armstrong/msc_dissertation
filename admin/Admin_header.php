<?php
session_start();
if(!isset($_SESSION["adminId"])){
	header("location: admin_login.php");
	exit();
}
//Check that Admin SESSION Value is in fact in the database
$admin = $_SESSION["adminId"];
$password = $_SESSION["password"];
include "../script/mysql_dbConnect.php";
$sql = mysql_query("SELECT * FROM admin WHERE username='$admin' AND p_word='$password' LIMIT 1");
//Make sure the person exists in the database
$existCount = mysql_num_rows($sql); // Count the number of rows
//Evaluate the count
if($existCount > 0){
	while($details = mysql_fetch_array($sql)){
		$name = $details["name"];
		$level = $details["admin_level"];
		$areaStudy = $details["area_of_study"];
		$image = $details["image"];
	}//end while
	if($image == NULL){
		$image = "default.png";
	}//end if
} else {
	echo("Your Login session data is not on record in the database");
	header("location:admin_login.php");
	exit();	
}
if($level < 2){
	//hide level two buttons
	?>
	<style type="text/css">
		.levelTwoAccess{
			display:none;
			width:auto;
		}
	</style>
	<?php
}//end if
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Olé Tutor</title>
<link rel="shortcut icon" href="../css/oleFavicon.ico" type="image/x-icon">
<link rel="icon" href="../css/oleFavicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="../css/main_layout.css" />
</head>

<body>
    <div id="head" class="header">
	<div class="headerFooterContent">
		<a href="index.php"><img id="logo" src="../css/logoOleTutor.png" name="olé tutor logo" alt="olé tutor logo" title="ole logo" /></a>
		<div id="member" tabindex="0">
			<div id="profilePicture">
				<img src="Admin_pics/<?php echo $image; ?>" name="member image" alt="member image" title="Profile Picture" />
			</div>
		</div>
	</div>
	<div id="menu">	
		<div class="headerFooterContent">
			<div class="levelOneAccess" style="float:left;">
				<a href="index.php" title="Go Home">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="options" href="manage_tut.php" title="Manage Tutorials">Manage Tutorials</a>&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<div class="levelTwoAccess" style="float:left;">
				<a class="options" href="verify_tut.php" title="Verify Tutorials">Verify Tutorials</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="options" href="SystemManage.php" title="System Management">System Management</a>&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<a class="options" href="man_acc.php" title="Manage Account">Manage Account</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a class="options" href="signout.php" title="Sign Out">Sign Out</a>&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
    	</div>
    </div>