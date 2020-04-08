<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


<style type="text/css">
	footer{display: none !important;}
</style>

  <title>Preview Schedule</title>
  </head>

  <body>

   <h2 class="text-center mb-0">Preview All Schedules</h2>
    <center>
      <button id="preview-print" class="btn btn-primary no-print"><i class="fa fa-print" aria-hidden="true"></i></i></i> Print Summary</button>
    </center>
    <br>
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

        $query  = "SELECT * FROM schedule_block ORDER BY time_start ASC ";
        $result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($result)){

        	$course_id = $row['course_id'];
        	$subject_id = $row['subject_id'];
        	$teacher_id = $row['teacher_id'];
        	$teacher_name = "";

        	echo "<tr>";
        			if ($row['day'] == 1) {
        				echo "<td width=\"14%\">";
        				echo "<hr>".get_course_code($course_id,"",$connection)."<br>";
        				echo $row['year'].", Section: ".$row["section"]."<br>";
        				echo $row['term']."<br>";
                        echo get_subject_code($subject_id,"",$connection)."<br>";
                        echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
                        echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "<hr></td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 2) {
        				echo "<td width=\"14%\">";
                        echo "<hr>".get_course_code($course_id,"",$connection)."<br>";
        				echo $row['year'].", Section:".$row["section"]."<br>";
        				echo $row['term']."<br>";
                        echo get_subject_code($subject_id,"",$connection)."<br>";
                        echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
                        echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "<hr></td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 3) {
        				echo "<td width=\"14%\">";
                        echo "<hr>".get_course_code($course_id,"",$connection)."<br>";
        				echo $row['year'].", Section:".$row["section"]."<br>";
        				echo $row['term']."<br>";
                        echo get_subject_code($subject_id,"",$connection)."<br>";
                        echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
                        echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "<hr></td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 4) {
        				echo "<td width=\"14%\">";
                        echo "<hr>".get_course_code($course_id,"",$connection)."<br>";
        				echo $row['year'].", Section:".$row["section"]."<br>";
        				echo $row['term']."<br>";
                        echo get_subject_code($subject_id,"",$connection)."<br>";
                        echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
                        echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "<hr></td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 5) {
        				echo "<td width=\"14%\">";
                        echo "<hr>".get_course_code($course_id,"",$connection)."<br>";
        				echo $row['year'].", Section:".$row["section"]."<br>";
        				echo $row['term']."<br>";
                        echo get_subject_code($subject_id,"",$connection)."<br>";
                        echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
                        echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "<hr></td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 6) {
        				echo "<td width=\"14%\">";
                        echo "<hr>".get_course_code($course_id,"",$connection)."<br>";
        				echo $row['year'].", Section:".$row["section"]."<br>";
        				echo $row['term']."<br>";
                        echo get_subject_code($subject_id,"",$connection)."<br>";
                        echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
                        echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "<hr></td>";
        			}
        			else{
        				echo "<td>&nbsp;</td>";
        			}

        			if ($row['day'] == 7) {
        				echo "<td width=\"14%\">";
                        echo "<hr>".get_course_code($course_id,"",$connection)."<br>";
        				echo $row['year'].", Section:".$row["section"]."<br>";
        				echo $row['term']."<br>";
                        echo get_subject_code($subject_id,"",$connection)."<br>";
                        echo get_subject_name($subject_id,"",$connection)."<br>";
        				echo "Class Start: ".date("g:i A", strtotime($row['time_start']))."<br>";
          				echo "Class End: ".date("g:i A", strtotime($row['time_end']))."<br>";
        				echo "Room: ".$row['room']."<br>";
                        echo "Teacher: ".get_teacher_name($teacher_id,"",$connection);
        				echo "<hr></td>";
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