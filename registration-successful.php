<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>
<?php 
  if (isset($_GET["success"]) && isset($_GET["stud_reg_id"]) ) {
    $success = $_GET["success"];
    $stud_reg_id = urldecode($_GET["stud_reg_id"]);
  }
  if (!isset($_GET["success"]) || !isset($_GET["stud_reg_id"]) || $_GET["stud_reg_id"] == "" || $_GET["success"] == "") {
    redirect_to("students.php");
  }

?>

  <title>Registration Successful</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "students";

  include 'layout/admin-sidebar.php';?>

  <div id="content-wrapper" class="col-md">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin-dashboard.php">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
        <a href="students.php">Students</a>
      </li>
      <li class="breadcrumb-item">
        <a href="register-student.php">Register New Student</a>
      </li>
      <li class="breadcrumb-item active">
        Registration Successful
      </li>
    </ol>
    <h1>Registration Successful</h1>
    <hr>
    <?php
      $student_name = get_student_name($stud_reg_id,$connection);
    ?>
    <div id="success-box" class="text-center">
    <h3>New Student Added!</h3>
    <div class="row">
      <div class="col-md-6"> 
        <div class="card text-center mx-auto" style="width: 25rem;">
          <div class="card-body">
            <i class="fa fa-file" aria-hidden="true"></i>
            <h5 class="card-title">Proceed to Enrollment</h5>
            <a href="<?php echo "process-enrollment.php?stud_reg_id=".urlencode($stud_reg_id); ?>"class="card-link">Enroll <?php echo $student_name; ?></a> <!-- Spit out php here, add the student reg id to the link -->
          </div>
        </div>
      </div>
      <div class="col-md-6"> 
        <div class="card text-center mx-auto" style="width: 25rem;">
          <div class="card-body">
            <i class="fa fa-file-text-o" aria-hidden="true"></i>
            <h5 class="card-title">Register Another Student</h5>
            <a href="register-student.php" class="card-link">Go Back to Registration</a> <!-- Spit out php here, add the student reg id to the link -->
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
 </div> 
  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>

<script src="static/city.js"></script> 

<script>  
window.onload = function() {  

  // ---------------
  // basic usage
  // ---------------
  var $ = new City();
  $.showProvinces("#province");
  $.showCities("#city");

  // ------------------
  // additional methods 
  // -------------------

  // will return all provinces 
  console.log($.getProvinces());
  
  // will return all cities 
  console.log($.getAllCities());
  
  // will return all cities under specific province (e.g Batangas)
  console.log($.getCities("Batangas")); 
  
}
</script>