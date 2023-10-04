<!DOCTYPE html>
<?php 
include('functions.php');
display_error();
?>

<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Signin</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
	</head>
	<body>
		<div class="container signin">
		  <form class="form-signin" method="post">
		

<h2><b><p class="login-box-msg">Login</p></b></h2>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">

			<label for="inputPassword" class="sr-only">Password</label>
			<input name="upass" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">

			<button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>

			<p >Don't have an account? <a href="./register.php" class="btn btn-lg btn-primary btn-block" type="submit"> Sign Up</a></p>
					
		  </form>
		</div>
		<?php
			require_once('dbclose.php');
		?>
	</body>
</html>