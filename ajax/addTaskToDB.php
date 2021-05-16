<?php 

require_once('../includes/db.php');
require_once('../classes/UserTasksClass.php');
//Validation
if (!empty($_POST['taskName']) && !empty($_POST['taskDescription']) && !empty($_POST['taskDueDate']) && !empty($_POST['taskDueTime']) && !empty($_POST['taskPriority'])) {

	//init variables
	$taskName = $_POST['taskName'];
	$taskDescription = $_POST['taskDescription'];
	$taskDueDate = $_POST['taskDueDate'];
	$taskDueTime = $_POST['taskDueTime'];
	$taskPriority = $_POST['taskPriority'];
	$userID = $_SESSION['userData']['user_id'];
	
	//Create new Obj and pass variables through to insert method
	$userTasksObj = new userTasks($DBH);
	echo $userTasksObj->addNewTask($taskName, $taskDescription, $taskDueDate, $taskDueTime, $taskPriority, $userID, $userID);
	
}

?>