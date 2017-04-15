<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'student_header.php'; ?>
    <div class="content">
    	<h1>Tutorials</h1>
	<?php
		$query = mysql_query("SELECT A.Tutorial_id AS id, A.Title AS title, A.Date_created AS date, A.Description AS description, A.Likes AS likes, A.TutViews AS views, B.name AS subject, D.area AS expertise FROM tutorial AS A
		INNER JOIN subject AS B ON B.id = A.Subject
		INNER JOIN areaofstudy AS D ON D.id = B.Area_of_study
		WHERE A.VerifyStatus = 1
		ORDER BY date ASC");
		$queryCount = mysql_num_rows($query);
		if($queryCount > 0){
			echo "<p>Number of Tutorials created: " . $queryCount . "</p>";
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
				<p>" . $row['title'] . "<br>Likes: " . $likes . "&nbsp;&nbsp;&nbsp;Views: " . $views . "
				<div class='playMedia'>
					Play Tutorial
				</div>
				</div></a>";
			}//end while()
		}else{
			echo "<p>No Tutorials have been created yet.</p>";
		}//end if..else()
	?>
    </div>
<?php include 'student_footer.php'; ?>