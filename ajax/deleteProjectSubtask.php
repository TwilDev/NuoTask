<?php 

//prereq
require_once('../includes/db.php');
require_once('../classes/ProjectTasksClass.php');

//validation of values
if (!empty($_POST['subtaskId'])) {
    
    //init variables
	$subtaskID = $_POST['subtaskId'];

	echo $subtaskID;
	//Create new Obj and pass variables through to insert method
	$projectTasksObj = new projectTask($DBH);
	echo $projectTasksObj->deleteSubtask($subtaskID);
    
} else {
    //return error
    echo "No subtask found";
}


	

?>