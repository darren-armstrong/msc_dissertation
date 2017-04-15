<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
iframe {
	margin:0 auto;
	display:block;
}
</style>
<?php include 'student_header.php'; ?>
    <div class="content">
	<?php
		if(isset($_GET['liked'])){
			$likeQuery = mysql_query("SELECT Likes FROM Tutorial WHERE Tutorial_id='" . $_GET['id'] . "'");
			$likeCount = mysql_num_rows($likeQuery);
			if($likeCount > 0){
				while($thisliked = mysql_fetch_array($likeQuery)){
					$thisLike = $thisliked["Likes"];
				}
				if(!isset($thisLike)){
					$thisLike = 0;
				}
				$thisLike++;
				mysql_query("UPDATE tutorial SET Likes='$thisLike' WHERE Tutorial_id='" . $_GET['id'] . "'") or die(mysql_error());
			}
		}
		$insertQuery = mysql_query("INSERT INTO viewed(Tutorial_id, username) VALUES ('" . $_GET['id'] . "', '" . $member . "')") or die(mysql_error());
		$query = mysql_query("SELECT Title, Url, Description, Date_created, Likes, TutViews, A.AdminCreator AS publisher, A.StudentCreator AS studPublisher, A.Subject AS sub, B.name AS subject, C.id AS areaId, C.area AS area FROM Tutorial AS A
		INNER JOIN subject AS B ON B.id = A.Subject
		INNER JOIN areaofstudy AS C ON C.id = B.Area_of_study
		WHERE Tutorial_id='" . $_GET['id'] . "'");
		$queryCount = mysql_num_rows($query);
		if($queryCount > 0){
			while($row = mysql_fetch_array($query)){
				$publisherId;
				if(!isset($row['publisher'])){
					$publisherId = $row["studPublisher"];
					$getCreator = mysql_query("SELECT fname, sname FROM student WHERE username='" . $publisherId . "'");
					$creatorCount = mysql_num_rows($getCreator);
					if($creatorCount > 0){
						while($publish = mysql_fetch_array($getCreator)){
							$publisher ="" . $publish['fname'] . " " . $publish['sname'] . "";
						}
					}
				} else {
					$publisherId = $row["publisher"];
					$getCreator = mysql_query("SELECT name FROM admin WHERE username='" . $publisherId . "'");
					$creatorCount = mysql_num_rows($getCreator);
					if($creatorCount > 0){
						while($publish = mysql_fetch_array($getCreator)){
							$publisher = $publish['name'];
						}
					}
				}
				
				$date = date_create($row['Date_created']);
				$formatted = date_format($date, 'g:ia \o\n l jS F Y');
				//Update Tutorial View
				$Views = $row['TutViews'];
				$Views++;
				$likes = $row['Likes'];
				if(!isset($likes)){
					$likes = 0;
				}
				echo "<div class='selectedTutorial'><h1>" . $row['Title'] . "</h1>";
				echo '' . $row["Url"] . '';
				echo "<div class='likeViewBox'><b>" . $Views ." Views</b></div><hr><div class='likeViewBox'>Likes: " . $likes ." <a href='AdmintutSelected.php?id=" . $_GET['id'] . "&liked=true'><img src='../css/thumbs-up-icon.png' style='vertical-align: middle;' width='45px' title='Like Tutorial'></a></div>  
				<p><u><b>Tutorial Description</b></u><br>" . $row['Description'] . "<br>
				<b>Subject:</b> <a href='subjectTutorials.php?sub=". $row['sub'] . "' title='Show " . $row['subject'] ." Tutorials'>" . $row['subject'] . "</a><br>
				<b>Area of Study:</b> <a href='areaTutorials.php?area=" . $row['areaId'] . "' title='Show " . $row['area'] ." Tutorials'>" . $row['area'] ."</a><br>
				<b>Published by:</b> <a href='AdminTutorials.php?publisher=" . $publisherId . "' title='Show " . $publisher ." Tutorials'>" . $publisher ."</a><br>
				<b>Published on:</b> " . $formatted . "</p></div>";
			}
		}
		mysql_query("UPDATE tutorial SET TutViews='$Views' WHERE Tutorial_id='" . $_GET['id'] . "'");
	?>
    </div>
<?php include 'student_footer.php'; ?>