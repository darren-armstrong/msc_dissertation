<?php include 'studentLoginHeader.php'; ?>
    	<h1>Forgotten username</h1>
	<?php
		//Set variables to NULL
		$email = NULL;
		$username = NULL;
		$dob = NULL;
		$secOne = NULL;
		$secTwo = NULL;
		//go back to login
		if(isset($_POST['cancel'])){
			//exit the forgotten username form
			header("location: index.php");
			exit();
		}//end if
		//check entered details
		if(isset($_POST['submit'])){
			if(isset($_GET['get'])){
				$email = $_POST['email'];
				$dob = $_POST['dateOB'];
				$secOne = $_POST['one'];
				$secTwo = $_POST['two'];
				//make security answers uppercase
				$checkOne = strtoupper($_POST['one']);
				$checkTwo = strtoupper($_POST['two']);
					//Check to see if given email is registered with a student
					$query = mysql_query("SELECT username, email, dob, securityOne, securityTwo FROM student WHERE email='" . $email . "'");
					$count = mysql_num_rows($query);
					if($count == 1){
						while($row = mysql_fetch_array($query)){
							$userDob = $row['dob'];
							$name = $row['username'];
							//make members answers uppercase
							$userOne = strtoupper($row['securityOne']);
							$userTwo = strtoupper($row['securityTwo']);					
						}//end while
						?><style type="text/css">
							#emailMatch{
							display:block;
							color:lime;
							}
						</style><?php
						if($dob == $userDob && $checkOne == $userOne && $checkTwo == $userTwo){
							echo "Your form details matched, Your username is below:";
							$username = $name;
							//Proceed to get username
							?><style type="text/css">
								#forgottenUser{
								display:none;
								width:auto;
								}
								#cancelReg{
								display:none;
								width:auto;
								}
								#showUser{
								display:block;
								}
							</style><?php
						}else{
							//Check Date of Birth
							if($dob == NULL){
								?><style type="text/css">
									#requireDoB{
									display:block;
									}
								</style><?php	
							}else if($dob != $userDob){
								?><style type="text/css">
									#DoBmismatch{
									display:block;
									}
								</style><?php	
								$dob = NULL;							
							}else{
								?><style type="text/css">
									#DoBmatch{
									display:block;
									color:lime
									}
								</style><?php
							}//end if..elseif..else
							//Check Answer for Security One
							if($checkOne == NULL){
								?><style type="text/css">
									#requireOne{
									display:block;
									}
								</style><?php	
							}else if($checkOne != $userOne){
								?><style type="text/css">
									#OneMismatch{
									display:block;
									}
								</style><?php	
								$secOne = NULL;							
							}else{
								?><style type="text/css">
									#Onematch{
									display:block;
									color:lime
									}
								</style><?php
							}//end if..elseif..else
							//Check Answer for Security Two
							if($checkTwo == NULL){
								?><style type="text/css">
									#requireTwo{
									display:block;
									}
								</style><?php	
							}else if($checkTwo != $userTwo){
								?><style type="text/css">
									#TwoMismatch{
									display:block;
									}
								</style><?php	
								$secTwo = NULL;							
							}else{
								?><style type="text/css">
									#Twomatch{
									display:block;
									color:lime
									}
								</style><?php
							}//end if..elseif..else
						}//end if..else
					}else{
						//write error info, email did not match with any accounts in the system.
						if($email != NULL){
							?><style type="text/css">
								#emailMismatch{
								display:block;
								}
							</style><?php
						}else{
							?><style type="text/css">
								#requireemail{
								display:block;
								}
							</style><?php
						}//end if..else
						$email == NULL;
					}//end if else
			}//end if
		}//end if
	echo '<div id="forgottenUser">
		<form method="post" action="fgt_username.php?get">
			<div class="regBox">
				What is your email address?<br>
				<input type="text" name="email" id="email" placeholder="Enter email here.." value="' . $email . '">
				<div class="searchMsg" id="requireemail">* Didn&#39;t enter an email... *</div>
				<div class="searchMsg" id="emailMismatch">* email Does not exist within the system... *</div>
				<div class="searchMsg" id="emailMatch">* email has matched with an account... *</div>
			</div>
			<div class="regBox">What is your date of birth?
				<input type="date" id="dateOB" name="dateOB" value="' . $dob . '">
				<div class="searchMsg" id="requireDoB">* Didn&#39;t enter a Date of Birth... *</div>
				<div class="searchMsg" id="DoBmismatch">* Date of Birth doesn&#39;t match... *</div>
				<div class="searchMsg" id="DoBmatch">* Date of Birth is correct... *</div>
			</div>
			<u>Security Questions</u> (Not case sensitive)<br>
			<div class="regBox">
				What is the name of your first pet?
				<input type="text" name="one" id="one" placeholder="Enter Answer here.." value="' . $secOne . '">
				<div class="searchMsg" id="requireOne">* Didn&#39;t answer question... *</div>
				<div class="searchMsg" id="OneMismatch">* Answer doesn&#39;t match... *</div>
				<div class="searchMsg" id="Onematch">* Answer is correct... *</div>
			</div>
			<div class="regBox">
				Where were you born?
				<input type="text" name="two" id="two" placeholder="Enter Answer here.." value="' . $secTwo . '">
				<div class="searchMsg" id="requireTwo">* Didn&#39;t answer question... *</div>
				<div class="searchMsg" id="TwoMismatch">* Answer doesn&#39;t match... *</div>
				<div class="searchMsg" id="Twomatch">* Answer is correct... *</div>
			</div></br>
			<div class="regBox">
				<input type="submit" class="button" name="submit" value="Get Username">
			</div>
		</form>
	</div>
	<div id="showUser">
		<p>Username: ' . $username . '</p>
		<p>Did you forget your password?</p>
		<a href="fgt_pwd.php"><button  class="button">Get Password</button></a>
		<a href="student_login.php"><button  class="button">Return To Login</button></a>
	</div>
	<div id="cancelReg">
		<form method="post" action="student_reg.php?cancel">
			</br>
    			<input type="submit" class="button" value="Return to Login" name="cancel">
		<form>
	</div>';
	?>
<?php include 'studentLoginFooter.php'; ?>