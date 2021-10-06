<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>
<?php

  if (isset($_GET['class_id'])) {
    $class_id = $_GET["class_id"]; //Refactor this validation later
    $term = $_GET["term"];
    $school_yr = $_GET["school_yr"];  
  }
  else{
    $class_id = NULL;
  }
  if ($class_id == NULL) {
    redirect_to("classes.php");
  }
    $query  = "SELECT * FROM classes WHERE class_id =".$class_id." LIMIT 1";
    $result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($result))
    {
    $sec_id = $row['sec_id'];
    $subject_id = $row['subject_id'];
    $teacher_id = $row['teacher_id'];
    $current_limit = $row['student_limit'];
    }
  ?>

  <title>Show All Schedule for Class</title>
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
        <li class="breadcrumb-item">
          <a href="view-schedule.php">View All Schedule</a>
        </li>
        <li class="breadcrumb-item">
          <a href="new-group-schedule.php">Scheduling Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <?php
            echo "<a href=\"create-schedule-for-class.php?sec_id=".urlencode($sec_id)."&term=".urlencode($term)."&school_yr=".$school_yr."\">Show All Classes for Section</a>";
          ?>
        </li>
        <li class="breadcrumb-item active">
         Show Schedule for Class
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-plus-square"></i>
          Display All Schedule</div>
          <div class="card-body">

            <h3>Class Info</h3>
            <?php
            echo "<ul class=\"list-group list-group-flush\">";
            echo "<li class=\"list-group-item\"><strong>School Year: </strong>".$school_yr."</li>";
            echo "<li class=\"list-group-item\"><strong>Semester: </strong>".$term."</li>";
            echo "<li class=\"list-group-item\"><strong>Course: </strong>".get_course_code(get_course_id_from_section($sec_id,"",$connection),"",$connection)."</li>";
            echo "<li class=\"list-group-item\"><strong>Section: </strong>".get_section_name($sec_id,"",$connection)."</li>";
            echo "<li class=\"list-group-item\"><strong>Subject: </strong>".get_subject_code($subject_id,"",$connection)."</li>";
            echo "<li class=\"list-group-item\"><strong>Teacher: </strong>".get_teacher_name($teacher_id,"",$connection)."</li>";
            echo "<li class=\"list-group-item\"><strong>Class Limit: </strong>".$current_limit."</li>";
            echo "<li class=\"list-group-item\"><a href=\"new-schedule.php?class_id=".$class_id."\" class=\"btn btn-success btn-sm\">Add New Schedule</a></li>";
            echo "</ul>";
            ?>

            <div class="table-responsive" id="dataTable_wrapper">
            <?php

              echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
              echo " <thead>";
              echo "  <tr>";
              echo "   <th>Subject</th>";
              echo "   <th>Room</th>";
              echo "   <th>Teacher</th>";
              echo "   <th>Day</th>";
              echo "   <th>Time Start</th>";
              echo "   <th>Time End</th>";
              echo "   <th>Option</th>";   
              echo "  </tr></thead><tbody>";
              
            $query  = "SELECT * FROM schedule_block WHERE class_id =".$class_id." AND term ='".$term."' AND school_yr='".$school_yr."' ORDER BY day, time_start ASC";
            $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result))
              {
              echo "<tr>";
              echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
              echo "<td>".$row['room']."</td>";
              echo "<td>".get_teacher_name($row['teacher_id'],"",$connection)."</td>";
              echo "<td>".number_to_day($row['day'],"")."</td>";
              echo "<td>".date("g:i A", strtotime($row['time_start']))."</td>";
              echo "<td>".date("g:i A", strtotime($row['time_end']))."</td>";
              echo "<td class=\"options-td\"><a class=\"btn btn-warning btn-xs\" title=\"Edit\" href=\"edit-schedule.php?schedule_id=".$row['schedule_id']."&school_yr=".urlencode($school_yr)."&term=".urlencode($term)." \"\"><i class=\"fa fa-pencil-square-o\"></i></a><a title=\"Delete\" class=\"btn btn-danger btn-xs ml-1\" href=\"javascript:confirmDelete2('delete-schedule.php?schedule_id=".$row['schedule_id']."&class_id=".$class_id."&school_yr=".urlencode($school_yr)."&term=".urlencode($term)."')\"><i class=\"fa fa-calendar-times-o\"></i></a></td>";
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
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>
<?php include 'layout/footer.php';?>
