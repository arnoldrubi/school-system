<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header-faculty.php';?>


  <title>Grading Portal</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php

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
        
        $teacher_id = $_SESSION["teacher_id"];

        $query  = "SELECT DISTINCT course_id,subject_id, year, term, sec_id, teacher_id FROM student_grades WHERE term='".return_current_term($connection,"")."' AND school_yr='".return_current_sy($connection,"")."' AND teacher_id =".$teacher_id;
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

        if ($row['sec_id'] == "0") {
           echo "<td>N/A (Irregular Students)</td>"; 
        }
        else{
        echo "<td>".get_section_name($row['sec_id'],"",$connection)."</td>"; 
        }
        if ($row['teacher_id'] == "") {
        echo "<td><small>No teacher assigned. Used the scheduling menu to assign a teacher to this subject.</small></td>"; 
        }
        else{
        echo "<td>".get_teacher_name($row['teacher_id'],"",$connection)."</td>"; 
       }
        echo "<td><a href=\"faculty-encode-grades.php?subject_id=".$subject_id."&term=".urlencode($row['term'])."&school_yr=".urlencode(return_current_sy($connection,""))."&course_id=".urlencode($row['course_id'])."&year=".urlencode($row['year'])."&section=".urlencode($row['sec_id'])."&teacher_id=".urlencode($row['teacher_id'])."\">Encode Grades</a></td>";
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

