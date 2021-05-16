<?php

//prereq
require_once('../includes/db.php');
require_once('../classes/ProjectTasksClass.php');

//validation
if(!empty($_POST['subtaskID'])) {
    
    //get data
	$subtaskID = $_POST['subtaskID'];
	
    //create object and pass to method
	$projectTaskObj = new projectTask($DBH);
	echo $result = $projectTaskObj->getSubtaskJSON($subtaskID);
	
} else {
    //if nothing passed through return error
	echo "Error no values found";
}


?>