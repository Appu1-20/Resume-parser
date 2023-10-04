<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$uname = $_POST['uname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$upass = $_POST['upass'];
		// $address = $_POST['address'];
		// $contact = $_POST['contact'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM user WHERE email=:email");
		$stmt->execute(['email'=>$email]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Email already taken';
		}
		else{
			$password = password_hash($upass, PASSWORD_DEFAULT);
			$filename = $_FILES['photo']['name'];
			$now = date('Y-m-d');
			if(!empty($filename)){
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
			}
			try{
				$stmt = $conn->prepare("INSERT INTO user (email, password, firstname, lastname, photo, status, created_on) VALUES (:email, :upass, :uname, :lname, :photo, :status, :created_on)");
				$stmt->execute(['email'=>$email, 'password'=>$upass, 'firstname'=>$uname, 'lastname'=>$lname,  'photo'=>$filename, 'status'=>1, 'created_on'=>$now]);
				$_SESSION['success'] = 'User added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up user form first';
	}

	header('location: users.php');

?>