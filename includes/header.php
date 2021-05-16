<?php

// DB and PHP files
require_once('includes/db.php');
require_once('classes/UserClass.php');
require_once('classes/UserTasksClass.php');
require_once('classes/ProjectTasksClass.php');
require_once('classes/ProjectClass.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
  <!-- Including frameworks including Bootstrap and jQuery -->
		<script src="https://kit.fontawesome.com/a6155b3317.js" crossorigin="anonymous"></script>
	
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  		<link rel="stylesheet" type="text/css" href="css/style.css">
	
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
	
	<!-- js files -->
	<script src="js/nav.js"></script>
	<script src="js/yourweek.js"></script>
	<script src="js/projectview.js"></script>
	<script src="js/newProject.js"></script>

	
  <!-- Including fonts -->
  <link href='https://fonts.googleapis.com/css?family=Sintony' rel='stylesheet'>
	<title>NuoTask</title>
</head>

<?php 
	//pre req
	require_once('db.php');
	require_once('classes/ProjectTasksClass.php');
	
	//if logged in show specific Nnav
	if($_SESSION['loggedin']) { 
	?>
	<body class="body">
			<header class="fixed-top">
					<div class="nav-container">
					  <nav class="navbar navbar-expand-sm" role="navigation">
						  <span id="overlayNavBtn">&#9776;</span>
						<a id="mainLogo" class="navbar-brand" href="#">NuoTask</a>
						<ul class="nav navbar-nav ml-auto">
						   <li class="nav-item">
								<a href="index.php?p=myProfile" class="nav-link m-2"><i  class="fas fa-user user-icon"></i></a>
							</li>
							<li class="nav-item">
								<a href="index.php?p=logout" class="nav-link m-2 user-icon-text">Logout<i class="fas fa-sign-out-alt user-icon "></i></a>
							</li>
						</ul>  
					  </nav>
					</div>
			</header>
			
	<div id="overlayNavContainer" class="overlayNav">
		<div class="overlayNavContent">
			<div class="overlayNavLink">
			    <a href="index.php?p=yourweek">Weekly Tasks</a>
			</div>
			<div class="overlayNavForm">
			<a href="#">Your Projects</a>
				<form class="form-inline">
				  <ul id="projectList" class="list-group">
					  <?php
						//GET PROJECTS
		
					  	//Create new project tasks object
					  	$projectTasksObj = new projectTask($DBH);
		
						//get user session information
						$userID = $_SESSION['userData']['user_id'];
						$userTeamID = $_SESSION['userData']['user_team_id'];
						
						//Get projects associated with user and user team
						$result = $projectTasksObj->getProjects($userID, $userTeamID);
						
						//iterate through results and print out projects as a link in a bootstrap list
						foreach($result as $row) {
								echo "<li id=" .$row[0]. " class='list-group-item project-list-item'><a href='index.php?p=yourprojects&id=" .$row[0]. "' id='projectName " .$row[0]. "' class='project-task-min'>" .$row['project_name']. "</a> <i id=" .$row[0]. " class='fas fa-edit nav-project-edit'></i><i id=" .$row[0]. " class='fas fa-trash-alt nav-project-delete'></i></li>";
						};
					  
					  ?>
					</ul>
				</form>
				<button id="addNewProject">New Project</button>
			</div>
		</div>
	</div>
	
	
	<?php 
	//if the p variable isn't set to the home page change body class for styling
	}elseif($_GET['p'] != "home"){
			?>

		<body class="signin-body">
			
	<?php }else{ ?>
		
				
			<header class="fixed-top">
			<div class="nav-container">
				<nav class="navbar navbar-expand-sm" role="navigation">
					<a class="navbar-brand" href="index.php?p=home">NuoTask</a>
					<ul class="nav navbar-nav ml-auto">
						<li class="nav-item">
							<a href="index.php?p=login" class="nav-link m-1">Login</a>
						</li>
						<li class="nav-item">
							<a href="index.php?p=register" class="nav-link m-1" id="signup-button">Sign-up</a>
						</li> 
					</ul>  
				</nav>
			</div>
		</header>
			
		
		
	<?php } ?>

	<div id="newProjectPopupContainer" class="popupForm">
			<div id="newProjectFormContainer" class="popupContent  col-lg-5">
				<h2 id="newProjectFormHeader" class="popupFormHeader">Add New Project</h2>
				<form id="newProjectNavForm">
					
					<div class="alert-error alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only"></span>
					</div>
					
					<div class="form-group">
						<input id="projectInputName" class="form-control" name="task_name" placeholder="Project Name">
					</div>
					
					<div class="form-group">
						<label for="projectInputStartDate" class="form-label">Start Date</label>
						<input id="projectInputStartDate" class="form-control" name="task_due_date" type="date">
					</div>
					
					<div class="form-group">
						<label for="projectInputEndDate" class="form-label">End Date</label>
						<input id="projectInputEndDate" class="form-control" name="task_due_date" type="date">
					</div>
											
					<input id="newProjectSubmit" class="popoutFormBtn" value="Submit" type="button">
		
					<input id="newProjectCancel" class="popoutFormBtn" value="Cancel" type="button">
				</form>
			</div>
		</div>
	
		<div id="editProjectPopupContainer" class="popupForm">
			<div id="editProjectFormContainer" class="popupContent  col-lg-5">
				<h2 id="editProjectFormHeader" class="popupFormHeader"> Edit Project</h2>
				<form id="editProjectNavForm">
					
					<div class="alert-error alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only"></span>
					</div>
					
					
					<div class="form-group">
						<input id="projectEditName" class="form-control" name="task_name" placeholder="Project Name">
					</div>
					
					<div class="form-group">
						<label for="projectEditStartDate" class="form-label">Start Date</label>
						<input id="projectEditStartDate" class="form-control" name="task_due_date" type="date">
					</div>
					
					<div class="form-group">
						<label for="projectEditEndDate" class="form-label">End Date</label>
						<input id="projectEditEndDate" class="form-control" name="task_due_date" type="date">
					</div>
					
					<input type="hidden" id="editProjectID">
											
					<input id="editProjectSubmit" class="popoutFormBtn" value="Submit" type="button">
		
					<input id="editProjectCancel" class="popoutFormBtn" value="Cancel" type="button">
				</form>
			</div>
		</div>
		
