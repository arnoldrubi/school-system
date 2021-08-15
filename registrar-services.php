<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Manage Schedule</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="admin-dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">
           Registrar Services
          </li>
    </ol>
    <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-certificate"></i>
                </div>
                <div class="mr-5">Certificate of Grades</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="request-certificate-of-grades.php">
                <span class="float-left">Go to Certificate of Grades</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-book"></i>
                </div>
                <div class="mr-5">Transfer of Credits</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="view-toc.php">
                <span class="float-left">Transfer of Credits</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
      </div>

    </div>
  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>
<?php include 'layout/footer.php';?>
