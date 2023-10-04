<style>
    .button {
  position: absolute; /* set button to an absolute position */
  top: 50%; /* adjust the top position of the button */
  left: 40%; /* adjust the left position of the button */
  transform: translate(-50%, -50%); /* center the button */
  z-index: 2; /* set a higher z-index than the image */
  background-color: #007bff; /* set your desired background color */
  color: #fff; /* set your desired text color */
  border: none; /* remove button border */
  padding: 10px 20px; /* set your desired padding */
  cursor: pointer; /* change mouse cursor on hover */
}

 .button1 {
  position: absolute; /* set button to an absolute position */
  top: 50%; /* adjust the top position of the button */
  left: 60%; /* adjust the left position of the button */
  transform: translate(-50%, -50%); /* center the button */
  z-index: 2; /* set a higher z-index than the image */
  background-color: #007bff; /* set your desired background color */
  color: #fff; /* set your desired text color */
  border: none; /* remove button border */
  padding: 10px 20px; /* set your desired padding */
  cursor: pointer; /* change mouse cursor on hover */
}
</style>

<?php include 'functions.php'; ?>
<?php  $page="home"; 
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: users/login.php');
    }
    
?>
<?php include 'header.php'; ?>
<?php
function reArrayFiles(&$file_post)
{
    $file_ary = [];
    $file_count = count($file_post['filename']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

if (isset($_POST) && isset($_POST['Do'])) {
    $target_dir = 'resume/';
    if (!is_dir($target_dir)) {
        mkdir('resume');
    }
    $glob = glob('resume/*.*');
    $glob = sprintf('%02d', count($glob) + 1);
    $files = reArrayFiles($_FILES['offer-main']);
    $details = [];
    foreach ($files as $fileToUpload) {
        // $fileToUpload = $_FILES['offer-main'];
        $do = 'offer-main-form';

        $uploadOk = 1;
        $imageFileType = pathinfo($fileToUpload['filename'], PATHINFO_EXTENSION);
        $target_file = $target_dir.$glob.'-'.$fileToUpload['filename'];

        $check = getimagesize($fileToUpload['tmp_name']);
        if ($fileToUpload['size'] > 500000) {
            $msg = 'Sorry, your file is too large.';
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != 'docx' && $imageFileType != 'doc' && $imageFileType != 'xlsx' && $imageFileType != 'pptx' && $imageFileType != 'pdf') {
            $msg = 'Sorry, invalid file type.';
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // $msg = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($fileToUpload['tmp_name'], $target_file)) {
                $msg = 'The Resume has been uploaded.';

                if ($imageFileType == 'pdf') {
                    $pdfObj = new PdfParser();
                    $resumeText = $pdfObj->parseFile($target_file);
                    // $resumeText = $pdfObj->getText();
                } else {
                    $docObj = new DocxConversion($target_file);
                    $resumeText = $docObj->convertToText();
                }

                    }
                }

                
        }
    }


?>

<body class="hold-transition skin-blue layout-top-nav">

    <div class="wrapper">

        <div class="content-wrapper">
            <div class="container">

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
							if (isset($_SESSION['error'])) {
								echo "
	        					<div class='alert alert-danger'>
	        						" . $_SESSION['error'] . "
	        					</div>
	        				";
								unset($_SESSION['error']);
							}
							?>

                            
                                <div class="carousel-inner">
                                    <div class="item active" >
                                        <img  src="../images/bg.jpg" width="1100" height="900" a>
                                        <div class="form-group text-center">
                                           
                                            <div class="button" onClick="location.href='./index.php'" id="btn-offer-main">Create Resume</div>&nbsp;&nbsp;&nbsp;
                                        
                                         <div class="button1">
                                            <input type="file" class="hidden" name="offer-main[]" multiple id="offer-main">
                                            <input type="hidden" name="Do" value="ChangeOfferMain">
                                            <input type="hidden" name="table" value="offer">
                                            <div onclick="$('#offer-main').click()" id="btn-offer-main">Upload Resume</div>
                                            <span id="info-offer-main"></span>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                           
                                                        
            </div>
        </div>     
                                </div>



        <?php include 'footer.php'; ?>
    </div>

</body>



</html>