<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'student_header.php'; ?>
    <div class="content">
    	<h1>Online Tutors</h1>
	<?php
		$db = new mysqli('localhost', 'msc14ad', 'suph44', 'project');
		// Check connection
		if (mysqli_connect_errno()) {
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  			exit;
		}
		$query = "SELECT A.username AS publisher, A.name AS name, A.image AS image, A.email AS email, B.area AS area, COUNT(C.AdminCreator) AS numOfTuts FROM admin AS A
		INNER JOIN areaofstudy AS B ON B.id = A.area_of_study
		INNER JOIN tutorial AS C ON C.AdminCreator = A.username";
		$result = $db->query($query);
		$num_results = $result->num_rows;
		echo "<p>Number of Tutors on the System: ".$num_results."</p>";
		for ($i=0; $i < $num_results; $i++) {
			$row = $result->fetch_assoc();
			echo "<div class='tutorProfile'>
				<img class='tutorPic' src='../admin/Admin_pics/" . $row['image'] . "' name='" . $row['name'] . "' alt='" . $row['name'] . "' title='" . $row['name'] . "' /><br>"
				 . $row['name'] . "<br>Expertise: " . $row['area'] . "<br>email: " . $row['email'] . "<br><a href='AdminTutorials.php?publisher=" . $row['publisher'] . "' title='View Tutorials'><button style='margin:3px; background:goldenRod;'>View Tutorials</button></a></div>";
		}
		$result->free();
		$db->close();
	?>
    </div>
<?php include 'student_footer.php'; ?>