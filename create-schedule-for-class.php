<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>
<?php

  if (isset($_GET['sec_id'])) {
    $sec_id = $_GET["sec_id"]; //Refactor this validation later
    $term = $_GET["term"];
    $school_yr = $_GET["school_yr"];  
  }
  else{
    $sec_id = NULL;
  }
  if ($sec_id == NULL) {
    redirect_to("classes.php");
  }

   $query  = "SELECT * FROM classes WHERE sec_id =".$sec_id." LIMIT 1";
   $result = mysqli_query($connection, $query);

   while($row = mysqli_fetch_assoc($result))
    {
      $sec_id = $row['sec_id'];
      $subject_id = $row['subject_id'];
      $teacher_id = $row['teacher_id'];
      $current_limit = $row['student_limit'];
    }

   $query  = "SELECT * FROM sections WHERE sec_id =".$sec_id." LIMIT 1";
   $result = mysqli_query($connection, $query);

   while($row = mysqli_fetch_assoc($result))
    {
      $course_id = $row['course_id'];
      $year = $row['year'];
      $sec_name = $row['sec_name'];
    }
  ?>

  <title>Show All Classes for Section</title>
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
        <li class="breadcrumb-item active">
         Show All Classes for Section
        </li>
      </ol>
      <div class="row">
        <div class="col-md-6">
          <h4><i class="fa fa-bell" aria-hidden="true"></i> All Classes for <?php echo get_course_code($course_id,"",$connection).", ".$year.", Section ".$sec_name; ?></h4>
        </div> 
      </div>
        <hr>
      <div class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject</th>";
        echo "   <th>Course</th>";
        echo "   <th>Year</th>";
        echo "   <th>Section</th>";
        echo "   <th>Teacher</th>";
        echo "   <th>Students (Current/Limit)</th>";
        echo "   <th>Option</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT classes.class_id,classes.sec_id, classes.subject_id, classes.teacher_id, classes.students_enrolled, classes.student_limit, sections.sec_name, sections.year, sections.course_id FROM classes INNER JOIN sections ON classes.sec_id=sections.sec_id WHERE classes.sec_id=".$sec_id." AND classes.term='".$term."' AND classes.school_yr='".$school_yr."'";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
        echo "<td>".get_course_code($row['course_id'],"",$connection)."</td>";
        echo "<td>".$row['year']."</td>";
        echo "<td>".$row['sec_name']."</td>";
        echo "<td>".get_teacher_name($row['teacher_id'],"",$connection)."</td>";
        echo "<td>".$row['students_enrolled']."/".$row['student_limit']."</td>";
        echo "<td class=\"option-grp\"><a href=\"new-schedule.php?class_id=".$row['class_id']."\" class=\"btn btn-success btn-sm\">Add New Schedule</a></td>";
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
