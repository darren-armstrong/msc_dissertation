<?php include 'Admin_header.php'; ?>
    <div class="content">
    	<h1>View Account</h1>
	<?php
		//Go back to home page
		if(isset($_POST['back'])){
			header("location: man_acc.php");
			exit();
		}//end if
		if(isset($_POST['cancel'])){
			header("location: man_acc.php");
			exit();
		}//end if
		$curpword = NULL;
		$repword = NULL;
		$newpword = NULL;
		//////////////////////////////////////////////////////////////////////////
		//Edit name
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
				$name = $_POST['newFname'];
				mysql_query("UPDATE admin SET name='$name' WHERE username='" . $admin . "'") or die(mysql_error());
				header("location: man_acc.php");	
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
		// Change Date of Birth
		if(isset($_POST['changeDob'])){
			if(isset($_GET['edit'])){
				$dobDB = $_POST['newDob'];
				mysql_query("UPDATE admin SET dob='$dobDB' WHERE username='" . $admin . "'") or die(mysql_error());
				header("location: man_acc.php");	
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
				$emailQuery = mysql_query("SELECT email FROM admin WHERE username <> '" . $admin . "'");
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
								mysql_query("UPDATE admin SET email='$email' WHERE username='" . $admin . "'") or die(mysql_error());
								header("location: man_acc.php");	
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
					if (file_exists("Admin_pics/" . $image)) {
						// delete current profile picture
    						unlink($image);
						// add in new profile picture
						$temp = $_FILES['upload']['name'];
						$ext = pathinfo($temp, PATHINFO_EXTENSION);
						$newfilename = $admin . '.' . $ext;
						move_uploaded_file($_FILES["upload"]["tmp_name"], "Admin_pics/" . $newfilename);
						$image = $newfilename;
					}else{
						// add in new profile picture
						$temp = $_FILES['upload']['name'];
						$ext = pathinfo($temp, PATHINFO_EXTENSION);
						$newfilename = $admin . '.' . $ext;
						move_uploaded_file($_FILES["upload"]["tmp_name"], "Admin_pics/" . $newfilename);
					}
					//update database
					mysql_query("UPDATE admin SET image = '$image' WHERE username = '$admin'");
					header("location: man_acc.php");
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
							mysql_query("UPDATE admin SET p_word = '" . $newpword . "' WHERE username = '" . $admin . "'");
							$_SESSION["password"] = $newpword;
							header("location: man_acc.php");
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
		//Delete Account
		if(isset($_POST['delete'])){
			echo "Are you sure you want to delete your account?&nbsp;&nbsp;&nbsp;&nbsp;
				<form method='post' action='man_acc.php?deleteAcc'>
					<input type='submit' class='button' name='deleteYes' id='deleteYes' value='Yes' title='Delete Your Account'>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type='submit' class='button' name='back' id='back' value='No' title='Back to manage your account'>
				</form>
				* All Tutorials Created by you will also be Deleted *
				</br></br></br></br>";
		}//end if
		if(isset($_POST['deleteYes'])){
			mysql_query("SET FOREIGN_KEY_CHECKS=0");
			if($image != NULL){
				//DELETE IMAGE
				if (file_exists("Admin_pics/" . $image)) {
					// delete current profile picture
    					unlink("Admin_pics/" . $image);
				}
			}//end if
			mysql_query("DELETE FROM admin WHERE username='" . $admin . "'") or die(mysql_error()); 
			mysql_query("DELETE FROM viewed WHERE username='" . $admin . "'") or die(mysql_error());
			mysql_query("DELETE FROM tutorial WHERE adminCreator='" . $admin . "'") or die(mysql_error());
			mysql_query("SET FOREIGN_KEY_CHECKS=1");
			unset($_SESSION["adminID"]);
			session_destroy();
			session_write_close();
			header('location:index.php');
			die;
		}//end if
		//////////////////////////////////////////////////////////////////////////
		echo "<div id='studentOptions'>
			<form method='post' action='man_acc.php?do'>
				<input type='submit' class='button' name='back' id='back' value='Member Info' title='Back to Member information'>
				<input type='submit' class='button' name='delete' id='delete' value='Delete Account' title='Delete Your Account'>
			</form>
		</div>";
		//Query to get members details
		$query = mysql_query("SELECT dob, email FROM admin WHERE username = '" . $admin . "'");
		$count = mysql_num_rows($query);
		if($count == 1){
			while($row = mysql_fetch_array($query)){
				$dob = date_format(date_create_from_format('Y-m-d', $row['dob']), 'd/m/Y');
				$dobDB = $row['dob'];
				$email = $row['email'];
			}//end while
		}//end if
		//Display the member's current details stored within the system.
		echo "<div id='studentDisplay'>			
			<h2>Current Member information</h2>
			<form method='post' action='man_acc.php?edit'>
				<h3>Personal Details</h3>
				<b>Forename:</b> " . $name . "&nbsp;&nbsp;
				<input type='submit' class='button' name='fname' id='fname' value='Edit' title='Edit your Forename'></br>
				<b>Date of Birth:</b> " . $dob . "&nbsp;&nbsp;
				<input type='submit' class='button' name='dob' id='dob' value='Edit' title='Edit your Date of Birth'></br>
				<b>email address:</b> " . $email . "&nbsp;&nbsp;
				<input type='submit' class='button' name='email' id='email' value='Edit' title='Edit your email address'>
				<h3>Account Details</h3>
				<b>Username:</b> " . $admin . "&nbsp;&nbsp;</br>
				<b>Profile Picture:</b> <img src='Admin_pics/" . $image . "' height='25px' title='Edit your profile Picture' />&nbsp;&nbsp;
				<input type='submit' class='button' name='pic' id='pic' value='Edit'></br></br>
				<input type='submit' class='button' name='pword' id='pword' value='Change Your Password' title='Change Your Password'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Edit Forename Code
		echo"<div id='changeForename'><h2>Edit Your name</h2>
			<form method='post' action='man_acc.php?edit'>
				Name: <input type='text' name='newFname' id='newFname' value='" . $name . "'></br></br>
				<input type='submit' class='button' name='changeFname' id='changeFname' value='Change' title='Change Forename'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Edit Date of Birth Code
		echo"<div id='changeDoB'><h2>Edit Your Date of Birth</h2>
			<form method='post' action='man_acc.php?edit'>
				Date of Birth: <input type='date' name='newDob' id='newDob' value='" . $dobDB . "'></br></br>
				<input type='submit' class='button' name='changeDob' id='changeDob' value='Change' title='Change Date of Birth'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Edit Email Address Code
		echo"<div id='changeEmailAdd'><h2>Edit Your Email Address</h2>
			<form method='post' action='man_acc.php?edit'>
				Email Address: <input type='text' name='newEmail' id='newEmail' value='" . $email . "'></br>
				<div class='searchMsg' id='requireEmail'>* Didn't enter an Email Address.. *</div>
				<div class='searchMsg' id='requireAuth'>* Email is already activated with another account... *</div>
				<div class='searchMsg' id='sameEmail'>* This is your current email.. *</div></br></br>
				<input type='submit' class='button' name='changeEmail' id='changeEmail' value='Change' title='Change Email Address'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Edit Profile Picture Code
		echo"<div id='changePicture'><h2>Edit Your Profile Picture</h2>
			<form method='post' action='man_acc.php?edit' enctype='multipart/form-data'>
				Current Picture: <img src='Admin_pics/" . $image . "' height='25px' title='Edit your profile Picture' /></br>
				<input type='file' name='upload' id='upload'></br>
				<div class='searchMsg' id='requireImage'>* No image Chosen... *</div></br></br>
				<input type='submit' class='button' name='changePic' id='changePic' value='Change' title='Change Profile Picture'></br></br>
				<input type='submit' class='button' name='cancel' id='cancel' value='Cancel' title='Cancel'>
			</form>
		</div>";
		/////////////////////////////////////////////////////////
		//Change Password Code
		echo"<div id='changePassword'><h2>Change your Password</h2>
			<form method='post' action='man_acc.php?edit'>
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
		//Delete Account Code
		echo"<div id='deleteAccount'></div>";
	?>
    </div>
<?php include 'Admin_footer.php'; ?>