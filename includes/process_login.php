<?php

include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['email'], $_POST['p'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['p']; // The hashed password.
    
    if (login($email, $password, $mysqli) == true) {
        // Login success, sjekker s� om det er admin eller ikke som er logget inn.
        	if($email == ADMIN){
        		header("Location: ../admin.php");
        		exit();
        	}
    		else{
    			header("Location: ../version.php");		
    			exit();
    		}

       // header("Location: ../admin.php");

    } else {
        // Login failed 
        header('Location: ../start.php?error=1');
        exit();
    }
} else {
    // The correct POST variables were not sent to this page. 
    header('Location: ../error.php?err=Could not process login');
    exit();
}