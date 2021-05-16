<?php

//prereq
require_once('../includes/db.php');
require_once('../classes/ProjectClass.php');

//validation
if(!empty($_POST['projectID'])){
    
    //init variables
	$projectID = $_POST['projectID'];

	//Create new Obj and pass variables through to insert method
	$projObj = new project($DBH);
	echo $projObj->deleteProject($projectID);
    
} else {
    //if nothing found passed through
    echo "No project found";
}




?>


