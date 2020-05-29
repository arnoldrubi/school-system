<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
if (isset($_POST['submit'])) {
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
         redirect_to("faculty-grading-portal.php");
    }
	$stud_reg_id = $_POST["stud_reg_id"];
    $prelim = $_POST["prelim"];
    $midterm =  $_POST["midterm"];
    $semis =  $_POST["semis"];
    $finals =  $_POST["finals"];
    $computed_grade = $_POST["final_grade"];
    $remarks = $_POST["remarks"];

//loop through values of the input arrays


	foreach ($prelim as $key => $value) {

		mysql_prep($remarks[$key]);


		$query  = "UPDATE student_grades SET prelim = '{$prelim[$key]}', midterm = '{$midterm[$key]}', semis = '{$semis[$key]}', finals = '{$finals[$key]}', final_grade = '{$computed_grade[$key]}', remarks = '{$remarks[$key]}', grade_posted = '0' WHERE subject_id = '{$subject_id}' AND stud_reg_id = '{$stud_reg_id[$key]}' LIMIT 1";

	    $result = mysqli_query($connection, $query);
	}
	if ($result === TRUE) {
         echo "<script type='text/javascript'>";
         echo "alert('Student grades are saved');";
         echo "</script>";

         $URL= "faculty-encode-grades.php?subject_id=".urlencode($subject_id)."&term=".urlencode($term)."&school_yr=".urlencode($school_yr)."&course_id=".urlencode($course_id)."&year=".urlencode($year)."&section=".urlencode($section)."&teacher_id=".urlencode($teacher_id)."&grade_saved=1";
         echo "<script>location.href='$URL'</script>";

	    // redirect_to("encode-grades.php?subject_id=".urlencode($subject_id)."&term=".urlencode($term)."&course_id=".urlencode($course_id)."&year=".urlencode($year)."&section=".urlencode($section)."&teacher_id=".urlencode($teacher_id)."&grade_saved=1");
	} else {
	    echo "Error updating record: " . $connection->error."<br>";
	}

}
if (isset($_POST['post'])) {
	if (isset($_GET['subject_id'])) {
    $subject_id = $_GET["subject_id"];
    $term = $_GET["term"];
    $school_yr = $_GET["school_yr"];
    $year = $_GET["year"];
    $section = $_GET["section"];
    $teacher_id = $_GET["teacher_id"];
    $course_id = $_GET["course_id"];
    }
    else{
      $subject_id = NULL;
    }
    if ($subject_id == NULL) {
      redirect_to("faculty-grading-portal.php");
    }
	$stud_reg_id = $_POST["stud_reg_id"];
    $prelim = $_POST["prelim"];
    $midterm =  $_POST["midterm"];
    $semis =  $_POST["semis"];
    $finals =  $_POST["finals"];
    $computed_grade = $_POST["final_grade"];
    $remarks = $_POST["remarks"];

//loop through values of the input arrays


	foreach ($prelim as $key => $value) {

		mysql_prep($remarks[$key]);

		$query  = "UPDATE student_grades SET prelim = '{$prelim[$key]}', midterm = '{$midterm[$key]}', semis = '{$semis[$key]}', finals = '{$finals[$key]}', final_grade = '{$computed_grade[$key]}', remarks = '{$remarks[$key]}', grade_posted = '1' WHERE subject_id = '{$subject_id}' AND stud_reg_id = '{$stud_reg_id[$key]}' LIMIT 1";

	    $result = mysqli_query($connection, $query);

	}
	if ($result === TRUE) {
         echo "<script type='text/javascript'>";
         echo "alert('Student grades are now posted!');";
         echo "</script>";

         $URL= "faculty-encode-grades.php?subject_id=".urlencode($subject_id)."&term=".urlencode($term)."&school_yr=".urlencode("2019-2020")."&course_id=".urlencode($course_id)."&year=".urlencode($year)."&section=".urlencode($section)."&teacher_id=".urlencode($teacher_id);
         echo "<script>location.href='$URL'</script>";

	    // redirect_to("encode-grades.php?subject_id=".urlencode($subject_id)."&term=".urlencode($term)."&course_id=".urlencode($course_id)."&year=".urlencode($year)."&section=".urlencode($section)."&teacher_id=".urlencode($teacher_id)."&grade_saved=2");
	} else {
	    echo "Error updating record: " . $connection->error."<br>";
	}

}
?>