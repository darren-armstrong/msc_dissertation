<?php include 'Admin_header.php'; ?>
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
				<b>Subject:</b> " . $row['subject'] . "<br>
				<b>Area of Study:</b> " . $row['area'] ."<br>
				<b>Published by:</b> " . $publisher ."<br>
				<b>Published on:</b> " . $formatted . "</p></div>";
			}
		}
		mysql_query("UPDATE tutorial SET TutViews='$Views' WHERE Tutorial_id='" . $_GET['id'] . "'");
	?>
    </div>
<?php include 'Admin_footer.php'; ?>