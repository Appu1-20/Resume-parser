<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$uid = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM user WHERE uid=:uid");
			$stmt->execute(['uid'=>$uid]);

			$_SESSION['success'] = 'User deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select user to delete first';
	}

	header('location: users.php');
	
?>