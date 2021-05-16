$(document).ready(function() {

//get project id for manipulation of subtasks
var projectId = $('#projectIDHidden').val();
console.log(projectId);

//Show add task form
$('#addNewProjectSubtask').click(function(){
	
	//Check if the task being added is the first task
	if ($('#firstSubtask').is(":visible")) {
		
		$('#subtaskInputDependency').prop("disabled", true);
		
	} else {
		// If tasks exist 
		$('#subtaskInputDependency').prop("disabled", false);
		
	}
	$('#newSubtaskPopupContainer').css("display", "block");
	
});

//Hide add task form
$('#newSubtaskCancel').click(function(){
	
	$('#newSubtaskPopupContainer').css("display", "none");
	
});
	
//Hide add task form
$('#editSubtaskCancel').click(function(){
	
	//show all items again when closing form
	$('#editSubtaskInputDependency > option').each(function(){
		$(this).show();
	});
	
	$('#editSubtaskPopupContainer').css("display", "none");
	
});
	
//Input new subtask for project
$('#newSubtaskSubmit').click(function(){
	
	//data validation
	if($('#subtaskInputName').val().length == 0 || $('#subtaskInputStartDate').val().length == 0 || $('#subtaskInputEndDate').val().length == 0) {
	
			//display error
			$('.alert-error').css("display", "block");
			$('.alert-error').text("Please fill in all fields");
			return false;
	} 
	
	//Test to see if dates are invalid 
	if ($('#subtaskInputStartDate').val() > $('#subtaskInputEndDate').val()) {
	 
		 	//display error
			$('.alert-error').css("display", "block");
			$('.alert-error').text("Invalid dates! - start date cannot be earlier than end date");
			return false;
	 	
	 }
	
	//Close form to avoid multiple inputs
	$('#newSubtaskPopupContainer').css("display", "none");

	//Data binding for input
	var subtaskName = $('#subtaskInputName').val();
	var subtaskStartDate = $('#subtaskInputStartDate').val();
	var subtaskEndDate = $('#subtaskInputEndDate').val();
	var subtaskPercent = $('#subtaskInputPercent').val();
	var subtaskDependency = $('#subtaskInputDependency').val();
	//console.log(subtaskDependency);
	
	console.log($('#subtaskInputDependency').val());
	
	//Validation for dependency
	
	if (subtaskDependency == 'undefined') {
	
		subtaskDependency = null;
		console.log(subtaskDependency);
	}
	
		//send ajax request 
		request = $.ajax({
		url: "ajax/addProjectSubtask.php",
		type: "POST",
		data: { subtaskName : subtaskName, subtaskStartDate : subtaskStartDate, subtaskEndDate : subtaskEndDate, subtaskPercent : subtaskPercent, subtaskDependency : subtaskDependency, projectId : projectId }
	});
	
		request.done(function (response, textStatus, jqXHR) {
		console.log(response);
		console.log(textStatus);
		
		//refresh page to redraw SVG with new task
		location.reload();
		});
});
	
$('.project-edit').click(function(){
	
	
	/// -- DATA BINDING -- ///
	
	//Gets parent ID for task ID
	var subtaskID = $(this).closest('li').attr('id');
	//assign ID to form
	$('#subtaskId').val(subtaskID);
	console.log(subtaskID);
	
	//remove dependency option for selected subtask
	$('#editSubtaskInputDependency > option').each(function(){
		if($(this).val() == subtaskID) {
			//console.log("removing option " +$(this).val());
			$(this).hide();
			console.log($(this).val());
			return true;
		}
	
	});
	
	//send ajax request for populating fields
	request = $.ajax({
		url: "ajax/getProjectSubtask.php",
		type: "POST",
		datatype: "json",
		data: { subtaskID: subtaskID }
	});
	
	//upon response
	request.done(function (response, textStatus, jqXHR) {

		
		//parse response to json object
		var json = JSON.parse(response)
		
		//data binding from JSON object
		$('#editSubtaskInputName').val(json[0].project_task_name);
		$('#editSubtaskInputStartDate').val(json[0].project_task_start_date);
		$('#editSubtaskInputEndDate').val(json[0].project_task_end_date);
		$('#editSubtaskInputPercent').val(json[0].project_task_percent);
		
		//assign dependency to variable for validation
		var subtaskDependency = json[0].project_task_dependency;
		
		//validation for dependency - Google will throw an error if the item in the chart has a dependency, stating cycle detected. This resolves that, yet is far from perfect
	if (subtaskDependency != null) {
		$('#editSubtaskInputDependency').prop("disabled", false);
		$('#editSubtaskInputDependency').val(subtaskDependency);
	} else {
		subtaskDependency = null;
		console.log(subtaskDependency);
		$('#editSubtaskInputDependency').prop("disabled", true);
	}
		
		});
	
	//Open Form
	$('#editSubtaskPopupContainer').css("display", "block");
	
});
	
//Input new subtask for project
$('#editSubtaskSubmit').click(function(){
	
		//data validation
		if($('#editSubtaskInputName').val().length == 0 || $('#editSubtaskInputStartDate').val().length == 0 || $('#editSubtaskInputEndDate').val().length == 0) {
	
			//display error
			$('.alert-error').css("display", "block");
			$('.alert-error').text("Please fill in all fields");
			return false;
	}
	
	//Remove form to stop multiple inputs
	$('#editSubtaskPopupContainer').css("display", "none");
	
	//Data Binding
	var subtaskId = 	$('#subtaskId').val();
	
	//Data binding for input
	var subtaskName = $('#editSubtaskInputName').val();
	var subtaskStartDate = $('#editSubtaskInputStartDate').val();
	var subtaskEndDate = $('#editSubtaskInputEndDate').val();
	var subtaskPercent = $('#editSubtaskInputPercent').val();
	
	//Validation for if dependency should be null or not
	if ($('#editSubtaskInputDependency').prop("disabled")) {
		var subtaskDependency = null;
	} else {
		var subtaskDependency = $('#editSubtaskInputDependency').val();
		
	}
	
	//Make ajax request
		request = $.ajax({
		url: "ajax/editProjectSubtask.php",
		type: "POST",
		data: {subtaskID: subtaskId, editSubtaskName: subtaskName, editSubtaskStartDate: subtaskStartDate, editSubtaskEndDate: subtaskEndDate, editSubtaskPercent: subtaskPercent, editSubtaskDependency: subtaskDependency  }
	});
	
		//console log for debugging
		request.done(function(response, textStatus, jqXHR){
		console.log(response);
		console.log(textStatus)
		
		//reload to update SVG
		location.reload();
	});

	
});

//Deleting Subtask validation	

$('.project-delete').click(function(){

	console.log("delete me");
	//Data Binding
	
	//Get parent ID for task ID
	var subtaskID = $(this).closest('li').attr('id');
	
	//Get dependency ID for validation check
	var dependencyID = $(this).siblings('.proj-dependency').text();
	
	//Create bool value
	var deleteConfirm = true;
	
	//Iterate through depedencies of each task to check if one subtask is not dependent on another
	$('.proj-dependency').each(function(index){
		//console.log($(this).text());
		if($(this).text() == subtaskID) {
			//if subtask is found to be dependent on parent class send out alert
			alert("Please update subtask dependencies, for child subtasks");
			//set bool value to false if any subtask should fail
			deleteConfirm = false;
			return false;
		} 
	});
	
	//if no subtasks have dependencies for this subtask proceed with delete operation
	if (deleteConfirm) {
		deleteProjectSubtask(subtaskID);
	};
	
//Delete Subtask function

function deleteProjectSubtask(subtaskID) {
		
	//Confirm with user that they want to delete the subtask
	if(!confirm("Are you sure you want to delete this subtask?")) {
		return;
	} else {
		console.log("Now deleting subtask with ID of  - " +subtaskID);
		
		var subtaskId = subtaskID;
		console.log(subtaskId);
		
		//Make ajax request
		request = $.ajax({
		url: "ajax/deleteProjectSubtask.php",
		type: "POST",
		data: {subtaskId: subtaskId}
		});
	
		//console log for debugging
		request.done(function(response, textStatus, jqXHR){
		console.log(response);
		console.log(textStatus)
		
		//reload to update SVG
		location.reload();
	});
		
	}
				
}
	
});	

});

