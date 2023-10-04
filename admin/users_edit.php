<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$uid = $_POST['id'];
		$uname = $_POST['firstname'];
		$lname = $_POST['lastname'];
		$email = $_POST['email'];
		$upass = $_POST['password'];
		// $address = $_POST['address'];
		// $contact = $_POST['contact'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT * FROM user WHERE uid=:uid");
		$stmt->execute(['uid'=>$uid]);
		$row = $stmt->fetch();

		if($upass == $row['upass']){
			// If the provided password is the same as the current one, retain the current password
			$upass = $row['upass'];
		}
		else{
			// If the password has changed, hash the new password
			$upass = password_hash($upass, PASSWORD_DEFAULT);
		}

		try{
			$stmt = $conn->prepare("UPDATE user SET email=:email, upass=:upass, uname=:uname, lname=:lname WHERE uid=:uid");
			$stmt->execute(['email'=>$email, 'upass'=>$upass, 'uname'=>$uname, 'lname'=>$lname, 'uid'=>$uid]);
			$_SESSION['success'] = 'User updated successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit user form first';
	}

	header('location: users.php');
?>
