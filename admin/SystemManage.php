<?php include 'Admin_header.php'; ?>
<?php
//variables needed to avoid errors on screen
$adminLvl = 0;
$userExpertise = 0;
$newName = NULL;
$dob = NULL;
$email = NULL;
$newPword = NULL;
$subjectName = NULL;
$newArea = NULL;
?>
    <div class="content">
    	<h1>System Management</h1>
	<div id="mainOptions">
		System Management Options:</br>
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="SystemManage.php?AddAd"><button>Add an Administrator</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="SystemManage.php?ManAd"><button>Manage Administrators</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="SystemManage.php?ManMem"><button>Manage Members</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="SystemManage.php?ManSub"><button>Manage Subjects</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="SystemManage.php?ManArea"><button>Manage Areas of Study</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
	</div>
	<?php
	//When Clicked display the options
	//Add administrator
	if(isset($_GET['AddAd'])){
		?>
		<style type="text/css">
			#AddAdmin{
				display:block;
			}
		</style>
		<?php
	}//end if
	///////////////////////////////////////////////////////////////////////////////
	//Manage administrator
	if(isset($_GET['ManAd'])){
		?>
		<style type="text/css">
			#ManAdmin{
				display:block;
			}
		</style>
		<?php
	}//end if
	//change administrator's Admin Level access
	if(isset($_GET['changeLevel'])){
		?>
		<style type="text/css">
			#ManAdmin{
				display:block;
			}
		</style>
		<?php
		$changeAdminAccess = $_GET['changeLevel'];
		if(isset($_GET['changed'])){
			$getAccess = mysql_query("SELECT admin_level FROM admin WHERE username='" . $changeAdminAccess . "'");
			$accessCount = mysql_num_rows($getAccess);
			if($accessCount > 0){
				while($AccessRow = mysql_fetch_array($getAccess)){
					if($AccessRow["admin_level"] == 1){
						//change admin level to two
						$newLevel = 2;
						mysql_query("UPDATE admin SET admin_level='" . $newLevel . "' WHERE username='" . $changeAdminAccess . "'");
						header('Location: SystemManage.php?ManAd');
						exit;
					}else if($AccessRow["admin_level"] == 2){
						//change admin level to one
						mysql_query("UPDATE admin SET admin_level=1 WHERE username='" . $changeAdminAccess . "'"); 
						header('Location: SystemManage.php?ManAd');
						exit;						
					}//end if..else
				}//end while
			}//end if
		}else{
			echo "Are you sure you want to change " . $changeAdminAccess . " admin user's Admin Level Access?&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?changeLevel=" . $changeAdminAccess . "&changed=1'><button>Yes</button></a>&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?ManAd'><button>No</button></a>";
		}//end if..else
	}//end if
	//change admin password
	if(isset($_GET['changeAdminPword'])){
		?>
		<style type="text/css">
			#ManAdmin{
				display:block;
			}
		</style>
		<?php
		$userPwordChange = $_GET['changeAdminPword'];
		if(isset($_GET['changed'])){
			//Change password to default password which is "password"
			mysql_query("UPDATE admin SET p_word='password' WHERE username='" . $userPwordChange . "'"); 
			header('Location: SystemManage.php?ManAd');
			exit;	
		}else{
			echo "Are you sure you want to change " . $userPwordChange . " admin user's Admin Level Access?&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?changeAdminPword=" . $userPwordChange . "&changed=1'><button>Yes</button></a>&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?ManAd'><button>No</button></a></br>
			* NOTE: the password will be set to the default password which is password (All lowercase).</br>
			Once you click Yes the password is changed. *";
		}//end if..else
	}//end if
	//Delete Admin Member
	if(isset($_GET['deleteAdmin'])){
		?>
		<style type="text/css">
			#ManAdmin{
				display:block;
			}
		</style>
		<?php
		$userDelete = $_GET['deleteAdmin'];
		if(isset($_GET['changed'])){
			//Delete Administrator from the database
			// if they have an admin profile picture delete it.
			$queryImage = mysql_query("SELECT image FROM admin WHERE username='" . $userDelete . "'");
			$imgCount = mysql_num_rows($queryImage);
			if($imgCount == 1){
				while($imgRow = mysql_fetch_array($queryImage)){
					$adminImage = $imgRow["image"];
				}//end while
			}//end if
			if($adminImage != NULL){
				//DELETE IMAGE
				if (file_exists("Admin_pics/" . $adminImage)){
					// delete current profile picture
    					unlink("Admin_pics/" . $adminImage);
				}//end if
			}//end if
			mysql_query("SET FOREIGN_KEY_CHECKS=0");
			mysql_query("DELETE FROM admin WHERE username='" . $userDelete . "'") or die(mysql_error()); 
			mysql_query("DELETE FROM tutorial WHERE AdminCreator='" . $userDelete . "'") or die(mysql_error());
			mysql_query("SET FOREIGN_KEY_CHECKS=1");
			header('Location: SystemManage.php?ManAd');
			exit;	
		}else{
			echo "Are you sure you want to delete " . $userDelete . " admin user from the system?&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?deleteAdmin=" . $userDelete . "&changed=1'><button>Yes</button></a>&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?ManAd'><button>No</button></a></br>
			* NOTE: When you delete a member you will also be deleting their tutorials from the system. *</br>
			* Once you click Yes the member is deleted. *";
		}//end if..else
	}//end if
	///////////////////////////////////////////////////////////////////////////
	//Manage Members
	if(isset($_GET["ManMem"])){
		?>
		<style type="text/css">
			#ManMembers{
				display:block;
			}
		</style>
		<?php
	}//end if
	//Delete Member
	if(isset($_GET["deleteMember"])){
		?>
		<style type="text/css">
			#ManMembers{
				display:block;
			}
		</style>
		<?php
		$memDelete = $_GET["deleteMember"];
		if(isset($_GET['changed'])){
			//Delete member from the database
			// if they have an member profile picture delete it.
			$querymemberImg = mysql_query("SELECT image FROM student WHERE username='" . $memDelete . "'");
			$imageCount = mysql_num_rows($querymemberImg);
			if($imageCount == 1){
				while($imageRow = mysql_fetch_array($querymemberImg)){
					$memberImage = $imageRow["image"];
				}//end while
			}//end if
			if($memberImage != NULL){
				//DELETE IMAGE
				if (file_exists("../Student/StudentPics/" . $memberImage)){
					// delete current profile picture
    					unlink("../Student/StudentPics/" . $memberImage);
				}//end if
			}//end if
			mysql_query("SET FOREIGN_KEY_CHECKS=0");
			mysql_query("DELETE FROM student WHERE username='" . $memDelete . "'") or die(mysql_error()); 
			mysql_query("DELETE FROM viewed WHERE username='" . $memDelete . "'") or die(mysql_error()); 
			mysql_query("DELETE FROM tutorial WHERE StudentCreator='" . $memDelete . "'") or die(mysql_error());
			mysql_query("SET FOREIGN_KEY_CHECKS=1");
			header('Location: SystemManage.php?ManMem');
			exit;	
		}else{
			echo "Are you sure you want to delete " . $memDelete . " member user from the system?&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?deleteMember=" . $memDelete . "&changed=1'><button>Yes</button></a>&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?ManMem'><button>No</button></a></br>
			* NOTE: When you delete a member you will also be deleting their tutorials from the system. *</br>
			* Once you click Yes the member is deleted. *";
		}//end if..else
	}//end if
	////////////////////////////////////////////////////////////////////////////
	//Manage Subjects
	if(isset($_GET["ManSub"])){
		?>
		<style type="text/css">
			#ManSub{
				display:block;
			}
		</style>
		<?php
	}//end if
	//Add a subject to the system
	if(isset($_GET["addSub"])){
		?>
		<style type="text/css">
			#ManSub{
				display:block;
			}
		</style>
		<?php
		if(isset($_POST["addSubject"])){
			$userExpertise = $_POST["areaExp"];
			$subjectName = $_POST["newSubject"];
			if($userExpertise == 0){
				//display require message
				?>
				<style type="text/css">
					#requireArea{
						display:block;
					}
				</style>
				<?php				
			}//end if
			if($subjectName == NULL){
				//display require message
				?>
				<style type="text/css">
					#requireSubject{
						display:block;
					}
				</style>
				<?php					
			}//end if
			if($subjectName != NULL && $userExpertise > 0){
				//check to see if subject exists
				$subMatch = 0;
				$subQuery = mysql_query("SELECT name, Area_of_study FROM subject");
				$subCount = mysql_num_rows($subQuery);
				if($subCount > 0){
					while($subjectRow = mysql_fetch_array($subQuery)){
						if((strtoupper($subjectRow["name"]) == strtoupper($subjectName)) && ($subjectRow["Area_of_study"] == $userExpertise)){
							$subMatch = 1;
							//display match message
							?>
							<style type="text/css">
							#subjectExists{
								display:block;
							}
							</style>
							<?php
							break;
						}//end if
					}//end while
				}//end if
				if($subMatch == 0){
					//add subject to subject table
					mysql_query("INSERT INTO subject(name, Area_of_study)
					VALUES('" . $subjectName . "', '" . $userExpertise . "')") or die(mysql_error());
					header('Location: SystemManage.php?ManSub');
					exit;
				}//end if
			}//end if
		}//end if
	}//end if
	//delete a subject from the system
	if(isset($_GET["deleteSubject"])){
		?>
		<style type="text/css">
			#ManSub{
				display:block;
			}
		</style>
		<?php
		$subjectToDel = $_GET["deleteSubject"];
		if(isset($_GET['changed'])){
			mysql_query("SET FOREIGN_KEY_CHECKS=0");
			mysql_query("DELETE FROM subject WHERE id='" . $subjectToDel . "'") or die(mysql_error()); 
			mysql_query("DELETE FROM tutorial WHERE Subject='" . $subjectToDel . "'") or die(mysql_error());
			mysql_query("SET FOREIGN_KEY_CHECKS=1");
			header('Location: SystemManage.php?ManSub');
			exit;	
		}else{
			echo "Are you sure you want to delete this subject from the system from the system?&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?deleteSubject=" . $subjectToDel . "&changed=1'><button>Yes</button></a>&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?ManSub'><button>No</button></a></br>";
		}//end if..else
	}//end if
	///////////////////////////////////////////////////////////////////////////
	//Manage Area of Study
	if(isset($_GET["ManArea"])){
		?>
		<style type="text/css">
			#ManArea{
				display:block;
			}
		</style>
		<?php
	}//end if
	if(isset($_GET["AddArea"])){
		?>
		<style type="text/css">
			#ManArea{
				display:block;
			}
		</style>
		<?php
		//Check to see id the area exists within the system
		if(isset($_POST["subArea"])){
			$newArea = $_POST["areaName"];
			if($newArea != NULL){
				$areaMatch = 0;
				$areaCheck = mysql_query("SELECT area FROM areaofStudy");
				$checkCount = mysql_num_rows($areaCheck);
				if($checkCount > 0){
					while($checkRow = mysql_fetch_array($areaCheck)){
						if(strtoupper($checkRow["area"]) == strtoupper($newArea)){
							$areaMatch = 1;
							?>
							<style type="text/css">
								#areaMatch{
									display:block;
								}
							</style>
							<?php	
							$newArea = NULL;
							break;
						}//end if
					}//end while
				}//end if
				if($areaMatch == 0){
					//add area to system
					mysql_query("INSERT INTO areaofstudy(area) VALUES('" . $newArea . "')");
					header('Location: SystemManage.php?ManArea');
					exit;
				}//end if	
			}else{
				?>
				<style type="text/css">
					#reqArea{
						display:block;
					}
				</style>
				<?php	
			}//end if..else
		}//end if
	}//end if
	// Delete area of study
	if(isset($_GET["deleteArea"])){
		?>
		<style type="text/css">
			#ManArea{
				display:block;
			}
		</style>
		<?php
		$areaToDel = $_GET["deleteArea"];
		if(isset($_GET['changed'])){
			mysql_query("SET FOREIGN_KEY_CHECKS=0");
			mysql_query("DELETE FROM areaofstudy WHERE id='" . $areaToDel . "'") or die(mysql_error()); 
			mysql_query("DELETE A FROM tutorial AS A
			INNER JOIN subject AS B ON B.id = A.subject
			WHERE B.Area_of_study ='" . $areaToDel . "'") or die(mysql_error());
			mysql_query("DELETE FROM subject WHERE Area_of_study='" . $areaToDel . "'") or die(mysql_error()); 
			mysql_query("SET FOREIGN_KEY_CHECKS=1");
			header('Location: SystemManage.php?ManArea');
			exit;	
		}else{
			echo "Are you sure you want to delete this Area from the system?&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?deleteArea=" . $areaToDel . "&changed=1'><button>Yes</button></a>&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?ManArea'><button>No</button></a></br>";
		}//end if..else
	}//end if
	///////////////////////////////////////////////////////////////////////////
	?>	
	<div class="clearBoth" style="clear:both;"></br></div>
	<div class="hideInput" id="AddAdmin">
		<!--Add Administrator to the system-->
		In this section you can Add an administrator to the system.
		<div class="clearBoth" style="clear:both;"></br></div>
		
		<?php
		//while loop will continue until the loop does not equal 0
		$loop = 0;
		//if the submit button is clicked
		if(isset($_POST['submitAdmin'])){ 
			//make sure it doesn't enter the while loop so the username stays the same
			$loop = 1;
			$autoUsername = $_POST['username'];
			$newName = $_POST['adminName'];
			$dob = $_POST['dateOB'];
			$email = $_POST['emailAdd'];
			$adminLvl = $_POST['adminLvl'];
			$userExpertise = $_POST['areaExp'];
			//make sure the form stays open
			?>
			<style type="text/css">
				#AddAdmin{
					display:block;
				}
			</style>
			<?php
			//make sure that all the fields are filled out
			if($newName == NULL){
				//display require field
				?>
				<style type="text/css">
					#requireName{
						display:block;
						float:none;
					}
				</style>
				<?php
			}//end if
			if($dob == NULL){
				//display require date of birth
				?>
				<style type="text/css">
					#requireDob{
						display:block;
						float:none;
					}
				</style>	
				<?php			
			}//end if
			if($email == NULL){
				//display require Email Address
				?>
				<style type="text/css">
					#requireEmail{
						display:block;
						float:none;
					}
				</style>	
				<?php			
			}else{
				//check if the email already exists with a new member
				$checkEmail = mysql_query("SELECT email FROM admin WHERE email='" . $email . "'");
				$emailCount = mysql_num_rows($checkEmail);
				if($emailCount == 1){
					//display message that this email is already in use and set email to null
					$email = NULL;
					?>
					<style type="text/css">
						#emailMatched{
							display:block;
							float:none;
						}
					</style>	
					<?php		
				}//end if
			}//end if...else
			if($adminLvl == 0){
				//display please choose an admin level
				?>
				<style type="text/css">
					#requireLevel{
						display:block;
						float:none;
					}
				</style>
				<?php							
			}//end if
			if($userExpertise == 0){
				//display please choose an area of study
				?>
				<style type="text/css">
					#requireArea{
						display:block;
						float:none;
					}
				</style>	
				<?php		
			}//end if
			//if all fields are filled out add to member to the system
			if(($dob != NULL && $newName != NULL)&&($emailCount == 0 && $email != NULL)&&($userExpertise > 0 && $adminLvl > 0)){
				$newPword = "password";
				mysql_query("INSERT INTO admin (username, p_word, name, email, area_of_study, admin_level, dob)
				VALUES('" . $autoUsername . "', '" . $newPword . "', '" . $newName . "', '" . $email . "', '" . $userExpertise . "', '" . $adminLvl . "', '" . $dob . "')") or die(mysql_error());
				// Once this is done display a message telling the user that they have successfully created a new admin member.
				?>
				<style type="text/css">
					#adminAdded{
						display:block;
					}
					#addAdminForm{
						display:none;
					}
				</style>	
				<?php				
			}//end if
		}//end if
		while($loop == 0){
			//auto create a username
			//get a random four digit number
			$number = $id_num = sprintf("%04d", (rand(0001,9999)));
			//get a random Upper case letter
			$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$sufix = $letters[rand(0, 25)];
			//merge the letter and number together
			$autoUsername = $sufix . $number;
			//check to see if the username exists
			$usernameCheck = mysql_query("SELECT username FROM admin");
			$uCount = mysql_num_rows($usernameCheck);
			$num = 0;
			if($uCount > 0){
				while($checker = mysql_fetch_array($usernameCheck)){
					if($checker["username"] == $autoUsername){
						//this resets the num to equal zero meaning the $loop will not be changed
						// so it will restart the while loop
						$num = 0;
						break;
					}else{
						$num++;
					}//end if...else
				}//end while
			}//end if
			// If there are zero rows found in the sql query it means they're no admin members in the system, this won't ever occur, just for security reasons.
			// If the $num variable is equal to the $uCount it means there has been no username matches, therefor the username can be used
			if($uCount == 0 || $uCount == $num){
				//Now check student usernames just for security reason
				$studCheck = mysql_query("SELECT username FROM student");
				$sCount = mysql_num_rows($studCheck);
				$number = 0;
				if($sCount > 0){
					while ($studChecker = mysql_fetch_array($studCheck)){
						if($studChecker["username"] == $autoUsername){
							//this resets the num to equal zero meaning the $loop will not be changed
							// so it will restart the while loop
							$num = 0;
							break;
						}else{
							$number++;
						}//end if...else
					}//end while
				}//end if
				if($sCount == 0 || $sCount == $number){
					$loop = 1;
				}//end if
			}//end if
		}//end while
		// create a form to enable the user to create a member
		echo "<div id='addAdminForm'><form method='post'  action='SystemManage.php?addAdministrator'>
			Generated Username</br><input type='text' name='username' id='username' value='" . $autoUsername . "' readonly></br>
			Name (required)</br><input type='text' name='adminName' id='adminName' value='" . $newName . "' placeholder='Enter name here..'>
			<div class='searchMsg' id='requireName'>Please fill out your name</div></br>
			Date of Birth (required)</br><input type='date' id='dateOB' name='dateOB' value='". $dob . "'>
			<div class='searchMsg' id='requireDob'>Please fill out your Date of Birth</div></br>
			email address (required)</br><input type='text' id='emailAdd' name='emailAdd' value='" . $email . "' placeholder ='Enter email here...'>
			<div class='searchMsg' id='requireEmail'>Please fill out your email address</div>
			<div class='searchMsg' id='emailMatched'>This email already exists with a current admin member</div></br>
			Admin Level (required)</br>
			<select id='adminLvl' name='adminLvl'>
				<option value='0'>choose an Admin Level...</option>
				<option value='1'>1 (minimum Access)</option>
				<option value='2'>2 (full Access)</option>
			</select><div class='searchMsg' id='requireLevel'>Please Choose an administration level</div></br>
			Area of Expertise (required)</br>";
				//so they don't have to rechoose their area of study everytime the page reloads because of a missing field
				if($userExpertise == 0){
					$startMsg = "Choose an Area of Expertise";
				}else{
					$getArea = mysql_query("SELECT area FROM areaofstudy WHERE id = '" . $userExpertise . "'");
					$getCount = mysql_num_rows($getArea);
					if($getCount == 1){
						while($get = mysql_fetch_array($getArea)){
							$startMsg = $get["area"];
							break;
						}//end while
					}//end if
				}//end if..else
				//run sql to display areas of study
				$areas = mysql_query("SELECT * FROM areaofstudy WHERE id <> '" . $userExpertise . "'");
				$areaCount = mysql_num_rows($areas);
				if($areaCount > 0){
					echo "<select id='areaExp' name='areaExp'>
						<option value='$userExpertise'>" . $startMsg . "</option>";
					while($areaAv = mysql_fetch_array($areas)){
						$areaId = $areaAv["id"];
						$areaName = $areaAv["area"];
						echo "<option value='" . $areaId . "'>" . $areaName . "</option>";
					}//end while
					echo "</select><div class='searchMsg' id='requireArea'>Please Choose an area of study</div></br>";
				}
			echo "<input type='submit' name='submitAdmin' id='submitAdmin' value='Submit'>&nbsp;&nbsp;&nbsp;&nbsp;<a href=''><button>Cancel</button></a>
		</form></div>";
		echo '<div class="hideInput" id="adminAdded">
			<h2>You have successfully added a new administrator</h2>
			New User: ' . $newName . '</br>
			<u>Login Details</u></br>
			Username: ' . $autoUsername . '</br>
			Password: ' . $newPword . '</br>
			Please be sure to change password on first login for security reasons.</br>
			Their profile picture is set to default, they can add their own image in once logged in if wished.
		</div>';
		?>
	</div>
	<div class="hideInput" id="ManAdmin">
		<!--Manage Administrators of the system-->
		In this section you can delete an Administrator, change their admin level and change their password if requested.</br>
		<b>Be aware that when deleting an Administrator, you will also delete any tutorials connected with that Administrator!!</b>
		<h2>Manage Administrators</h2>
		<?php
		// Get the table of all the administrators not including the using admin member
		$AdminQuery = mysql_query("SELECT * FROM admin WHERE username <> '" . $admin ."'");
		$adminCount = mysql_num_rows($AdminQuery);
		if($adminCount > 0){
			$counter = 0;
		?>
			<style type="text/css">
			.CSSTableGenerator table{
				width:90%;
			}
			</style>
		<?php
			echo '<div class="CSSTableGenerator"><table align="center"><tr>
                        		<td>#</td>
					<td>username</td>
                        		<td>name</td>
                        		<td>email</td>
					<td>admin Level</td>
					<td>Area of Expertise</td>
                        		<td>Options</td>
				</tr>';
			while($rowAdmin = mysql_fetch_array($AdminQuery)){
				$counter++;
				echo '<tr>
					<td>' . $counter. '</td>
					<td>' . $rowAdmin["username"] . '</td>
					<td>' . $rowAdmin["name"] . '</td>
					<td>' . $rowAdmin["email"] . '</td>
					<td>' . $rowAdmin["admin_level"] . '</td>';
				$areaOfStudy = $rowAdmin['area_of_study'];
				//get name of area of study
				$AreaName = mysql_query("SELECT area FROM areaofstudy WHERE id='" . $areaOfStudy . "'");
				$areaNameCount = mysql_num_rows($AreaName);
				if($areaNameCount > 0){
					while($rowName = mysql_fetch_array($AreaName)){
						echo '<td>' . $rowName["area"] . '</td>';	
					}//end while
				}//end if
					echo '<td>
						<a href="SystemManage.php?changeLevel=' . $rowAdmin["username"] . '"><button>Change Admin Level</button></a>
						<a href="SystemManage.php?changeAdminPword=' . $rowAdmin["username"] . '"><button>Change password</button></a>
						<a href="SystemManage.php?deleteAdmin=' . $rowAdmin["username"] . '"><button>Delete</button></a>
					</td>
				</tr>';
			}//end while
			echo "</table></div>";
		}else{
			echo "<p>You are currently the only admin member on the system</p>";
		}//end if...else
		?>
	</div>
	<div class="hideInput" id="ManMembers">
		<!--Manage members of the system-->
		In this section you can delete a member.</br>
		<b>Be aware that when deleting a member, you will also delete any tutorials connected with that member!!</b>
		<h2>Manage Members</h2>
		<?php
		$memberQuery = mysql_query("SELECT * FROM student WHERE username <> 'NULL'");
		$memberCount = mysql_num_rows($memberQuery);
		if($memberCount > 0){
			$counter = 0;
		?>
			<style type="text/css">
			.CSSTableGenerator table{
				width:90%;
			}
			</style>
		<?php
			echo '<div class="CSSTableGenerator"><table align="center"><tr>
                        	<td>#</td>
				<td>username</td>
                        	<td>fname</td>
                        	<td>sname</td>
				<td>email</td>
                        	<td>Options</td>
			</tr>';
			while($memberRow = mysql_fetch_array($memberQuery)){
				$counter++;
				echo "<tr><td>" . $counter . "</td>
					<td>" . $memberRow['username'] . "</td>
					<td>" . $memberRow['fname'] . "</td>
					<td>" . $memberRow['sname'] . "</td>
					<td>" . $memberRow['email'] . "</td>
					<td><a href='SystemManage.php?deleteMember=" . $memberRow['username'] . "'><button>Delete Member</button></a></td>
				</tr>";
			}//end while
			echo "</table></div>";
		}else{
			echo "There are currently no members within the system";
		}//end if..else
		?>
	</div>
	<div class="hideInput" id="ManSub">
		<!--Add or delete Subject to any area of study-->
		In this section you can Add a Subject to any area of study and also delete subjects that are no longer needed.</br>
		<b>Be aware that when deleting a Subject, you will also delete any tutorials connected with that subject!!</b>
		<h2>Add a Subject</h2>
		<?php
		// create an add subject form
		echo "<form method='post' action='systemManage.php?addSub'>
		New Subject Title (required)</br>
		<input type='text' name='newSubject' id='newSubject' placeholder='Enter subject name here...' value='" . $subjectName . "'>
		<div class='searchMsg' id='requireSubject'>Please enter subject name here</div>
		<div class='searchMsg' id='subjectExists'>This subject already exists</div></br>
		Choose an Area of Study (required)</br>";
		//so they don't have to rechoose their area of study everytime the page reloads because of a missing field
		if($userExpertise == 0){
			$startMsg = "Choose an Area of Study";
		}else{
			$getArea = mysql_query("SELECT area FROM areaofstudy WHERE id = '" . $userExpertise . "'");
			$getCount = mysql_num_rows($getArea);
			if($getCount == 1){
				while($get = mysql_fetch_array($getArea)){
					$startMsg = $get["area"];
					break;
				}//end while
			}//end if
		}//end if..else
		//run sql to display areas of study
		$areas = mysql_query("SELECT * FROM areaofstudy WHERE id <> '" . $userExpertise . "'");
		$areaCount = mysql_num_rows($areas);
		if($areaCount > 0){
			echo "<select id='areaExp' name='areaExp'>
			<option value='$userExpertise'>" . $startMsg . "</option>";
			while($areaAv = mysql_fetch_array($areas)){
				$areaId = $areaAv["id"];
				$areaName = $areaAv["area"];
				echo "<option value='" . $areaId . "'>" . $areaName . "</option>";
			}//end while
			echo "</select><div class='searchMsg' id='requireArea'>Please Choose an area of study</div></br>";
		}//end if
		echo "<input type='submit' name='addSubject' id='addSubject' value='Add Subject'>&nbsp;&nbsp;&nbsp;
		<a href='SystemManage.php?ManSub'><button>Cancel</button></a>
		</form>"; 
		?>
		<hr>
		<h2>Manage Subjects</h2>
		<?php
		//Make the user choose an area to view the subjects of that area
		echo "<form method='post' action='SystemManage.php?showSubs'>			
		Choose an Area of Study</br>";
		$areaName = mysql_query("SELECT * FROM areaofstudy");
		$areaCounter = mysql_num_rows($areaName);
		if($areaCounter > 0){
			echo "<select id='areaExpert' name='areaExpert'>
			<option value='0'>Select an area of study</option>";
			while($areaAvs = mysql_fetch_array($areaName)){
				$areasId = $areaAvs["id"];
				$areasName = $areaAvs["area"];
				echo "<option value='" . $areasId . "'>" . $areasName . "</option>";
			}//end while
		}//end if
			echo "</select><div class='searchMsg' id='requireArea'>Please Choose an area of study</div></br>";
			echo "<input type='submit' name='showSubs' id='showSubs' value='Show Subjects'></form>";
		if(isset($_POST["showSubs"])){
			?>
			<style type="text/css">
				#ManSub{
					display:block;
				}
			</style>
			<?php
			$areaChosen = $_POST['areaExpert'];
			$showSubjects = mysql_query("SELECT id, name FROM subject WHERE Area_of_study='" . $areaChosen . "'");
			$subjectCounter = mysql_num_rows($showSubjects);
			if($subjectCounter > 0){
				// display subject table
				echo '</br><div class="CSSTableGenerator" style="width:auto;"><table align="center"><tr>
                        	<td>#</td>
				<td>subect</td>
                        	<td>Option</td>
				</tr>';
				$num = 0;
				while($subrow = mysql_fetch_array($showSubjects)){
					echo"<tr>
						<td>" . ++$num . "</td>
						<td>" . $subrow['name'] . "</td>
						<td><a href='SystemManage.php?deleteSubject=" . $subrow['id'] . "'><button>Delete</button></a></td>
					</tr>";
				}//end while
				echo "</table></div>";
			}else{
				// Message explaining that there is no subjects for the area of study
				echo "There is currently no subjects for this area of study.";
			}//end if..else
		}//end if
		?>
	</div>
	<div class="hideInput" id="ManArea">
		<!--Add or delete an area of study-->
		<h2>Manage Areas of Study</h2>
		In this section you can Add an area of study and also delete areas that are no longer needed.</br>
		<b>Be aware that when deleting a area, you will also delete any tutorials and subjects connected with that area!!</b>
		<?php
		//create a form to add an Area of Study
		echo "<form method='post' action='SystemManage.php?AddArea'>
			</br><u><b>Add An Area of Study</b></u></br>
			Area Title (required)</br>
			<input type='text' id='areaName' name='areaName' value='" . $newArea . "' placeholder='Enter area name here...'>
			<div class='searchMsg' id='reqArea'>Please Choose an area of study</div>
			<div class='searchMsg' id='areaMatch'>This Area already exists...</div></br>
			<input type='submit' id='subArea' name='subArea' value='Submit'>&nbsp;&nbsp;&nbsp;
			<a href='SystemManage.php?ManArea'><button>Cancel</button></a>
		</form>";
		$areaDisplay = mysql_query("SELECT * FROM areaofstudy");
		$displayCount = mysql_num_rows($areaDisplay);
		if($displayCount > 0){
			// display Area of Study table
			echo '</br><div class="CSSTableGenerator" style="width:auto;"><table align="center"><tr>
                        <td>#</td>
			<td>Area of Study</td>
                        <td>Option</td>
			</tr>';
			$num = 0;
			while($arearow = mysql_fetch_array($areaDisplay)){
				echo"<tr>
					<td>" . ++$num . "</td>
					<td>" . $arearow['area'] . "</td>
					<td><a href='SystemManage.php?deleteArea=" . $arearow['id'] . "'><button>Delete</button></a></td>
				</tr>";
			}//end while
			echo "</table></div>";
		}else{
			echo "There are currently no areas of study within this system";
		}//end if..else
		?>
	</div>
    </div>
<?php include 'Admin_footer.php'; ?>