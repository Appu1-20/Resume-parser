<?php 
	include 'includes/session.php';

	if(isset($_POST['jid'])){
		$id = $_POST['jid'];
		
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT * FROM jobs WHERE jid=:id");
		$stmt->execute(['jid'=>$jid]);
		$row = $stmt->fetch();
		
		$pdo->close();

		echo json_encode($row);
	}
?>