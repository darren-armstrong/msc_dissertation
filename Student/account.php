<?php include 'student_header.php'; ?>
    <div class="content">
    	<h1>View Account</h1>
	<?php
		//Go back to home page
		if(isset($_POST['back'])){
			header("location: account.php");
			exit();
		}//end if
		if(isset($_POST['cancel'])){
			header("location: account.php");
			exit();
		}//end if
		$curpword = NULL;
		$repword = NULL;
		$newpword = NULL;
		$currSecAns1 = NULL;
		$currSecAns2 = NULL;
		$newSecAns1 = NULL;
		$newSecAns2 = NULL;
		//////////////////////////////////////////////////////////////////////////
		//Edit Forename
		if(isset($_POST['fname'])){
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeForename{
						display:block;
					}
				</style><?php
			}//end if
		}//end if
		// Change Forename
		if(isset($_POST['changeFname'])){
			if(isset($_GET['edit'])){
				$fname = $_POST['newFname'];
				mysql_query("UPDATE student SET fname='$fname' WHERE username='" . $member . "'") or die(mysql_error());
				header("location: account.php");	
			}//end if
		}//end if
		//////////////////////////////////////////////////////////////////////////
		//Edit Surname
		if(isset($_POST['sname'])){
			//get input fields displayed to enable the user to edit
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeSurname{
						display:block;
					}
				</style><?php
			}//end if
		}//end if
		// Change Surname
		if(isset($_POST['changeSname'])){
			if(isset($_GET['edit'])){
				$sname = $_POST['newSname'];
				mysql_query("UPDATE student SET sname='$sname' WHERE username='" . $member . "'") or die(mysql_error());
				header("location: account.php");	
			}//end if
		}//end if
		//////////////////////////////////////////////////////////////////////////
		//Edit Date of Birth
		if(isset($_POST['dob'])){
			//get input fields displayed to enable the user to edit
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeDoB{
						display:block;
					}
				</style><?php
			}//end if
		}//end if
		// Change Surname
		if(isset($_POST['changeDob'])){
			if(isset($_GET['edit'])){
				$dobDB = $_POST['newDob'];
				mysql_query("UPDATE student SET dob='$dobDB' WHERE username='" . $member . "'") or die(mysql_error());
				header("location: account.php");	
			}//end if
		}//end if
		//////////////////////////////////////////////////////////////////////////
		//Edit Email Address
		if(isset($_POST['email'])){
			//get input fields displayed to enable the user to edit
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeEmailAdd{
						display:block;
					}
				</style><?php
			}//end if
		}//end if
		// Change email
		if(isset($_POST['changeEmail'])){
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeEmailAdd{
						display:block;
					}
				</style><?php
				//check email
				$email = $_POST['newEmail'];
				$emailQuery = mysql_query("SELECT email FROM student WHERE username <> '" . $member . "'");
				$emailCount = mysql_num_rows($emailQuery);
				if($emailCount >= 0){
					$emailMatch = 0;
					while($eCheck = mysql_fetch_array($emailQuery)){
						if($eCheck["email"] == $email){
							$emailMatch++;		
							//display error message email address already exist with another account
							?><style type="text/css">
								#requireAuth{
									display:block;
								}
							</style><?php
						}//end if
					}//end while
				}//end if
				if($emailMatch == 0){
					$emailCheck = mysql_query("SELECT email FROM student WHERE username = '" . $member . "'");
					$emailRows = mysql_num_rows($emailCheck);
					if($emailRows >= 0){
						while($check = mysql_fetch_array($emailCheck)){
							if($check["email"] == $email){
								//This is already your email Address
								?><style type="text/css">
									#sameEmail{
										display:block;
									}
								</style><?php
							}else if($email == NULL){
								//Error Email address field is Null
								?><style type="text/css">
									#requireEmail{
										display:block;
									}
								</style><?php
							}else{
								//Update Email Address
								mysql_query("UPDATE student SET email='$email' WHERE username='" . $member . "'") or die(mysql_error());
								header("location: account.php");	
							}//end if..else if..else
						}//end while
					}//end if
				}//end if
			}//end if
		}//end if				
		//////////////////////////////////////////////////////////////////////////
		//Edit username
		if(isset($_POST['uname'])){
			//get input fields displayed to enable the user to edit
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeUsername{
						display:block;
					}
				</style><?php
			}//end if
		}//end if
		// Change Username
		if(isset($_POST['changeUname'])){
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeUsername{
						display:block;
					}
				</style><?php
				//check Username
				$potUname = $_POST['newUname'];
				$unameQuery = mysql_query("SELECT username FROM student WHERE username <> '" . $member . "'");
				$unameCount = mysql_num_rows($unameQuery);
				if($unameCount >= 0){
					$userMatch = 0;
					while($uCheck = mysql_fetch_array($unameQuery)){
						if($uCheck["username"] == $potUname){
							$userMatch++;		
							//display error message email address already exist with another account
							?><style type="text/css">
								#UnameinUse{
									display:block;
								}
							</style><?php
						}//end if
					}//end while
				}//end if
				//check that new username does not match an admin username
				$userCheck = mysql_query("SELECT username FROM admin");
				$userCount = mysql_num_rows($userCheck);
				if($userCount > 0){
					while($usernameCheck = mysql_fetch_array($userCheck)){
						if($usernameCheck["username"] == $potUname){
							$userMatch++;		
							//display error message email address already exist with another account
							?><style type="text/css">
								#UnameinUse{
									display:block;
								}
							</style><?php
						}//end if
					}//end while
				}//end if
				if($userMatch == 0){
					$userCheck = mysql_query("SELECT username FROM student WHERE username = '" . $member . "'");
					$userRows = mysql_num_rows($userCheck);
					if($userRows == 1){
						while($usercheck = mysql_fetch_array($userCheck)){
							if($usercheck["username"] == $potUname){
								//This is already your Username
								?><style type="text/css">
									#sameUname{
										display:block;
									}
								</style><?php
							}else if($potUname == NULL){
								//Error Username field is Null
								?><style type="text/css">
									#requireUname{
										display:block;
									}
								</style><?php
							}else{
								//rename user's profile picture to match username
								$ext = pathinfo($image, PATHINFO_EXTENSION);
								$image2 = $potUname . '.' . $ext;
								if (file_exists("StudentPics/" . $image)) {
									// rename current profile picture
    									rename("StudentPics/" . $image, "StudentPics/" . $image2);
								}
								//Update username 
								mysql_query("SET FOREIGN_KEY_CHECKS=0");
								if($image != NULL){
									mysql_query("UPDATE student SET image = '" . $image2 . "' WHERE username='" . $member . "'") or die(mysql_error());
								}//end if
								mysql_query("UPDATE student SET username='$potUname' WHERE username='" . $member . "'") or die(mysql_error()); 
								mysql_query("UPDATE viewed SET username='$potUname' WHERE username='" . $member . "'") or die(mysql_error());
								mysql_query("UPDATE tutorial SET StudentCreator='$potUname' WHERE StudentCreator='" . $member . "'") or die(mysql_error());
								mysql_query("SET FOREIGN_KEY_CHECKS=1");
								$_SESSION["studentId"] = $potUname;
								header("location: account.php");	
							}//end if..else if..else
						}//end while
					}//end if
				}//end if
			}//end if
		}//end if
		//////////////////////////////////////////////////////////////////////////
		//Edit Profile Picture
		if(isset($_POST['pic'])){
			//get input fields displayed to enable the user to edit
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changePicture{
						display:block;
					}
				</style><?php
			}//end if
		}//end if
		// Change Picture
		if(isset($_POST['changePic'])){
			if(isset($_GET['edit'])){
				//get the uploaded file and rename it to the username
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changePicture{
						display:block;
					}
				</style><?php
				if($_FILES['upload']['name'] == NULL){
					?><style type="text/css">
						#requireImage{
							display:block;
						}
					</style><?php
				}else{
					if (file_exists("StudentPics/" . $image)) {
						// delete current profile picture
    						unlink($image);
						// add in new profile picture
						$temp = $_FILES['upload']['name'];
						$ext = pathinfo($temp, PATHINFO_EXTENSION);
						$newfilename = $member . '.' . $ext;
						move_uploaded_file($_FILES["upload"]["tmp_name"], "StudentPics/" . $newfilename);
						$image = $newfilename;
					}else{
						// add in new profile picture
						$temp = $_FILES['upload']['name'];
						$ext = pathinfo($temp, PATHINFO_EXTENSION);
						$newfilename = $member . '.' . $ext;
						move_uploaded_file($_FILES["upload"]["tmp_name"], "StudentPics/" . $newfilename);
					}
					//update database
					mysql_query("UPDATE student SET image = '$image' WHERE username = '$member'");
					header("location: account.php");
				}//end if..else
			}//end if
		}//end if	
		//////////////////////////////////////////////////////////////////////////
		//Change Password
		if(isset($_POST['pword'])){
			//get input fields displayed to enable the user to edit
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changePassword{
						display:block;
					}
				</style><?php
			}//end if
		}//end if
		// Change Picture
		if(isset($_POST['change'])){
			if(isset($_GET['edit'])){
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changePassword{
						display:block;
					}
				</style><?php
				$curpword = $_POST['curPword'];
				$repword = $_POST['changeRePword'];
				$newpword = $_POST['changePword'];
				if($newpword == NULL){
					?><style type="text/css">
						#requireNewpword{
							display:block;
						}
					</style><?php
				}//end if
				if($repword == NULL){
					?><style type="text/css">
						#requireRepword{
							display:block;
						}
					</style><?php
				}
				if($curpword == $password){
					//password Matched
					?><style type="text/css">
						#currPassword{
							display:block;
							color: lime;
						}
					</style><?php
					// Movie on to new and retype passwords
					if($newpword == $password){
						?><style type="text/css">
							#samePword{
								display:block;
							}
						</style><?php
						$newpword == NULL;
					}else if($newpword != NULL){
						//check for match
						if($newpword == $repword){
							//change password
							mysql_query("UPDATE student SET p_word = '" . $newpword . "' WHERE username = '" . $member . "'");
							$_SESSION["password"] = $newpword;
							header("location: account.php");
						}else if($repword != NULL){
							//Password doesn't match
							?><style type="text/css">
								#requireRpword{
									display:block;
								}
							</style><?php
						}//end if..else if
					}//end if else
				}else{
					//Please enter current password
					?><style type="text/css">
						#requirepword{
							display:block;
						}
					</style><?php
				}
			}//end if
		}//end if	
		//////////////////////////////////////////////////////////////////////////
		//Change Security Answers
		if(isset($_POST['security'])){
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeSecAns{
						display:block;
					}
				</style><?php
			}//end if	
		}//end if
		//Change Security Answers Options
		if(isset($_POST['changeOne'])){
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeSecAns{
						display:block;
					}
					#changeOne{
						display:none;
						width:auto;
					}
					#changeBoth{
						display:none;
						width:auto;
					}
					#changeTwo{
						display:none;
						width:auto;
					}
					#hideOne{
						display:block;
					}
					#hideQ2{
						display:none;
						width:auto;
					}
					.removeBr{
						display:none;
						width:auto;
					}
				</style><?php
			}//end if	
		}//end if
		if(isset($_POST['changeTwo'])){
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeSecAns{
						display:block;
					}
					#changeOne{
						display:none;
						width:auto;
					}
					#changeBoth{
						display:none;
						width:auto;
					}
					#changeTwo{
						display:none;
						width:auto;
					}
					#hideTwo{
						display:block;
					}
					#hideQ1{
						display:none;
						width:auto;
					}
					.removeBr{
						display:none;
						width:auto;
					}					
				</style><?php
			}//end if	
		}//end if
		if(isset($_POST['changeBoth'])){
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeSecAns{
						display:block;
					}
					#changeOne{
						display:none;
						width:auto;
					}
					#changeBoth{
						display:none;
						width:auto;
					}
					#changeTwo{
						display:none;
						width:auto;
					}
					.hide_changeButtons{
						display:none;
						width:auto;
					}
					#hideBoth{
						display:block;
					}
					#hideOne{
						display:block;
					}
					#hideTwo{
						display:block;
					}
					.removeBr{
						display:none;
						width:auto;
					}
				</style><?php
			}//end if	
		}//end if
		// Get real secuity answers
		$secCheck = mysql_query("SELECT securityOne, securityTwo FROM student WHERE username = '" . $member . "'");
		$secRows = mysql_num_rows($secCheck);
		if($secRows == 1){
			while($security = mysql_fetch_array($secCheck)){
				$realSecurityOne = strtoupper($security["securityOne"]);
				$realSecurityTwo = strtoupper($security["securityTwo"]);
			}//end while
		}//end if
		// Change Security Question One
		if(isset($_POST['changeSecOne'])){
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeSecAns{
						display:block;
					}
					#changeOne{
						display:none;
						width:auto;
					}
					#changeBoth{
						display:none;
						width:auto;
					}
					#changeTwo{
						display:none;
						width:auto;
					}
					#hideOne{
						display:block;
					}
					#hideQ2{
						display:none;
						width:auto;
					}
					.removeBr{
						display:none;
						width:auto;
					}
				</style><?php
				if(strtoupper($_POST['currentAnsOne']) == $realSecurityOne){
					$currSecAns1 = $_POST['currentAnsOne'];	
				}else{
					?><style type="text/css">
						#currentAns1{
							display:block;
						}
					</style><?php	
				}//end if...else
				if(strtoupper($_POST['newAnsOne']) == $realSecurityOne){
					//Same as current answer
					?><style type="text/css">
						#sameAns1{
							display:block;
						}
					</style><?php
				}else if((strtoupper($_POST['newAnsOne']) != $realSecurityOne && $_POST['newAnsOne'] != NULL) && strtoupper($currSecAns1) == $realSecurityOne){
					//change security Answer
					$currSecAns1 = $_POST['newAnsOne'];	
					mysql_query("UPDATE student SET securityOne = '" . $currSecAns1 . "' WHERE username = '" . $member . "'");
					header("location: account.php");
				}else if($_POST['newAnsOne'] == NULL){
					//No input
					?><style type="text/css">
						#requireAns1{
							display:block;
						}
					</style><?php
				}//end if//else if...else
			}//end if	
		}//end if
		// Change Security Question Two
		if(isset($_POST['changeSecTwo'])){
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeSecAns{
						display:block;
					}
					#changeOne{
						display:none;
						width:auto;
					}
					#changeBoth{
						display:none;
						width:auto;
					}
					#changeTwo{
						display:none;
						width:auto;
					}
					#hideTwo{
						display:block;
					}
					#hideQ1{
						display:none;
						width:auto;
					}
					.removeBr{
						display:none;
						width:auto;
					}
				</style><?php
				if(strtoupper($_POST['currentAnsTwo']) == $realSecurityTwo){
					$currSecAns2 = $_POST['currentAnsTwo'];	
				}else{
					?><style type="text/css">
						#currentAns2{
							display:block;
						}
					</style><?php	
				}//end if...else
				if(strtoupper($_POST['newAnsTwo']) == $realSecurityTwo){
					//Same as current answer
					?><style type="text/css">
						#sameAns2{
							display:block;
						}
					</style><?php
				}else if((strtoupper($_POST['newAnsTwo']) != $realSecurityTwo && $_POST['newAnsTwo'] != NULL) && strtoupper($currSecAns2) == $realSecurityTwo){
					//change security Answer
					$currSecAns2 = $_POST['newAnsTwo'];	
					mysql_query("UPDATE student SET securityTwo = '" . $currSecAns2 . "' WHERE username = '" . $member . "'");
					header("location: account.php");
				}else if($_POST['newAnsTwo'] == NULL){
					//No input
					?><style type="text/css">
						#requireAns2{
							display:block;
						}
					</style><?php
				}//end if...else if...else
			}//end if	
		}//end if
		// Change Both Security Questions
		if(isset($_POST['bothSecs'])){
			if(isset($_GET['edit'])){
				//get input fields displayed to enable the user to edit
				?><style type="text/css">
					#studentDisplay{
						display:none;
						width:auto;
					}
					#changeSecAns{
						display:block;
					}
					#changeOne{
						display:none;
						width:auto;
					}
					#changeBoth{
						display:none;
						width:auto;
					}
					#changeTwo{
						display:none;
						width:auto;
					}
					.hide_changeButtons{
						display:none;
						width:auto;
					}
					#hideBoth{
						display:block;
					}
					#hideOne{
						display:block;
					}
					#hideTwo{
						display:block;
					}
					.removeBr{
						display:none;
						width:auto;
					}
				</style><?php
				if(strtoupper($_POST['currentAnsOne']) == $realSecurityOne){
					$currSecAns1 = $_POST['currentAnsOne'];	
				}else{
					?><style type="text/css">
						#currentAns1{
							display:block;
						}
					</style><?php	
				}//end if...else
				if(strtoupper($_POST['newAnsOne']) == $realSecurityOne){
					//Same as current answer
					?><style type="text/css">
						#sameAns1{
							display:block;
						}
					</style><?php
				}else if((strtoupper($_POST['newAnsOne']) != $realSecurityOne && $_POST['newAnsOne'] != NULL) && strtoupper($currSecAns1) == $realSecurityOne){
					//change security Answer
					$currSecAns1 = $_POST['newAnsOne'];	
					mysql_query("UPDATE student SET securityOne = '" . $currSecAns1 . "' WHERE username = '" . $member . "'");
					//show that answer one has been changed
					?><style type="text/css">
						#newAnswer1{
							display:block;
							color:lime;
						}
						#hideQ1{
							display:none;
						}
						#hideOne{
							display:none;
						}
					</style><?php
					$currSecAns1 = NULL;
					$_SESSION["one"] = 1;
				}else if($_POST['newAnsOne'] == NULL){
					//No input
					?><style type="text/css">
						#requireAns1{
							display:block;
						}
					</style><?php
				}
				if(strtoupper($_POST['currentAnsTwo']) == $realSecurityTwo){
					$currSecAns2 = $_POST['currentAnsTwo'];	
				}else{
					?><style type="text/css">
						#currentAns2{
							display:block;
						}
					</style><?php	
				}//end if...else
				if(strtoupper($_POST['newAnsTwo']) == $realSecurityTwo){
					//Same as current answer
					?><style type="text/css">
						#sameAns2{
							display:block;
						}
					</style><?php
				}else if((strtoupper($_POST['newAnsTwo']) != $realSecurityTwo && $_POST['newAnsTwo'] != NULL) && strtoupper($currSecAns2) == $realSecurityTwo){
					//change security Answer
					$currSecAns2 = $_POST['newAnsTwo'];	
					mysql_query("UPDATE student SET securityTwo = '" . $currSecAns2 . "' WHERE username = '" . $member . "'");
					$_SESSION["two"] = 1;
					//show that answer two has been changed
					?><style type="text/css">
						#newAnswer2{
							display:block;
							color:lime;
						}
						#hideQ2{
							display:none;
						}
						#hideTwo{
							display:none;
						}
					</style><?php
					$currSecAns2 = NULL;
				}else if($_POST['newAnsTwo'] == NULL){
					//No input
					?><style type="text/css">
						#requireAns2{
							display:block;
						}
					</style><?php
				}//end if...else if...else
				if(isset($_SESSION["one"]) && isset($_SESSION["two"])){
					unset($_SESSION['one']);
					unset($_SESSION['two']);
					header("location: account.php");
				}else if(isset($_SESSION["one"])){
					//show that answer one has been changed
					?><style type="text/css">
						#newAnswer1{
							display:block;
							color:lime;
						}
						#hideQ1{
							display:none;
						}
						#hideOne{
							display:none;
						}
					</style><?php
				}else if(isset($_SESSION["two"])){
					//show that answer two has been changed
					?><style type="text/css">
						#newAnswer2{
							display:block;
							color:lime;
						}
						#hideQ2{
							display:none;
						}
						#hideTwo{
							display:none;
						}
					</style><?php
				}//end if...else if
			}//end if	
		}//end if
		//////////////////////////////////////////////////////////////////////////
		//Delete Account
		if(isset($_POST['delete'])){
			echo "Are you sure you want to delete your account?&nbsp;&nbsp;&nbsp;&nbsp;
				<form method='post' action='account.php?deleteAcc'>
					<input type='submit' class='button' name='deleteYes' id='deleteYes' value='Yes' title='Delete Your Account'>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type='submit' class='button' name='back' id='back' value='No' title='Back to Member information'>
				</form>
				* All Tutorials Created by you will also be Deleted *
				</br></br></br></br>";
		}//end if
		if(isset($_POST['deleteYes'])){
			mysql_query("SET FOREIGN_KEY_CHECKS=0");
			if($image != NULL){
				//DELETE IMAGE
				if (file_exists("StudentPics/" . $image)) {
					// delete current profile picture
    					unlink("StudentPics/" . $image);
				}
			}//end if
			mysql_query("DELETE FROM student WHERE username='" . $member . "'") or die(mysql_error()); 
			mysql_query("DELETE FROM viewed WHERE username='" . $member . "'") or die(mysql_error());
			mysql_query("DELETE FROM tutorial WHERE StudentCreator='" . $member . "'") or die(mysql_error());
			mysql_query("SET FOREIGN_KEY_CHECKS=1");
			unset($_SESSION["studentID"]);
			session_destroy();
			session_write_close();
			header('location:index.php');
			die;
		}//end if
		//////////////////////////////////////////////////////////////////////////
		echo "<div id='studentOptions'>
			<form method='post' action='account.php?do'>
				<input type='submit' class='button' name='back' id='back' value='Member Info' title='Back to Member information'>
				<input type='submit' class='button' name='delete' id='delete' value='Delete Account' title='Delete Your Account'>
			</form>
		</div>";
		//Query to get members details
		$query = mysql_query("SELECT dob, email, dateJoined, securityOne, securityTwo FROM student WHERE username = '" . $member . "'");
		$count = mysql_num_rows($query);
		if($count == 1){
			while($row = mysql_fetch_array($query)){
				$dob = date_format(date_create_from_format('Y-m-d', $row['dob']), 'd/m/Y');
				$dobDB = $row['dob'];
				$email = $row['email'];
				$secOne = $row['securityOne'];
				$secTwo = $row['securityTwo'];
				$dateJoined = date_create($row['dateJoined']);
			}//end while
				$joined = date_format($dateJoined, "l jS F Y");
		}//end if
		//Display the member's current details stored within the system.
		echo "<div id='studentDisplay'>			
			<h2>Current Member information</h2>
			<p>Member since: " . $joined . "</p>
			<form method='post' action='account.php?edit'>
				<h3>Personal Details</h3>
				<b>Forename:</b> " . $fname . "&nbsp;&nbsp;
				<input type='submit' class='button' name='fname' id='fname' value='Edit' title='Edit your Forename'></br>
				<b>Surname:</b> " . $sname . "&nbsp;&nbsp;
				<input type='submit' class='button' name='sname' id='sname' value='Edit' title='Edit your Surname'></br>
				<b>Date of Birth:</b> " . $dob . "&nbsp;&nbsp;
				<input type='submit' class='button' name='dob' id='dob' value='Edit' title='Edit your Date of Birth'></br>
				<b>email address:</b> " . $email . "&nbsp;&nbsp;
				<input type='submit' class='button' name='email' id='email' value='Edit' title='Edit your email address'>
				<h3>Account Details</h3>
				<b>Username:</b> " . $member . "&nbsp;&nbsp;
				<input type='submit' class='button' name='uname' id='uname' value='Edit' title='Edit Your username'></br>
				<b>Profile Picture:</b> <img src='StudentPics/" . $image . "' height='25px' title='Edit your profile Picture' />&nbsp;&nbsp;
				<input type='submit' class='button' name='pic' id='pic' value='Edit'></br></br>
				<input type='submit' class='button' name='pword' id='pword' value='Change Your Password' title='Change Your Password'></br></br>
				<input type='submit' class='button' name='security' id='security' value='Change Your Security Answers' title='Change Your Security Answers'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Edit Surname Code
		echo"<div id='changeSurname'><h2>Edit Your Surname</h2>
			<form method='post' action='account.php?edit'>
				Surname: <input type='text' name='newSname' id='newSname' value='" . $sname . "'></br></br>
				<input type='submit' class='button' name='changeSname' id='changeSname' value='Change' title='Change Surname'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Edit Forename Code
		echo"<div id='changeForename'><h2>Edit Your Forename</h2>
			<form method='post' action='account.php?edit'>
				Forename: <input type='text' name='newFname' id='newFname' value='" . $fname . "'></br></br>
				<input type='submit' class='button' name='changeFname' id='changeFname' value='Change' title='Change Forename'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Edit Date of Birth Code
		echo"<div id='changeDoB'><h2>Edit Your Date of Birth</h2>
			<form method='post' action='account.php?edit'>
				Date of Birth: <input type='date' name='newDob' id='newDob' value='" . $dobDB . "'></br></br>
				<input type='submit' class='button' name='changeDob' id='changeDob' value='Change' title='Change Date of Birth'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Edit Email Address Code
		echo"<div id='changeEmailAdd'><h2>Edit Your Email Address</h2>
			<form method='post' action='account.php?edit'>
				Email Address: <input type='text' name='newEmail' id='newEmail' value='" . $email . "'></br>
				<div class='searchMsg' id='requireEmail'>* Didn't enter an Email Address.. *</div>
				<div class='searchMsg' id='requireAuth'>* Email is already activated with another account... *</div>
				<div class='searchMsg' id='sameEmail'>* This is your current email.. *</div></br></br>
				<input type='submit' class='button' name='changeEmail' id='changeEmail' value='Change' title='Change Email Address'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Edit Username Code
		echo"<div id='changeUsername'><h2>Edit Your Username</h2>
			<form method='post' action='account.php?edit'>
				Username: <input type='text' name='newUname' id='newUname' value='" . $member . "'></br>
				<div class='searchMsg' id='requireUname'>* Didn't enter Username... *</div>
				<div class='searchMsg' id='UnameinUse'>* Username is already taken by another member... *</div>
				<div class='searchMsg' id='sameUname'>* This is your current Username... *</div></br></br>
				<input type='submit' class='button' name='changeUname' id='changeUname' value='Change' title='Change Username'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Edit Profile Picture Code
		echo"<div id='changePicture'><h2>Edit Your Profile Picture</h2>
			<form method='post' action='account.php?edit' enctype='multipart/form-data'>
				Current Picture: <img src='StudentPics/" . $image . "' height='25px' title='Edit your profile Picture' /></br>
				<input type='file' name='upload' id='upload'></br>
				<div class='searchMsg' id='requireImage'>* No image Chosen... *</div></br></br>
				<input type='submit' class='button' name='changePic' id='changePic' value='Change' title='Change Profile Picture'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Change Password Code
		echo"<div id='changePassword'><h2>Change your Password</h2>
			<form method='post' action='account.php?edit'>
				<p>Please Fill out the following</p>
				<div class='formspace' style='width:170px; float:left;'>Current Password: </div><input type='password' placeholder='Enter current password here...' name='curPword' id='curPword' value='". $curpword . "'></br>
				<div class='searchMsg' id='requirepword'>* Current Password didn't matched... *</div>
				<div class='searchMsg' id='currPassword'>* Password Matched... *</div></br>
				<div class='formspace' style='width:170px; float:left;'>New Password: </div><input type='password' name='changePword' placeholder='Enter New password here...' id='changePword' value='". $newpword . "'></br>
				<div class='searchMsg' id='samePword'>* This is already your Password... *</div>
				<div class='searchMsg' id='requireNewpword'>* Didn't enter New Password... *</div></br>
				<div class='formspace' style='width:170px; float:left;'>Retype New Password: </div><input type='password' name='changeRePword' id='changeRePword' placeholder='Re-enter New password here...' value='". $repword . "'></br>
				<div class='searchMsg' id='requireRepword'>* Please Re-enter Password... *</div>
				<div class='searchMsg' id='requireRpword'>* Passwords Don't match... *</div></br></br>
				<input type='submit' class='button' name='change' id='change' value='Change' title='Change Password'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Change Security Answers 
		echo"<div id='changeSecAns'><h2>Change your Security Answers</h2>
			<form method='post' action='account.php?edit'></br></br>
				<div id='hideQ1'>Q1) What is the name of your first pet?</div>
				<div class='hideInput' id='hideOne'>
					<input type='text' name='currentAnsOne' id='currentAnsOne' style='float:left;' placeholder='Enter current Answer here' value='" . $currSecAns1 . "'>
					<div class='searchMsg' id='currentAns1'>
						* Current Answer didn't matched... *
					</div>
					</br>
					<input type='text' name='newAnsOne' id='newAnsOne' placeholder='Enter New Answer here' style='float:left;' value='" . $newSecAns1 . "'>
					<div class='searchMsg' id='requireAns1'>
						* Please enter new answer... *
					</div>
					<div class='searchMsg' id='sameAns1'>
						* This is the same as your current answer... *
					</div>
					</br>
					<div class='hide_changeButtons'>
						<input type='submit' class='button' name='changeSecOne' id='changeSecOne' value='Change' title='Change Security Answer'>
					</div>
				</div>
				<div class='searchMsg' id='newAnswer1'>* Answer One has been changed... *</div>
				<input type='submit' class='button' name='changeOne' id='changeOne' value='Change Security Answer One' title='Change Security Answer One'></br>
				<div id='hideQ2'>Q2) Where were you born?</div>
				<div class='hideInput' id='hideTwo'>
					<input type='text' name='currentAnsTwo' id='currentAnsTwo' style='float:left;' placeholder='Enter current Answer here' value='" . $currSecAns2 . "'>
					<div class='searchMsg' id='currentAns2'>
						* Current Answer didn't matched... *
					</div>
					</br>
					<input type='text' name='newAnsTwo' id='newAnsTwo' style='float:left;' placeholder='Enter New Answer here' value='" . $newSecAns2 . "'>
					<div class='searchMsg' id='requireAns2'>
							* Please enter new answer... *
					</div>
					<div class='searchMsg' id='sameAns2'>
						* This is the same as your current answer... *
					</div>
					</br></br>
					<div class='hide_changeButtons'>
						<input type='submit' class='button' name='changeSecTwo' id='changeSecTwo' value='Change' title='Change Security Answer Two'>
					</div>
				</div>
				<div class='searchMsg' id='newAnswer2'>* Answer Two has been changed... *</div></br>
				<div class='hideInput' id='hideBoth'>
					<input type='submit' class='button' name='bothSecs' id='bothSecs' Value='Change' title='Change Security Answers'>
				</div>
				<input type='submit' class='button' name='changeTwo' id='changeTwo' value='Change Security Answer Two' title='Change Security Answer Two'></br></br>
				<input type='submit' class='button' name='changeBoth' id='changeBoth' value='Change Both Security Answers' title='Change Both Security Answers'>
				<div class='removeBr'></br></br></div>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Delete Account Code
		echo"<div id='deleteAccount'></div>";
	?>
    </div>
<?php include 'Student_footer.php'; ?>