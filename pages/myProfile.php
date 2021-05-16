
<?php 
//Check page and add class to body to get green background

$var = $_GET['p'];
if ($var == "myProfile") {
	echo "<script>console.log('its my profile');
$(document).ready(function() {

	$('.body').addClass('signin-body');
		
});
</script>";

//Initial Validation

if(!$_POST['password'] || !$_POST['oldPassword']){
	$error = "Please fill in all forms";
} else if (strlen($_POST['password']) < 8){
	$error = "password must be 8 characters or longer";
} else if (!preg_match('/[0-9]/', $_POST['password'])) {
	$error = "password must include a number";
} else if (!preg_match('/[A-Z]/', $_POST['password']) && !preg_match('/[a-z]/')) {
	$error = "password must include an upper case letter";
} 
	
//if no error
if(!$error) {

	//cleanse error
	$error = null;
	
	//Create new user object
	$userObj = new User($DBH);
	//check current pasword inputted is valid
	$passwordCheck = $userObj->checkUserInfo($_SESSION['userData']['user_email'], $_POST['oldPassword']);
	
	//if passwords do not match
	if ($passwordCheck == 0) {
		//create new error
		$error = "Passwords do not match";
	} else {
		//if passwords match encrypt new password with salt
		$encryptedPass = password_hash($_POST['password'], PASSWORD_DEFAULT);
		
		//update password
		echo $passwordEdit = $userObj->editUserPass($_SESSION['userData']['user_id'], $encryptedPass);
		
		$success = "Password updated!";
		
	}
}

}

?>

<div class="signin-body">
    
    <div id="signin-form-container">
        
		<form method="post" action="index.php?p=myProfile">
            <div class="signin-form-group profile-form-group">
                <h2>My Profile</h2>
				
				<?php
						if($error) {
							echo '<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							'.$error.'
							</div>'; 
						}
				?>
				
				<?php
						if($success) {
							echo '<div class="alert alert-success" role="alert">
											<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
											<span class="sr-only">Success:</span>
											'.$success.'
									</div>'; 
						}
				?>
				
                
                <div id="profile-email-input-container">
					
					<?php
						
						//Get user information for viewing
					
						$userID =  $_SESSION['userData']['user_id'];
						$userEmail = $_SESSION['userData']['user_email'];
						$userName = $_SESSION['userData']['user_name'];

					?>
					
                	
					<div class="form-group ">
					<label for="email" class="profileFormLabel" id="emaillabel">Current Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $userEmail; ?>" disabled>	
					</div>
					
					<div class="form-group">
						<label for="name" class="profileFormLabel" id="namelabel">Current Name</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Names" value="<?php echo $userName; ?>" disabled><br>
				
					</div>
					
					<div class="form-group">
						<input type="password" class="form-control" id="Oldpassword" name="oldPassword" placeholder="Old Password"><br>
					
                    	<input type="password" class="form-control" id="password" name="password" placeholder="New Password">
					</div>
					
					<button type="submit" id="changeSubmit" class="btn btn-default">Confirm</button>
                    
                </div>

            </div>
		</form>
    
    </div>
</div>