$(document).ready(function(){
	

	
	//Open form when clicking on new project
	$('#addNewProject').click(function() {
	
		console.log("addNewProject");
		$('#newProjectPopupContainer').css('display', 'block');
	});
	
	//Closing form on cancel
	$('#newProjectCancel').click(function() {
	
		console.log("addNewProject");
		$('#newProjectPopupContainer').css('display', 'none');
	});
	
	//on new project submit
	$('#newProjectSubmit').click(function(){
	
		if ($('#projectInputName').val().length == 0 || $('#projectInputStartDate').val().length == 0 || $('#projectInputEndDate').val()) {
		
			//display error
			$('.alert-error').css("display", "block");
			$('.alert-error').text("Please fill in all fields");
			return false;
		
		} 
		
		$('#newProjectPopupContainer').css('display', 'none');
		
		//Data binding
		var projectName = $('#projectInputName').val();
		var projectStartDate = $('#projectInputStartDate').val();
		var projectEndDate = $('#projectInputEndDate').val();
		
		//send ajax request 
		request = $.ajax({
		url: "ajax/addNewProject.php",
		type: "POST",
		data: { projectName : projectName, projectStartDate : projectStartDate, projectEndDate : projectEndDate }
		});
	
		request.done(function (response, textStatus, jqXHR) {
		console.log(response);
		console.log(textStatus);
			
		//append response to project list 
		$('#projectList').append("<li class='list-group-item project-list-item'><a href='index.php?p=yourprojects&id="+response+"' id="+response+" class='project-task-min'>"+projectName+"</a> <i id="+response+ " class='fas fa-edit nav-project-edit'></i><i id="+response+" class='fas fa-trash-alt nav-project-delete'></i></li>");
			
		//Have to force a reload as for some reason the href applied to the a tag has a space added betweeh the ID and response variable I have no idea why
		location.reload();
			
		});
		
	});
	
	
	//on  click edit project 
	$('.nav-project-edit').click(function(){
		
		//assign variable projectID for query
		var projectID = $(this).attr('id');
		$('#editProjectID').val(projectID);
		console.log(projectID);
		
		//make ajax request
		request =  $.ajax({
		url: "ajax/getProjectInfo.php",
		type: "POST",
		datatype: "json",
		data: { projectID : projectID }
		});
		
		//get response
		request.done(function(response, textStatus, jqXHR){
		
		//parse response to json object
		var json = JSON.parse(response)
		
		//populate fields with JSON object
		$('#projectEditName').val(json[0].project_name);
		$('#projectEditStartDate').val(json[0].project_start_date);
		$('#projectEditEndDate').val(json[0].project_end_date);
			
	});

		//display form		
		$('#editProjectPopupContainer').css("display", "block");

	});
	
	$('#editProjectCancel').click(function(){
		
		$('#editProjectPopupContainer').css("display", "none");
		
	});
	
	$('#editProjectSubmit').click(function(){
		
		//validation of fields
		if ($('#editProjectID').val().length == 0 ||  $('#projectEditName').val().length == 0 || $('#projectEditStartDate').val() == 0 || $('#projectEditEndDate').val().length == 0) 		  {
			//display error
			$('.alert-error').css("display", "block");
			$('.alert-error').text("Please fill in all fields");
			return false;
		}
		
		//Close form to avoid multiple submissions
		$('#editProjectPopupContainer').css("display", "none");
		
		//Data binding
		var projectID = $('#editProjectID').val()
		var projectName = $('#projectEditName').val();
		var projectStartDate = $('#projectEditStartDate').val();
		var projectEndDate = $('#projectEditEndDate').val();
		
		//Make Ajax call
		request =  $.ajax({
		url: "ajax/editProjectInfo.php",
		type: "POST",
		data: { projectID : projectID, projectName: projectName, projectStartDate: projectStartDate, projectEndDate: projectEndDate}
		});
		
		//get response
		request.done(function(response, textStatus, jqXHR){
			
			//Some weirdness means I can't update values 
			location.reload();
		});
		
	
	});
	
	$('.nav-project-delete').click(function() {
	
		if (confirm("Are you sure you want to delete this project? All subtasks will be removed")) {
			
			console.log("delete confirm");
			var delID = $(this).attr('id');
			//Ajax Call
			request =  $.ajax({
				url: "ajax/deleteProject.php",
				type: "POST",
				data: {projectID: delID}
			});
			
			
			request.done(function(response, textStatus, jqXHR){
				console.log(response);
				location.reload();
		});
			
		} else {
			
			console.log("don't delete");
		}
		
	});
	

});