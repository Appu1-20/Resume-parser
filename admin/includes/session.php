<?php
	include './includes/conn.php';
// $pdo = new PDO("mysql:host='localhost';dbname='myresume'; 'root', '' ");
// $pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	session_start();
	if(!isset($_SESSION['user']['user_type']) == 1){
	// 	echo "<pre>";
	// print_r($_SESSION);die;
	// 	echo 'test';die;
		header('location: ../index.php');
		exit();
	}

	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT * FROM user WHERE uid=:uid");
	$stmt->execute(['uid'=>$_SESSION['user']['uid']]);
	$admin = $stmt->fetch();

	$pdo->close();

?>