<?php include('functions.php') ?>
<?php display_error(); ?>

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
	<section>
		<!-- <div class="imgBx">
			<img src="images/sign.jpg">
		</div> -->
		<div class="contentBx">
			<div class="formBx">
				
				<div class="container signin">
		  <form class="form-signin" method="post">
<h2><b><p class="register-box-msg">Register</p></b></h2>
			<label for="inputUsername" class="sr-only">Username</label>
			<input name="uname" type="username" id="inputusername" class="form-control" placeholder="Username" required="" autofocus="">

			<label for="inputEmail" class="sr-only">Email address</label>
			<input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">

			<label for="inputPassword" class="sr-only">New Password</label>
			<input name="upass1" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">

			<label for="inputPassword" class="sr-only">Confirm Password</label>
			<input name="upass2" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">

			<button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Sign up</button>

			<p >Already have an account? <a href="./login.php" class="btn btn-lg btn-primary btn-block" type="submit"> Sign In</a></p>
					
		  </form>
		</div>
			</div>
		</div>
	</section>
</body>
</html>