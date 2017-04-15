<?php include 'studentLoginHeader.php'; ?>
    	<h1>Student Registration</h1>
	<div id="regContent">
	<?php
		$fname = NULL;
		$sname = NULL;
		$dob = NULL;
		$eAdd = NULL;
		$uname = NULL;
		$pword = NULL;
		$repword = NULL;
		$secOne = NULL;
		$secTwo = NULL;
		$stuPic = NULL;
		//cancel registration form
		if(isset($_POST['cancel'])){
			//Kill Any Session variable created, as they are not needed.
			unset($_SESSION["fname"]);
			unset($_SESSION["sname"]);
			unset($_SESSION["eAdd"]);
			unset($_SESSION["dob"]);
			unset($_SESSION["One"]);
			unset($_SESSION["Two"]);
			unset($_SESSION["pword"]);
			unset($_SESSION["uname"]);
			//exit the registration form
			header("location: index.php");
			exit();
		}//end if
		// Process the data entered from stage One
		if(isset($_POST['search1'])){ 
	  		if(isset($_GET['go'])){
				$fname=$_POST['forname'];
				$sname=$_POST['surname'];
				$dob=$_POST['dateOB'];
				$eAdd=$_POST['email'];
				//check email
				$emailQuery = mysql_query("SELECT email FROM student");
				$emailCount = mysql_num_rows($emailQuery);
				if($emailCount >= 0){
					while($eCheck = mysql_fetch_array($emailQuery)){
						if($eCheck["email"] == $eAdd){
							$echeck = $eAdd;
							$eAdd = NULL;
						}//end if
					}//end while
				}//end if
				if(($fname != NULL && $sname != NULL) && ($dob != NULL && $eAdd != NULL)){
					//Proceed to stage two
					?><style type="text/css">
						#stageOne{
						display:none;
						width:auto;
						}
						#stageTwo{
						display:block;
						}
					</style><?php
					$_SESSION["fname"] = $fname;
					$_SESSION["sname"] = $sname;
					$_SESSION["dob"] = $dob;
					$_SESSION["eAdd"] = $eAdd;
				}else{
					//Display Error Messages
					if($fname == NULL){
						?><style type="text/css">
							#requireFname{
							display:block;
							}
						</style><?php
					}//end if
					if($sname == NULL){
						?><style type="text/css">
							#requireSname{
							display:block;
							}
						</style><?php
					}//end if
					if($dob == NULL){
						?><style type="text/css">
							#requireDoB{
							display:block;
							}
						</style><?php
					}//end if
					if(isset($echeck)){
						?><style type="text/css">
							#requireAuth{
							display:block;
							}
						</style><?php
					}elseif($eAdd == NULL){
						?><style type="text/css">
							#requireEmail{
							display:block;
							}
						</style><?php
					}//end if..elseif
				}//end if..else
			}//end if
		}//end if
		// Process the data from stage Two
		if(isset($_POST['search2'])){ 
	  		if(isset($_GET['ready'])){
				//Proceed to stage two
				?><style type="text/css">
					#stageOne{
						display:none;
						width:auto;
					}
					#stageTwo{
						display:block;
					}
				</style><?php
				$uname = $_POST['username'];
				$pword = $_POST['password'];
				$repword = $_POST['repassword'];
				$secOne = $_POST['securityOne'];
				$secTwo = $_POST['securityTwo'];
				//check if username is already taken
				//To avoid future problems it will be checked against both the administration and student usernames.
				//Reason being is when display tutorials there could be a mix up if there is identical usernames in the different tables.
				$userCheck = mysql_query("SELECT username FROM admin");
				$userStud = mysql_query("SELECT username FROM student");
				$AdminCount = mysql_num_rows($userCheck);
				$studCount = mysql_num_rows($userStud);
				//student username check
				$ucheck = NULL;
				if($studCount >= 0){
					while($searchStu = mysql_fetch_array($userStud)){
						if($searchStu["username"] == $uname){
							$ucheck = $uname;
							$uname = NULL;
							?><style type="text/css">
								#UnameinUse{
								display:block;
								}
							</style><?php
						}//end if
					}//end while
				}//end if
				// admin username check
				if($AdminCount >= 0){
					while($search = mysql_fetch_array($userCheck)){
						if($search["username"] == $uname){
							$ucheck = $uname;
							$uname = NULL;
							?><style type="text/css">
								#UnameinUse{
								display:block;
								}
							</style><?php
						}else if($uname != NULL){
							?><style type="text/css">
								#Available{
								display:block;
								color:lime;
								}
							</style><?php
						}
					}//end while
				}//end if
				// check that password matches
				if($pword != NULL && $repword != NULL){
					if($pword != $repword){
						$repword = NULL;
						?><style type="text/css">
							#requireRpword{
							display:block;
							}
						</style><?php
					}else {
						?><style type="text/css">
							#matchpword{
							display:block;
							color:lime;
							}
						</style><?php
						//insert the data into student database and proceed to final stage - Uploading a profile pic
						if($ucheck == NULL && $secOne != NULL && $secTwo != NULL){
							//Confirm Account Creation and Give option to upload image
							?><style type="text/css">
								#stageThree{
								display:block;
								}
								#stageTwo{
								display:none;
								width:auto;
								}
							</style><?php
							$_SESSION["uname"] = $uname;
							$_SESSION["pword"] = $pword;
							$_SESSION["One"] = $secOne;
							$_SESSION["Two"] = $secTwo;
						}//end if
					}//end if..else
				}else{
					if($pword == NULL){
						?><style type="text/css">
							#requirepword{
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
					}//end if
				}//end if...else
				//Check if username field is empty
				if($ucheck == NULL && $uname == NULL){
					?><style type="text/css">
						#requireUname{
						display:block;
						}
					</style><?php					
				}//end if
				//check that the security questions are filled out.
				if($secOne == NULL) {
					?><style type="text/css">
						#requiresecOne{
						display:block;
						}
					</style><?php
				}//end if
				if($secTwo == NULL) {
					?><style type="text/css">
						#requiresecTwo{
						display:block;
						}
					</style><?php
				}//end if
			}//end if
		}//end if
		//Stage Three
		// Process the data from stage Two
		if(isset($_POST['submit3'])){ 
	  		if(isset($_GET['done'])){
				//Proceed to stage three
				?><style type="text/css">
					#stageOne{
						display:none;
						width:auto;
					}
					#stageTwo{
						display:none;
						width:auto;
					}
					#stageThree{
						display:block;
					}
				</style><?php
				//get the uploaded file and rename it to the username
				if($_FILES['upload']['name'] == NULL){
					$newfilename = NULL;
				}else{
					$temp = $_FILES['upload']['name'];
					$ext = pathinfo($temp, PATHINFO_EXTENSION);
					$newfilename = $_SESSION["uname"] . '.' . $ext;
					move_uploaded_file($_FILES["upload"]["tmp_name"], "StudentPics/" . $newfilename);
				}//end if..else
				//Add Student details to the system
				$insertStudent = mysql_query("INSERT INTO student (fname, sname, email, username, p_word, dob, securityOne, securityTwo, image)
    				VALUES ('" . $_SESSION['fname'] . "', '" . $_SESSION['sname'] . "', '" . $_SESSION['eAdd'] . "', '" . $_SESSION['uname'] . "', '" . $_SESSION['pword'] . "', '" . $_SESSION['dob'] . "', '" . $_SESSION['One'] . "', '" . $_SESSION['Two'] . "', '" . $newfilename . "')") or die(mysql_error());
				//log student in to the system
				$loginmember = $_SESSION["uname"];
				$_SESSION["studentId"] = $loginmember;
				$loginPword = $_SESSION["pword"];
				$_SESSION["password"] = $loginPword;
				//Kill Session variable created, as they are not needed.
				unset($_SESSION["fname"]);
				unset($_SESSION["sname"]);
				unset($_SESSION["eAdd"]);
				unset($_SESSION["dob"]);
				unset($_SESSION["One"]);
				unset($_SESSION["Two"]);
				unset($_SESSION["pword"]);
				unset($_SESSION["uname"]);
				//Proceed to stage three
				?><style type="text/css">
					#cancelReg{
						display:none;
						width:auto;
					}
					#stageThree{
						display:none;
						width:auto;
					}
					#stageFour{
						display:block;
					}
				</style><?php
			}// end if
		}//end if
		// Stage One
		echo "<div id='stageOne'><h2>Stage One - Personal Details</h2><form method='post' action='student_reg.php?go'>
			<div class='regBox'>Forename:</div>
			<div class='regBox'>
				<input type='text' id='forname' name='forname' placeholder='Enter forename here...' value='". $fname . "'>
				<div class='searchMsg' id='requireFname'>* Didn't enter Forename... *</div>
			</div><br>
			<div class='regBox'>Surname:</div> 
			<div class='regBox'>
				<input type='text' id='surname' name='surname' placeholder='Enter surname here...' value='". $sname . "'>
				<div class='searchMsg' id='requireSname'>* Didn't enter Surname.. *</div>
			</div><br>
			<div class='regBox'>DoB:</div> 
			<div class='regBox'>
				<input type='date' id='dateOB' name='dateOB' value='". $dob . "'>
				<div class='searchMsg' id='requireDoB'>* Didn't enter a DoB... *</div>
			</div><br>
			<div class='regBox'>Email Address:</div> 
			<div class='regBox'>
				<input type='text' id='email' placeholder='Enter email here...' name='email' value='". $eAdd . "'>
				<div class='searchMsg' id='requireEmail'>* Didn't enter an Email Address.. *</div>
				<div class='searchMsg' id='requireAuth'>* Email is already activated with an account... *
					<br>If you are already a member sign in by clicking the link, 
					<a href='student_login.php'>Sign in</a>
				</div>
			</div><br>
			<div class='regBox'>
				<input type='submit' class='button' name='search1' value='Proceed >'>
			</div>
		</form></div>";
		//Stage Two
		echo "<div id='stageTwo'>
			<h2>Stage Two - Account Details</h2>
			<form method='post' action='student_reg.php?ready'>
				<div class='regBox'>Username:</div>
				<div class='regBox'>
					<input type='text' id='username' name='username' placeholder='Enter Username here...' value='". $uname . "'>
					<div class='searchMsg' id='requireUname'>* Didn't enter Username... *</div>
					<div class='searchMsg' id='UnameinUse'>* Username is already taken... *</div>
					<div class='searchMsg' id='Available'>* Username is available... *</div>
				</div><br>
				<div class='regBox'>Password:</div> 
				<div class='regBox'>
					<input type='password' id='password' name='password' placeholder='Enter password here...' value='". $pword . "'>
					<div class='searchMsg' id='requirepword'>* Didn't enter Password... *</div>
				</div><br>
				<div class='regBox'>Re-enter Password:</div> 
				<div class='regBox'>
					<input type='password' id='repassword' name='repassword' placeholder='Re-enter password here...' value='". $repword . "'>
					<div class='searchMsg' id='matchpword'>* Passwords Match... *</div>
					<div class='searchMsg' id='requireRepword'>* Please Re-enter Password... *</div>
					<div class='searchMsg' id='requireRpword'>* Passwords Don't match... *</div>
				</div><br>
				<div class='regBox'>Security Questions:<br><p style='font-size:11px; margin:0px; padding:0px;'>Q1:What is/was the name of your first pet?</p></div> 
				<div class='regBox'>
					<input type='text' id='securityOne' name='securityOne' placeholder='Enter Security Answer...' value='". $secOne . "'>
					<div class='searchMsg' id='requiresecOne'>* Didn't Answer Security Q1... *</div>
				</div><br>
				<div class='regBox'><p style='font-size:11px; margin:0px; padding:0px;'>Q2:Where were you born?</p></div> 
				<div class='regBox'>
					<input type='text' id='securityTwo' name='securityTwo' placeholder='Enter Security Answer...' value='". $secTwo . "'>
					<div class='searchMsg' id='requiresecTwo'>* Didn't Answer Security Q2... *</div>
				</div><br>
				<div class='regBox'>
					<input type='submit' class='button' name='search2' value='Proceed >'>
				</div>
			</form>
		</div>";
		//Stage Three
		echo "<div id='stageThree'>
			<h2>Profile Picture</h2>
			<p>Final Step is adding a Profile picture to the system, you can do this now or do it later through view account.  To do it later click submit button whitout choosing an image, otherwise upload an image by chossing an image then click the submit button.</p>
			<form action='student_reg.php?done' method='post' enctype='multipart/form-data'>
    				Select image to upload:
    				<input type='file' name='upload' id='upload'>
    				<input type='submit' class='button' value='Submit' name='submit3'>
			</form>
		</div>";
	?>
		<div id="stageFour">
			<p>Congratulations, you have successfull created an account with Olé Tutor, the Online Learning Environment.<br>Click on the button below to enter the website</p>
			<a href='index.php' title='Enter the site'><button class='button'>Enter the Website</button></a>
		</div>
		<div id="cancelReg">
			<form method="post" action="student_reg.php?cancel">
				</br>
    				<input type="submit" class="button" value="Cancel Registration" name="cancel">
			<form>
		</div>
	</div>
<?php include 'studentLoginFooter.php'; ?>