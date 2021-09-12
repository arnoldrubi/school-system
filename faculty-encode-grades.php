<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header-faculty.php';?>

<?php 
  if (isset($_GET['subject_id'])) {
    $subject_id = $_GET["subject_id"];
    $school_yr = $_GET["school_yr"];
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
    redirect_to("faculty-dashboard.php");
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

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="faculty-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="faculty-grading-portal.php">Grading Portal</a>
        </li>
        <li class="breadcrumb-item active">
         Process Grades
        </li>
      </ol>
      <h1>Process Grades for <?php echo $subject_code."(".$subject_name.")"; ?></h1>
      <hr>


      <?php

      if (isset($_GET["grade_posted"]) && !empty($_GET["grade_posted"])) {
        $grade_posted = $_GET["grade_posted"];
        if ($grade_posted == 1) {
          echo "<div class=\"alert alert-success mt-3\" role=\"alert\">";
          echo "Grades are posted.</div>";   
        }
        if($grade_posted == 0){
          echo "<div class=\"alert alert-warning mt-3\" role=\"alert\">";
          echo "Cannot post grades. Make sure all fields are not empty. Only students with \"Incomplete\" remarks are allowed to be empty.</div>";        
        }
      }

        $today = date("Y-m-d");
        $deadline = "";

        $query  = "SELECT * FROM site_settings WHERE id = 1";
        $result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($result))
          {
            $end_of_class = $row['end_class'];
          }

      ?>
      
      <input class="form-control" id="myInput" type="text" placeholder="Quick Search">
      <?php
      if (isset($_GET["grade_saved"])) {
        $url_grade_save = $_GET["grade_saved"];
        $form_url = "faculty-process-grades.php?subject_id=".$subject_id."&term=".urlencode($term)."&school_yr=".urlencode($school_yr)."&course_id=".urlencode($course_id)."&year=".urlencode($year)."&section=".urlencode($section)."&teacher_id=".urlencode($teacher_id)."&grade_saved=".$url_grade_save;
      }
      else{
      $form_url = "faculty-process-grades.php?subject_id=".$subject_id."&term=".urlencode($term)."&school_yr=".urlencode($school_yr)."&course_id=".urlencode($course_id)."&year=".urlencode($year)."&section=".urlencode($section)."&teacher_id=".urlencode($teacher_id);
      }
      ?>
      <form action="<?php echo $form_url;?>" method="post">
      <?php

        $grade_values = array("N/A", "5.00","3.00","2.75","2.50","2.25","2.00","1.75","1.50","1.25","1.00");

        echo "<table id=\"example\" class=\"table table-striped table-bordered dataTable\">";
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
        echo "   <th>&nbsp;</th>";
        echo "  </tr></thead><tbody>";
        
        $remarks_value = 0;

        $query = "SELECT student_grades.stud_reg_id, student_grades.prelim, student_grades.midterm, student_grades.semis, student_grades.finals, student_grades.final_grade,student_grades.remarks, student_grades.grade_posted,students_reg.first_name, students_reg.middle_name, students_reg.last_name FROM student_grades INNER JOIN students_reg ON student_grades.stud_reg_id = students_reg.stud_reg_id WHERE student_grades.subject_id ='".$subject_id."' AND student_grades.sec_id ='".$section."' AND term='".$term."' AND school_yr='".$school_yr."' ORDER BY students_reg.last_name";
        
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

          if ($row['remarks'] == "Incomplete") {
            $remarks_value = "checked=\"checked\"";
            $extra_class_jquery = "incomplete";
          }
          else{
            $remarks_value = "";
            $extra_class_jquery = "allowed";
          }
        echo "<tr>";
          echo "<td style=\"display: none;\"><input class=\"student-id-box\" type=\"number\" name=\"stud_reg_id[]\" min=\"1\" style=\"display: none\" max=\"100\" value=\"".$row['stud_reg_id']."\"><input class=\"student-id-box\" type=\"number\" disabled name=\"stud_id[]\" min=\"0\" max=\"5\" value=\"".$row['stud_reg_id']."\"></td>";
          echo "<td><input class=\"student-id-box\" type=\"text\" disabled name=\"stud_id[]\" value=\"".get_student_number($row['stud_reg_id'],$connection)."\"></td>";
          echo "<td>".$row['last_name'].", ".$row['first_name'].", ".substr($row['middle_name'], 0,1).".</td>";
                echo "<td>";
                echo" <select name=\"prelim[]\" class=\"grade-box ".$extra_class_jquery."\" ".$lock_grade." aria-label=\"Default select example\">";
                
                loadDropdownValues($grade_values,$row['prelim']);

                echo "</select>";
                echo "</td>";
                echo "<td>";
                echo" <select name=\"midterm[]\" class=\"grade-box ".$extra_class_jquery."\" ".$lock_grade." aria-label=\"Default select example\">";
                
                loadDropdownValues($grade_values,$row['midterm']);

                echo "</select>";
                echo "</td>";
                echo "<td>";
                echo" <select name=\"semis[]\" class=\"grade-box ".$extra_class_jquery."\" ".$lock_grade." aria-label=\"Default select example\">";
                
                loadDropdownValues($grade_values,$row['semis']);

                echo "</select>";
                echo "</td>";
                echo "<td>";
                echo" <select name=\"finals[]\" class=\"grade-box ".$extra_class_jquery."\" ".$lock_grade." aria-label=\"Default select example\">";
                
                loadDropdownValues($grade_values,$row['finals']);

                echo "</select>";
                echo "</td>";
                echo "<td><input class=\"final-computed-grade\" step=\".25\" maxlength =\"3\" type=\"number\" name=\"final_grade[]\"  min=\"0.00\" max=\"5.00\" readonly value=\"".$row['final_grade']."\"></td>";

                echo "<td>";
                echo  "<input class=\"remarks form-control\" name=\"remarks[]\" value=\"".$row['remarks']."\" readonly />";
                echo "</td>";
                echo "<td>";
  
                echo  "<div class=\"form-check\"><input class=\"form-check-input MarkIncomplete\" type=\"checkbox\" ".$remarks_value." ".$checkboxDisabled."><label class=\"form-check-label\ for=\"MarkIncomplete\">Mark as Incomplete</label></div>";
                echo "</td>";
              echo "</tr>";
        }

        echo "</tbody></table>"; 

        echo "<div class=\"col-md-4\">";



        if ($today > $end_of_class) {
          echo "<div class=\"alert alert-warning\" role=\"alert\">
            Posting of grades has reached past the deadline.
          </div>";
          $deadline = 1;
        }
        else{
            //query check to make sure the grades are locked before proceeding, if not, the buttons will be set to default

            $grades_set_lock = "";

            $query_check = "SELECT grade_posted FROM student_grades WHERE subject_id ='".$subject_id."' AND sec_id ='".$section."' AND teacher_id = '".$teacher_id."' AND term='".$term."' AND school_yr='".$school_yr."' LIMIT 1";
            $result_check = mysqli_query($connection, $query_check);
            while($row_check = mysqli_fetch_assoc($result_check))
            {
              $grades_set_lock = $row_check['grade_posted'];
            }



          if (isset($_GET["grade_posted"]) && !empty($_GET["grade_posted"])) {
              if ($grade_posted == 1) {
               echo "<input type=\"submit\" name=\"submit\" disabled value=\"Save Grades\" class=\"btn btn-primary\" />";  
               echo "&nbsp;<input id=\"post-grades\" type=\"submit\" disabled name=\"post\" value=\"Post Grades\" class=\"btn btn-success\" />";
               echo "&nbsp;<input type=\"submit\" name=\"edit\" value=\"Edit Grades\" class=\"btn btn-warning\" />";   
              }
              else if($grade_posted == 0){
                echo "<div class=\"alert alert-warning mt-3\" role=\"alert\">";
                echo "Cannot post grades. Make sure all fields are not empty. Only students with \"Incomplete\" remarks are allowed to be empty.</div>"; 

               echo "<input type=\"submit\" name=\"submit\"  value=\"Save Grades\" class=\"btn btn-primary\" />";  
               echo "&nbsp;<input id=\"post-grades\" type=\"submit\" name=\"post\" value=\"Post Grades\" class=\"btn btn-success\" />";
               echo "&nbsp;<input type=\"submit\" disabled name=\"edit\" value=\"Edit Grades\" class=\"btn btn-warning\" />";  

              }

            }
          else{
              if ($grade_posted == 1) {
               echo "<input type=\"submit\" name=\"submit\" disabled value=\"Save Grades\" class=\"btn btn-primary\" />";  
               echo "&nbsp;<input id=\"post-grades\" type=\"submit\" disabled name=\"post\" value=\"Post Grades\" class=\"btn btn-success\" />";
               echo "&nbsp;<input type=\"submit\" name=\"edit\" value=\"Edit Grades\" class=\"btn btn-warning\" />";   
              }
              else{
                echo "<input type=\"submit\" name=\"submit\"  value=\"Save Grades\" class=\"btn btn-primary\" />";  
                echo "&nbsp;<input id=\"post-grades\" type=\"submit\" name=\"post\" value=\"Post Grades\" class=\"btn btn-success\" />";
                echo "&nbsp;<input type=\"submit\" disabled name=\"edit\" value=\"Edit Grades\" class=\"btn btn-warning\" />";        
              }
       
          }

        }

  
         echo "&nbsp;<a class=\"btn btn-secondary\" href=\"faculty-grading-portal.php\">Cancel</a></div>";
      ?>
    </form>
  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
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
    $("#table-grades tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  //bunch of scripts for computing the grades real time
  $(".grade-box").change(function(){
    var prelim = parseFloat($(this).closest("tr").find("select[name='prelim[]']").val());
    var midterm = parseFloat($(this).closest("tr").find("select[name='midterm[]']").val());
    var semis = parseFloat($(this).closest("tr").find("select[name='semis[]']").val());
    var finals = parseFloat($(this).closest("tr").find("select[name='finals[]']").val());
    var raw_computed_grades = (prelim + midterm + semis + finals) / 4;
    var computed_grades = roundOffGrade(raw_computed_grades,0);

    $(this).closest("tr").find(".final-computed-grade").val(computed_grades.toFixed(2));
// fix the assignment of pass and fail 
    if (parseFloat(computed_grades) <= 3.50 && parseFloat(computed_grades) >= 1 && computed_grades != "") {
      $(this).closest("tr").find(".remarks").val("Passed");
      $(this).closest("tr").find(".MarkIncomplete").prop("checked",false);
    }
    else if (parseFloat(computed_grades) > 3.50 && computed_grades != "") {
      $(this).closest("tr").find(".remarks").val("Failed");
      $(this).closest("tr").find(".MarkIncomplete").prop("checked",false);
    }
    else if($(this).closest("tr").find(".final-computed-grade") == ""){
      $(this).closest("tr").find(".remarks").val("");
    }
    else{
      $(this).closest("tr").find(".remarks").val("");
    }

  });

  //automatically do some scripts and changes when a student is marked as incomplete

  $( ".MarkIncomplete" ).click(function() {
    if ($(this).closest("tr").find(".remarks").val() !== "Incomplete") {
      $(this).closest("tr").find(".remarks").val("Incomplete");
      $(this).closest("tr").find(".grade-box option[value='N/A']").attr('selected', 'selected');
      $(this).closest("tr").find(".grade-box option[value='N/A']").prop('selected', 'selected');
      $(this).closest("tr").find(".final-computed-grade").val("");
      $(this).closest("tr").find(".allowed").removeClass( "allowed" ).addClass( "incomplete" );
    }
    else if ($(this).closest("tr").find(".remarks").val() == "Incomplete"){
      $(this).closest("tr").find(".remarks").val("");
      $(this).closest("tr").find(".grade-box option[value='N/A']").attr('selected', 'selected');
      $(this).closest("tr").find(".grade-box option[value='N/A']").prop('selected', 'selected');
      $(this).closest("tr").find(".incomplete").removeClass( "incomplete" ).addClass( "allowed" );
    }
  });

});

$("#post-grades").click(function(e){

  $(".grade-box").each(function(i, obj) {     
       // $(".allowed").prop("required", true);
       // $(".incomplete").prop("required", false);
       if ($(this).val() == "N/A" && $(this).closest("tr").find(".remarks").val() !== "Incomplete") {
        e.preventDefault();
        alert("Grades must be inputted before posting");
        exit();        
       }    
  });
});

</script>
