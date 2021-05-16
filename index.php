<?php

// DB and PHP files
require_once('includes/db.php');
require_once('classes/UserClass.php');
require_once('classes/UserTasksClass.php');



// page check
$var = $_GET['p'];

//If a URL parameter exists
if ($_GET['p']) {
	// header include
	require_once('includes/header.php');

	
	//Go to page defined by variable
	require_once('pages/'.$var.'.php');
} else {
	
	//define default URL
	$url = "https://nuotask.gola1-20.wbs.uni.worc.ac.uk/a1web/?p=home";
	//Goto url
	header("Location: $url");
	
	// header include
	require_once('includes/header.php');

}


// footer include
require_once('includes/footer.php');
?>