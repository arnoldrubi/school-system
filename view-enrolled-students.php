<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>View Enrolled Students</title>
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
          View Enrolled Students
        </li>
      </ol>
      <h1>View Enrolled Students</h1>
      <hr>
      <div class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th class=\"skip-filter\">Student Number</th>";
        echo "   <th class=\"skip-filter\">Last Name</th>";
        echo "   <th class=\"skip-filter\">First Name</th>";
        echo "   <th class=\"skip-filter\">Middle Name</th>";
        echo "   <th>Course</th>";
        echo "   <th>Year</th>";
        echo "   <th>Section</th>";
        echo "   <th>S.Y.</th>";
        echo "   <th>Semester</th>";
        echo "   <th>Regular/Irregular</th>"; 
        echo "   <th class=\"skip-filter\">&nbsp;</th>";
        echo "   <th class=\"skip-filter\">&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT enrollment.stud_reg_id,enrollment.student_id, enrollment.student_number, enrollment.course_id, enrollment.year, enrollment.sec_id, enrollment.school_yr, enrollment.term, enrollment.irregular, students_reg.last_name, students_reg.first_name, students_reg.middle_name FROM enrollment INNER JOIN students_reg ON enrollment.stud_reg_id=students_reg.stud_reg_id ORDER BY last_name ASC";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        $student_number = $row['student_number'];
        $stud_reg_id = $row['stud_reg_id'];
        $student_id = $row['student_id']; 
        echo "<td>".$student_number."</td>";
          echo "<td>".$row['last_name']."</td>";
          echo "<td>".$row['first_name']."</td>";
          echo "<td>".$row['middle_name']."</td>";

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
        $section = get_section_name($row['sec_id'],"",$connection);
        $sec_id = $row['sec_id'];

        echo "<td>".$year."</td>"; 
        echo "<td>".$section."</td>"; 
        echo "<td>".$sy."</td>";      
        echo "<td>".$term."</td>";
        if ($row['irregular'] == 1) {
          $regirreg = "Irregular Student" ;
        }
        else{
          $regirreg = "Regular Student" ;
        }
        echo "<td>".$regirreg."</td>";
        echo "<td style=\"text-align:center\">";
        echo "<a title=\"Delete Enrollment Info\" href=\"javascript:confirmDelete('delete-student-enrollment.php?student_id=".$student_id."&student_reg_id=".$stud_reg_id."&course_id=".$new_course_id."&sy=".urlencode($sy)."&term=".urlencode($term)."&year=".$year."&sec_id=".urlencode($sec_id)."&irregular=".urlencode($row['irregular'])."')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td>";
        echo "<td style=\"text-align:center\">";
        echo "<a title=\"Print Enrollment Form\" target=\"_blank\" href=\"print-enrollment-form.php?student_reg_id=".urlencode($stud_reg_id)."&irregular=".urlencode($row['irregular'])."\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a></td>";
        echo "</tr>";
        }

        echo "</tbody></table>"; 
      ?>

      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning:</strong> Deleting enrollment data will also delete all grades associated with it.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
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

  $('#dataTable').ddTableFilter();

});
</script>