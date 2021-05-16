<?php 
//Initial Validation

//if values are empty
if(!$_POST['email'] || !$_POST['password'] || !$_POST['name']){
	//return error
	$error = "Please fill in all forms";
//if password is less than 8 characters
} else if (strlen($_POST['password']) < 8){
	//return error
	$error = "password must be 8 characters or longer";
//if password does not have a number
} else if (!preg_match('/[0-9]/', $_POST['password'])) {
	//return error
	$error = "password must include a number";
//if password does not have either a lower case letter or upper case letter
} else if (!preg_match('/[A-Z]/', $_POST['password']) && !preg_match('/[a-z]/')) {
	//return error
	$error = "password must include an upper case letter";
}


if(!$error) {
	//No error creating account
	$error = "";
	
	//encrypt with salt
	$encryptedPass = password_hash($_POST['password'], PASSWORD_DEFAULT);
	
	//Insert into DB
	$query = "INSERT INTO team (team_name) VALUES (:teamname)";
	$result=$DBH->prepare($query);
	//binding values
	$result->bindParam(':teamname', $_POST['teamname']);
	//execute
	$result->execute();
	
	//get inserted team ID
	$id = $DBH->lastInsertId();
	echo $id;
	
	//Insert into DB
	$query = "INSERT INTO user (user_email, user_name, user_password, user_team_id) VALUES (:email, :name, :password, :userteamid)";
	$result=$DBH->prepare($query);
	//binding values
	$result->bindParam(':email', $_POST['email']);
	$result->bindParam(':name', $_POST['name']);
	$result->bindParam(':password', $encryptedPass);
	$result->bindParam(':userteamid', $id);
	//execute
	$result->execute();
	
	//send user to logon page to create session
	echo "<script> window.location.assign('index.php?p=login '); </script>";

}

?>

 
    <div class="col-lg-6" id="signin-header-container">
    
		<h1><a href="index.php?p=home">NuoTask</a></h1>
		
	</div>
	
	<div id="signin-form-container">
	
	<form method="post" action="index.php?p=register" id="login-form-actual">
			
		 <div class="signin-form-group">
			 <h1 class="mobile-signin-head" ><a href="index.php?p=home">NuoTask</a></h1>
             <h2>Sign up</h2>
			
			 <?php
						if($error) {
							echo '<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							'.$error.'
							</div>'; 
						}
				?>
                
			<div id="signin-input-container">

				<input type="email" class="form-control" id="email" name="email" placeholder="Email"><br>
				
				<input type="text" class="form-control" id="name" name="name" placeholder="Name"><br>
				
				<input type="text" class="form-control" id="teamname" name="teamname" placeholder="Team Name"><br>

				<input type="password" class="form-control" id="password" name="password" placeholder="Password"><br>

				 <button type="submit" class="btn btn-lg" id="signin-btn">Sign up</button>
				
				 <p>Already a member? Click <a class="signin-redirect" href="index.php?p=login">here</a>!</p>
				


			</div>
			 
		</div>
			 
	</form>
	
</div> 

