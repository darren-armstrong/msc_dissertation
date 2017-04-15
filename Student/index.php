<?php include 'student_header.php'; ?>
    <div class="content">
    	<h1>Home</h1>
	<?php
		$subVar= 0;
		$areaVar= 0;
		//Create Quicksearch bar for tutorials
		$areaSearch = mysql_query("SELECT * FROM areaofstudy");
		$areaCount = mysql_num_rows($areaSearch); // Count the number of Rows 
		if($areaCount > 0){
			echo "<div id='searchBar'><h1>Tutorial Quick Search</h1><br><form method='post' action='index.php?go' id='searchform'><div class='searchName'> Area of Study: </div><select name='area' class='area'><option selected='true' disabled='disabled'>Select an Area of Study...</option>";
			while($areas = mysql_fetch_array($areaSearch)){
				$id = $areas["id"];
				$area = $areas["area"];
				if(isset($area)){
					echo "<option value='" . $id ."'>" . $area . "</option>";
				}//end if
			}//end while
			echo "</select><br>";		
		}//end if
		echo "<div class='searchName'> Subject: </div><select name='subject' class='subject'><option selected='true' disabled='disabled'>Choose an Area of Study...</option>";
		echo "</select><br><br><input type='submit' id='searchButton' name='search' value='Show Search'><div id='searchMsg'>*An Error Occurred Please Select Again</div></form></div>";
		if(isset($_POST['search'])){ 
	  		if(isset($_GET['go'])){	
				if(isset($_POST['area']) && isset($_POST['subject'])){
					$areaVar=$_POST['area'];
					$subVar=$_POST['subject'];
					$tutorialSearch = mysql_query("SELECT A.Tutorial_id AS id, A.Title AS title, A.Date_created AS date, A.Description AS description, A.Likes AS likes, A.TutViews AS views, B.name AS subject, D.area AS expertise FROM tutorial AS A
					INNER JOIN subject AS B ON B.id = A.Subject
					INNER JOIN areaofstudy AS D ON D.id = B.Area_of_study
					WHERE (A.Subject='$subVar' AND B.Area_of_study='$areaVar') AND A.VerifyStatus = 1
					ORDER BY date ASC");
					$tutcount = mysql_num_rows($tutorialSearch);
					?><style type="text/css">
						#subContent{
						display:none;
						}
					</style>						
					<?php
					if($tutcount > 0){
						echo "<h2>". $tutcount . " Matches found for this search</h2><br>";
						echo "<div id='displaySearchResult'>";
						while($tuts = mysql_fetch_array($tutorialSearch)){			
							$likes = $tuts['likes'];
							$views = $tuts['views'];
							if(!isset($views)){
								$views = 0;
							}//end if()
							if(!isset($likes)){
								$likes = 0;
							}//end if()
							echo "<a class='studTuts' href='AdmintutSelected.php?id=" . $tuts['id'] ."' title='Play Tutorial'>
							<div class='tutDisplay'>
								<img id='tutImg' src='../css/logoOleTutor.png' name='" . $tuts['title'] ."' />
								<p>" . $tuts['title'] ."<br>Likes: " . $likes . "&nbsp;&nbsp;&nbsp;Views: " . $views . "</p>
								<div class='playMedia'>
									Play Tutorial
								</div>
							</div></a>";
						}//end while
						echo "</div>";
					}else{
						echo "<h2>". $tutcount . " Matches found for this search</h2>";
					}//end if..else
				}else{
					?><style type="text/css">
						#searchMsg{
						display:block;
						}
					</style>						
					<?php
				}//end if...else
			}//end if
		}//end if 		
	?>
	<div id="subContent">
		<div id="welcomeText">	
			<p>Hi <?php echo $fname;?> <?php echo $sname;?>,<br>Welcome to Olé Tutor, 
			enjoy the tutorials provided in this forum.  
			Also feel free to create your own tutorials 
			to make the website bigger and better.<br></p>
		</div>
		<hr>
	<?php
		$query = mysql_query("SELECT A.Tutorial_id AS id, A.Title AS title, A.Date_created AS date, A.Description AS description, A.Likes AS likes, A.TutViews AS views, B.name AS subject, C.name AS creator, D.area AS expertise FROM tutorial AS A
		INNER JOIN subject AS B ON B.id = A.Subject
		INNER JOIN admin AS C ON C.username = A.AdminCreator
		INNER JOIN areaofstudy AS D ON D.id = B.Area_of_study
		WHERE A.AdminCreator IS NOT NULL
		ORDER BY date ASC LIMIT 9");
		$count = mysql_num_rows($query);
		if($count > 0){
			echo "<div class='tutorialPos' style='clear:both;'><h2>Recently Created Tutorials By Tutors</h2>";
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
				<p>" . $row['title'] ."<br>Likes: " . $likes . "&nbsp;&nbsp;&nbsp;Views: " . $views . "</p>
				<div class='playMedia'>
					Play Tutorial
				</div>
				</div></a>";
			}//while()
			echo "</div><hr>";
		}else{
			echo "<div class='tutorialPos' style='clear:both;'><h2>Recently Created Tutorials By Tutors</h2><p>No Tutorials created by Tutors</p></div><hr>";
		}//end if...else()
		$Studquery = mysql_query("SELECT A.Tutorial_id AS id, A.Title AS title, A.Date_created AS date, A.Description AS description, A.Likes AS likes, A.TutViews AS views, B.name AS subject, C.fname + ' ' + C.sname AS creator, D.area AS expertise FROM tutorial AS A
		INNER JOIN subject AS B ON B.id = A.Subject
		INNER JOIN student AS C ON C.username = A.StudentCreator
		INNER JOIN areaofstudy AS D ON D.id = B.Area_of_study
		WHERE A.StudentCreator IS NOT NULL AND VerifyStatus = 1
		ORDER BY date ASC LIMIT 9");
		$sCount = mysql_num_rows($Studquery);	
		if($sCount > 0){
			echo "<div class='tutorialPos' style='clear:both;'><h2>Recently Created Tutorials By Members</h2>";
			while($Studrow = mysql_fetch_array($Studquery)){
				$likes = $Studrow['likes'];
				$views = $Studrow['views'];
				if(!isset($views)){
					$views = 0;
				}//end if()
				if(!isset($likes)){
					$likes = 0;
				}//end if()
				echo "<a class='studTuts' href='AdmintutSelected.php?id=" . $Studrow['id'] ."' title='Play Tutorial'><div class='tutDisplay'>
				<img id='tutImg' src='../css/logoOleTutor.png' name='" . $row['title'] ."' />
				<p>" . $Studrow['title'] ."<br>Likes: " . $likes . "&nbsp;&nbsp;&nbsp;Views: " . $views . "</p>
				<div class='playMedia'>
					Play Tutorial
				</div>
				</div></a>";
			}//end while()
			echo "</div>";
		}else{
			echo "<div class='tutorialPos' style='clear:both;'>
				<h2>Recently Created Tutorials By Members</h2><p>No Members have created Tutorials yet!!</p><hr>";
		}//end if..else()
	?>
	
		<div class='tutorialPos' style='clear:both;'><h2>Tutorials Recommended For You</h2>
		<?php
		//get the last subject viewed by the member
		$latestTut = mysql_query("SELECT A.Tutorial_id AS tutId, subject FROM viewed AS A
		INNER JOIN tutorial AS B ON B.Tutorial_id = A.Tutorial_id
		WHERE username = '" . $member . "'
		ORDER BY dateViewed DESC LIMIT 1");
		$latestCount = mysql_num_rows($latestTut);
		if($latestCount == 1){
			while($tutLate = mysql_fetch_array($latestTut)){
				$tutorialSub = $tutLate["subject"];
				$tutorialID = $tutLate["tutId"];
			}//end while
			//now that the subject is found we then suggest tutorials for them to watch.
			$recTuts = mysql_query("SELECT * FROM tutorial WHERE subject = '" . $tutorialSub . "' AND Tutorial_id <> '" . $tutorialID . "' ORDER BY Likes DESC LIMIT 9");
			$recCount = mysql_num_rows($recTuts);
			if($recCount > 0){
				while($rec = mysql_fetch_array($recTuts)){
					$likes = $rec['Likes'];
					$views = $rec['TutViews'];
					if(!isset($views)){
						$views = 0;
					}//end if()
					if(!isset($likes)){
						$likes = 0;
					}//end if()
					echo "<a class='studTuts' href='AdmintutSelected.php?id=" . $rec['Tutorial_id'] ."' title='Play Tutorial'>
					<div class='tutDisplay'>
						<img id='tutImg' src='../css/logoOleTutor.png' name='" . $rec['Title'] ."' />
						<p>" . $rec['Title'] ."<br>Likes: " . $likes . "&nbsp;&nbsp;&nbsp;Views: " . $views . "</p>
						<div class='playMedia'>
							Play Tutorial
						</div>
					</div></a>";
				}//end while
			}else{
				echo "<p>There is not enough tutorials in the system yet for us to recommend to you.</br>
				Sorry for any inconvenience caused.</p>";
			}//end if..else
		}else{
			echo "<p>For us to recommend tutorials you first have to view an area of interest to you..</p>";
		}//end if...else
		?>
	</div>
	</div>
	</div>
    </div>
<?php include 'Student_footer.php'; ?>