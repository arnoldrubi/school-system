<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>

<?php 
	if (isset($_GET['sec_id'])) {
      $sec_id = $_GET["sec_id"];
    }
    else{
      redirect_to("new-group-schedule.php");
    }

    //get all available classes

  $query_get_classes  = "SELECT * FROM classes WHERE sec_id='".$sec_id."'";
  $result_get_classes = mysqli_query($connection, $query_get_classes);

  $class_id = array();
  while($row_get_classes = mysqli_fetch_assoc($result_get_classes)){
    array_push($class_id, $row_get_classes['class_id']);
  }

  $query_get_section  = "SELECT * FROM sections WHERE sec_id='".$sec_id."'";
  $result_get_section = mysqli_query($connection, $query_get_section);

  while($row_get_section = mysqli_fetch_assoc($result_get_section)){
    $course_id = $row_get_section['course_id'];
    $year = $row_get_section['year'];
    $section = $row_get_section['sec_name'];
  } 
  ?>


<style type="text/css">
	footer{display: none !important;}
</style>

  <title>Preview Schedule</title>
  </head>

  <body>


  <?php

        echo "<h2 class=\"text-center mb-0\">".get_course_code($course_id,"",$connection)."</h2>";
        echo "<p class=\"text-center mb-0\">".$year.", ".return_current_term($connection,"").", Section: ".$section."</p>";
        echo "<p class=\"text-center\">School Year: ".return_current_sy($connection,"")."</p>";
        echo "<center>";
        echo "<button id=\"preview-print\" class=\"btn btn-primary no-print\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></i></i> Print Schedule</button></center><br>";
 

        echo "<table style=\"font-size: 11px;\" id=\"schedule-table\" class=\"table table-striped table-bordered table-sm text-center\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Monday</th>";
        echo "   <th>Tuesday</th>";
        echo "   <th>Wednesday</th>";
        echo "   <th>Thursday</th>";
        echo "   <th>Friday</th>";
        echo "   <th>Saturday</th>";
        echo "   <th>Sunday</th>";   
        echo "  </tr></thead><tbody>";
         

        
        $class_set = implode(",", $class_id);

        $query  = "SELECT * FROM schedule_block WHERE class_id IN (".$class_set.") ORDER BY time_start ASC ";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) < 1) {
         die ("<tr><td><div class=\"alert alert-danger\" role=\"alert\">No schedule created. <a href=\"create-schedule-for-class.php?sec_id=".$sec_id."\" class=\"btn btn-success btn-sm\">Add New Schedule</a></div></td></tr>");
        }


        while($row = mysqli_fetch_assoc($result)){

        	$subject_id = $row['subject_id'];
        	$teacher_id = $row['teacher_id'];
        	$teacher_name = "";

        	echo "<tr>";
        			if ($row['day'] == 1) {
        				echo "<td width=\"14%\">";
        				echo get_subject_code($subject_id,"",$connection)."<br>";
        				echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
        				echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "</td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 2) {
        				echo "<td width=\"14%\">";
                echo get_subject_code($subject_id,"",$connection)."<br>";
                echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
        				echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "</td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 3) {
        				echo "<td width=\"14%\">";
                echo get_subject_code($subject_id,"",$connection)."<br>";
                echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
        				echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "</td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 4) {
        				echo "<td width=\"14%\">";
                echo get_subject_code($subject_id,"",$connection)."<br>";
                echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
        				echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "</td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 5) {
        				echo "<td width=\"14%\">";
                echo get_subject_code($subject_id,"",$connection)."<br>";
                echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
        				echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "</td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 6) {
        				echo "<td width=\"14%\">";
                echo get_subject_code($subject_id,"",$connection)."<br>";
                echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
        				echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "</td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 7) {
        				echo "<td width=\"14%\">";
                echo get_subject_code($subject_id,"",$connection)."<br>";
                echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
        				echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "</td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

           	echo "</tr>";
      }

        echo "</tbody></table>"; 

  ?>
<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>


  <?php include 'layout/footer.php';?>

  <script type="text/javascript">
  
  $('#preview-print').click(function () {
    window.print("preview-print-schedule-all");
  });

</script>