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
  border: none; /* remove button border */
  padding: 10px 20px; /* set your desired padding */
  cursor: pointer; /* change mouse cursor on hover */
}

.button1 form input[type=submit] {
    width: 116px;
    /* margin: 0 auto; */
    background: #007bff;
    border: none;
    color: white;
    padding: 5px;
    border-radius: 3px;
}

.button1 form{
    display: flex;
    flex-direction: column;
    gap: 10px;
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define the target directory for file uploads
    $target_dir = 'resume/';

    // Create the 'resume' directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir);
    }

    // Loop through the uploaded files
    foreach ($_FILES['offer-main']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['offer-main']['name'][$key];
        $target_file = $target_dir . $file_name;

        // Check if the file already exists
        if (file_exists($target_file)) {
            echo "Sorry, the file $file_name already exists.";
        } else {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['offer-main']['tmp_name'][$key], $target_file)) {
                // print_r( $target_file, true );die;
                // $pythonScript = "test.py";
                try{
                    $command = 'python test2.py '.$target_file;

                    $descriptorspec = array(
                            0 => array('pipe', 'r'), // stdin
                            1 => array('pipe', 'w'), // stdout
                            2 => array('pipe', 'w'), // stderr
                        );

                    // Open the Python script process
                    $process = proc_open($command, $descriptorspec, $pipes);

                    if (is_resource($process)) {
                        // Write the JSON data to the Python script
                         fclose($pipes[0]);

                        // Read the output from the Python script
                        $output = stream_get_contents($pipes[1]);
                        fclose($pipes[1]);

                        // Read the error output from the Python script
                        $error = stream_get_contents($pipes[2]);
                        fclose($pipes[2]);

                        // Close the Python script process
                        $returnValue = proc_close($process);

                        if ($returnValue === 0) {
                            $resumeData = json_decode($output, true);
                            $conn = new mysqli('localhost', 'root', '', 'myresume');
                            
                            // $name = $resumeData["Name"];
                            $name = $resumeData["Name"];
                            $contact = $resumeData["Contact"];
                            $address = $resumeData["Address"];
                            $skills = implode(", ", $resumeData["Skills"]);
                            $language = implode(", ", $resumeData["Language"]);
                            $education = implode(", ", $resumeData["Education"]);
                            $experience = implode(", ", $resumeData["Experience"]);
                            $projects = implode(", ", $resumeData["Projects"]);

                            $sql = "INSERT INTO resume (filename, Name, Contact, Address, Skills, Language, Education, Experience, Projects) 
                                    VALUES ('$target_file','$name', '$contact', '$address', '$skills', '$language', '$education', '$experience', '$projects')";

                            // Perform the insert operation
                            mysqli_query($conn, $sql);
                            
                                
                        } else {
                            // Execution failed, print the error
                            echo 'Error: ' . $error;
                        }
                    } else {
                        echo 'Error: Unable to start Python script.';
                    }
                  


                }catch(Exception $e){
                    file_put_contents( 
                        __DIR__ .'/test.txt', 
                        print_r( $e, true ) . PHP_EOL, FILE_APPEND 
                    );
                }
                echo "The file $file_name has been uploaded successfully.<br>";

                 $command = 'python jobs.py '.$target_file;

                    $descriptorspec = array(
                            0 => array('pipe', 'r'), // stdin
                            1 => array('pipe', 'w'), // stdout
                            2 => array('pipe', 'w'), // stderr
                        );

                    // Open the Python script process
                    $process = proc_open($command, $descriptorspec, $pipes);

                    if (is_resource($process)) {
                        // Write the JSON data to the Python script
                         fclose($pipes[0]);

                        // Read the output from the Python script
                        $output = stream_get_contents($pipes[1]);
                        fclose($pipes[1]);

                        // Read the error output from the Python script
                        $error = stream_get_contents($pipes[2]);
                        fclose($pipes[2]);

                        // Close the Python script process
                        $returnValue = proc_close($process);

                        if ($returnValue === 0) {
                            // $job = ($output, true);
                            print_r($output);
                            
                                
                        } else {
                            // Execution failed, print the error
                            echo 'Error: ' . $error;
                        }
                    } else {
                        echo 'Error: Unable to start Python script.';
                    }


                
            } else {
                echo "Sorry, there was an error uploading your file.";
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
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <input type="file" name="offer-main[]" multiple>
                                                <input type="submit" name="Do" value="Upload Resume">
                                            </form>                                                                                                                                                                                                                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                           
                                                        
            </div>
        </div>     
                                </div>



        <?php include 'footer.php'; ?>
