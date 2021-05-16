 <?php

class projectTask {
	
	//declaring DB
	protected $db =  null;	
	
	//DB constructor
	public function __construct($db) {
		$this->db = $db;
	}

	//Get project tasks for projects
	public function getProjectTasks($projectId) {
		
		$query = "SELECT * FROM project_task 
						  WHERE project_id = :projectID";
		
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':projectID', $projectId);
		
		$pdo->execute();
		return $pdo->fetchall();
	}
	
    /* Method for obtaining subtask information through JSON format - outdated
	public function getSubtaskJSON($subtaskID) {
	
		$query = "SELECT * FROM project_task 
						  WHERE project_task_id = :subtaskID";
		
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':subtaskID', $subtaskID);
		
		$pdo->execute();
		$result = $pdo->fetchall();
		echo json_encode($result);
	}*/
	
	//Get all projects for user
	public function getProjects($userId, $userTeamId) {
		
		$query = "SELECT pro.project_Id, pro.project_name, pro.project_start_date, pro.project_end_date 
						 FROM project pro
						 LEFT JOIN user usr ON usr.user_team_id = pro.project_team_id
						 WHERE usr.user_team_id = :userTeamId AND usr.user_id = :userId;";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':userTeamId', $userTeamId);
		$pdo->bindParam(':userId', $userId);
		
		$pdo->execute();
		return $pdo->fetchall();
	
	}
	
	//Add new subtask to project
	public function addNewSubtask($projectId, $subtaskName, $subtaskStartDate, $subtaskEndDate, $subtaskPercent, $subtaskDependency) {
	
		$query = "INSERT into project_task
						 (project_task_name, project_task_start_date, project_task_end_date, project_task_duration, project_task_percent, project_task_dependency, project_id)
						 VALUES (:subtaskName, :subtaskStartDate, :subtaskEndDate, 1, :subtaskPercent, :subtaskDependency, :projectId)";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':subtaskName', $subtaskName);
		$pdo->bindParam(':subtaskStartDate', $subtaskStartDate);
		$pdo->bindParam(':subtaskEndDate', $subtaskEndDate);
		$pdo->bindParam(':subtaskPercent', $subtaskPercent);
		$pdo->bindParam(':subtaskDependency', $subtaskDependency);
		$pdo->bindParam(':projectId', $projectId);
		
		$pdo->execute();
		
		return($this->db->lastInsertId());
		
	}
	
	//update project subtask
	public function editSubtask($subtasktId, $subtaskName, $subtaskStartDate, $subtaskEndDate, $subtaskPercent, $subtaskDependency) {
	
			$query = "UPDATE project_task
						 SET project_task_name=:subtaskName, project_task_start_date=:subtaskStartDate, project_task_end_date=:subtaskEndDate, project_task_duration=1, 							project_task_percent=:subtaskPercent, project_task_dependency=:subtaskDependency
						 WHERE project_task_id=:subtaskId";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':subtaskName', $subtaskName);
			$pdo->bindParam(':subtaskStartDate', $subtaskStartDate);
			$pdo->bindParam(':subtaskEndDate', $subtaskEndDate);
			$pdo->bindParam(':subtaskPercent', $subtaskPercent);
			$pdo->bindParam(':subtaskDependency', $subtaskDependency);
			$pdo->bindParam(':subtaskId', $subtasktId);
			
			$pdo->execute();
		
			return $subtaskId;
	}
	
	//delete project subtask
	public function deleteSubtask($subtaskID) {
	
		$query = "DELETE FROM project_task
					  WHERE project_task_id = :subtaskID";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':subtaskID', $subtaskID);
		
		$pdo->execute();
		
		return 1;
		
	}
	

	

	
}

?>