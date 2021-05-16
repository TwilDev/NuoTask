$(document).ready(function() {

//////// Setting the date to the current date ////////
	
var curr = new Date();
var firstWeekDate = curr.getDate() - curr.getDay() + 1 //Get the first day of the week (+1 for monday)
var lastWeekDate = firstWeekDate + 6; // Gets sunday
	
// Splitting ISO date format into just the YY-MM-DD Format found here - https://stackoverflow.com/questions/34053715/how-to-output-date-in-javascript-in-iso-8601-without-milliseconds-and-with-z

var thisDay = new Date(curr).toISOString().split('T')[0]; //Get current date once more
var firstDay = new Date(curr.setDate(firstWeekDate)).toISOString().split('T')[0]; //get dates into correct format
var lastDay = new Date(curr.setDate(lastWeekDate)).toISOString().split('T')[0]; 

	
//////// Show task in main body ////////
	
$('.task-list').click(function() {
	//init variables
	var taskArray=[];
	var getChild = $(this).children(); //gets all children elements of div
	
	
	//assign each child elements text value to task array
	getChild.each(function(key,val) {
		taskArray.push([($(val).text())]);
	});
	console.log(taskArray);
	
	//Get main task container and display
	$('.task-body').css("display", "block");
	$('.lower-task-nav').css("display", "block");
	
	if($('#mobileClose').is(":visible")) {
		
		$('.lower-task-nav').hide();
		console.log("visible");
	}
	
	console.log(taskArray);
	
	//Set main body with array values
	$('#taskMainHead').text(taskArray[0]);
	$('#taskMainDesc').text(taskArray[2]);
	$('#taskMainDate').text(taskArray[3]);
	$('#taskMainPriority').attr('name', taskArray[4]);
	$('#taskMainID').attr('name', taskArray[5]);
	
});
	
	
//////// click events for opening and closing popup forms ////////
$('#yourWeekNewTask').click(function() {
	$('#newTaskPopupContainer').css("display", "block");
});

$('#newTaskCancel').click(function() {
	$('#newTaskPopupContainer').css("display", "none");
});
	
	
//////// Click event for adding new task ////////
$('#newTaskSubmit').click(function() {
	
	//validation
	if ($('#taskInputName').val().length == 0 || $('#taskInputDescription').val().length == 0 || $('#taskInputDate').val().length == 0 || $('#taskInputTime').val().length == 0
	   	|| $('#taskInputPriority').val() == 0) 
	{
			//display error
			$('.alert-error').css("display", "block");
			$('.alert-error').text("Please fill in all fields");
			console.log("got here");
			return false;
	
	};
	
	//Close form to stop repeated inserts
	$('#newTaskPopupContainer').css("display", "none");
	
	//Get Form Values
	var taskName_input = $('#taskInputName').val();
	var taskDescription_input = $('#taskInputDescription').val();
	var taskDueDate_input = $('#taskInputDate').val();
	var taskDueTime_input = $('#taskInputTime').val();
	var taskPriority_input = $('#taskInputPriority').val();
	console.log(taskName_input);
	console.log(taskPriority_input);
	
	//send ajax request 
	request = $.ajax({
		url: "ajax/addTaskToDB.php",
		type: "POST",
		data: { taskName : taskName_input, taskDescription : taskDescription_input, taskDueDate : taskDueDate_input, taskDueTime : taskDueTime_input, taskPriority : taskPriority_input }
	});
	
	//console log on success
	request.done(function (response, textStatus, jqXHR) {
		console.log(response);
		console.log(textStatus);
		
		//when added append to webpage according to section
		if (taskDueDate_input == thisDay) {
			
			$("#DueListContainer").append("<div class='task-list' id="+response+"> <a class='task-name' href='#'><h6>"+taskName_input+"</h6></a><br><p class='task-text'>"+taskDescription_input+"</p><p class='task-date-time'>"+taskDueDate_input+"</p></div>");
			
			
		} else if (taskPriority_input == "High" && taskDueDate_input >= thisDay && taskDueDate_input <= lastDay) {
			
			$("#HighListContainer").append("<div class='task-list' id="+response+"> <a class='task-name' href='#'><h6>"+taskName_input+"</h6></a><br><p class='task-text'>"+taskDescription_input+"</p><p class='task-date-time'>"+taskDueDate_input+"</p></div>");

		} else if (taskPriority_input == "Medium" && taskDueDate_input >= thisDay && taskDueDate_input <= lastDay) {
			
						$("#MediumListContainer").append("<div class='task-list' id="+response+"> <a class='task-name' href='#'><h6>"+taskName_input+"</h6></a><br><p class='task-text'>"+taskDescription_input+"</p><p class='task-date-time'>"+taskDueDate_input+"</p></div>");
		
		} else if (taskPriority_input == "Low" && taskDueDate_input >= thisDay && taskDueDate_input <= lastDay) {
			
						$("#LowListContainer").append("<div class='task-list' id="+response+"> <a class='task-name' href='#'><h6>"+taskName_input+"</h6></a><br><p class='task-text'>"+taskDescription_input+"</p><p class='task-date-time'>"+taskDueDate_input+"</p></div>");
		
		}
		
		//Change current active text to task text;
		
			$('#taskMainHead').text(taskName_input);
			$('#taskMainDesc').text(taskDescription_input);
			$('#taskMainDate').text(taskDueDate_input);
			$('#taskMainPriority').attr('name', taskPriority_input);
			$('#taskMainID').attr('name', response);

		
	});
});
	
	
//////// Click events for opening and closing popup forms ////////
$('.btnEditTask').click(function() {
	
	//Grab task details
	var editTaskName = $('#taskMainHead').text();
	console.log(editTaskName);
	var editTaskDueDate = $('#taskMainDate').text();
	var editTaskDescription = $('#taskMainDesc').text();
	var editTaskPriority = $('#taskMainPriority').attr('name');
	console.log(editTaskPriority);
	
	//Set input fields to task details
	$('#editTaskPopupContainer').css("display", "block");
	$('#editTaskInputName').val(editTaskName);
	$('#editTaskInputDate').val(editTaskDueDate);
	$('#editTaskInputDescription').val(editTaskDescription);
	$('#editTaskInputPriority').val(editTaskPriority);
	
});

$('#editTaskCancel').click(function() {
	$('#editTaskPopupContainer').css("display", "none");
});
	
//////// Click event for editing an exisiting task ////////
$('#editTaskSubmit').click(function() {
	
	//validation
	if ($('#editTaskInputName').val().length == 0 || $('#editTaskInputDescription').val().length == 0 || $('#editTaskInputDate').val().length == 0 || $('#editTaskInputTime').val().length == 0
	   	|| $('#editTaskInputPriority').val().length == 0) 
	{
			//display error
			$('.alert-error').css("display", "block");
			$('.alert-error').text("Please fill in all fields");
			console.log("got here");
			return false;
	
	};
	
	//Close form to stop repeated inserts
	$('#editTaskPopupContainer').css("display", "none");
	
	//Get Form Values
	var editName_input = $('#editTaskInputName').val();
	var editDescription_input = $('#editTaskInputDescription').val();
	var editDueDate_input = $('#editTaskInputDate').val();
	var editDueTime_input = $('#editTaskInputTime').val();
	var editPriority_input = $('#editTaskInputPriority').val();
	console.log(editName_input);
	console.log(editDescription_input);
	console.log(editDueDate_input);
	console.log(editDueTime_input);
	console.log(editPriority_input);
	
	var editTaskID = $('#taskMainID').attr('name');
	console.log(editTaskID);
	
	//send ajax request
	request = $.ajax({
		url: "ajax/editTask.php",
		type: "POST",
		data: { taskID : editTaskID, taskName : editName_input, taskDescription : editDescription_input, taskDueDate : editDueDate_input, taskDueTime : editDueTime_input, taskPriority : editPriority_input}
	});
	
		//console log on success
	request.done(function (response, textStatus, jqXHR) {
		console.log(response);
		console.log(textStatus);
		window.location.reload();
	});
	
});
	
//////// Delete handler ////////

$('.btnDeleteTask').click(function() {
	var del = confirm("Are you sure you want to delete this task?");
	if (del) {
		console.log("delete");
					
		//get task ID
		var delTaskID = $('#taskMainID').attr('name');
		
		//Send ajax request to delete
		request = $.ajax ({
			url: "ajax/deleteTask.php",
			type: "POST",
			data: { taskID : delTaskID }
		});
		
		request.done(function(response, textStatus, jqXHR) {
			console.log(response);
			window.location.reload();
		})
		
	} else {
		console.log("cancel delete");

	}
});

$('#mobileClose').click(function(){

	$('.task-body').hide();
});

});