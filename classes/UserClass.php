<?php

class User {
	
	protected $db = null;

	public function __construct($db){

				$this->db = $db;

			}

	public function checkLoginRequest($email, $password){

		//GET User from database

		$query = "SELECT * FROM user WHERE user_email = :email";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':email', $email);
		$pdo->execute();
		
		$user = $pdo->fetch(PDO::FETCH_ASSOC);


		//CHECK user against results
		
		//if no value is found
		if(empty($user)){

			return false;
		//if value is found test using result from DB using password_verify function
		}else if(password_verify($password, $user['user_password'])){

			return $user;

		}else{

			return false;

		}

}
	
public function checkUserInfo($email, $password) {
	

		$query = "SELECT * FROM user WHERE user_email = :email";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':email', $email);
		$pdo->execute();
		
		$user = $pdo->fetch(PDO::FETCH_ASSOC);

		if(password_verify($password, $user['user_password'])){
			
			return true;
		
		} else {
		
			return 0;
			
		}
}

//Edit user information
public function editUserInfo($id, $email, $name, $password) {

	$query = "UPDATE user 
					 SET user_email=:email, user_name=:name, user_password=:password
					 WHERE user_id=:id";
	$pdo = $this->db->prepare($query);
	$pdo->bindParam(':email', $email);
	$pdo->bindParam(':name', $name);
	$pdo->bindParam(':password', $password);
	$pdo->bindParam(':id', $id);
	
	$pdo->execute();
	
	return $id;
}

//Change password from MyAccount
public function editUserPass($userID, $password) {
	
	$query = "UPDATE user
					SET user_password=:password
					WHERE user_id=:userid";
	$pdo = $this->db->prepare($query);
	$pdo->bindParam(':password', $password);
	$pdo->bindParam(':userid', $userID);
	
	$pdo->execute();
	
	return "Password reset successfully";

}

//Get user information for profile page
public function getUserInfo($userID) {

		$query = "SELECT * FROM user WHERE user_id = :userid";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':userid', $userID);
		$pdo->execute();
		
		return $pdo->fetchall();
}



}

?>