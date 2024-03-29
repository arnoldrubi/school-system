<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Manual Enrollment for Irregular Students</title>
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
        <li class="breadcrumb-item active">
            Manual Enrollment for Irregular Students
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          Manual Enrollment for Irregular Students</div>
          <div class="card-body">
            <div class="table-responsive" id="dataTable_wrapper">
            <?php

              echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
              echo " <thead>";
              echo "  <tr>";
              echo "   <th>Student Number</th>";
              echo "   <th>First Name</th>";
              echo "   <th>Middle Name</th>";
              echo "   <th>Last Name</th>";
              echo "   <th>Course</th>";
              echo "   <th>Year</th>";
              echo "   <th>S.Y.</th>";
              echo "   <th>Semester</th>"; 
              echo "   <th>Options</th>"; 
              echo "  </tr></thead><tbody>";
              
              

              $query  = "SELECT * FROM enrollment WHERE irregular = 1 ORDER BY school_yr DESC, term ASC";
              $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result))
              {
              $student_number = $row['student_number'];
              $stud_reg_id = $row['stud_reg_id'];
              $student_id = $row['student_id']; 

              echo "<tr>";
              echo "<td>".$student_number."</td>";
              $query2 = "SELECT last_name, first_name, middle_name FROM students_reg WHERE stud_reg_id='".$stud_reg_id."'";
              $result2 = mysqli_query($connection, $query2);
              while($row2 = mysqli_fetch_assoc($result2))
              {
                echo "<td>".$row2['first_name']."</td>";
                echo "<td>".$row2['middle_name']."</td>";
                echo "<td>".$row2['last_name']."</td>";
              }

              $new_course_id = $row['course_id'];

              $query3 = "SELECT course_code FROM courses WHERE course_id='".$new_course_id."'";
              $result3 = mysqli_query($connection, $query3);
              while($row3 = mysqli_fetch_assoc($result3))
              {
                echo "<td>".$row3['course_code']."</td>";
              }

              $year = $row['year'];
              $sy = $row['school_yr'];
              $term = $row['term'];

              echo "<td>".$year."</td>"; 
              echo "<td>".$sy."</td>";      
              echo "<td>".$term."</td>";

              //only display the "Assign Subject" link to irreg students that have subjects enrolled

              echo "<td class=\"options-td\"><a class=\"btn btn-success btn-sm\" href=\"assign-subjects-irreg-student.php?regid=".$stud_reg_id."&student_num=".$student_number."&course=".$new_course_id."&year=".urlencode($year)."&sy=".urlencode($sy)."&term=".urlencode($term)." \">Manage Subjects</a>";

              $query_check  = "SELECT * FROM student_grades WHERE stud_reg_id = '".$stud_reg_id."' AND course_id='".$new_course_id."' AND year = '".$year."' AND term = '".$term."' AND school_yr='".$sy."'";
              $result_check = mysqli_query($connection, $query_check);

              echo "</td>";
              echo "</tr>";
              }

              echo "</tbody></table>"; 
            ?>
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