<?php
session_start();
if(!isset($_SESSION["studentId"])){
	header("location: student_login.php");
	exit();
}
//Check that Member SESSION Value is in fact in the database
$member = $_SESSION["studentId"];
$password = $_SESSION["password"];
include "../script/mysql_dbConnect.php";
$sql = mysql_query("SELECT * FROM student WHERE username='$member' AND p_word='$password' LIMIT 1");
//Make sure the person exists in the database
$existCount = mysql_num_rows($sql); // Count the number of rows
//Evaluate the count
if($existCount > 0){
	while($details = mysql_fetch_array($sql)){
		$fname = $details["fname"];
		$sname = $details["sname"];
		$image = $details["image"];
	}//end while
	if($image == NULL){
		$image = "default.png";
	}//end if
} else {
	echo("Your Login session data is not on record in the database");
	header("location:student_login.php");
	exit();	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Olé Tutor</title>
<link rel="shortcut icon" href="../css/oleFavicon.ico" type="image/x-icon">
<link rel="icon" href="../css/oleFavicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="../css/main_layout.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".area").change(function(){
		var id=$(this).val();
		var dataString = 'id='+ id;
		$.ajax({
			type: "POST",
			url: "ajax_subject.php",
			data: dataString,
			cache: false,
			success: function(html){
				$(".subject").html(html);
			} 
		});
	});
});
</script>
</head>

<body>
    <div id="head" class="header">
	<div class="headerFooterContent">
		<a href="index.php"><img id="logo" src="../css/logoOleTutor.png" name="olé tutor logo" alt="olé tutor logo" title="ole logo" /></a>
		<div id="member" tabindex="0">
			<div id="profilePicture">
				<img src="StudentPics/<?php echo $image; ?>" name="member image" alt="member image" title="Profile Picture" />
			</div>
		</div>
    	</div>
	<div id="menu">	
		<div class="headerFooterContent">
			<a href="index.php" title="Go Home">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="tutorials.php" title="View Tutorials">Tutorials</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="onlineTutors.php" title="View our Online Tutors">Online Tutors</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="manage_tuts.php" title="Manage Your Tutorials">Manage Your Tutorials</a>&nbsp;&nbsp;&nbsp;&nbsp;
        		<a href="account.php" title="View Account">View Account</a>&nbsp;&nbsp;&nbsp;&nbsp;
        		<a href="student_logout.php" title="Sign Out">Sign out</a>&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
    	</div>
    </div>