<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php include 'layout/header.php';?>

  <title>Register New Subject Schedule</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <?php 
    if (isset($_GET['course_id']) && isset($_GET['year']) && isset($_GET['term']) && isset($_GET['sy']) && $_GET['course_id'] !== "" && $_GET['year'] !== "" && $_GET['term'] !== "" && $_GET['sy'] !== "") {
      $course_id = $_GET["course_id"];
      $year = urldecode($_GET["year"]);
      $term = urldecode($_GET["term"]);
      $section = urldecode($_GET["section"]);
      $sy = urldecode($_GET["sy"]);

    }
    else{
      $URL="new-group-schedule.php";
      echo "<script>location.href='$URL'</script>";
    }
  ?>

  <div id="wrapper">

  <?php
  $sidebar_context = "scheduling";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="view-schedule.php">View All Schedule</a>
        </li>
        <li class="breadcrumb-item active">
         New Schedule Block
        </li>
      </ol>
      <h1>Register New Schedule Block</h1>
      <hr>
      <!-- Text input-->
     <form action="" method="post" >
      <h2>Basic Course Info</h2>
      <?php
        echo "<div class=\"form-group row\">";
        echo "<label class=\"col-md-2 col-form-label\" for=\"Course\">Course</label>";
        
        //this block will load the course name from the database
        $query  = "SELECT * FROM courses WHERE course_id='".$course_id."' LIMIT 1";
        $result = mysqli_query($connection, $query);

        echo "<div class=\"col-md-4\">";
          while($row = mysqli_fetch_assoc($result)){
            echo  "<input id=\"course-name\" name=\"course_id\" disabled type=\"text\" value=\"".$row['course_code']."\"  class=\"form-control\" required=\"\">";
          }
          echo "";
      ?>
          </div>
         <label class="col-md-2 col-form-label" for="School Year">School Year</label>
            <?php
              echo "<div class=\"col-md-4\">";
              echo  "<input id=\"sy\" name=\"sy\" disabled type=\"text\" value=\"".$sy."\"  class=\"form-control\" required=\"\">";
            ?>
         </div>
       </div>
       <div class="form-group row">
         <label class="col-md-2 col-form-label" for="Year">Year</label>
            <?php
              echo "<div class=\"col-md-4\">";
              echo  "<input id=\"year\" name=\"year\" disabled type=\"text\" value=\"".$year."\"  class=\"form-control\" required=\"\">";
            ?>
         </div>
         <label class="col-md-2 col-form-label" for="Year">Term</label>
            <?php
              echo "<div class=\"col-md-4\">";
              echo  "<input id=\"term\" name=\"term\" disabled type=\"text\" value=\"".$term."\"  class=\"form-control\" required=\"\">";
            ?>
         </div>
        </div>
        <hr>
        <h2>Enter Schedule Info</h2>
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="Subject">Subject</label>  
        <div class="col-md-4">
         <select id="subject" class="form-control" name="subject">
           <?php
           //this block will load the subject name from the database
              $query  = "SELECT * FROM course_subjects WHERE course_id='".$course_id."' AND year='".$year."' AND term='".$term."'";
              $result = mysqli_query($connection, $query);

            //check if there are still subjects assigned to the selected course, year, and term
            if (mysqli_num_rows($result) <= 0) {
              echo "<script type='text/javascript'>";
              echo "alert('No assigned subjects for this course, year, and term exists!');";
              echo "</script>";

              $URL="manage-course-subjects.php";
              echo "<script>location.href='$URL'</script>";
            }

              while($row = mysqli_fetch_assoc($result))
                {
                  $subject_id = $row['subject_id'];

                  $query2  = "SELECT * FROM subjects WHERE subject_id='".$subject_id."'";
                  $result2 = mysqli_query($connection, $query2);

                  while($row2 = mysqli_fetch_assoc($result2)){

                  $subject_code = $row2['subject_code']." - ".$row2['subject_name'];
                  }

                  echo  "<option value=\"".$subject_id."\">".$subject_code."</option>";
                }
          ?>

         </select>
       </div>
       <label class="col-md-2 col-form-label" for="Room">Room</label>  
       <div class="col-md-4">
         <select name="room" class="form-control" required>
           <?php
           //this block will load the room name from the database
              $query  = "SELECT * FROM rooms";
              $result = mysqli_query($connection, $query);


              while($row = mysqli_fetch_assoc($result))
                {
                  echo  "<option value\"=".$row['room_id']."\">".$row['room_name']."</option>";
                }
          ?>
         </select>
       </div>
     </div>
     <div class="form-group row">
       <label class="col-md-2 col-form-label" for="Room">Teacher</label>
       <div class="col-md-4">
         <select name="teacher" class="form-control" required>
           <?php
           //this block will load the teacher name from the database
              $query  = "SELECT * FROM teachers";
              $result = mysqli_query($connection, $query);


              while($row = mysqli_fetch_assoc($result))
                {
                  echo  "<option value=\"".$row['teacher_id']."\">".$row['first_name']." ".$row['last_name']."</option>";
                }
          ?>
         </select>
       </div>
      <label class="col-md-2 col-form-label" for="subject-code">Max Students</label>  
        <div class="col-md-1">
          <input id="max-students" min="1" max="99" type="number" name="max_students" class="form-control" required placeholder="1">
        </div>
      <label class="col-md-1 col-form-label" for="subject-code">Section</label>  
        <div class="col-md-1">
          <input id="section" type="text" name="section" class="form-control" <?php echo "value=\"".$section."\""; ?> required placeholder="1" readonly="">
        </div>
      </div>
      <h2>Input Time and Day</h2>
      <div class="form-group row">        
        <label class="col-md-2 col-form-label" for="time-start">Time Start</label>  
        <div class="col-md-2">
        <input id="time-start" name="time-start" type="time" step="1" min="06:00" max="20:00" class="form-control input-md" required="">
        </div>


        <label class="col-md-2 col-form-label" for="description">Time End</label>  
        <div class="col-md-2">
        <input id="time-end" name="time-end" type="time" step="1" min="06:00" max="20:00" class="form-control input-md" required="">
        </div>


        <label class="col-md-2 col-form-label" for="description">Select Day(s)</label>  
        <div class="col-md-2">

            <select name="day" required class="form-control">
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Saturday</option>
                <option value="7">Sunday</option>
            </select>

        </div>
      </div>

      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <input type="submit" name="submit" value="Create Schedule" class="btn btn-primary" />&nbsp;
            <a class="btn btn-secondary"href="view-schedule.php">Cancel</a>
        </div>
      </div>
    </form>
      <?php 



        if (isset($_POST['submit'])) {

          $subject_id = mysql_prep($_POST["subject"]);
          $teacher = $_POST["teacher"];
          $room = mysql_prep($_POST["room"]);
          $time_start = ($_POST["time-start"]);
          $time_end = ($_POST["time-end"]);
          $day = mysql_prep($_POST['day']);
          $max_students = (int) $_POST["max_students"];

          //validation to make sure that the teacher selected for repeat schedules are the same

          $query_check_teacher = "SELECT teacher_id FROM student_grades WHERE subject_id='".$subject_id."' AND course_id='".$course_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."' AND section='".$section."' LIMIT 1";
          $result_check_teacher = mysqli_query($connection, $query_check_teacher);

            while($row_check_teacher = mysqli_fetch_assoc($result_check_teacher))
            {
              $teacher_name = get_teacher_name($row_check_teacher['teacher_id'],"",$connection);
            
            if ($row_check_teacher['teacher_id'] !== $teacher && $row_check_teacher['teacher_id'] !== NULL) {
              die ("<div class=\"alert alert-danger\" role=\"alert\">".$teacher_name." is already assigned for ".get_subject_name($subject_id,"",$connection)."</div>");
              }              
          }

          //series of validations to make sure all forms have values
          if (!isset($subject_id) || !isset($teacher) || !isset($room) || !isset($time_start) || !isset($time_end) || !isset($day) || !isset($max_students) || $subject_id == null || $teacher == null || $room == null || $time_start == null || $time_end == null || $day == null || $max_students == null) {
           die ("<div class=\"alert alert-danger\" role=\"alert\">One or more fields are empty.</div>");
          }
          else{

          //query and codes for getting the current students enrolled for this course, term, year and school year
          $query_for_enrolled_students = query_for_current_students("enrollment",$course_id, $year, $term, $section, $sy)."AND irregular=0";
          $result_enrolled_students = mysqli_query($connection, $query_for_enrolled_students);
          $students_enrolled = mysqli_num_rows($result_enrolled_students);
          // Free result set
          mysqli_free_result($result_enrolled_students);

            if ($students_enrolled>$max_students) {
              die ("<div class=\"alert alert-danger\" role=\"alert\">Currently enrolled students are greater than max students. <br> Current Students: ".$students_enrolled."</div>");
            }

          $query_counter = "SELECT * FROM schedule_block WHERE course_id='".$course_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."'";
          $result_counter = mysqli_query($connection, $query_counter);

          $query  = "SELECT * FROM schedule_block WHERE CAST('".$time_start."' AS time) BETWEEN time_start AND time_end AND room='".$room."' AND day='".$day."'";
          $result = mysqli_query($connection, $query);

          $query2  = "SELECT * FROM schedule_block WHERE CAST('".$time_end."' AS time) BETWEEN time_start AND time_end AND room='".$room."' AND day='".$day."'";
          $result2 = mysqli_query($connection, $query2);

          if (mysqli_num_rows($result) >= 1 OR mysqli_num_rows($result2) >=1) { // logical check for conflicts in time, room, and day

           echo "<div class=\"alert alert-warning\" role=\"alert\">";
           echo "Conflict in schedule! The time, room and day for this schedule is already taken.";
           echo "</div>";
        }
          $query3  = "SELECT * FROM schedule_block WHERE CAST('".$time_start."' AS time) BETWEEN time_start AND time_end AND teacher_id='".$teacher."' AND day='".$day."'";
          $result3 = mysqli_query($connection, $query3);

          $query4  = "SELECT * FROM schedule_block WHERE CAST('".$time_end."' AS time) BETWEEN time_start AND time_end AND teacher_id='".$teacher."' AND day='".$day."'";
          $result4 = mysqli_query($connection, $query4);

          if (mysqli_num_rows($result3) >= 1 OR mysqli_num_rows($result4) >=1) { // logical check for conflicts in time and teacher

           echo "<div class=\"alert alert-warning\" role=\"alert\">";
           echo "Conflict in schedule! This teacher is already assigned to the set time range.";
           echo "</div>";
        }
        else{


            $query  = "INSERT INTO schedule_block (subject_id, room, teacher_id, time_start, time_end, day, course_id ,year, term, section, school_yr,students_enrolled, student_limit) VALUES ('{$subject_id}', '{$room}', '{$teacher}', '{$time_start}', '{$time_end}', '{$day}', '{$course_id}', '{$year}', '{$term}', '{$section}', '{$sy}',$students_enrolled , '{$max_students}')";
            $result = mysqli_query($connection, $query);


            //update the teacher assigned to the selected subject and section on the students grade table

            $query_update_teacher  = "UPDATE student_grades SET teacher_id = '{$teacher}' WHERE subject_id='".$subject_id."' AND course_id='".$course_id."' AND year='".$year."' AND term='".$term."' AND section='".$section."'";
            $result_update_teacher = mysqli_query($connection, $query_update_teacher);

            if ($result === TRUE) {
              echo "<script type='text/javascript'>";
              echo "alert('Schedule successfully created!');";
              echo "</script>";

              $URL="view-schedule.php";
              echo "<script>location.href='$URL'</script>";
            } else {
              echo "Error updating record: " . $connection->error;
            }
          }
         }
        }

        if(isset($connection)){ mysqli_close($connection); }
        //close database connection after an sql command
        ?>
    </div>
 </div> 
  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>

