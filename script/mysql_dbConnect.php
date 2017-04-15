<?php
// place db host name.
$db_host = "localhost";
// place the username for the MySQL database here
$db_username = "msc14ad";
// Place the password for the MySQL database here
$db_pass = "suph44";
// Place the name for the MySQL database here
$db_name = "project";

// Run the actual connection here
mysql_connect($db_host, $db_username, $db_pass) or die ("<html><script language='JavaScript'>alert('Unable to connect to database! Please try again later. $db_host $db_username $db_pass')</script></html>");
mysql_select_db($db_name) or die ("no database");
?>
