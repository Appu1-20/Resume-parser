
<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$jtitle = $_POST['jtitle'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM jobs WHERE jtitle=:jtitle");
		$stmt->execute(['jtitle'=>$jtitle]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Job already exist';
		}
		else{
			$jdes = str_replace(' ', '_', strtolower($jtitle));
			try{
				$stmt = $conn->prepare("INSERT INTO jobs (jtitle, jdes) VALUES (:jtitle, :jdes)");
				$stmt->execute(['jtitle'=>$jtitle, 'jdes'=>$jdes]);
				$_SESSION['success'] = 'Job added successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up job form first';
	}

	header('location: jobs.php');

?>