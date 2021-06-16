<?php include 'layout/header.php';?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['regid']) && isset($_GET['classid']) && isset($_GET['year']) && isset($_GET['term']) && isset($_GET['sy']) && isset($_GET['sy']) && isset($_GET['student_num']) ) {
    $stud_reg_id = $_GET["regid"];
    $student_num = $_GET["student_num"];
    $class_id = (int) $_GET["classid"];
    $year = urldecode($_GET["year"]);
    $term = urldecode($_GET["term"]);
    $sy = urldecode($_GET["sy"]);
    $subject_id = get_subject_id_by_class("",$class_id,$connection);
    $teacher_id= $_GET["teacherid"];
    $course_id = $_GET["course"];
    $success = 0;
  }
 else{
  redirect_to('irregular-manual-enrollment.php');
}

if (empty($_GET['regid']) || empty($_GET['classid']) || empty($_GET['year']) || empty($_GET['term'])|| empty($_GET['sy']) || empty($_GET['sy']) || empty($_GET['student_num']) ) {
  redirect_to("irregular-manual-enrollment.php");
}

// do a check if a student choose a subject with prerequisite

$subject_has_prerequisite = get_prerequisite_id($subject_id,"",$connection);

if ($subject_has_prerequisite !== NULL) {
  $check_if_student_passed = check_if_student_passed($subject_has_prerequisite,$stud_reg_id,"",$connection);
  if ($check_if_student_passed == "no grade") {
   echo "Error. The prerequisite for this subject has not been taken yet. Please press the browser's back button";
  }
  else{
    $success = 1;
  }
}
else{
  $success = 1;
}

// setup the overload value if checked by the user
if (isset($_GET['overload']) && empty($_GET['overload'])){
  $overload = $_GET['overload'];
}

// do a check for the total units of the irreg student

$max_units = return_max_units($connection);

$current_units = 0;
$query_subject_info = "SELECT * FROM irreg_manual_sched WHERE stud_reg_id='".$stud_reg_id."'";
$result_subject_info = mysqli_query($connection, $query_subject_info);

while($row_subject_info = mysqli_fetch_assoc($result_subject_info))
{
  $subject_id = get_subject_id_by_class("",$row_subject_info['class_id'],$connection);
  $current_units = $current_units + get_subject_total_unit($subject_id,"",$connection);
} 

if ($current_units + get_subject_total_unit($subject_id,"", $connection) > $max_units) {
  $success == 0;
  redirect_to("assign-subjects-irreg-student.php?regid=".$stud_reg_id."&student_num=".urlencode($student_num)."&course=".$course_id."&year=".urlencode($year)."&sy=".urlencode($sy)."&term=".$term."&error=1");
  }



if ($success == 1) {
  //#2 add student info to irreg manual subject
  $query2   = "INSERT INTO irreg_manual_subject (stud_reg_id, subject_id, year, term, school_yr) VALUES ('{$stud_reg_id}', '{$subject_id}', '{$year}', '{$term}', '{$sy}')";
  $result2 = mysqli_query($connection, $query2);

  //#2 add subject info to grades
  $query   = "INSERT INTO student_grades (stud_reg_id, course_id, subject_id, teacher_id, year, term, sec_id, school_yr,grade_posted) VALUES ('{$stud_reg_id}', '{$course_id}', '{$subject_id}', '{$teacher_id}', '{$year}', '{$term}','0', '{$sy}', '0')"; 

  $result = mysqli_query($connection, $query);

  //#3 add student info to irreg manual schedule
  $query3   = "INSERT INTO irreg_manual_sched (stud_reg_id, class_id, year, term, school_yr) VALUES ('{$stud_reg_id}', '{$class_id}', '{$year}', '{$term}', '{$sy}')";
  $result3 = mysqli_query($connection, $query3);

  //#4 Update current students count

  $current_students = get_students_enrolled_in_class($class_id,"",$connection) + 1;
  $query_update_current_students  = "UPDATE classes SET students_enrolled = '{$current_students}' WHERE class_id='".$class_id."' LIMIT 1";
  $result_update_current_students = mysqli_query($connection, $query_update_current_students);

  if(isset($connection)){ mysqli_close($connection); }

  $redirect_text = $stud_reg_id."&student_num=".urlencode($student_num)."&course=".$course_id."&year=".urlencode($year)."&sy=".urlencode($sy)."&term=".$term."&success=".$success;

  redirect_to("assign-subjects-irreg-student.php?regid=".$redirect_text);
}


?>

