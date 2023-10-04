<?php
	$page="index";
	require("header.php");
	
	if(isset($_POST['profilePicSubmit'])) {
		$target = "../images/".$_FILES['profilepic']['name'];
		$datatarget = "images/".$_FILES['profilepic']['name'];
		if(!move_uploaded_file($_FILES['profilepic']['tmp_name'],$target))
		{
			echo "Sorry can't upload file....";	
		}
		else
		{
			$query="update personal set image='$datatarget' where uid=".$_SESSION['user']['uid'];
			mysqli_query($link,$query) or die("Error updating data.".mysqli_error($link));
		}
	}
	if(isset($_POST['fName'])) {
		$fname=$_POST['fName'];
		$lname=$_POST['lName'];
		$uid=$_SESSION['user']['uid'];
		$designation=$_POST['designation'];
		$query = "INSERT INTO personal (fname, lname, designation, uid) 
                  VALUES('$fname', '$lname', '$designation', $uid)";
                  // echo $query;die;
		// $query="insert INTO personal set fname=".$fname.", lname=".$lname.", designation=".$designation." , uid=".$_SESSION['user']['uid'];
		// echo $query;die;
		mysqli_query($link,$query) or die("Error updating data.".mysqli_error($link));
	}
	if(isset($_POST['contactInfo'])) {
		$phone=$_POST['phone'];
		$email=$_POST['email'];
		$web=$_POST['web'];
		
		$query="update personal set phone='$phone', email='$email', website='$web' where uid=".$_SESSION['user']['uid'];
		mysqli_query($link,$query) or die("Error updating data.".mysqli_error($link));
	}
	if(isset($_POST['basicInfo'])) {
		$pagedata=$_POST['info'];
		$query="update pages set data='$pagedata' where pid=1";
		mysqli_query($link,$query) or die("Error updating data.".mysqli_error($link));
	}
	if(isset($_POST['social'])) {
		$facebook=$_POST['facebook'];
		$twitter=$_POST['twitter'];
		$googleplus=$_POST['googleplus'];
		$instagram=$_POST['instagram'];
		$query="update social set facebook='$facebook', twitter='$twitter', googleplus='$googleplus', instagram='$instagram' where uid=1";
		mysqli_query($link,$query) or die("Error updating data.".mysqli_error($link));
	}
?>
			<div class="row">
				<?php
					$query="select * from personal where uid=".$_SESSION['user']['uid'];
					$result=mysqli_query($link,$query) or die("Error fetching data.".mysqli_error($link));
					$personaldetails=mysqli_fetch_assoc($result);
					mysqli_free_result($result);
				?>
				<div class="col-md-10 col-md-offset-1">
					<form method="post" enctype="multipart/form-data" class="form-inline">
						<div class="form-group ">
							<img src="../<?= isset($personaldetails['image']) ? $personaldetails['image']: ''; ?>" class="img-thumbnail"/>
						</div>
						<div class="form-group ">
							<input id="profilePhotoIn" type="file" name="profilepic">
							<button type="submit" class="btn btn-primary" id="profilePhotoBtn" name="profilePicSubmit">Submit</button>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 col-md-offset-1">
				<form method="post">
					<div class="form-group">
					  <div class="input-group">
						<span class="input-group-addon">First Name</span>
						<input type="text" class="form-control" name="fName" value="<?= ucfirst(isset($personaldetails['fname']) ? $personaldetails['fname'] : ''); ?>">
					  </div>
					</div>
					<div class="form-group">
					  <div class="input-group">
						<span class="input-group-addon">Last Name</span>
						<input type="text" class="form-control" name="lName" value="<?= ucfirst(isset($personaldetails['lname']) ? $personaldetails['lname'] : ''); ?>">
					  </div>
					</div>
					<div class="form-group">
					  <div class="input-group">
						<span class="input-group-addon">Designation</span>
						<input type="text" class="form-control" name="designation" value="<?= ucfirst(isset($personaldetails['designation']) ? $personaldetails['designation'] : ''); ?>">
					  </div>
					</div>
					<div class="form-group clearfix">
						<button type="submit" class="btn btn-success pull-right" name="userInfo">Update</button>
					</div>
				</form>
				</div>
				<div class="col-md-5">
				<form method="post">
					<div class="form-group">
					  <div class="input-group">
						<span class="input-group-addon">Phone Number</span>
						<input type="text" class="form-control" name="phone" value="<?= isset($personaldetails['phone']) ? $personaldetails['phone'] : ''; ?>">
					  </div>
					</div>
					<div class="form-group">
					  <div class="input-group">
						<span class="input-group-addon">Mail ID</span>
						<input type="text" class="form-control" name="email" value="<?= isset($personaldetails['email']) ? $personaldetails['email'] : ''; ?>">
					  </div>
					</div>
					<div class="form-group">
					  <div class="input-group">
						<span class="input-group-addon">Website</span>
						<input type="text" class="form-control" name="web" value="<?= isset($personaldetails['website']) ? $personaldetails['website'] : ''; ?>">
					  </div>
					</div>
					<div class="form-group clearfix">
						<button type="submit" class="btn btn-success pull-right" name="contactInfo">Update</button>
					</div>
				</form>
				</div>
			</div>	
			<div class="row">
				<?php
					$query="select * from pages where page='home'";
					$result=mysqli_query($link,$query) or die("Error fetching data.".mysqli_error($link));
					$homecontent=mysqli_fetch_assoc($result);
					mysqli_free_result($result);
				?>
				<div class="col-md-10 col-md-offset-1">
				<form method="post">
					<h4>Basic Information</h4>
					<div class="form-group">
						<textarea class="form-control" rows="10" name="info" id="myInfo"><?= isset($homecontent['data'])?$homecontent['data']:''; ?></textarea>
					</div>
					<div class="form-group clearfix">
						<button type="submit" class="btn btn-success pull-right" name="basicInfo">Update</button>
					</div>
				</form>
				</div>
			</div>
			<div class="row">
				<?php
					$query="select * from social where uid=1";
					$result=mysqli_query($link,$query) or die("Error fetching data.".mysqli_error($link));
					$socialdetails=mysqli_fetch_assoc($result);
					mysqli_free_result($result);
				?>
				<div class="col-md-10 col-md-offset-1">
				<form method="post">
					<h4>Social Links</h4>
					<div class="form-group">
					  <div class="input-group">
						<span class="input-group-addon">Facebook</span>
						<input type="text" class="form-control" name="facebook" value="<?= isset($socialdetails['facebook'])?$socialdetails['facebook']:''; ?>">
					  </div>
					</div>
					<div class="form-group">
					  <div class="input-group">
						<span class="input-group-addon">Twitter</span>
						<input type="text" class="form-control" name="twitter" value="<?= isset($socialdetails['twitter'])?$socialdetails['twitter']:''; ?>">
					  </div>
					</div>
					<div class="form-group">
					  <div class="input-group">
						<span class="input-group-addon">Google+</span>
						<input type="text" class="form-control" name="googleplus" value="<?= isset($socialdetails['googleplus'])?$socialdetails['googleplus']:''; ?>">
					  </div>
					</div>
					<div class="form-group">
					  <div class="input-group">
						<span class="input-group-addon">Instagram</span>
						<input type="text" class="form-control" name="instagram" value="<?= isset($socialdetails['instagram'])?$socialdetails['instagram']:''; ?>">
					  </div>
					</div>
					<div class="form-group clearfix">
						<button type="submit" class="btn btn-success pull-right" name="social">Update</button>
					</div>
				</form>
				</div>
			</div>
<?php
	require("footer.php");
?>