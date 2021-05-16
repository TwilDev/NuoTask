 <?php

class userTasks {
	
	//declaring DB
	protected $db =  null;	
	
	//DB constructor
	public function __construct($db) {
		$this->db = $db;
	}
	
	//Add new task
	public function addNewTask($taskName, $taskDescription, $taskDueDate, $taskDueTime, $taskPriority, $taskUserID) {
		
		$query = "INSERT INTO task 
						(task_name, task_description, task_due_date, task_due_time, task_priority, task_user_id) 
						VALUES (:taskName, :taskDescription, :taskDueDate, :taskDueTime, :taskPriority, :taskUserID)";
		
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':taskDueTime', $taskDueTime);
		$pdo->bindParam(':taskUserID', $taskUserID);
		$pdo->bindParam(':taskPriority', $taskPriority);
		$pdo->bindParam(':taskDueDate', $taskDueDate);
		$pdo->bindParam(':taskDescription', $taskDescription);
		$pdo->bindParam(':taskName', $taskName);
		
		$pdo->execute();
		
		return($this->db->lastInsertId());
	}
	
	//Get list of upcoming tasks for the current week 
	public function getTaskItems($userID, $startDate, $endDate) {
		
		$query = "SELECT * FROM task 
						  WHERE task_user_ID = :userID
						  AND task_due_date >= :startDate
						  AND task_due_date <= :endDate";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':userID', $userID);
		$pdo->bindParam(':startDate', $startDate);
		$pdo->bindParam(':endDate', $endDate);
		
		$pdo->execute();
		
		return $pdo->fetchall();
	}
	
    //Edit task information
	public function editTask($taskID, $taskName, $taskDescription, $taskDueDate, $taskDueTime, $taskPriority, $taskUserID) {
		
		$query = "UPDATE task
						 SET task_name=:taskName, task_description=:taskDescription, task_priority=:taskPriority, task_due_date=:taskDueDate, task_due_time=:taskDueTime
						 WHERE task_id=:taskID ";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':taskDueTime', $taskDueTime);
		$pdo->bindParam(':taskPriority', $taskPriority);
		$pdo->bindParam(':taskDueDate', $taskDueDate);
		$pdo->bindParam(':taskDescription', $taskDescription);
		$pdo->bindParam(':taskName', $taskName);
		$pdo->bindParam(':taskID', $taskID);
		
		$pdo->execute();
		
		return $taskID;
		
	}
	
    //Delete task from Database
	public function deleteTask($taskID) {
		
		$query = "DELETE FROM task
					  WHERE task_id = :taskID";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':taskID', $taskID);
		
		$pdo->execute();
		
		return 5;
	
	}
	
}

?>