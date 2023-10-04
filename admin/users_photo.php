<?php
	include 'includes/session.php';

	if(isset($_POST['upload'])){
		$id = $_POST['uid'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE user SET photo=:photo WHERE uid=:uid");
			$stmt->execute(['photo'=>$filename, 'uid'=>$uid]);
			$_SESSION['success'] = 'User photo updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select user to update photo first';
	}

	header('location: users.php');
?>