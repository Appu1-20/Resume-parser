<!DOCTYPE html>
<?php
	include('users/functions.php'); 
    if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: users/login.php');
	}else{
	header('location: users/homepage.php');
		
	}
  ?>

