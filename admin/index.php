<?php include 'Admin_header.php'; ?>
	<div class="content">
    		<h1>Administration Area</h1>
		<?php
		// Get Admins Area of study
		$areaName = mysql_query("SELECT area FROM areaofstudy WHERE id='" . $areaStudy ."'");
		$areaCount = mysql_num_rows($areaName);
		if($areaCount > 0){
			while($areas = mysql_fetch_array($areaName)){
				$expertise = $areas["area"];
			}//end while
		}//end if
		//Check to see if subject already exists
		if(isset($_GET['newSubject'])){
			if(isset($_POST['addSub'])){
				if($_POST['newSub'] != NULL){
					//check to see if the subject exists within that area of study
					$subjectSearch = mysql_query("SELECT name FROM subject WHERE Area_of_study='" . $areaStudy . "'");
					$subjectCount = mysql_num_rows($subjectSearch);
					if($subjectCount > 0){
						$num = 0;
						while($sub = mysql_fetch_array($subjectSearch)){
							if(strtoupper($sub["name"]) == strtoupper($_POST['newSub'])){
								$num++;
							}//end if
						}//end while
						if($num > 0){
							//this subject alread exists within the system
							?>
							<style type="text/css">
								#subjectMatch{
									display:block;
								}
							</style>
							<?php
						}else{
							//add subject to system
							mysql_query("INSERT INTO subject (name, Area_of_study) 
							VALUES ('" . $_POST['newSub'] . "','" . $areaStudy . "')");
							?>
							<style type="text/css">
								#subjectAdded{
									display:block;
									color:lime;
								}
							</style>
							<?php
						}//end if...else
					}else{
						//add subject to area of study, As no subjects for that area exists
						mysql_query("INSERT INTO subject (name, Area_of_study) 
						VALUES ('" . $_POST['newSub'] . "','" . $areaStudy . "')");
						?>
						<style type="text/css">
							#subjectAdded{
								display:block;
								color:lime;
							}
						</style>
						<?php
					}//end if...else
				}else{
					//display error message
					?>
					<style type="text/css">
						#requireSubject{
							display:block;
						}
					</style>
					<?php
				}//end if...else
			}//end if
		}//end if
		// Welcome administrator to the site
		echo '<p>Hi ' . $name . ',<br>Welcome to the Administration Area, 
		what would you like to do today?<br></p>
		Add new Subject to your area of expertise - ' . $expertise . ':
		<form method="post" action="index.php?newSubject">
			<input type="text" name="newSub" id="newSub" placeholder="Enter new Subject here..." />
			<input type="submit" name="addSub" id="addSub" class="button" value="Add New Subject" /></br>
			<div class="searchMsg" id="requireSubject">* Please enter in a new subject... *</div>
			<div class="searchMsg" id="subjectMatch">* This subject already exists within the area of ' . $expertise . '... *</div>
			<div class="searchMsg" id="subjectAdded">* This subject has been added to the area of ' . $expertise . '... *</div>
		</form>';
		echo "<br>Other options:<br><a href='manage_tut.php' title='Create a Tutorial'><button>Create a Tutorial</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='#' title='Change your profile picture'><button>Change your profile picture</button></a>";
		//check to see if the admin member has any tutorials created
		$tutSearch = mysql_query("SELECT Tutorial_id, Title, Likes, TutViews FROM tutorial WHERE AdminCreator='$admin' ORDER BY Date_created DESC LIMIT 9");
		$tutCount = mysql_num_rows($tutSearch);
		if($tutCount > 0){
			echo "<h2>Recently Created Tutorials By You</h2>";
			while($row = mysql_fetch_array($tutSearch)){
				$likes = $row['Likes'];
				$views = $row['TutViews'];
				if(!isset($views)){
					$views = 0;
				}//end if()				
				if(!isset($likes)){
					$likes = 0;
				}//end if()
				echo "<a class='studTuts' href='AdmintutSelected.php?id=" . $row['Tutorial_id'] ."' title='Play Tutorial'><div class='tutDisplay'>
				<img id='tutImg' src='../css/logoOleTutor.png' name='" . $row['Title'] ."' />
				<p>" . $row['Title'] ."<br>Likes: " . $likes . "&nbsp;&nbsp;&nbsp;Views: " . $views . "
				<div class='playMedia'>
					Play Tutorial
				</div>
				</div></a>";
			}//while()
		}else{
			echo "<h2>Recently Created Tutorials By You</h2><p>You haven't created any tutorials yet.</p>";
		}//end if...else()		
		?>
    	</div>
<?php include 'Admin_footer.php'; ?>