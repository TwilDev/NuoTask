<?php
//session check
if(!$_SESSION['loggedin']) {
	echo "<script>window.location.assign('index.php?p=login');</script>";
}

if ($_POST['taskName']) {
	echo "<script>console.log('test');</script>";
} else {
	echo "<script>console.log('test2');</script>";
}
?>

		<?php 
				$curDate = date("Y-m-d");
				$weekStart = strtotime("last Monday");
				$weekStartDate = date("Y-m-d",$weekStart);
				$weekEnd = strtotime("next Sunday");
				$weekEndDate = date("Y-m-d",$weekEnd);
		?>

	
    
    <section id="your-week-body">
    
        <div id="taskaside" class="col-lg-4 col-sm-12">
            
            <div id="date-nav">
                    
                <button id="yourWeekNewTask">New Task</button>
				
                <h5>Tasks for  <span id="curDate"><?php echo " $curDate "; ?></span></h5>
                                                            
            </div>
            
            <div id="task-list-sidebar">
				
				<?php
					
					//instantiate user tasks with reference to DB
					$userTasksObj = new userTasks($DBH); 
					$userID = $_SESSION['userData']['user_id'];
					
					//execute method with date parameters
					$taskItems = $userTasksObj->getTaskItems($userID, $weekStartDate, $weekEndDate); 
					//echo $taskItems . "/n";
				    //echo count($taskItems);
					$temp = $taskItems;
					$temp2 = $temp;
				?>
				    <div class="task-list-container" id="due-container">

						<button class="task-list-head">Due Today</button>

						<div class="task-list-section-container"  id="DueListContainer">
							
							<?php foreach($taskItems as $key => $value) { ?>
							<?php if($value['task_due_date'] == date('Y-m-d')) { ?>
							
								<div class="task-list" name="<?php echo $value['task_priority']; ?>">
									<a class="task-name" id="<?php echo "task" . $value['task_id'] . "Name" ;?>" href="#"><h6><?php echo $value['task_name']; ?></h6></a><br>
									<p class="task-text"><?php echo $value['task_description']; ?></p>
									<p class="task-date-time"><?php echo $value['task_due_date']; ?></p>
									<!-- Get priority and ID -->
									<p id="hiddenPriority" style="display : none"><?php echo $value['task_priority']; ?></p>
									<p id="hiddenID" style="display : none"><?php echo $value['task_id']; ?></p>
								</div>
							<?php }} ?>
							</div>						

                	</div>

				
				<div class="task-list-container" id="high-container">

                    	<button class="task-list-head">High</button>
					
						<div class="task-list-section-container" id="HighListContainer">
							
							<?php foreach($taskItems as $key => $value) { //use fetched results to append task to webpage?>
							<?php if($value['task_priority'] == "High") { ?>
							
								<div class="task-list" id="<?php echo $value['task_id']; ?>">
									<a class="task-name" href="#"><h6><?php echo $value['task_name']; ?></h6></a><br>
									<p class="task-text"><?php echo $value['task_description']; ?></p>
									<p class="task-date-time"><?php echo $value['task_due_date']; ?></p>
									<!-- Get priority and ID -->
									<p id="hiddenPriority" style="display : none"><?php echo $value['task_priority']; ?></p>
									<p id="hiddenID" style="display : none"><?php echo $value['task_id']; ?></p>
								</div>
							<?php }} ?>
						
                		</div>

				</div>
				
				<div class="task-container" id="med-container">

					<button class="task-list-head">Medium</button>

					<div class="task-list-section-container"  id="MediumListContainer">
					
							<?php foreach($taskItems as $key => $value) { //use fetched results to append task to webpage?>
							<?php if($value['task_priority'] == "Medium") { ?>
							
								<div class="task-list" id="<?php echo $value['task_id']; ?>">
									<a class="task-name" href="#"><h6><?php echo $value['task_name']; ?></h6></a><br>
									<p class="task-text"><?php echo $value['task_description']; ?></p>
									<p class="task-date-time"><?php echo $value['task_due_date']; ?></p>
									<!-- Get Priority and ID -->
									<p id="hiddenPriority" style="display : none"><?php echo $value['task_priority']; ?></p>
									<p id="hiddenID" style="display : none"><?php echo $value['task_id']; ?></p>
								</div>
							<?php }} ?>
						
                	</div>

				</div>
				
                <div class="task-list-container" id="low-container">

                    <button class="task-list-head">Low</button>

                    <div class="task-list-section-container"  id="LowListContainer">
						
							<?php foreach($taskItems as $key => $value) { //use fetched results to append task to webpage?>
							<?php if($value['task_priority'] == "Low") { ?>
							
								<div class="task-list" id="<?php echo $value['task_id']; ?>" name="<?php echo $value['task_priority']; ?>">
									<a class="task-name" href="#"><h6><?php echo $value['task_name']; ?></h6></a><br>
									<p class="task-text"><?php echo $value['task_description']; ?></p>
									<p class="task-date-time"><?php echo $value['task_due_date']; ?></p>
									<!-- Get Priority and ID -->
									<p id="hiddenPriority" style="display : none"><?php echo $value['task_priority']; ?></p>
									<p id="hiddenID" style="display : none"><?php echo $value['task_id']; ?></p>
								</div>
							<?php }} ?>
						

                    </div>

                </div>
            </div>

        </div>
            
        <div class="lower-task-nav">
        
                <ul>
                   <li>
                        <button class="btnDeleteTask" id="deleteTask">Delete Task</button>
                    </li>
                    <li>
                        <button class="btnEditTask" id="editTask">Edit Task</button>
                    </li>
                </ul>  
            
        </div>
        
        <div class="task-body col-lg-6 col-sm-10"  style="display : none">
			

			<span class="close" id="mobileClose">&times;</span>
			
            <div id="taskMainBody">
                
				<br><h2 id="taskMainHead"></h2>
                <div id="taskbody-datecontainer">
                    
                    <label>Date:</label>
					 <p id="taskMainDate"></p>
                    
                </div>
                <div id="taskbody-textcontainer">
                    
                    <label>Task details: </label>
                    <p id="taskMainDesc"></p>                  				
					
                </div>
				
				<input type="hidden"  id="taskMainPriority">
				<input type="hidden"  id="taskMainID">

            </div>
			
			<button class="btnFormMobile btnEditTask" id="editTaskMobile">Edit Task</button>
            <button class="btnFormMobile btnDeleteTask" id="deleteTaskMobile">Delete Task</button>

        </div>
</section>
		<div id="newTaskPopupContainer" class="popupForm">
			<div id="newTaskFormContainer" class="popupContent  col-lg-5">
				<h2 id="newTaskFormHeader" class="popupFormHeader">Create New Task</h2>
				<form id="newTaskForm">
					
					<div class="alert-error alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only"></span>
					</div>
					
					<div class="form-group">
						<input id="taskInputName" class="form-control" name="task_name" placeholder="Task Name" />
					</div>
					
					<div class="form-group">
						<textarea id="taskInputDescription" class="form-control" name="task_description" placeholder="Task Description"></textarea>
					</div>
					
					<div class="form-group">
						<input id="taskInputDate" class="form-control" name="task_due_date" type="date"><br>
						<input id="taskInputTime" class="form-control" name="task_due_time" type="time">
					</div>
					
					<div class="form-group">
						<select id="taskInputPriority" class="form-control">
							<option value="High">High</option>
							<option value="Medium" selected>Medium</option>
							<option value="Low">Low</option>
						</select>
					</div>
				
					<input id="newTaskSubmit" class="popoutFormBtn" value="Submit" type="button">
		
					<input id="newTaskCancel" class="popoutFormBtn" value="Cancel" type="button">
				</form>
			</div>
		</div>
		
		<div id="editTaskPopupContainer" class="popupForm">
			<div id="editTaskFormContainer" class="popupContent  col-lg-5">
				<h2 id="editTaskFormHeader" class="popupFormHeader">Edit Task</h2>
				<form id="editTaskForm">
					
					<div class="alert-error alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only"></span>
					</div>
					
					<div class="form-group">
						<input id="editTaskInputName" class="form-control" name="task_name" placeholder="Task Name">
					</div>
					
					<div class="form-group">
						<textarea id="editTaskInputDescription" class="form-control" name="task_description" placeholder="Task Description"></textarea>
					</div>
					
					<div class="form-group">
						<input id="editTaskInputDate" class="form-control" name="task_due_date" type="date"><br>
						<input id="editTaskInputTime" class="form-control" name="task_due_time" type="time">
					</div>
					
					<div class="form-group">
						<select id="editTaskInputPriority" class="form-control">
							<option value="High">High</option>
							<option value="Medium" selected>Medium</option>
							<option value="Low">Low</option>
						</select>
					</div>
				
					<input id="editTaskSubmit" class="popoutFormBtn" value="Submit" type="button">
		
					<input id="editTaskCancel" class="popoutFormBtn" value="Cancel" type="button">
				</form>
			</div>
		</div>
        
