<?php
	include 'includes/session.php';
	if(isset($_POST['edit'])){
		$jid = $_POST['jid'];
		

		try{
			$stmt = $conn->prepare("UPDATE jobs WHERE jid=:id");
			$stmt->execute(['jid'=>$id]);
			$_SESSION['success'] = 'Job updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit job form first';
	}

	header('location: jobs.php');

?>