<?php
	include 'includes/session.php';
	// var_dump($_POST);die;

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$uname = $_POST['uname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$upass = $_POST['upass'];
		// $address = $_POST['address'];
		// $contact = $_POST['contact'];

		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT * FROM user WHERE uid=:uid");
		$stmt->execute(['uid'=>$uid]);
		$row = $stmt->fetch();

		if($upass == $row['upass']){
			$upass = $row['upass'];
		}
		else{
			$upass = password_hash($upass, PASSWORD_DEFAULT);
		}

		try{
			$stmt = $conn->prepare("UPDATE user SET email=:email, upass=:upass, uname=:uname, lname=:lname, address=:address, contact_info=:contact WHERE uid=:uid");
			$stmt->execute(['email'=>$email, 'upass'=>$upass, 'uname'=>$uname, 'lname'=>$lname, 'address'=>$address, 'contact'=>$contact, 'id'=>$id]);
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