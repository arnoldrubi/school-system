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

    // setup the overload value if checked by the user
    if (isset($_GET['overload'])){
      $overload = $_GET['overload'];
    }

  }
 else{
  redirect_to('irregular-manual-enrollment.php');
}

if (empty($_GET['regid']) || empty($_GET['classid']) || empty($_GET['year']) || empty($_GET['term'])|| empty($_GET['sy']) || empty($_GET['sy']) || empty($_GET['student_num']) ) {
  redirect_to("irregular-manual-enrollment.php");
}



//#1 DELETE student info to irreg manual subject
$query_delete_subject   = "DELETE FROM irreg_manual_subject WHERE stud_reg_id='".$stud_reg_id."' AND subject_id=".$subject_id." AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."'";
$result = mysqli_query($connection, $query_delete_subject);

//#2 DELETE subject info to grades
$query_delete_grades   = "DELETE FROM student_grades WHERE stud_reg_id='".$stud_reg_id."' AND subject_id=".$subject_id." AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."' AND sec_id='"."0"."'";
$result2 = mysqli_query($connection, $query_delete_grades);

//#3 add student info to irreg manual schedule
$query_delete_sched   = "DELETE FROM irreg_manual_sched WHERE stud_reg_id='".$stud_reg_id."' AND class_id=".$class_id." AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."'";
$result = mysqli_query($connection, $query_delete_sched);


//#4 Update current students count

$current_students = get_students_enrolled_in_class($class_id,"",$connection) - 1;
$query_update_current_students  = "UPDATE classes SET students_enrolled = '{$current_students}' WHERE class_id='".$class_id."' LIMIT 1";
$result_update_current_students = mysqli_query($connection, $query_update_current_students);

if(isset($connection)){mysqli_close($connection); }

if ($overload == 1) {
  $redirect_text = $stud_reg_id."&student_num=".urlencode($student_num)."&course=".$course_id."&year=".urlencode($year)."&sy=".urlencode($sy)."&term=".$term."&success=".$success."&overload=".$overload;  
}
else{
  $redirect_text = $stud_reg_id."&student_num=".urlencode($student_num)."&course=".$course_id."&year=".urlencode($year)."&sy=".urlencode($sy)."&term=".$term."&success=".$success;  
}
redirect_to("assign-subjects-irreg-student.php?regid=".$redirect_text);

?>

