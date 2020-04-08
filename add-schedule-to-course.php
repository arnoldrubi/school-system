<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['course_id']) && isset($_GET['shedule_id']) && isset($_GET['year']) && isset($_GET['term']) && isset($_GET['sy'])) {
    $course_id = (int) $_GET["course_id"];
    $shedule_id = (int) $_GET["shedule_id"];
    $year = urldecode($_GET["year"]);
    $term = urldecode($_GET["term"]);
    $sy = urldecode($_GET["sy"]);

    $redirect_url = "new-group-schedule.php?course_id=".$course_id."&year=".urlencode($year)."&term=".urlencode($term)."&sy=".urlencode($sy);

  }
  elseif (!isset($_GET['course_id']) OR !isset($_GET['shedule_id']) OR !isset($_GET['year']) OR !isset($_GET['term']) OR !isset($_GET['sy'])){
    redirect_to($redirect_url);
  }

    $query  = "SELECT * FROM group_schedule WHERE schedule_id ='".$shedule_id."' AND course_id='".$course_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."' LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result === TRUE) {
    redirect_to($redirect_url);
    }
    else{
    $query   = "INSERT INTO group_schedule (course_id, year, term, schedule_id, school_yr) VALUES ('{$course_id}', '{$year}', '{$term}', '{$shedule_id}', '{$sy}')";
    $result = mysqli_query($connection, $query);
  }

  //close database connection after an sql command

  if ($result === TRUE) {
    $redirect_url = "build-group-schedule.php?course_id=".$course_id."&year=".urlencode($year)."&term=".urlencode($term)."&sy=".urlencode($sy);
    redirect_to($redirect_url);
  } else {
    echo "Error updating record: " . $connection->error;
    echo "<br><br>". print_r($query);
  }

  if(isset($connection)){ mysqli_close($connection); }

?>




