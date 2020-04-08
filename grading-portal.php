<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Grading Portal</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "grading";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">
         Grading Portal
        </li>
      </ol>
      <h1>View Available Subjects</h1>

<!-- search form in php, something we can use later if the simple dropdown search won't get approved by the panel      <button class="btn btn-primary" data-toggle="collapse" data-target="#advance-search">Advance Search</button>
      <div id="advance-search" class="collapse">
        <form action="grading-portal-advance-search.php">
          <p><i style="height: 16px; width: 16px;" class="fa fa-eye" aria-hidden="true"></i>Filter by:</p>
          <div class="form-group row">
            <label class="col-md-1 col-form-label" for="Course">Course:</label>
            <div class="col-md-2">
              <select class="form-control" name="course">
                <option value="1">BSCRIM</option>
                <option value="2">BSED</option><option value="3">BEED</option><option value="4">BAMS</option>
              </select>
            </div>
            <label class="col-md-1 col-form-label" for="Year">Year:</label>
            <div class="col-md-2">
              <select class="form-control" name="year">
                <option value="1">BSCRIM</option>
                <option value="2">BSED</option><option value="3">BEED</option><option value="4">BAMS</option>
              </select>
            </div>
            <label class="col-md-1 col-form-label" for="Term">Term:</label>
            <div class="col-md-2">
              <select class="form-control" name="term">
                <option value="1">BSCRIM</option>
                <option value="2">BSED</option><option value="3">BEED</option><option value="4">BAMS</option>
              </select>
            </div>
            <label class="col-md-1 col-form-label" for="Section">Section:</label>
            <div class="col-md-2">
              <select class="form-control" name="section">
                <option value="1">BSCRIM</option>
                <option value="2">BSED</option><option value="3">BEED</option><option value="4">BAMS</option>
              </select>
            </div>
         </div>
        <button class="btn btn-primary">Submit</button>
        </form>
      </div> -->

      <div class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered\" id=\"dataTable2\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Code</th>";
        echo "   <th class=\"skip-filter\">Description</th>";
        echo "   <th>Course</th>";
        echo "   <th>Year</th>";
        echo "   <th>Semester</th>";
        echo "   <th>Section</th>";
        echo "   <th>Teacher</th>";
        echo "   <th class=\"skip-filter\">&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT DISTINCT course_id,subject_id, year, term, section, teacher_id FROM student_grades";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";

        $subject_id = $row['subject_id'];

        $query2 = "SELECT subject_name, subject_code FROM subjects WHERE subject_id='".$subject_id."'";
        $result2 = mysqli_query($connection, $query2);
        while($row2 = mysqli_fetch_assoc($result2))
        {
          echo "<td>".$row2['subject_code']."</td>";
          echo "<td>".$row2['subject_name']."</td>";
        }
        echo "<td>".get_course_code($row['course_id'],"",$connection)."</td>"; 
        echo "<td>".$row['year']."</td>"; 
        echo "<td>".$row['term']."</td>"; 

        if ($row['section'] == "N/A") {
           echo "<td>N/A (Irregular Students)</td>"; 
        }
        else{
        echo "<td>".$row['section']."</td>"; 
        }
        if ($row['teacher_id'] == "") {
        echo "<td><small>No teacher assigned. Used the scheduling menu to assign a teacher to this subject.</small></td>"; 
        }
        else{
        echo "<td>".get_teacher_name($row['teacher_id'],"",$connection)."</td>"; 
       }
        echo "<td><a href=\"encode-grades.php?subject_id=".$subject_id."&term=".urlencode($row['term'])."&course_id=".urlencode($row['course_id'])."&year=".urlencode($row['year'])."&section=".urlencode($row['section'])."&teacher_id=".urlencode($row['teacher_id'])."\">Encode Grades</a></td>";
        echo "</tr>";
        }

        echo "</tbody></table>"; 
      ?>


     </div>
    </div>
  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>
<?php include 'layout/footer.php';?>

<script src="static/lisenme.js"></script>

<script type="text/javascript"> 
$(document).ready(function(){

  $('#dataTable2').ddTableFilter();

  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#example tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>

