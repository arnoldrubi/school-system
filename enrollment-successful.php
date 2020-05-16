<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>
<?php 
  if (isset($_GET["success"]) && isset($_GET["stud_reg_id"]) ) {
    $success = $_GET["success"];
    $stud_reg_id = urldecode($_GET["stud_reg_id"]);
    $term = urldecode($_GET["term"]);
    $sy = urlencode($_GET["sy"]);
    $irregular = urlencode($_GET["irregular"]);
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
        <a href="enrollment.php">Enroll Student</a>
      </li>
      <li class="breadcrumb-item active">
        Enrollment Successful
      </li>
    </ol>
    <h1>Enrollment Successful</h1>
    <hr>
    <?php
      $query_stud_reg_id = "SELECT * FROM enrollment WHERE stud_reg_id=".$stud_reg_id;
      $result_stud_reg_id = mysqli_query($connection, $query_stud_reg_id);
       while($row_stud_reg_id = mysqli_fetch_assoc($result_stud_reg_id))
       {
        $student_name = get_student_name($row_stud_reg_id["stud_reg_id"],$connection);
        $course_id = $row_stud_reg_id['course_id'];
        $school_yr = $row_stud_reg_id['school_yr'];
        $section = $row_stud_reg_id['sec_id'];
        $year = $row_stud_reg_id['year'];
        $term = $row_stud_reg_id['term'];
       }
    ?>
    <div id="success-box" class="text-center">
    <h3>New Enrollment Added!</h3>
    <div class="row">
      <div class="col-md-6"> 
        <div class="card text-center mx-auto" style="width: 25rem;">
          <div class="card-body">
            <i class="fa fa-file" aria-hidden="true"></i>
            <h5 class="card-title">Print Enrollment Form for<br> <?php echo $student_name; ?></h5>
            <a target="_blank" href="<?php echo "print-enrollment-form.php?student_reg_id=".urlencode($stud_reg_id)."&irregular=".urlencode($irregular); ?>"class="card-link">Preview</a>
          </div>
        </div>
      </div>
      <div class="col-md-6"> 
        <div class="card text-center mx-auto" style="width: 25rem;">
          <div class="card-body">
            <i class="fa fa-file-text-o" aria-hidden="true"></i>
            <h5 class="card-title">Print Schedule for<br><?php echo get_course_code($course_id,"",$connection).", ".get_section_name($section,"",$connection); ?></h5>
            <?php echo "<a target=\"_blank\" class=\"card-link\" href=\"preview-print-schedule.php?course_id=".$course_id."&year=".urlencode($year)."&term=".urlencode($term)."&section=".urlencode($section)."&sy=".urlencode($school_yr)."\">" ?>Preview</a>
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