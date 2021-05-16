 <?php

class project {
	
	//declaring DB
	protected $db =  null;	
	
	//DB constructor
	public function __construct($db) {
		$this->db = $db;
	}
	
		
	//Add new subtask to project
	public function addNewProject($projectName, $projectStartDate, $projectEndDate, $projectTeamID) {
	
		$query = "INSERT into project
						 (project_name, project_start_date, project_end_date, project_team_id)
						 VALUES (:projectName, :projectStartDate, :projectEndDate, :projectTeamID)";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':projectName', $projectName);
		$pdo->bindParam(':projectStartDate', $projectStartDate);
		$pdo->bindParam(':projectEndDate', $projectEndDate);
		$pdo->bindParam(':projectTeamID', $projectTeamID);
		
		$pdo->execute();
		
		return($this->db->lastInsertId());
		
	}
	
	//retrieve project information for form population
	public function getProjectInformation($projectID) {
	
		$query = "SELECT * FROM project
						 WHERE project_id = :projectID";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(":projectID", $projectID);
		
		$pdo->execute();
		$result = $pdo->fetchall();
		echo json_encode($result);
	}
	
	//Edit project information
	public function editProject($projectID, $projectName, $projectStartDate, $projectEndDate) {
					
		$query = "UPDATE project
						 SET project_name=:projectName, project_start_date=:projectStartDate, project_end_date=:projectEndDate
						 WHERE project_id=:projectId";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(":projectName",$projectName);
		$pdo->bindParam(":projectStartDate",$projectStartDate);
		$pdo->bindParam(":projectEndDate", $projectEndDate);
		$pdo->bindParam(":projectId", $projectID);
		
		$pdo->execute();
		
		return $projectID;
		
	}
	
	//delete project
	public function deleteProject($projectID) {
	
		$query = "DELETE FROM project_task
						 WHERE project_id = :projectID;
						 
						 DELETE FROM project
						 WHERE project_id = :projectID";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':projectID', $projectID);
		
		$pdo->execute();
		
		echo $projectID;
		
	}
	
	

	

	
}

?>