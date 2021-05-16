<?php 

require_once('../includes/db.php');
require_once('../classes/ProjectClass.php');


//Validation
if(!empty($_POST['projectName']) && !empty($_POST['projectStartDate']) && !empty($_POST['projectEndDate']) ) {

	//init variables
	$projectName = $_POST['projectName'];
	$projectStartDate = $_POST['projectStartDate'];
	$projectEndDate = $_POST['projectEndDate'];
	$projectTeamId = $_SESSION['userData']['user_team_id'];

	
	//Create new Obj and pass variables through to insert method
	$projectObj = new project($DBH);
	echo $projectObj->addNewProject($projectName, $projectStartDate, $projectEndDate, $projectTeamId);

} else {
    //if values not found
    echo "Please fill in all values";
} 
?>