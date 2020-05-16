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
            <a href="#">Dashboard</a>
          </li>
    </ol>
    <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-list"></i>
                </div>
                <div class="mr-5">Course Management</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="view-courses.php">
                <span class="float-left">Go to Course Management</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-id-card"></i>
                </div>
                <div class="mr-5">Faculty and Room Management</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="view-teachers-and-rooms">
                <span class="float-left">Go to Faculty and Room Management</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-graduation-cap"></i>
                </div>
                <div class="mr-5">Students</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="view-registered-students.php">
                <span class="float-left">Go to Students Menu</span>
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
                  <i class="fa fa-fw fa-calendar"></i>
                </div>
                <div class="mr-5">Classes and Schedule Management</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="new-group-schedule.php">
                <span class="float-left">Go to Classes and Schedule Management</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-table" aria-hidden="true"></i>
                </div>
                <div class="mr-5">Grading System</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="grading-portal.php">
                <span class="float-left">Go to Students' Grades</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-users"></i>
                </div>
                <div class="mr-5">Users</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="view-users.php">
                <span class="float-left">Manage Users</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-secondary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-list-alt" ></i>
                </div>
                <div class="mr-5">Registrar Services</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="registrar-services.php">
                <span class="float-left">Go to Registar Services</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-dark o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-cogs"></i>
                </div>
                <div class="mr-5">Site Settings</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="site-settings.php">
                <span class="float-left">Manage Settings</span>
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
