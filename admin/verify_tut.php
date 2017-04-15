<?php include 'Admin_header.php'; ?>
    <div class="content">
    	<h1>Verify Tutorials</h1>
	<p>Here you can verify tutorials made by members of this site.  You can only verify tutorials from your area of expertise.</p>
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
				margin-left:50%;
			}
			</style><?php
			$viewIframe = $_SESSION["viewIframe"];
			unset($_SESSION["viewIframe"]);
		}else{
			//Set the session to 0
			$_SESSION["viewIframe"] = NULL;
		}//if..else
	// Delete Tutorial Check
		if(isset($_GET['tutId'])){
			echo "<div class='deleteMsg' style='align:center;width:90%;margin-left:20px;'>Are you sure you want to delete this tutorial? <a href='verify_tut.php?deleteId=" . $_GET['tutId'] . "'><button>YES</button></a> <a href='verify_tut.php'><button>NO</button></a></div>";
		}//end if
		if(isset($_GET['deleteId'])){			
			$deleteTut = mysql_query("DELETE FROM Tutorial WHERE Tutorial_id = '" . $_GET['deleteId'] . "'") or die(mysql_error());
			$_GET['deleteId'] = NULL;
		}//end if
	// Verify Tutorial Check
		if(isset($_GET['verifyId'])){
			echo "<div class='deleteMsg' style='align:center;width:90%;margin-left:20px;'>Are you sure you want to verify this tutorial? <a href='verify_tut.php?verifiedId=" . $_GET['verifyId'] . "'><button>YES</button></a> <a href='verify_tut.php'><button>NO</button></a>
			</br>* NOTE: if this is verified it will be viewable by all members. *</div>";
		}//end if
		if(isset($_GET['verifiedId'])){			
			mysql_query("UPDATE tutorial SET VerifyStatus=1 WHERE Tutorial_id = '" . $_GET['verifiedId'] . "'") or die(mysql_error());
			$_GET['verifiedId'] = NULL;
		}//end if
	//Display created tutorials by that need to be verified
		$selectTuts = mysql_query("SELECT * FROM tutorial AS A
		INNER JOIN subject AS B ON B.id=A.subject
		WHERE A.verifyStatus=0 AND B.Area_of_study=" . $areaStudy . "  
		ORDER BY Date_created ASC");
		$selectCount = mysql_num_rows($selectTuts);
		if($selectCount > 0){
			$num = 1;
			echo "<div id='viewTutorials'><h2>Tutorials to be Verified</h2>";
			?>
			<style type="text/css">
			.CSSTableGenerator table{
				width:90%;
			}
			</style>
			<?php
			echo '<div class="CSSTableGenerator"><table align="center"><tr>
                        <td>#</td>
                        <td>Title</td>
                        <td>Verified</td>
			<td>Subject</td>
			<td>Created By</td>
                        <td>Date Created</td>
                        <td>Manage</td></tr>';
			while($selected = mysql_fetch_array($selectTuts)){
				$idList = $selected["Tutorial_id"];
				$titleList = $selected["Title"];
				$verifiedList = $selected["VerifyStatus"];
				$dateList = $selected["Date_created"];
				$username = $selected["StudentCreator"];
				$tutSubject = $selected["name"];
				if($username == NULL){
					$username = $selected["AdminCreator"];
				}//end if
				if($verifiedList == '1'){
					$verifiedList = "Yes";
				}else{
					$verifiedList = "No";
				}//end if...else
				echo "<tr><td >" . $num ."</td>
                        	<td>" . $titleList ."</td>
                        	<td>" . $verifiedList ."</td>
                        	<td>" . $tutSubject ."</td>
                        	<td>" . $username ."</td>
                        	<td>" . $dateList ."</td>
                        	<td><a href='verify_tut.php?viewId=" . $idList . "'><button>View</button></a> <a href='verify_tut.php?verifyId=" . $idList . "'><button>Verify</button></a> <a href='verify_tut.php?tutId=" . $idList . "'><button>Delete</button></a></td></tr>";
				$num++;
			}//end while
			echo "</table></div></div>";
		}else{
			echo "There are no Tutorials for you to verify!";
		}//end if..else
		echo "<div id='viewTut'>" . $viewIframe . "</div>";
		?>
    </div>
<?php include 'Admin_footer.php'; ?>