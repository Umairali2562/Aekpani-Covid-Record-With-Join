<?php
	$servername = "localhost";
	$username = "autopa14_wp17";
	$password = "scnHPM8uOGyD";
	$database = "autopa14_wp17";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
?>