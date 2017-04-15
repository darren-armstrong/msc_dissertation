<?php include 'studentLoginHeader.php'; ?>
    	<h1>Forgotten Password</h1>
	<?php
		//Set variables to NULL
		$email = NULL;
		$username = NULL;
		$password = NULL;
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
				$username = $_POST['username'];
				$secOne = $_POST['one'];
				$secTwo = $_POST['two'];
				//make security answers uppercase
				$checkOne = strtoupper($_POST['one']);
				$checkTwo = strtoupper($_POST['two']);
				//Check to see if given email is registered with a student
				$query = mysql_query("SELECT username, email, p_word, securityOne, securityTwo FROM student WHERE username='" . $username . "'");
				$count = mysql_num_rows($query);
				if($count == 1){
					while($row = mysql_fetch_array($query)){
						$userEmail = $row['email'];
						$p_word = $row['p_word'];
						//make members answers uppercase
						$userOne = strtoupper($row['securityOne']);
						$userTwo = strtoupper($row['securityTwo']);					
					}//end while
					?><style type="text/css">
						#userMatch{
						display:block;
						color:lime;
						}
					</style><?php
					if($email == $userEmail && $checkOne == $userOne && $checkTwo == $userTwo){
						echo "Your form details matched, Your Password is below:";
						$password = $p_word;
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
						//Check email
						if($email == NULL){
							?><style type="text/css">
								#requireemail{
								display:block;
								}
							</style><?php
						}elseif($email != $userEmail){
							?><style type="text/css">
								#emailMismatch{
								display:block;
								}
							</style><?php
						}else{
							?><style type="text/css">
								#emailMatch{
								display:block;
								color:lime;
								}
							</style><?php
						}//end if..else
						$email == NULL;
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
					//write error info, Uername did not match with any accounts in the system.
					if($username != NULL){
						?><style type="text/css">
							#userMismatch{
							display:block;
							}
						</style><?php
					}else{
						?><style type="text/css">
							#requireUser{
							display:block;
							}
						</style><?php
					}//end if..else
					$username == NULL;
				}//end if else
			}//end if
		}//end if
	echo '<div id="forgottenUser">
		<form method="post" action="fgt_pwd.php?get">
			<div class="regBox">What is your username?
				<input type="text" id="username" name="username" placeholder="Enter username here.." value="' . $username . '">
				<div class="searchMsg" id="requireUser">* Didn&#39;t enter a Username... *</div>
				<div class="searchMsg" id="userMismatch">* Username doesn&#39;t match... *</div>
				<div class="searchMsg" id="userMatch">* Username is correct... *</div>
			</div>
			<div class="regBox">
				What is your email address?<br>
				<input type="text" name="email" id="email" placeholder="Enter email here.." value="' . $email . '">
				<div class="searchMsg" id="requireemail">* Didn&#39;t enter an email... *</div>
				<div class="searchMsg" id="emailMismatch">* email Does not match this account... *</div>
				<div class="searchMsg" id="emailMatch">* email has matched this account... *</div>
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
				<input type="submit" class="button" name="submit" value="Get Password">
			</div>
		</form>
	</div>
	<div id="showUser">
		<p>Password: ' . $password . '</p>
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