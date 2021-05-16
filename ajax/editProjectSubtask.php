<?php 

//prequistes
require_once('../includes/db.php');
require_once('../classes/ProjectTasksClass.php');

//Validation for subtask values - percent not includes as can be passed through as null and shown as 0%
if (!empty($_POST['subtaskID']) && !empty($_POST['editSubtaskName']) && !empty($_POST['editSubtaskStartDate']) && !empty($_POST['editSubtaskEndDate']) && !empty($_POST['editSubtaskDependency'])) {

	//init variables
	$subtaskID = $_POST['subtaskID'];
	$subtaskName = $_POST['editSubtaskName'];
	$subtaskStartDate = $_POST['editSubtaskStartDate'];
	$subtaskEndDate = $_POST['editSubtaskEndDate'];
	$subtaskPercent = $_POST['editSubtaskPercent'];
	$subtaskDependency = $_POST['editSubtaskDependency'];
	
    //validation for subtask dependency, if first task added then the entry to the database needs to be null
	if (empty($subtaskDependency)) {
		$subtaskDependency = null;
	} 
	
	//Create new Obj and pass variables through to insert method
	$projectTasksObj = new projectTask($DBH);
	echo $projectTasksObj->editSubtask($subtaskID, $subtaskName, $subtaskStartDate, $subtaskEndDate, $subtaskPercent, $subtaskDependency);

} else {
    //if one required value not found
    echo "Please fill in all required values";

}
?>