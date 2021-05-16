<?php

//prereq
require_once('../includes/db.php');
require_once('../classes/ProjectClass.php');

//initial validation
if(!empty($_POST['projectID'])) {

	//get values
    $projectID = $_POST['projectID'];
	
    //Make new object and pass values to method
	$projectObj = new project($DBH);
	echo $result = $projectObj->getProjectInformation($projectID);
} else {
    //if nothing passed through return error.
	echo "Error no values found";
}


?>