<?php
session_start();
if(isset($_SESSION["studentId"])){
	header("location: index.php");
	exit();
}

//Connect to MySQL database
require "../script/mysql_dbConnect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<metta http-equiv="Content-Type" content="text/html; charset=ut-8" />
<title>Olé Tutor</title>
<link rel="shortcut icon" href="../css/oleFavicon.ico" type="image/x-icon">
<link rel="icon" href="../css/oleFavicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="../css/login_layout.css" />
<body>
    <div class="content">
	<img id="logo" src="../css/logoOleTutor.png" name="ole tutor logo" alt="ole tutor logo" title="home" />