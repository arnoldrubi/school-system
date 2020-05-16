<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>

<?php 
  if (isset($_GET['subject_id'])) {
    $subject_id = $_GET["subject_id"];
    $term = $_GET["term"];
    $year = $_GET["year"];
    $section = $_GET["section"];
    $teacher_id = $_GET["teacher_id"];
    $course_id = $_GET["course_id"];
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

  <title>Encode Grades</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "grading";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="grading-portal.php">Grading Portal</a>
        </li>
        <li class="breadcrumb-item active">
         Process Grades
        </li>
      </ol>
      <h1>Process Grades for <?php echo $subject_code."(".$subject_name.")"; ?></h1>
      <hr>
      
      <input class="form-control" id="myInput" type="text" placeholder="Quick Search">
      <?php
      if (isset($_GET["grade_saved"])) {
        $url_grade_save = $_GET["grade_saved"];
        $form_url = "process-grades.php?subject_id=".$subject_id."&term=".urlencode($term)."&course_id=".urlencode($course_id)."&year=".urlencode($year)."&section=".urlencode($section)."&teacher_id=".urlencode($teacher_id)."&grade_saved=".$url_grade_save;
      }
      else{
      $form_url = "process-grades.php?subject_id=".$subject_id."&term=".urlencode($term)."&course_id=".urlencode($course_id)."&year=".urlencode($year)."&section=".urlencode($section)."&teacher_id=".urlencode($teacher_id);
      }
      ?>
      <form action="<?php echo $form_url;?>" method="post">
      <?php

        echo "<table id=\"example\" class=\"table table-striped table-bordered dataTable\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Student Reg. ID</th>";
        echo "   <th>Student Number</th>";
        echo "   <th>Name</th>";
        echo "   <th>Prelim</th>";
        echo "   <th>Midterm</th>";
        echo "   <th>Semis</th>";
        echo "   <th>Finals</th>";
        echo "   <th>Final Grade</th>";
        echo "   <th>Remarks</th>";
        echo "   <th>&nbsp;</th>";
        echo "  </tr></thead><tbody>";
        
        $remarks_value = 0;

        $query = "SELECT student_grades.stud_reg_id, student_grades.prelim, student_grades.midterm, student_grades.semis, student_grades.finals, student_grades.final_grade,student_grades.remarks, student_grades.grade_posted,students_reg.first_name, students_reg.middle_name, students_reg.last_name FROM student_grades INNER JOIN students_reg ON student_grades.stud_reg_id = students_reg.stud_reg_id WHERE student_grades.subject_id ='".$subject_id."' AND student_grades.sec_id ='".$section."' ORDER BY students_reg.last_name";
        
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
          $grade_posted = $row['grade_posted'];
          $lock_grade = "";
          $checkboxDisabled = "";
          if ($grade_posted == 1) {
            $lock_grade = "readonly style=\"background: #e9ecef;\"";
            $checkboxDisabled = "disabled";
          }
        echo "<tr>";
          echo "<td><input class=\"student-id-box\" type=\"number\" name=\"stud_reg_id[]\" min=\"1\" style=\"display: none\" max=\"100\" value=\"".$row['stud_reg_id']."\"><input class=\"student-id-box\" type=\"number\" disabled name=\"stud_id[]\" min=\"0\" max=\"5\" value=\"".$row['stud_reg_id']."\"></td>";
          echo "<td><input class=\"student-id-box\" type=\"text\" disabled name=\"stud_id[]\" value=\"".get_student_number($row['stud_reg_id'],$connection)."\"></td>";
          echo "<td>".$row['last_name'].", ".$row['first_name'].", ".substr($row['middle_name'], 0,1).".</td>";
          echo "<td><input class=\"grade-box\" step=\".25\" type=\"number\" maxlength =\"3\" name=\"prelim[]\" min=\"1\" max=\"5\" ".$lock_grade." value=\"".$row['prelim']."\"></td>";
          echo "<td><input class=\"grade-box\" step=\".25\" type=\"number\" maxlength =\"3\" name=\"midterm[]\" min=\"1\" max=\"5\" ".$lock_grade." value=\"".$row['midterm']."\"></td>";
          echo "<td><input class=\"grade-box\" step=\".25\" type=\"number\" maxlength =\"3\" name=\"semis[]\" min=\"1\" max=\"5\" ".$lock_grade." value=\"".$row['semis']."\"></td>";
          echo "<td><input class=\"grade-box\" step=\".25\" type=\"number\" maxlength =\"3\" name=\"finals[]\" min=\"1\" max=\"5\" ".$lock_grade." value=\"".$row['finals']."\"></td>";

          echo "<td><input class=\"final-computed-grade\" step=\".25\" maxlength =\"3\" type=\"number\" name=\"final_grade[]\"  min=\"0.00\" max=\"5.00\" readonly value=\"".$row['final_grade']."\"></td>";

          echo "<td>";
          echo  "<input class=\"remarks form-control\" name=\"remarks[]\" value=\"".$row['remarks']."\" readonly />";
          echo "</td>";
          echo "<td>";
          if ($row['remarks'] == "Incomplete") {
            $remarks_value = "checked=\"checked\"";
          }
          else{
            $remarks_value = "";
          }
          echo  "<div class=\"form-check\"><input class=\"form-check-input MarkIncomplete\" type=\"checkbox\" ".$remarks_value." ".$checkboxDisabled."><label class=\"form-check-label\ for=\"MarkIncomplete\">Mark as Incomplete</label></div>";
          echo "</td>";
        echo "</tr>";
        }

        echo "</tbody></table>"; 

        echo "<div class=\"col-md-4\">";

        //query check to make sure the grades are locked before proceeding, if not, the buttons will be set to default

        $grades_set_lock = 0;

        $query_check = "SELECT grade_posted FROM student_grades WHERE subject_id ='".$subject_id."' AND sec_id ='".$section."' AND teacher_id = '".$teacher_id."' LIMIT 1";
        $result_check = mysqli_query($connection, $query_check);
        while($row_check = mysqli_fetch_assoc($result_check))
        {
          $grades_set_lock = $row_check['grade_posted'];
        }
          
        if (isset($_GET["grade_saved"])) {
          $grade_saved = $_GET["grade_saved"];
          if ($grade_saved == 1) {
          echo "<input type=\"submit\" name=\"post\" value=\"Post Grades\" class=\"btn btn-success\" />";
          }
          elseif ($grade_saved == 2) {
          echo "<input type=\"submit\" name=\"edit\" value=\"Edit Grades\" class=\"btn btn-warning\" />";      
          }
          elseif ($grades_set_lock > 0) {
          echo "<input type=\"submit\" name=\"edit\" value=\"Edit Grades\" class=\"btn btn-warning\" />";      
          }
          else{
            echo "<input type=\"submit\" name=\"submit\" value=\"Save Grades\" class=\"btn btn-primary\" />";
          }
        }
        else{
          if ($grades_set_lock == 1) {
            echo "<input type=\"submit\" name=\"edit\" value=\"Edit Grades\" class=\"btn btn-warning\" />";      
          }
          else{
           echo "<input type=\"submit\" name=\"submit\" value=\"Save Grades\" class=\"btn btn-primary\" />";
          }
        }

        echo "&nbsp;<a class=\"btn btn-secondary\" href=\"grading-portal.php\">Cancel</a></div>";
      ?>

      <center>
             <?php echo "<a id=\"preview-print\" style=\"color: #fff;\" class=\"btn btn-primary hidden-print\" href=\"preview-print-grades-all.php?subject_id=".$subject_id."&term=".urlencode($term)."&course_id=".urlencode($course_id)."&year=".urlencode($year)."&section=".urlencode($section)."&teacher_id=".urlencode($teacher_id)."\"><i class=\"fa fa-table\" aria-hidden=\"true\"></i> Preview Summary</a>";
             ?>
      <center><br>     
      <div class="alert alert-success" role="alert">
        Make sure you "Post" the grades first before clicking preview to get the latest data on the grades.
      </div>
    </form>
    <h3>Schedule Info</h3>
      <div class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered\" id=\"\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
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
        echo "  </tr></thead><tbody>";
        
        $query_get_class  = "SELECT * FROM classes WHERE subject_id='".$subject_id."' AND sec_id='".$section."'";
        $result_get_class = mysqli_query($connection, $query_get_class);

      while($row_result_get_class = mysqli_fetch_assoc($result_get_class))
        {
          $class_id = $row_result_get_class['class_id'];
        }
        

        $query  = "SELECT * FROM schedule_block WHERE subject_id='".$subject_id."' AND class_id='".$class_id."' AND year ='".$year."' AND term='".$term."' AND teacher_id='".$teacher_id."' ORDER BY day ASC, time_start ASC";
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

          $query_get_section  = "SELECT * FROM classes WHERE class_id='".$class_id."'";
          $result_get_section = mysqli_query($connection, $query_get_section);

        while($row_result_get_section = mysqli_fetch_assoc($result_get_section))
          {
            $section_display = $row_result_get_section['sec_id'];
          }
          echo "<td>".get_section_name($section_display,"",$connection)."</td>";
          echo "<td>".$row['room']."</td>";
          echo "<td>".$teacher_name."</td>";
          echo "<td>".$day."</td>";
          echo "<td>".date("g:i A", strtotime($row['time_start']))."</td>";
          echo "<td>".date("g:i A", strtotime($row['time_end']))."</td>";
          echo "</tr>";
        }

        echo "</tbody></table>"; 
      ?>
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
<script type="text/javascript"> 

function roundOffGrade(raw_grade,final_grade){
  if (raw_grade >= 1.0 && raw_grade <= 1.12 ) {
    final_grade = 1.0;
  }
  else if(raw_grade >= 1.13 && raw_grade <= 1.37 ){
    final_grade = 1.25;
  }
  else if(raw_grade >= 1.18 && raw_grade <= 1.63 ){
    final_grade = 1.5;
  }
  else if(raw_grade >= 1.64 && raw_grade <= 1.88 ){
    final_grade = 1.75;
  }
  else if(raw_grade >= 1.89 && raw_grade <= 2.13 ){
    final_grade = 2.0;
  }
  else if(raw_grade >= 2.14 && raw_grade <= 2.38 ){
    final_grade = 2.25;
  }
  else if(raw_grade >= 2.39 && raw_grade <= 2.63 ){
    final_grade = 2.50;
  }
  else if(raw_grade >= 2.64 && raw_grade <= 2.88 ){
    final_grade = 2.75;
  }
  else if(raw_grade >= 2.89 && raw_grade <= 3.25 ){
    final_grade = 3.0;
  }
  else if(raw_grade >= 3.26 && raw_grade <= 5.0 ){
    final_grade = 5.0;
  }
  return final_grade;
}

$(document).ready(function(){


  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#example tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  //bunch of scripts for computing the grades real time
  $(".grade-box").change(function(){
    if ($(this).val()>5 || $(this).val()<0 ) {
      alert ("Error! Values should not be greater than or quals to 0 not lower than or equals to 5.");
      $(this).val(0);
      $(this).focus();
    }
    var prelim = parseFloat($(this).closest("tr").find("input[name='prelim[]']").val());
    var midterm = parseFloat($(this).closest("tr").find("input[name='midterm[]']").val());
    var semis = parseFloat($(this).closest("tr").find("input[name='semis[]']").val());
    var finals = parseFloat($(this).closest("tr").find("input[name='finals[]']").val());
    var raw_computed_grades = (prelim + midterm + semis + finals) / 4;
    var computed_grades = roundOffGrade(raw_computed_grades,0);

    $(this).closest("tr").find(".final-computed-grade").val(computed_grades.toFixed(2));

    if (parseFloat(computed_grades) <= 3.50 && computed_grades != "") {
      $(this).closest("tr").find(".remarks").val("Passed");
    }
    else if (parseFloat(computed_grades) > 3.50 && computed_grades != "") {
      $(this).closest("tr").find(".remarks").val("Failed");
    }
    else if($(this).closest("tr").find(".final-computed-grade") == ""){
      $(this).closest("tr").find(".remarks").val("");
    }

  });

  //automatically do some scripts and changes when a student is marked as incomplete

  $( ".MarkIncomplete" ).click(function() {
    if ($(this).closest("tr").find(".remarks").val() == "Incomplete") {

    if ($(this).closest("tr").find(".final-computed-grade").val() <=3 && $(this).closest("tr").find(".final-computed-grade").val() !="") {
        $(this).closest("tr").find(".remarks").val("Passed");
      }
    else if ( $(this).closest("tr").find(".final-computed-grade").val() > 3 && $(this).closest("tr").find(".final-computed-grade").val() != "") {
      $(this).closest("tr").find(".remarks").val("Failed");
    }
    else{
      $(this).closest("tr").find(".remarks").val("");
    }
  }
    else if($(this).closest("tr").find(".remarks").val() !== "Incomplete" || $(this).closest("tr").find(".remarks").val() == ""){
    $(this).closest("tr").find("td .grade-box").removeAttr("required");
    $(this).closest("tr").find(".remarks").val("Incomplete");
    }
});

});

  
</script>

  <script type="text/javascript">
    $(document).ready(function(){

       $("#select-deleted").change(function(){
        show_deleted = $("#select-deleted").val();
        $("#datatable").load("include-deleted-courses.php",{
          show_deleted: show_deleted
        });

       });
      }
    );
  </script>



