<?php
//Check inputs aren't empty
if(isset($_POST['email']) || isset($_POST['password'])){
	if(!$_POST['email'] || !$_POST['password']){
		//return error if EITHER are empty
		$error = "Please enter an email and password";
	}
	//If no error
	if(!$error){
		//get prereq
		require_once('classes/UserClass.php');
		
		//Create new user object
		$usersObj = new User($DBH);
		//Pass POST values over to user object method, result is assigned to checkUser
		$checkUser = $usersObj->checkLoginRequest($_POST['email'], $_POST['password']);
		
		//If checkUser is true
		if($checkUser){
			//User found - create new session
			$_SESSION['loggedin'] = true;
			$_SESSION['userData'] = $checkUser;
			
			//Forward user onto page
		    echo "<script> window.location.assign('index.php?p=yourweek'); </script>";
		}else{
			//If there is an error notify user that EITHER username or password is incorrect, not providing specific details as to which one to avoid security issues
		    $error = "Username/Password Incorrect";
		}
		
	}
}
?>


    <div class="col-lg-6" id="signin-header-container">
    
		<h1><a href="index.php?p=home">NuoTask</a></h1>
    
    </div>
    
    <div id="signin-form-container">
        
        <form method="post" action="index.php?p=login" id="login-form-actual">
        
            <div class="signin-form-group">
				<h1 class="mobile-signin-head" ><a href="index.php?p=home">NuoTask</a></h1>
                <h2>Login</h2>
				
				<?php
						if($error) {
							echo '<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							'.$error.'
							</div>'; 
						}
				?>
                
                <div id="login-email-input-container">
                
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"><br>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <!-- <button type="submit" href="yourweek.html" class="btn btn-lg" id="signin-btn">Sign in</button> -->
					<button type="submit" class="btn btn-default btn-signin">Login</button>
                    <p>Not a member? Click <a class="signin-redirect" href="index.php?p=register">here</a>!</p>
                    
                </div>

            </div>
        
        </form>
    
    </div>
