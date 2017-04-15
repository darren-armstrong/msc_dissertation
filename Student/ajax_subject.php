<?php
include('../script/mysql_dbConnect.php');
if($_POST['id']){
	$id=$_POST['id'];
	$subjectSearch = mysql_query("SELECT * FROM subject WHERE Area_of_study='$id'");
	$subCount = mysql_num_rows($subjectSearch);
	if($subCount > 0){
		echo "<option selected='true' disabled='disabled'>Select a Subject...</option>";
		while($subs = mysql_fetch_array($subjectSearch)){
			$Sid = $subs["id"];
			$subject = $subs["name"];
			if(isset($subject)){
				echo "<option value='" . $Sid ."'>" . $subject . "</option>";
			}
		}
	}else {
		echo "<option selected='true' disabled='disabled'>No Subjects available...</option>";
	}
}
?>