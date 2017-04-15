<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'student_header.php'; ?>
    <div class="content">
	<?php
		$getName = mysql_query("SELECT name FROM admin WHERE username='" . $_GET['publisher'] . "'");
		$nameCount = mysql_num_rows($getName);
		if($nameCount > 0){
			while($name = mysql_fetch_array($getName)){
				$publisher = $name['name'];
				echo "<h1>" . $publisher ." Tutorials</h1>";
				$query = mysql_query("SELECT A.Tutorial_id AS id, A.Title AS title, A.Date_created AS date, A.Description AS description, A.Likes AS likes, A.TutViews AS views, B.name AS subject, D.area AS expertise FROM tutorial AS A
				INNER JOIN subject AS B ON B.id = A.Subject
				INNER JOIN areaofstudy AS D ON D.id = B.Area_of_study
				WHERE A.AdminCreator='" . $_GET['publisher'] . "'
				ORDER BY A.Subject ASC");
				$queryCount = mysql_num_rows($query);
				if($queryCount > 0){
					echo "<p>Number of Tutorials created by " . $publisher . ": " . $queryCount . "</p>";
					while($row = mysql_fetch_array($query)){
						$likes = $row['likes'];
						$views = $row['views'];
						if(!isset($views)){
							$views = 0;
						}//end if()
						if(!isset($likes)){
							$likes = 0;
						}//end if()
						echo "<a class='studTuts' href='AdmintutSelected.php?id=" . $row['id'] ."' title='Play Tutorial'><div class='tutDisplay'>
						<img id='tutImg' src='../css/logoOleTutor.png' name='" . $row['title'] ."' />
						<p>" . $row['title'] ."<br>Likes: " . $likes . "&nbsp;&nbsp;&nbsp;Views: " . $views . "
						<div class='playMedia'>
							Play Tutorial
						</div></div></a>";
					}//end while()
				}else{
					echo"<p>There is currently no Tutorials Developed by " . $publisher . ".";
				}//if..else()
			}//end while()
		}else{
			$getSName = mysql_query("SELECT fname, sname FROM student WHERE username='" . $_GET['publisher'] . "'");
			$SnameCount = mysql_num_rows($getSName);
			if($SnameCount > 0){
				while($name = mysql_fetch_array($getSName)){
					$publisher = "" . $name['fname'] . " " . $name['sname'] . "";
					echo "<h1>" . $publisher ." Tutorials</h1>";
					$query = mysql_query("SELECT A.Tutorial_id AS id, A.Title AS title, A.Date_created AS date, A.Description AS description, A.Likes AS likes, A.TutViews AS views, B.name AS subject, D.area AS expertise FROM tutorial AS A
					INNER JOIN subject AS B ON B.id = A.Subject
					INNER JOIN areaofstudy AS D ON D.id = B.Area_of_study
					WHERE A.StudentCreator='" . $_GET['publisher'] . "'
					ORDER BY date ASC");
					$queryCount = mysql_num_rows($query);
					if($queryCount > 0){
						echo "<p>Number of Tutorials created by " . $publisher . ": " . $queryCount . "</p>";
						while($row = mysql_fetch_array($query)){
							$likes = $row['likes'];
							if(!isset($likes)){
								$likes = 0;
							}//end if()
							echo "<a class='studTuts' href='AdmintutSelected.php?id=" . $row['id'] ."' title='Play Tutorial'><div class='tutDisplay'>
							<img id='tutImg' src='../css/logoOleTutor.png' name='" . $row['title'] ."' />
							<p>" . $row['title'] ."<br>Likes: " . $likes . "&nbsp;&nbsp;&nbsp;Views: " . $row['views'] . "
							<div class='playMedia'>
								Play Tutorial
							</div></div></a>";
						}//end while()
					}else{
						echo"<p>There is currently no Tutorials Developed by " . $publisher . ".";
					}//if..else()
				}//end while()
			}//end if()
		}//end if..else()
	?>
    </div>