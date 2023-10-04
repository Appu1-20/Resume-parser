<?php 
	include 'includes/session.php';

	if(isset($_POST['uid'])){
		$id = $_POST['uid'];
		
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT * FROM user WHERE uid=:uid");
		$stmt->execute(['uid'=>$uid]);
		$row = $stmt->fetch();
		
		$pdo->close();

		echo json_encode($row);
	}
?>