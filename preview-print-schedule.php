<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>

<?php 
	if (isset($_GET['course_id']) && isset($_GET['year']) && isset($_GET['term']) && isset($_GET['sy']) && $_GET['course_id'] !== "" && $_GET['year'] !== "" && $_GET['term'] !== "" && $_GET['sy'] !== "") {
      $course_id = $_GET["course_id"];
      $year = urldecode($_GET["year"]);
      $term = urldecode($_GET["term"]);
      $sy = urldecode($_GET["sy"]);
      $section = urldecode($_GET["section"]);
    }
    else{
      $URL="new-group-schedule.php";
      echo "<script>location.href='$URL'</script>";
    }
  ?>


<style type="text/css">
	footer{display: none !important;}
</style>

  <title>Preview Schedule</title>
  </head>

  <body>


  <?php

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

      $course_id = $_GET["course_id"];
      $year = urldecode($_GET["year"]);
      $term = urldecode($_GET["term"]);
      $sy = urldecode($_GET["sy"]);

        $query_get_course  = "SELECT * FROM courses WHERE course_id='".$course_id."'";
        $result_get_course = mysqli_query($connection, $query_get_course);

        while($row_get_course = mysqli_fetch_assoc($result_get_course)){
        	$course_code = $row_get_course['course_code'];
        	$course_desc = $row_get_course['course_desc'];
        }

      	echo "<h2 class=\"text-center mb-0\">".$course_desc." (".$course_code.")</h2>";
      	echo "<p class=\"text-center mb-0\">".$year.", ".$term.", Section: ".$section."</p>";
        echo "<p class=\"text-center\">School Year: ".$sy."</p>";
 	      echo "<center>";
        echo "<button id=\"preview-print\" class=\"btn btn-primary no-print\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></i></i> Print Schedule</button></center><br>";
        

        $query  = "SELECT * FROM schedule_block WHERE course_id='".$course_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."' ORDER BY time_start ASC ";
        $result = mysqli_query($connection, $query);

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