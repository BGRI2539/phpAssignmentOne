<?php

$host    = 'localhost';       
$db      = 'assignmentOne';   
$user    = 'root';  
$pass    = 'mysql';  

// Create connection 
$conn = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>