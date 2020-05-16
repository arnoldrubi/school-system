<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>

<?php 
  if (isset($_GET['subject_id'])) {
    $subject_id = $_GET["subject_id"];
    $term = $_GET["term"];
    $year = $_GET["year"];
    $course_id = $_GET["course_id"];
    $sec_id = $_GET["section"];
    $teacher_id = $_GET["teacher_id"];
  }
  else{
     $subject_id = NULL;
  }
  if ($subject_id == NULL) {
    redirect_to("admin-dashboard.php");
  }

  $query = "SELECT * FROM subjects WHERE subject_id ='".$subject_id."'";

  $result = mysqli_query($connection, $query);

  while($row = mysqli_fetch_assoc($result))
        {    
         $subject_name = $row['subject_name'];
         $subject_code = $row['subject_code'];
        }
?>

<style type="text/css">
	footer{display: none !important;}
</style>

  <title>Preview Schedule</title>
  </head>

  <body>

   <h2 class="text-center mb-0">Preview All Grades</h2><br>
   <div id="print-info">
    <?php 
      echo "<p>".get_subject_code($subject_id,"",$connection)." (".get_subject_name($subject_id,"",$connection).")</p>";
      echo "<p>Teacher: ".get_teacher_name($teacher_id,"",$connection)."</p>";
      echo "<p>".get_course_code($course_id,"",$connection).",".$year.", ".$term."</p>";
      echo "<p>Section:".get_section_name($sec_id,"",$connection)."</p>";

    ?>
  </div>
    <center>
      <button id="preview-print" class="btn btn-primary no-print"><i class="fa fa-print" aria-hidden="true"></i></i></i> Print Summary</button>
    </center><br>

    <br>
  <?php

        echo "<table style=\"font-size: 11px;\" id=\"datatable\" class=\"table table-striped table-bordered table-sm text-center\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Student Number</th>";
        echo "   <th>Name</th>";
        echo "   <th>Prelim</th>";
        echo "   <th>Midterm</th>";
        echo "   <th>Semis</th>";
        echo "   <th>Finals</th>";
        echo "   <th>Final Grade</th>";
        echo "   <th>Remarks</th>";
        echo "  </tr></thead><tbody>";


        $query = "SELECT student_grades.stud_reg_id, student_grades.prelim, student_grades.midterm, student_grades.semis, student_grades.finals, student_grades.final_grade,student_grades.remarks, students_reg.first_name, students_reg.middle_name, students_reg.last_name FROM student_grades INNER JOIN students_reg ON student_grades.stud_reg_id = students_reg.stud_reg_id WHERE student_grades.subject_id ='".$subject_id."' AND student_grades.sec_id ='".$sec_id."' AND student_grades.grade_posted=1";

        $result = mysqli_query($connection, $query);


      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
          echo "<td width=\"12.5%\">".get_student_number($row['stud_reg_id'],$connection)."</td>";
          echo "<td width=\"12.5%\">".$row['last_name'].", ".$row['first_name'].", ".substr($row['middle_name'], 0,1).".</td>";
          echo "<td width=\"12.5%\">".$row['prelim']."</td>";
          echo "<td width=\"12.5%\">".$row['midterm']."</td>";
          echo "<td width=\"12.5%\">".$row['semis']."</td>";
          echo "<td width=\"12.5%\">".$row['finals']."</td>";
          echo "<td width=\"12.5%\">".$row['final_grade']."</td>";
          echo  "<td width=\"12.5%\">".$row['remarks']."</td>";
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