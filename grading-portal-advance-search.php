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

      <button class="btn btn-primary" data-toggle="collapse" data-target="#advance-search">Advance Search</button>
      <div id="advance-search" class="collapse">
        <form action="grading-portal-advance-search.php">
          <button class="btn btn-primary">Submit</button>
        </form>
      </div>

      <div class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Code</th>";
        echo "   <th class=\"skip-filter\">Description</th>";
        echo "   <th>Course</th>";
        echo "   <th>Year</th>";
        echo "   <th>Semester</th>";
        echo "   <th>Section</th>";
        echo "   <th>Teacher</th>";
        echo "   <th class=\"skip-filter\">Schedule</th>";
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
        echo "<td>".get_teacher_name($row['teacher_id'],"",$connection)."</td>"; 
        $query3 = "SELECT * FROM schedule_block WHERE subject_id='".$subject_id."' ORDER BY day";
        $result3 = mysqli_query($connection, $query3);
        echo "<td><table class=\"table table-sm table-borderless\">";
        while($row3 = mysqli_fetch_assoc($result3))
        {          
          echo "<tr>";
            echo "<td>".number_to_day($row3['day'])."</td>";
            echo "<td>Time: ".date("g:i A", strtotime($row3['time_start']))." - ".date("g:i A", strtotime($row3['time_end']))."</td>";
            echo "<td>Room: ".$row3['room']."</td>";
          echo "</tr>";          
        }
        
        if (mysqli_num_rows($result3) < 1) {
          echo "<td>None: Please create a schedule";
        }
        echo "</table></td>";
        echo "<td><a href=\"encode-grades.php?subject_id=".$subject_id."&term=".urlencode($row['term'])."&year=".urlencode($row['year'])."\">Encode Grades</a></td>";
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

<script type="text/javascript"> 
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#example tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>

