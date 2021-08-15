<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>

<?php 
  if (isset($_GET['regid']) && isset($_GET['student_num']) && isset($_GET['course']) && isset($_GET['year']) && isset($_GET['sy']) && isset($_GET['term'])) {
      $stud_reg_id = $_GET["regid"];
      $student_num = $_GET["student_num"];
      $course = $_GET["course"];
      $year = $_GET["year"];
      $sy = $_GET["sy"];
      $term = $_GET["term"];

      if (isset($_GET['error'])) {
        $error_code = $_GET['error'];
      }
    }
    else{
      redirect_to("irregular-manual-enrollment.php");
    }
?>

  <title>Assign Subjects to <?php echo $student_num; ?></title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "students";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="students.php">Students</a>
        </li>
        <li class="breadcrumb-item active">
            Assign Subjects for Irregular Students
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          Subjects Management: Irregular Student</div>
          <div class="card-body">
            <?php
              if (isset($error_code) && $error_code == 1) {
                echo "<div class=\"row\"><div class=\" col-md-12 alert alert-danger\" role=\"alert\"><p>Error: Over the max units allowed</p></div></div>";
              }
            ?>
            <div class="row">

              <div class="col-md-6">
               <h4>Student Info</h4>
                <form id="courses_form" action="" method="post" >
                  <?php
                    echo "<label class=\"col-md-6 col-form-label\" for=\"Course\">Name: ";

                    $query = "SELECT * FROM students_reg WHERE stud_reg_id='".$stud_reg_id."'";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($result))
                    {
                      echo $row['last_name'].", ".$row['first_name']." ".substr($row['middle_name'],0,1).".";
                    }
                    echo "</label><br>";
                  ?>
                  <?php
                    echo "<label class=\"col-md-6 col-form-label\" for=\"Course\">Course: ";

                    $query2 = "SELECT course_code FROM courses WHERE course_id='".$course."'";
                    $result2 = mysqli_query($connection, $query2);
                    while($row2 = mysqli_fetch_assoc($result2))
                    {
                      $course_code = $row2['course_code'];
                      echo $course_code;
                    }
                    echo "</label><br>";
                  ?>
                  <label class="col-md-6 col-form-label" for="Year">Year: <?php echo $year; ?></label><br>
                  <label class="col-md-6 col-form-label" for="Year">Term: <?php echo $term; ?></label><br>
                  <div class="form-group">
                    <label class="col-md-2 col-form-label" for="Course">Max Units</label>
                    <div class="col-md-3" style="display: inline-grid;">

                      <div class="form-check">
                        <?php
                          if (isset($_GET['overload'])){
                            $overload = $_GET['overload'];

                            if ($overload == 1) {
                             echo "<input class=\"form-check-input\" type=\"checkbox\" checked value=\"1\" id=\"allow-overload\">";
                            }
                          }
                          else{
                            echo "<input class=\"form-check-input\" type=\"checkbox\" value=\"\" id=\"allow-overload\">";
                          }
                        ?>
                        <label class="form-check-label" for="flexCheckIndeterminate">
                        Allow Overload
                        </label>
                      </div>
                      <?php                 
                        echo "<a class=\"btn btn-warning btn-xs\" title=\"Print Enrollment Form\" target=\"_blank\" href=\"print-enrollment-form.php?student_reg_id=".$stud_reg_id."&irregular=1\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a>";
                      ?>
                    </div>
                  </div>


                    <input type="text" name="stud_reg_id" value ="<?php echo $stud_reg_id; ?>" style="display: none">
                    <input type="text" name="course" value ="<?php echo $course; ?>" style="display: none">
                    <input type="text" name="year" value ="<?php echo $year; ?>" style="display: none">
                    <input type="text" name="term" value ="<?php echo $term; ?>" style="display: none">
                    <input type="text" name="sy" value ="<?php echo $sy; ?>" style="display: none">
                    <input type="text" name="array_values" id="array_values" style="display: none">
              

              </div>

              <div class="col-md-6">
                  <h4>Selected Subjects</h4>
                  <ul id="selected-subjects">
                  <table class="table table-bordered mt-3" id="" width="50%" cellspacing="0" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>Subject Name</th><th>Subject Code</th><th width="10%">&nbsp;</th>
                      </tr>
                    </thead>
                  
                  <?php
                  // note: create array for pushing class_id and subject ID
                    $class_array = array();
                    $subjects_array = array();
                    $current_units = 0;

                    $query_subject_info = "SELECT * FROM irreg_manual_sched WHERE stud_reg_id='".$stud_reg_id."'";
                    $result_subject_info = mysqli_query($connection, $query_subject_info);

                    while($row_subject_info = mysqli_fetch_assoc($result_subject_info))
                    {
                      $teacher_class_delete = get_teacher_id_by_class($row_subject_info['class_id'],"",$connection);

                      $subject_id = get_subject_id_by_class("",$row_subject_info['class_id'],$connection);
                      echo "<tr><td>".get_subject_name($subject_id,"",$connection)."</td><td>".get_subject_code($subject_id,"",$connection)."</td><td style=\"text-align: center\"><a title=\"Delete Subject\" class=\"btn btn-danger btn-xs delete-subject\" href=\"delete-irreg-subjects.php?regid=".$stud_reg_id."&student_num=".urlencode($student_num)."&classid=".$row_subject_info['class_id']."&year=".urlencode($year)."&term=".urlencode($term)."&sy=".urlencode($sy)."&course=".$course."&teacherid=".$teacher_class_delete."\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td></tr>";
                      $current_units = $current_units + get_subject_total_unit($subject_id,"",$connection);

                      array_push($class_array,$row_subject_info['class_id']);
                      array_push($subjects_array,get_subject_id_by_class("",$row_subject_info['class_id'],$connection));
                    }

                  ?>
                  </table>
                  </ul>
                  <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="Course">Current Units</label>
                    <div class="col-md-3">
                      <input type="text" name="current_units" class="form-control" id="current-units" <?php echo "value=".$current_units; ?> readonly="">                    
                    </div>
                  </div>
              </div>

            </form>

            <div class="col-md-12">
            <?php
              echo "<hr>";
              echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
              echo " <thead>";
              echo "  <tr>";
              echo "   <th>Subject Name</th>";
              echo "   <th>Subject Code</th>";
              echo "   <th>Prerequisite</th>";
              echo "   <th>Type</th>";
              echo "   <th>Course</th>";
              echo "   <th>Year</th>";
              echo "   <th>Section</th>";
              echo "   <th>Teacher</th>";
              echo "   <th>Units</th>";
              echo "   <th>Student Enrolled</th>";
              echo "   <th>Options</th>";   
              echo "  </tr></thead><tbody>";    
              
          

              if (count($class_array)<1) {
                // $query3 = "SELECT * FROM classes WHERE students_enrolled < student_limit"; 
                $query3 = "SELECT classes.class_id, classes.sec_id, classes.subject_id, classes.teacher_id, classes.students_enrolled, classes.student_limit, subjects.type, subjects.pre_id, subjects.active, sections.course_id";
                $query3 .=" FROM classes INNER JOIN subjects ON classes.subject_id = subjects.subject_id INNER JOIN sections ON classes.sec_id = sections.sec_id";
                $query3 .=" WHERE classes.students_enrolled < classes.student_limit AND subjects.type='Major' AND subjects.active = 1 AND sections.course_id =".$course; 
              } 
              else{
                // $query3 = "SELECT * FROM classes WHERE students_enrolled < student_limit AND class_id NOT IN(".implode(",", $class_array).") AND subject_id NOT IN(".implode(",", $subjects_array).")";
                $query3 = "SELECT classes.class_id, classes.sec_id, classes.subject_id, classes.teacher_id, classes.students_enrolled, classes.student_limit, subjects.type, subjects.pre_id, subjects.active, sections.course_id";
                $query3 .=" FROM classes INNER JOIN subjects ON classes.subject_id = subjects.subject_id INNER JOIN sections ON classes.sec_id = sections.sec_id";
                $query3 .=" WHERE classes.students_enrolled < classes.student_limit AND subjects.type='Major' AND subjects.active = 1 AND sections.course_id =".$course; 
                $query3 .=" AND classes.class_id NOT IN(".implode(",", $class_array).") AND subjects.subject_id NOT IN(".implode(",", $subjects_array).")";
              }
              $result3 = mysqli_query($connection, $query3);

              if (mysqli_num_rows($result3)< 1) {
                echo "<br><div class=\"alert alert-danger\" role=\"alert\">";
                echo "No Major subjects assigned for ".$course_code.", ".$year.", ".$term.".<br>";
                echo "Please assign subjects using the \"Assign Subjects\" form under the \"Courses\" menu.";
                echo "</div><br>";
              }

                while($row3 = mysqli_fetch_assoc($result3))
                  {

                    echo "<tr>";
                    echo "<td>".get_subject_name($row3['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code($row3['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code(get_prerequisite_id($row3['subject_id'],"",$connection),"",$connection)."</td>";
                    echo "<td>".$row3['type']."</td>";
                    echo "<td>".get_course_code(get_course_id_from_section($row3['sec_id'],"",$connection),"",$connection)."</td>";
                    echo "<td>".get_section_year($row3['sec_id'],"",$connection)."</td>";
                    echo "<td>".get_section_name($row3['sec_id'],"",$connection)."</td>";
                    echo "<td>".get_teacher_name($row3['teacher_id'],"",$connection)."</td>";             
                    echo "<td>".get_subject_total_unit($row3['subject_id'],"",$connection)."</td>";
                    echo "<td>".$row3['students_enrolled']."/".$row3['student_limit']."</td>";
                    echo "<td class=\"subject-wrap options-td\"><a class=\"".get_subject_total_unit($row3['subject_id'],"",$connection)."-".get_subject_code($row3['subject_id'],"",$connection)." add-subject btn btn-success btn-sm\" id=\"".$row3['class_id']."\""." href=\"add-subject-to-irreg.php?regid=".$stud_reg_id."&student_num=".urlencode($student_num)."&classid=".$row3['class_id']."&year=".urlencode($year)."&term=".urlencode($term)."&sy=".urlencode($sy)."&course=".$course."&teacherid=".$row3['teacher_id']."\">Add Subject</a> </td>";
                    echo "</tr>";
                    }

              if (count($class_array)<1) {
                // $query3 = "SELECT * FROM classes WHERE students_enrolled < student_limit"; 
                $query_general_elective = "SELECT classes.class_id, classes.sec_id, classes.subject_id, classes.teacher_id, classes.students_enrolled, classes.student_limit, subjects.type, subjects.pre_id, subjects.active";
                $query_general_elective .=" FROM classes INNER JOIN subjects ON classes.subject_id = subjects.subject_id";
                $query_general_elective .=" WHERE classes.students_enrolled < classes.student_limit AND subjects.type='GE' AND subjects.active = 1"; 
              } 
              else{
                // $query3 = "SELECT * FROM classes WHERE students_enrolled < student_limit AND class_id NOT IN(".implode(",", $class_array).") AND subject_id NOT IN(".implode(",", $subjects_array).")";
                $query_general_elective = "SELECT classes.class_id, classes.sec_id, classes.subject_id, classes.teacher_id, classes.students_enrolled, classes.student_limit, subjects.type, subjects.pre_id, subjects.active";
                $query_general_elective .=" FROM classes INNER JOIN subjects ON classes.subject_id = subjects.subject_id";
                $query_general_elective .=" WHERE classes.students_enrolled < classes.student_limit AND subjects.type='GE' AND subjects.active = 1"; 
                $query_general_elective .=" AND classes.class_id NOT IN(".implode(",", $class_array).") AND subjects.subject_id NOT IN(".implode(",", $subjects_array).")";
              }
              $result_general_elective = mysqli_query($connection, $query_general_elective);

              if (mysqli_num_rows($result_general_elective)< 1) {
                echo "<br><div class=\"alert alert-danger\" role=\"alert\">";
                echo "No GE subjects assigned for ".$course_code.", ".$year.", ".$term.".<br>";
                echo "Please assign subjects using the \"Assign Subjects\" form under the \"Courses\" menu.";
                echo "</div><br>";
              }

                while($row_general_elective = mysqli_fetch_assoc($result_general_elective))
                  {

                    echo "<tr>";
                    echo "<td>".get_subject_name($row_general_elective['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code($row_general_elective['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code(get_prerequisite_id($row_general_elective['subject_id'],"",$connection),"",$connection)."</td>";
                    echo "<td>".$row_general_elective['type']."</td>";
                    echo "<td>".get_course_code(get_course_id_from_section($row_general_elective['sec_id'],"",$connection),"",$connection)."</td>";
                    echo "<td>".get_section_year($row_general_elective['sec_id'],"",$connection)."</td>";
                    echo "<td>".get_section_name($row_general_elective['sec_id'],"",$connection)."</td>";
                    echo "<td>".get_teacher_name($row_general_elective['teacher_id'],"",$connection)."</td>";             
                    echo "<td>".get_subject_total_unit($row_general_elective['subject_id'],"",$connection)."</td>";
                    echo "<td>".$row_general_elective['students_enrolled']."/".$row_general_elective['student_limit']."</td>";
                    echo "<td class=\"subject-wrap options-td\"><a class=\"".get_subject_total_unit($row_general_elective['subject_id'],"",$connection)."-".get_subject_code($row_general_elective['subject_id'],"",$connection)." add-subject btn btn-success btn-sm\" id=\"".$row_general_elective['class_id']."\""." href=\"add-subject-to-irreg.php?regid=".$stud_reg_id."&student_num=".urlencode($student_num)."&classid=".$row_general_elective['class_id']."&year=".urlencode($year)."&term=".urlencode($term)."&sy=".urlencode($sy)."&course=".$course."&teacherid=".$row_general_elective['teacher_id']."\">Add Subject</a> </td>";
                    echo "</tr>";
                    } 

              echo "</tbody></table>"; 

            ?>

<!-- start ge table -->

<!-- end ge table -->
              <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Reminder</h4>
                <p>Subjects listed above are those where classes were created.</p>
                <hr>
                <p>If a subject is missing in the list, it's because no classes has been created for it yet. Kindly go to the <a href="sections-and-classes.php">classes</a> page to fix this.</p>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="response"></div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>


<?php include 'layout/footer.php';?>

<script>
$( document ).ready(function() {
  var once = "";
  $(".add-subject" ).click(function() {
    alert( "Subject is added!" );
  });
  $("a.btn.btn-danger.btn-xs" ).click(function() {
    return confirm( "Remove this subject?" );
  });
  $("#allow-overload" ).click(function() {
    if ($("#allow-overload" ).is(":checked")) {
      $(".add-subject").attr("href", $(".add-subject").attr("href")+"&overload=1");
      $(".delete-subject").attr("href", $(".delete-subject").attr("href")+"&overload=1");
    } 
    else {
      $("a.add-subject").attr("href",$(".add-subject").attr("href").replace("&overload=1",""));
      $("a.delete-subject").attr("href", $(".delete-subject").attr("href").replace("&overload=1",""));
    }
  });
  if ($("#allow-overload" ).is(":checked")) {
      $(".add-subject").attr("href", $(".add-subject").attr("href")+"&overload=1");
      $(".delete-subject").attr("href", $(".delete-subject").attr("href")+"&overload=1");
  } 
});

</script>


