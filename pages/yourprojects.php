<?php
//session check
if(!$_SESSION['loggedin']) {
	echo "<script>window.location.assign('index.php?p=login');</script>";
}
?>
<div id="projectHeadContainer" class="row">
	<div id="projectHead" class="col-lg-6">
		<h2>Project Gantt View</h2>
	</div>
	<div id="projectHeadAdd" class="col-lg-6">
		
		<button id="addNewProjectSubtask">New Subtask</button>
		<span id="firstSubtask" >Add your first project task!<i class="fas fa-arrow-right"></i></span>
	</div>
</div>
<div class="row">
	<div id="projectTaskContainer" class="col-sm-11 col-md-11 col-lg-1">
		<div id="projectTasks">
			<ul id="projectTasksList"  class="list-group">
			<?php
			
				$pID = $_GET['id'];
				$projectTableTasksObj = new projectTask($DBH);
				$tableResult = $projectTableTasksObj->getProjectTasks($pID);
						
				
				foreach($tableResult as $row) {
							echo "<li id=" .$row[0]. " class='list-group-item project-list-item'><a id=" .$row[0]. " class='project-task-min'>" .$row[1]. "</a> 
							<i id=" .$row[0]. " class='fas fa-edit project-edit alt='Edit''></i><i id=" .$row[0]. " class='fas fa-trash-alt project-delete' alt='Delete'></i>";
							//add hidden items, avoids needing to make a server request to populate edit fields and add dynamically created ID
							echo "<p id='hidden-name" .$row[0]. "' class='proj-hidden' >" .$row['project_task_name']."</p>";
							echo "<p id='hidden-start-date" .$row[0]. "' class='proj-hidden' >" .$row['project_task_start_date']."</p>";
							echo "<p id='hidden-end-date" .$row[0]. "' class='proj-hidden'>" .$row['project_task_end_date']."</p>";
							echo "<p  id='hidden-percent" .$row[0]. "' class='proj-hidden'>" .$row['project_task_percent']."</p>";
							echo "<p  id='hidden-dependency" .$row[0]. "' class='proj-hidden proj-dependency'>"  .$row['project_task_dependency']."</p>";
							
							echo "</li>";
						};
			?>
			</ul>
		</div>
	</div>
	<div id="projectChartContainer" class="col-lg-11 col-md-10 col-sm-12">
		<div id="chart_head" style="margin-top:3.3rem;"></div>
		<div id="chart_div"></div>
	</div>
</div>
	
<?php

echo"<input type='hidden' id='projectIDHidden' value='".$pID."'>";
$projectTasksObj = new projectTask($DBH);
$result = $projectTasksObj->getProjectTasks($pID);

//Check if the project is empty
if(!empty($result)) {
		echo "
	<script>
	
		$('#firstSubtask').hide();
	
	</script>
	";
} else {
	echo "
	<script>
	
		$('#firstSubtask').show();
	
	</script>
	";
}
?>

<script>

	
google.charts.load('current', {'packages':['gantt']});
google.charts.setOnLoadCallback(drawChart);

function daysToMilliseconds(days) {
 
  return days * 24 * 60 * 60 * 1000;
}

function drawChart()  {
	
	//add columns for gantt chart
 var otherData = new google.visualization.DataTable();
  otherData.addColumn('string', 'Task ID');
  otherData.addColumn('string', 'Task Name');
  otherData.addColumn('date', 'Start');
  otherData.addColumn('date', 'End');
  otherData.addColumn('number', 'Duration');
  otherData.addColumn('number', 'Percent Complete');
  otherData.addColumn('string', 'Dependencies');

	//add rows
  otherData.addRows([

	  <?php
	  	//iterate through project subtasks and echo out in Google Charts format
	  	foreach($result as $row) {
		
								echo "['" . $row['project_task_id'] . "', '" .$row['project_task_name']. "', new Date('" .$row['project_task_start_date']. "'), new Date('" .$row['project_task_end_date']. "'), daysToMilliseconds(" .$row['project_task_duration']. "), " .$row['project_task_percent']. ", '" .$row['project_task_dependency']. "'],";
		
		}	  
	  ?>
	 
  ]);
	
 var options = {
	 title: 'test',};

  var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
	
//Remove google errors showing up (for when new project is started)
  google.visualization.events.addListener(chart, 'error', function(googleError) {
  		google.visualization.errors.removeError(googleError.id);
  });

  chart.draw(otherData, options);
}
	

	
</script>
				




		<div id="newSubtaskPopupContainer" class="popupForm">
			<div id="newSubtaskFormContainer" class="popupContent  col-lg-5">
				<h2 id="newSubtaskFormHeader" class="popupFormHeader">Add New Project Task</h2>
				<form id="newSubtaskForm">
					
					<div class="alert-error alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only"></span>
					</div>
					
					
					<div class="form-group">
						<input id="subtaskInputName" class="form-control" name="task_name" placeholder="Task Name">
					</div>
					
					<div class="form-group">
						<label for="subtaskInputStartDate" class="form-label">Start Date</label>
						<input id="subtaskInputStartDate" class="form-control" name="task_due_date" type="date">
					</div>
					
					<div class="form-group">
						<label for="subtaskInputEndDate" class="form-label">End Date</label>
						<input id="subtaskInputEndDate" class="form-control" name="task_due_date" type="date">
					</div>
											
					
					<div class="form-group">
						<input id="subtaskInputPercent" class="form-control" name="task_due_date" type="text" placeholder="% Completed" maxlength="3">
					</div>
					
					<div class="form-group">
						<select id="subtaskInputDependency" class="form-control">
							<?php
								foreach($result as $row) {
									echo "<option value='" .$row['project_task_id']. "'>" .$row['project_task_name']. "</option>";
								}
							?>
						</select>
					</div>
				
					<input id="newSubtaskSubmit" class="popoutFormBtn" value="Submit" type="button">
		
					<input id="newSubtaskCancel" class="popoutFormBtn" value="Cancel" type="button">
				</form>
			</div>
		</div>

		<div id="editSubtaskPopupContainer" class="popupForm">
			<div id="editSubtaskFormContainer" class="popupContent  col-lg-5">
				<h2 id="editSubtaskFormHeader" class="popupFormHeader">Edit Task</h2>
				<form id="editSubtaskForm">
					
					<div class="alert-error alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only"></span>
					</div>
					
					<div class="form-group">
						<input id="editSubtaskInputName" class="form-control" name="task_name" placeholder="Task Name">
					</div>
					
					<div class="form-group">
						<label for="editSubtaskInputStartDate" class="form-label">Start Date</label>
						<input id="editSubtaskInputStartDate" class="form-control" name="task_due_date" type="date">
					</div>
					
					<div class="form-group">
						<label for="editSubtaskInputEndDate" class="form-label">End Date</label>
						<input id="editSubtaskInputEndDate" class="form-control" name="task_due_date" type="date">
					</div>
											
					
					<div class="form-group">
						<input id="editSubtaskInputPercent" class="form-control" name="task_due_date" type="text" placeholder="% Completed" maxlength="3">
					</div>
					
					<div class="form-group">
						<select id="editSubtaskInputDependency" class="form-control">
							<?php
								foreach($result as $row) {
									echo "<option value='" .$row['project_task_id']. "'>" .$row['project_task_name']. "</option>";
								}
							?>
						</select>
					</div>
					
					<input id="subtaskId" type="hidden">
				
					<input id="editSubtaskSubmit" class="popoutFormBtn" value="Submit" type="button">
		
					<input id="editSubtaskCancel" class="popoutFormBtn" value="Cancel" type="button">
				</form>
			</div>
		</div>