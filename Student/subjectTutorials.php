<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'student_header.php'; ?>
    <div class="content">
	<?php
		$query = mysql_query("SELECT A.Tutorial_id AS id, A.Title AS title, A.Date_created AS date, A.Description AS description, A.Likes AS likes, A.TutViews AS views, B.name AS subject, D.area AS expertise FROM tutorial AS A
		INNER JOIN subject AS B ON B.id = A.Subject
		INNER JOIN areaofstudy AS D ON D.id = B.Area_of_study
		WHERE A.subject='" . $_GET['sub'] . "'
		ORDER BY date ASC");
		$count = mysql_num_rows($query);
		$getName = mysql_query("SELECT name FROM subject WHERE id='" . $_GET['sub'] . "'");
		$nameCount = mysql_num_rows($getName);
		if($nameCount > 0){
			while($nameRow = mysql_fetch_array($getName)){
				$subject = $nameRow['name'];
			}//end while()
		}//end if()
		echo "<h1>" . $subject ." Tutorials</h1><p>Number of " . $subject ." Tutorials: ".$nameCount."</p>";
		if($count > 0){
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
				</div>
				</div></a>";
			}//end while()
		}else{
			echo "<p>There are no tutorials on this Subject</p>";
		}//end if..else()
	?>
    </div>