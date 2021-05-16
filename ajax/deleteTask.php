<?php 
//prereq
require_once('../includes/db.php');
require_once('../classes/UserTasksClass.php');

if(!empty($_POST['taskID'])){
    //init variables
	$taskID = $_POST['taskID'];

	//Create new Obj and pass variables through to insert method
	$userTasksObj = new userTasks($DBH);
	echo $userTasksObj->deleteTask($taskID);
} else {
    //if nothing passed through
    echo "No task found";
}



?>