<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Resumes
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Resumes</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
          
            <div class="box-body">
              <table class="table table-bordered" id="resumeList">
                                <thead>
                                  <tr>
                                    <th>S.No</th>
                                    <th>File Name</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Skills</th>
                                    <th>Language</th>
                                    <th>Experience</th>
                                    <th>Education</th>
                                    <th>Projects</th>
                                    
                                  </tr>
                                </thead>
                                <tbody>
                              <?php
                              $conn = $pdo->open();
                              try{
                                $stmt = $conn->prepare("SELECT * FROM resume "); 
                                $stmt->execute();
                              }catch(PDOException $e){
                                echo $e->getMessage();
                              }

                              $pdo->close();
                                            $i = 1;
                                            foreach ($stmt as $resume) {
                                                ?><tr><?php
                                                ?><td><?php echo $i;
                                                $i++;
                                                ?></td><?php
                                                ?><td><a href="../users/<?php echo $resume['filename'] ?>" target="_blank"><?php echo $resume['filename'];
                                                ?></a></td><?php
                                                ?><td>
                                                  <a href="view.php?id=<?php echo $resume['id'] ?>">
                                                  <?php echo $resume['Name'];
                                                ?>
                                                  </a>

                                                </td><?php
                                                ?><td><?php echo $resume['Contact'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Address'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Skills'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Language'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Experience'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Education'];
                                                ?></td><?php 
                                                ?><td>
                                <?php echo $resume['Projects'];
                                                ?></tr><?php 

                                            }
                                        ?>
                                </tbody>
                              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
     
  </div>
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/users_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });



});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'users_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.userid').val(response.id);
      $('#edit_email').val(response.email);
      $('#edit_password').val(response.password);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_address').val(response.address);
      $('#edit_contact').val(response.contact_info);
      $('.fullname').html(response.firstname+' '+response.lastname);
    }
  });
}
</script>
</body>
</html>



