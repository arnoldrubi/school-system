<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>
<?php

  if (isset($_GET['class_id'])) {
    $class_id = $_GET["class_id"]; //Refactor this validation later
  }
  else{
    $class_id = NULL;
  }
  if ($class_id == NULL) {
    redirect_to("classes.php");
  }
?>

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
      <?php
          $query_section  = "SELECT * FROM classes WHERE class_id='".$class_id."'";
          $result_section = mysqli_query($connection, $query_section);

          while($row_section = mysqli_fetch_assoc($result_section))
            {
              $sec_name = get_section_name($row_section['sec_id'],"",$connection);
              $sec_year = get_section_year($row_section['sec_id'],"",$connection);
              $subject_name = get_subject_name($row_section['subject_id'],"",$connection);
              $subject_code = get_subject_code($row_section['subject_id'],"",$connection);
              $sec_id = $row_section['sec_id'];

              $query_course  = "SELECT * FROM sections WHERE sec_id='".$row_section['sec_id']."'";
              $result_course = mysqli_query($connection, $query_course);
              while($row_course = mysqli_fetch_assoc($result_course))
                {
                  $course = get_course_code($row_course['course_id'],"",$connection);
                }
              
            }
      ?>
      <div class="row">
        <div class="col-md-8">
          <h4><i class="fa fa-bell" aria-hidden="true"></i> All Schedule for <?php echo $subject_name." (".$subject_code."), ".$course." ".$sec_year." ".$sec_name; ?></h4>
        </div>
        <div class="col-md-4">
          <div class="button-flt-right">
            <?php
              echo "<a href=\"new-schedule.php?class_id=".urlencode($class_id)."\" class=\"btn btn-success btn-sm\">Add New Schedule</a><br>";
            ?>
          </div>
        </div>  
      </div>
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
        echo "   <th class=\"skip-filter\">Options</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT * FROM schedule_block WHERE class_id='".$class_id."' ORDER BY day ASC, time_start ASC";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
          $day = number_to_day($row['day']);
          $teacher_name = get_teacher_name($row['teacher_id'],"",$connection);
          echo "<tr>";
          echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>"; 
          echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>"; 
          echo "<td>".get_course_code($row['course_id'],"",$connection)."</td>";
          echo "<td>".$row['year']."</td>";
          echo "<td>".$row['term']."</td>";
          echo "<td>".$sec_name."</td>";
          echo "<td>".$row['room']."</td>";
          echo "<td>".$teacher_name."</td>";
          echo "<td>".$day."</td>";
          echo "<td>".date("g:i A", strtotime($row['time_start']))."</td>";
          echo "<td>".date("g:i A", strtotime($row['time_end']))."</td>";
          echo "<td style=\"text-align: center;\"><a class=\"btn btn-warning btn-xs\" title=\"Edit\" href=\"edit-schedule.php?schedule_id=".$row['schedule_id']."\""."><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a> ";
          echo "<a title=\"Delete\" class=\"btn btn-danger btn-xs\" href=\"javascript:confirmDelete('delete-schedule.php?schedule_id=".$row['schedule_id']."')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td>";
          //echo "<a href=\"delete-schedule.php?schedule_id=".$row['schedule_id']."\""." onclick=\"confirm('Are you sure?')\"> Delete Schedule</a></td>";
          echo "</tr>";
        }

        echo "</tbody></table>"; 
      ?>


      <center>
          <?php
            echo "<a href=\"new-group-schedule.php\" class=\"btn btn-success btn-sm\">Select Another Section</a>";             
          ?>
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