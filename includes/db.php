<?php
//Create session and init database iformation
session_start();
$host = '172.16.11.22:3306';
$dbname = 'gola1_20_nuotask';
$user = 'gola1_nuoadmin';
$pass = 'nuopass123!';

//Create new Database variable as a PDO object
try {
$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
}
//if error return exception
catch(PDOException $e) {
echo $e->getMessage(); 
}
?>