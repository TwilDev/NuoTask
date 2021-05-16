<?php

//Prerequsities
require_once('../includes/db.php');
require_once('../classes/ProjectClass.php');


//Validation
if(!empty($_POST['projectID']) && !empty($_POST['projectName']) && !empty($_POST['projectStartDate']) && !empty($_POST['projectEndDate']) ) {
    
    //Init varaibles from POST
	$projectID = $_POST['projectID'];
	$projectName = $_POST['projectName'];
	$projectStartDate = $_POST['projectStartDate'];
	$projectStartDate = $_POST['projectEndDate'];
	
    //Create new object and forward variables onto object
	$projectObj = new project($DBH);
	echo $result = $projectObj->editProject($projectID, $projectName, $projectStartDate, $projectStartDate);
} else {
    //if nothing found return error
	echo "Error no values found";
}


?>