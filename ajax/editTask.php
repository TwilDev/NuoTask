<?php 

//prereq
require_once('../includes/db.php');
require_once('../classes/UserTasksClass.php');

//Initial validation
if (!empty($_POST['taskID']) && !empty($_POST['taskName']) && !empty($_POST['taskDescription']) && !empty($_POST['taskDueDate']) && !empty($_POST['taskDueTime']) && !empty($_POST['taskPriority'])) {
    
	//init variables
	$taskID = $_POST['taskID'];
	$taskName = $_POST['taskName'];
	$taskDescription = $_POST['taskDescription'];
	$taskDueDate = $_POST['taskDueDate'];
	$taskDueTime = $_POST['taskDueTime'];
	$taskPriority = $_POST['taskPriority'];
	$userID = $_SESSION['userData']['user_id'];
	
	//Create new Obj and pass variables through to insert method
	$userTasksObj = new userTasks($DBH);
	echo $userTasksObj->editTask($taskID, $taskName, $taskDescription, $taskDueDate, $taskDueTime, $taskPriority, $userID, $userID);
	
} else {
    //if values not found
    echo "Please fill all values";
}

?>