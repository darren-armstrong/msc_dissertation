<?php
session_start();
if(isset($_SESSION["studentId"]) && isset($_SESSION["password"])){
	header("location: index.php");
	exit();
}
?>
<?php
//Parse the log in form if the user has filled it out and pressed "Login"
if(isset($_POST["username"]) && isset($_POST["password"])){
	// Filter everthing but numbers and letters
	$member = $_POST["username"];
	$password = $_POST["password"];
	//Connect to MySQL database
	require "../script/mysql_dbConnect.php";
	//Query the person
	$sql = mysql_query("SELECT username FROM student WHERE username='$member' AND p_word='$password' LIMIT 1");
	//Make sure the person exists in the database
	$existCount = mysql_num_rows($sql); // Count the number of rows
	//Evaluate the count
	if($existCount == 1){
		while($row = mysql_fetch_array($sql)){
			$id = $row["username"];
		}
		$_SESSION["studentId"] = $id;
		$_SESSION["password"] = $password;
		header("location:index.php");
		exit();
	} else {
		$_SESSION['message'] = 'Incorrect Login Details, Please try again.';
	}
}
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
    	<h1>Welcome to Olé Tutor</h1>
	<p>Olé Tutor is a free online learing environment, 
	where you can view tutorials or create your own.
	Olé Tutor offers continuing professional development to students/professionals
	in most areas involved in educational studies.</p><br>
	<form id="loginform" name="loginform" method="post" action="student_login.php">
	<div id="errorMsg">
		<?php
		if (isset($_SESSION['message'])){
    			echo $_SESSION['message'];
    			unset($_SESSION['message']);
		}
		?>
	</div>
	<div id="input_username">
		Username<br><input name="username" type="text" id="username" placeholder="Enter Username here..." />
		<br>
		<a href="fgt_username.php">Forgotten your username?</a>
	</div>
	<div id="input_password">
		Password<br><input name="password" type="password" id="password" placeholder="Enter Password here..." />
		<br>
		<a href="fgt_pwd.php">Forgotten your password?</a>
	</div>
	<div id="input_login">
		<br><input type="submit" name="Button" id="button" value="Login" />
	</div>
	Not Registered?<br>
	<a href="student_reg.php">Create an Account</a>
	</form>
<?php include 'studentLoginFooter.php'; ?>