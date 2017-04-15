<?php include 'Admin_header.php'; ?>
    <div class="content">
    	<h1>Manage Your Tutorials</h1>
	<?php
		//Get the tutorial that the user wishes to view
		$viewIframe = NULL;
		if(isset($_GET["viewId"])){
			$tutorialToViewId = $_GET["viewId"];
			$tutorFind = mysql_query("SELECT Url FROM tutorial WHERE Tutorial_id = '" . $tutorialToViewId . "'");
			$findCount = mysql_num_rows($tutorFind);
			if($findCount==1){
				while($found = mysql_fetch_array($tutorFind)){
					$_SESSION["viewIframe"] = $found["Url"];
				}//end while
			}else{
				echo "problem occurred please try again!!";
			}
		}//end if		
		//Check to see if the $_SESSION["viewIframe"] is empty
		if(isset($_SESSION["viewIframe"])){
			// Display Tutorial
			?><style type="text/css">
			#viewTut{
				display:block;
				clear:both;
				margin-left:20%;
			}
			</style><?php
			$viewIframe = $_SESSION["viewIframe"];
			unset($_SESSION["viewIframe"]);
		}else{
			//Set the session to 0
			$_SESSION["viewIframe"] = NULL;
		}//if..else
		// Make changes to the tutorial
		if(isset($_POST["changeTutorial"])){
			if(isset($_GET['editTutorial'])){
				if($_POST["editTitle"] != NULL && $_POST["editIframe"] != NULL && $_POST["editDesc"] != NULL){
					//update fields
					mysql_query("UPDATE tutorial SET Title = '" . $_POST['editTitle'] . "', Url = '" . $_POST['editIframe'] . "', Description = '" . $_POST['editDesc'] . "' WHERE Tutorial_id = '" . $_SESSION['tutId'] . "'");
					unset($_SESSION["tutId"]);
					header("location: manage_tut.php");
					exit();
				}else{
					$editTutorialID = $_SESSION["tutId"];
					header('location: manage_tut.php?editId=' . $editTutorialID  . '');
					exit();
				}//end if...else
			}//end if
		}//end if
		//Edit Tutorial
		if(isset($_GET['editId'])){
			?><style type="text/css">
			#searchBar{
				display:none;
				width:auto;
			}
			#viewTutorials{
				display:none;
				width:auto;
			}
			</style><?php
			
			$_SESSION["tutId"] = $_GET["editId"];
			$editTutorial = mysql_query("SELECT Url, Title, Description, Subject FROM tutorial WHERE Tutorial_id = '" . $_SESSION['tutId'] . "'") or die(mysql_error());
			while($editTut = mysql_fetch_array($editTutorial)){
				$editUrl = $editTut["Url"];
				$editTitle = $editTut["Title"];
				$editDesc = $editTut["Description"];
				$editSubjectId = $editTut["Subject"];
			}//end while
			echo "<h2>Edit Tutorial - " . $editTitle . "</h2>";
			echo "<form method='post' action='manage_tut.php?editTutorial'>
				<div id='blankfieldInfo'>* All Fields must be filled in *</div>
				<div class='editName'>
					Title: 
				</div>
				<input type='text' name='editTitle' id='editTitle' value='". $editTitle . "'>
				<br>
				<div class='editName'>
					Tutorial iframe: 
				</div>
				<textarea name='editIframe' rows='3' cols='30'>". $editUrl . "</textarea>
				<br>
				<div class='editName'>
					Tutorial Description: 
				</div>
				<textarea name='editDesc' rows='3' cols='30'>". $editDesc . "</textarea>
				<br>
				<div class='editName'>
					Subject: 
				</div>
				<select>";
				$subQuery = mysql_query("SELECT name FROM subject WHERE id='$editSubjectId'");
				$subQueryCount = mysql_num_rows($subQuery);
				if($subQueryCount > 0){
					while($sub = mysql_fetch_array($subQuery)){
						echo "<option value='" . $editSubjectId ."'>" . $sub['name'] . "</option>";
					}//end while
				}//end if
				$subQuery2 = mysql_query("SELECT id, name FROM subject WHERE id<>'$editSubjectId'");
				$subQueryCount2 = mysql_num_rows($subQuery2);
				if($subQueryCount2 > 0){
					while($sub2 = mysql_fetch_array($subQuery2)){
						echo "<option value='" . $sub2['id'] ."'>" . $sub2['name'] . "</option>";
					}//end while
				}//end if
				echo "</select>
				<br>
				<input type='submit' name='changeTutorial' style='background-color:#0084b4;' id='changeTutorial' value='Change'>
				<a href='manage_tut.php' title='Cancel'><button>Cancel</button></a>
			</form>";
		}//end if
		// Delete Tutorial Check
		if(isset($_GET['tutId'])){
			echo "<div class='deleteMsg' style='align:center;width:90%;margin-left:20px;'>Are you sure you want to delete this tutorial? <a href='manage_tut.php?deleteId=" . $_GET['tutId'] . "'><button>YES</button></a> <a href='manage_tut.php'><button>NO</button></a></div>";
		}//end if
		if(isset($_GET['deleteId'])){			
			$deleteTut = mysql_query("DELETE FROM Tutorial WHERE Tutorial_id = '" . $_GET['deleteId'] . "'") or die(mysql_error());
			$_GET['deleteId'] = NULL;
		}//end if
		//create tutorial bar
		$areaSearch = mysql_query("SELECT * FROM subject WHERE Area_of_study='$areaStudy'");
		$areaCount = mysql_num_rows($areaSearch); // Count the number of Rows
		$iframe = "";
		$tutName = "";
		$tutDesc = "";
		$subject="";
		$chooseSubject = "";
		if(isset($_POST['search'])){ 
	  		if(isset($_GET['go'])){
				$iframe=$_POST['iframe'];
				$tutName=$_POST['title'];
				$tutDesc=nl2br($_POST['description']);
			}//end if
		}//end if
		if($areaCount > 0){
			echo "<div id='searchBar'><h1>Create a Tutorial</h1><br><div class='searchMsg' id='requireMsg'>* Required Field</div><br><form method='post' action='manage_tut.php?go' id='searchform'>";
			echo "<div class='searchName'> Title: </div><input type='text' name='title' value='". $tutName . "'><div class='searchMsg' id='requireTitle'>*</div>";
			echo "<div class='searchName'> Tutorial iframe: </div><textarea name='iframe' rows='3' cols='30'>". $iframe . "</textarea><div class='searchMsg' id='requireIframe'>*</div>";
			echo "<div class='searchName' id='iframeInUse' style='width:auto; color: red'></div>";
			echo "<div class='searchName'> Tutorial Description: </div><textarea name='description' rows='3' cols='30'>". $tutDesc . "</textarea><div class='searchMsg' id='requireDesc'>*</div>";			
		}//end if
		echo "<div class='searchName'> Subject: </div>
		<select name='subject' class='subject'><option value='0'>Choose a Subject...</option>";
		while($areas = mysql_fetch_array($areaSearch)){
				$id = $areas["id"];
				$subject = $areas["name"];
				if(isset($subject)){
					echo "<option value='" . $id ."'>" . $subject . "</option>";
				}//end if
			}//end while
		echo "</select><div class='searchMsg' id='requireSubject'>*</div>
		<div class='searchMsg' id='displaySubError'>* Choose A Subject *</div>
		<br><br>
		<input type='submit' id='searchButton' name='search' value='Submit'>
		</form>
		</div>";
		if(isset($_POST['search'])){ 
	  		if(isset($_GET['go'])){
				if($tutName== ""||$tutDesc== ""||$iframe== ""){	
					?><style type="text/css">
						#requireMsg{
						display:block;
						}
					</style>						
					<?php
					if($tutName== ""){	
						?><style type="text/css">
							#requireTitle{
							display:block;
							}
						</style><?php
					}//end if
					if($tutDesc== ""){	
						?><style type="text/css">
							#requireDesc{
							display:block;
							}
						</style><?php
					}//end if
					if($iframe== ""){	
						?><style type="text/css">
							#requireIframe{
							display:block;
							}
						</style><?php
					}//end if
					if($subject== 0){	
						?><style type="text/css">
							#requireArea{
							display:block;
							}
							#requireSubject{
							display:block;
							}
						</style><?php
					}//end if
				}//end if
				if($tutName!= "" && $tutDesc!= "" && $iframe!= ""){
					//check that iframe does not already exist in the system
					$iframeCheck = mysql_query("SELECT url FROM Tutorial");
					$iframeCount = mysql_num_rows($iframeCheck); // Count the number of Rows
					if($iframeCount > 0){
						$iframenum = 0;
						while($iframes = mysql_fetch_array($iframeCheck)){
							if($iframe == $iframes["url"]){
								$iframenum++;
							}//end if
						}//end while
					}//end if
					//Letting member know that this iframe is already in use.
					if($iframenum > 0){
						?><script>
							document.getElementById("iframeInUse").innerHTML = " *The iframe for this tutorial is already being displayed*";
						</script>
						<style type="text/css">
							#requireIframe{
							display:block;
							}
						</style>						
						<?php
					}else{
						?><style type="text/css">
							#sectionB{
							display:block;
							}
							#sectionA{
							display:none;
							}
						</style>						
						<?php
						if(isset($_POST['subject'])){
							$subject=$_POST['subject'];
						}else {
							$subject=0;
						}//end if else
						$verified=1;
						if($subject>0){
							//do insertion here, hide the create a tutorial bar and display tutorial to user once inserted.
							$insertTut = mysql_query("INSERT INTO Tutorial (Subject, Url, Title, AdminCreator, Description, VerifyStatus)
    							VALUES ('" . $subject . "', '" . $iframe . "', '" . $tutName . "', '" . $admin . "', '" . $tutDesc . "', '" . $verified . "')") or die(mysql_error());
							$subject=0;
							?><style type="text/css">
							#sectionB{
							display:none;
							}
							#sectionA{
							display:block;
							}
						</style>						
						<?php
							//Get the id of the entered tutorial to preview the tutorial
						}else if($subject==0){
							?><style type="text/css">
								#displaySubError{
								display:block;
								}
							</style>						
							<?php
						}//end else if
					}//end if...else
				}//end if
			}//end if
		}//end if
		//Display created tutorials by member
		if (isset($_GET["page"])) { 
			$page  = $_GET["page"]; 
		}else{ 
			$page=1; 
		}
		$start_from = ($page-1) * 10; 
		$selectTuts = mysql_query("SELECT * FROM tutorial WHERE AdminCreator = '$admin' ORDER BY Date_created DESC LIMIT $start_from, 10");
		$selectCount = mysql_num_rows($selectTuts);
		if($selectCount > 0){
			$num = 1;
			echo "<div id='viewTutorials'><h2>Created Tutorials</h2>";
			echo '<div class="CSSTableGenerator"><table><tr>
                        <td>#</td>
                        <td>Title</td>
                        <td>Likes</td>
                        <td>Views</td>
                        <td>Verified</td>
                        <td>Date Created</td>
                        <td>Manage</td></tr>';
			while($selected = mysql_fetch_array($selectTuts)){
				$idList = $selected["Tutorial_id"];
				$titleList = $selected["Title"];
				$likeList = $selected["Likes"];
				$tutViewList = $selected["TutViews"];
				$verifiedList = $selected["VerifyStatus"];
				$dateList = $selected["Date_created"];
				if(!isset($likeList)){
					$likeList = 0;
				}
				if($verifiedList == '1'){
					$verifiedList = "Yes";
				}else{
					$verifiedList = "No";
				}
				if(!isset($tutViewList)){
					$tutViewList = 0;
				}
				echo "<tr><td >" . $num ."</td>
                        	<td>" . $titleList ."</td>
                        	<td>" . $likeList ."</td>
                        	<td >" . $tutViewList ."</td>
                        	<td>" . $verifiedList ."</td>
                        	<td>" . $dateList ."</td>
                        	<td><a href='manage_tut.php?viewId=" . $idList . "'><button>View</button></a> <a href='manage_tut.php?editId=" . $idList . "'><button>Edit</button></a> <a href='manage_tut.php?tutId=" . $idList . "'><button>Delete</button></a></td></tr>";
				$num++;
			}//end while
			echo "</table>";
			$sqlTut = mysql_query("SELECT COUNT(*) FROM tutorial WHERE AdminCreator = '$admin'");
			$rowTut = mysql_fetch_row($sqlTut); 
			$total_records = $rowTut[0];
			$total_pages = ceil($total_records / 10);
			if($total_pages > 1){
				echo "<div class='pageDisplay' style='clear:both;margin:10px;margin-right:20px;float:right;'>Pages: ";
				for ($i=1; $i<=$total_pages; $i++) { 
        				echo "<a href='manage_tut.php?page=".$i."'>".$i."</a> "; 
				}//end for
				echo "</div>";
			}else{
				echo "<div class='pageDisplay' style='clear:both;margin:10px;margin-right:20px;float:right;'>Page: 1</div>";
			}//end if..else
			echo "</div></div>";
		}//end if
		echo "<div id='viewTut'>" . $viewIframe . "</div>";
	?>    
	</div>
<?php include 'Admin_footer.php'; ?>