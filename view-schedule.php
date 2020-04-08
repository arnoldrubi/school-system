<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Manage Schedule</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "scheduling";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">
         View All Schedule
        </li>
      </ol>
      <h1>View All Schedule</h1>
      <hr>
      <div class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Code</th>";
        echo "   <th class=\"skip-filter\">Subject</th>";
        echo "   <th>Course</th>";
        echo "   <th>Year</th>";
        echo "   <th>Term</th>";
        echo "   <th>Section</th>";
        echo "   <th class=\"skip-filter\">Room</th>";
        echo "   <th class=\"skip-filter\">Teacher</th>";
        echo "   <th class=\"skip-filter\">Day</th>";        
        echo "   <th class=\"skip-filter\">Time Start</th>";
        echo "   <th class=\"skip-filter\">Time End</th>";
        echo "   <th class=\"skip-filter\">Current Students</th>";
        echo "   <th class=\"skip-filter\">Max Students</th>";
        echo "   <th class=\"skip-filter\">&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT * FROM schedule_block ORDER BY day ASC, time_start ASC";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
          $day = number_to_day($row['day']);
          $teacher_name = get_teacher_name($row['teacher_id'],"",$connection);
          echo "<tr>";

          //query that gets the name of the subject using the subject ID from the schedule_block table
          $query2  = "SELECT * FROM subjects WHERE subject_id='".$row['subject_id']."' LIMIT 1";
          $result2 = mysqli_query($connection, $query2);
            while($row2 = mysqli_fetch_assoc($result2)){
              echo "<td>".$row2['subject_code']."</td>"; 
              echo "<td>".$row2['subject_name']."</td>"; 
            }

          //query that gets the name of the course using the course ID from the schedule_block table
          $query3  = "SELECT course_code FROM courses WHERE course_id='".$row['course_id']."' LIMIT 1";
          $result3 = mysqli_query($connection, $query3);
          if (mysqli_num_rows($result3) < 1) {
             echo "<td>&nbsp;</td>";
          }
          else{
            while($row3 = mysqli_fetch_assoc($result3)){
              echo "<td>".$row3['course_code']."</td>"; 
            }
          }
          echo "<td>".$row['year']."</td>";
          echo "<td>".$row['term']."</td>";
          echo "<td>".$row['section']."</td>";
          echo "<td>".$row['room']."</td>";
          echo "<td>".$teacher_name."</td>";
          echo "<td>".$day."</td>";
          echo "<td>".date("g:i A", strtotime($row['time_start']))."</td>";
          echo "<td>".date("g:i A", strtotime($row['time_end']))."</td>";
          echo "<td>".$row['students_enrolled']."</td>";
          echo "<td>".$row['student_limit']."</td>";
          echo "<td><a href=\"edit-schedule.php?schedule_id=".$row['schedule_id']."\"".">Edit Schedule</a> | ";
          echo "<a href=\"javascript:confirmDelete('delete-schedule.php?schedule_id=".$row['schedule_id']."')\"> Delete Schedule</a></td>";
          //echo "<a href=\"delete-schedule.php?schedule_id=".$row['schedule_id']."\""." onclick=\"confirm('Are you sure?')\"> Delete Schedule</a></td>";
          echo "</tr>";
        }

        echo "</tbody></table>"; 
      ?>


      <center>
             <button id="preview-print" class="btn btn-primary hidden-print"><i class="fa fa-table" aria-hidden="true"></i></i> Preview Summary</button>
      </center>
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
  
  $('#preview-print').click(function () {
    window.open("preview-print-schedule-all");
  });
$('#dataTable').ddTableFilter();
</script>