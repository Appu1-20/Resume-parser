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
        Jobs List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Jobs List</li>
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
          <div class="box-header with-border">
              <a href="#addnewjobs" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table class="table table-bordered" id="resumeList">
                                <thead>
                                  <tr>
                                    <th>S.No</th>
                                    <th>Job Title</th>
                                    <th>Job Description</th>
                                    <th>Tools</th>
                                  </tr>
                                </thead>
                                <tbody>
                              <?php
                              $conn = $pdo->open();
                              try{
                                $stmt = $conn->prepare("SELECT * FROM jobs "); 
                                $stmt->execute();
                              }catch(PDOException $e){
                                echo $e->getMessage();
                              }

                              $pdo->close();
                                            $i = 1;
                                            foreach ($stmt as $jobs) {
                                                ?><tr><?php
                                                ?><td><?php echo $i;
                                                $i++;
                                                ?></td><?php
                                                ?><?php
                                                ?><td><?php echo $jobs['jtitle'];
                                                ?></td><?php
                                                ?><td><?php echo $jobs['jdes'];
                                                ?></td><?php
                                                ?><td>
                                <button class='btn btn-success btn-sm edit btn-flat' data-id=<?php echo $jobs['jid'] ?> ><i class='fa fa-edit'></i> Edit</button> 
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id=<?php echo $jobs['jid'] ?> ><i class='fa fa-trash'></i> Delete</button>
                            </td><?php
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
    <?php include 'includes/jobs_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var jid = $(this).data('jid');
    getRow(jid);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var jid = $(this).data('jid');
    getRow(jid);
  });

 


});

function getRow(jid){
  $.ajax({
    type: 'POST',
    url: 'jobs_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.jid').val(response.jid);
      $('#edit_jtitle').val(response.jtitle);
      $('#edit_jdes').val(response.jdes);
      
      // $('.fullname').html(response.firstname+' '+response.lastname);
    }
  });
}
</script>
</body>
</html>





