<html>
<head>
</head>
<body>
<?php
$db = new mysqli('localhost', 'msc14ad', 'suph44', 'project');
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit;
}
$query = "select * from subject";
$result = $db->query($query);
$num_results = $result->num_rows;

echo "<p>Number of Subjects Found: ".$num_results."</p>";

for ($i=0; $i < $num_results; $i++) {
	$row = $result->fetch_assoc();
	echo "<p>" . ($i+1) . " " . $row['name'] . "</p>";
}
$result->free();
$db->close();
?>
</body>
</html>
