<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>AIMS Admin Dashboard</title>
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

<?php
// bunch of query getting the total population

// Total Students Enrolled for this term and School Year

  $query_total_students = "SELECT * FROM enrollment WHERE term ='".return_current_term($connection,"")."' AND school_yr='".return_current_sy($connection,"")."'" ;
  $result_total_students = mysqli_query($connection, $query_total_students);

  $total_students_enrolled =mysqli_num_rows($result_total_students);


  $query_total_teachers = "SELECT * FROM teachers WHERE active = 1" ;
  $result_total_teachers = mysqli_query($connection, $query_total_teachers);

  $total_teachers =mysqli_num_rows($result_total_teachers);

  $query_total_classes = "SELECT * FROM classes WHERE term ='".return_current_term($connection,"")."' AND school_yr='".return_current_sy($connection,"")."'" ;
  $result_total_classes = mysqli_query($connection, $query_total_classes);

  $total_classes =mysqli_num_rows($result_total_classes);

  $query_total_courses = "SELECT * FROM courses" ;
  $result_total_courses = mysqli_query($connection, $query_total_courses);

  $total_courses =mysqli_num_rows($result_total_courses);

?>

<h4>Summary</h4>
  <div class="row">

    <div class="col-md-3">
      <div class="dashboard-window clearfix bg-primary-fcat" style="background: #62acec; border-left: 5px solid #019002;">
        <div class="d-w-icon">
          <span class="glyphicon glyphicon-send giant-white-icon"></span>
        </div>
        <div class="d-w-text">
           <span class="d-w-num"><?php echo $total_students_enrolled; ?></span><br>Students Enrolled </div>
      </div>
      </div>

      <div class="col-md-3">
      <div class="dashboard-window clearfix bg-primary-fcat" style="background: #5cb85c; border-left: 5px solid #019002;">
        <div class="d-w-icon">
          <span class="glyphicon glyphicon-wrench giant-white-icon"></span>
        </div>
        <div class="d-w-text">
           <span class="d-w-num"><?php echo $total_teachers; ?></span><br>Teachers </div>
      </div>
      </div>

      <div class="col-md-3">
      <div class="dashboard-window clearfix bg-primary-fcat" style="background: #f0ad4e; border-left: 5px solid #019002;">
        <div class="d-w-icon">
          <span class="glyphicon glyphicon-folder-close giant-white-icon"></span>
        </div>
        <div class="d-w-text">
           <span class="d-w-num"><?php echo $total_classes; ?></span><br>Classes  </div>
      </div>
      </div>

      <div class="col-md-3">
      <div class="dashboard-window clearfix bg-primary-fcat" style="background: #d9534f; border-left: 5px solid #019002;">
        <div class="d-w-icon">
          <span class="glyphicon glyphicon-user giant-white-icon"></span>
        </div>
        <div class="d-w-text">
           <span class="d-w-num"><?php echo $total_courses; ?></span><br>Courses Offered</div>
      </div>
      </div>
    </div>

    <hr>

    <?php include 'layout/admin-menu-dashboard.php';?>

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


  <!-- Page level plugin JavaScript-->
  <script src="static/Chart.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="static/chart-area-demo.js"></script>
  <script src="static/chart-bar-demo.js"></script>
  <script src="static/chart-pie-demo.js"></script>