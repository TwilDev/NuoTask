<?php 

require_once('../includes/db.php');
require_once('../classes/ProjectTasksClass.php');

//validation
if(!empty($_POST['subtaskName']) && !empty($_POST['subtaskStartDate']) && !empty($_POST['subtaskEndDate'])  && !empty($_POST['projectId'])) {
	//init variables
	$subtaskName = $_POST['subtaskName'];
	$subtaskStartDate = $_POST['subtaskStartDate'];
	$subtaskEndDate = $_POST['subtaskEndDate'];
	$subtaskPercent = $_POST['subtaskPercent'];
	$subtaskDependency = $_POST['subtaskDependency'];
	$projectId = $_POST['projectId'];

	//Dependency validation
	if (empty($subtaskDependency)) {
		$subtaskDependency = null;
	}


	//Create new Obj and pass variables through to insert method
	$projectTasksObj = new projectTask($DBH);
	echo $projectTasksObj->addNewSubtask($projectId, $subtaskName, $subtaskStartDate, $subtaskEndDate, $subtaskPercent, $subtaskDependency);
	
} else {

	echo "Erorr during input, empty values";
}
	
?>