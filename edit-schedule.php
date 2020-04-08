<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
      if (isset($_GET['schedule_id'])) {
          $schedule_id = $_GET["schedule_id"]; //Refactor this validation later
        }
        else{
          $schedule_id = NULL;
        }
        if ($schedule_id == NULL) {
          redirect_to("view-schedule.php");
       }

?>

  <title>Edit Schedule</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

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
         Edit Schedule Block
        </li>
      </ol>
     <h1>Edit Schedule Form</h1>
     <hr>
     <form action="" method="post" >
      <h2>Basic Course Info</h2>
      <?php

        $query  = "SELECT * FROM schedule_block WHERE schedule_id = ".$schedule_id;
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) < 1) {
              echo "<script type='text/javascript'>";
              echo "alert('No record exists!');";
              echo "</script>";

              $URL="view-schedule.php";
              echo "<script>location.href='$URL'</script>";

        }
        while($row = mysqli_fetch_assoc($result))
        {
          $current_course_id = $row['course_id'];
          $current_subject_id = $row['subject_id'];
          $year = $row['year'];
          $term = $row['term'];
          $sy = $row['school_yr'];
          $student_limit = $row['student_limit'];
          $students_enrolled = $row['students_enrolled'];
          $section = $row['section'];
        }
        $query  = "SELECT course_code FROM courses WHERE course_id='".$current_course_id."'";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($result))
          {
          $course_code = $row['course_code'];
        }
      ?>

      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="Course">Course</label>
        <div class="col-md-4">
          <input id="course-name" name="course" disabled="" type="text" value="<?php echo $course_code; ?>" class="form-control input-md" required="">
        </div>
        <label class="col-md-2 col-form-label" for="School Year">School Year</label>
        <div class="col-md-4">
          <?php
            echo  "<input id=\"sy\" name=\"sy\" disabled type=\"text\" value=\"".$sy."\"  class=\"form-control input-md\" required=\"\">";
          ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="Year">Year</label>
        <div class="col-md-4">
          <?php
            echo  "<input id=\"year\" name=\"year\" disabled type=\"text\" value=\"".$year."\"  class=\"form-control input-md\" required=\"\">";
          ?>
        </div>
        <label class="col-md-2 col-form-label" for="Term">Term</label>
        <div class="col-md-4">
          <?php
            echo  "<input id=\"term\" name=\"term\" disabled type=\"text\" value=\"".$term."\"  class=\"form-control input-md\" required=\"\">";
          ?>
        </div>
      </div>
      <hr>
      <h2>Edit Schedule Info</h2>
      <?php
          echo "<div class=\"form-group row\">";
          echo "<label class=\"col-md-2 col-form-label\" for=\"Subject\">Subject</label> ";
          echo "<div class=\"col-md-4\">";
          echo "<select class=\"form-control\" required name=\"subject\">";

          $query  = "SELECT * FROM subjects";
          $result = mysqli_query($connection, $query);

          while($row = mysqli_fetch_assoc($result))
            {
              if ($current_subject_id == $row['subject_id']) {
                echo  "<option value=".$row['subject_id']." required selected=\"selected\">".$row['subject_code']."</option>";
              }else{
                echo  "<option value=".$row['subject_id']." required>".$row['subject_code']."</option>";
             }
            }

         echo "</select></div>";

         echo "<label class=\"col-md-2 col-form-label\" for=\"Room\">Room</label>";
         echo "<div class=\"col-md-4\">";
         echo "<select class=\"form-control\" name=\"room\">";

        $query2  = "SELECT room FROM schedule_block WHERE schedule_id = ".$schedule_id;
        $result2 = mysqli_query($connection, $query2);

        while($row = mysqli_fetch_assoc($result2))
          {
            $current_room = $row['room'];
          }

           //this block will load the room name from the database
        $query  = "SELECT * FROM rooms";
        $result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($result))
          {
            if ($current_room == $row['room_name']) {
              echo  "<option value\"=".$row['room_id']."\" required selected=\"selected\">".$row['room_name']."</option>";
            }else{
              echo  "<option value\"=".$row['room_id']."\" required>".$row['room_name']."</option>";
            }
          }

        echo "</select></div></div>";

        ?>

        <div class="form-group row">
        <label class="col-md-2 col-form-label" for="Teacher">Teacher</label>  
        <div class="col-md-4">
         <select class="form-control" name="teacher" required>
           <?php
            $query2  = "SELECT teacher FROM schedule_block WHERE schedule_id = ".$schedule_id;
            $result2 = mysqli_query($connection, $query2);

            while($row = mysqli_fetch_assoc($result2))
              {
                $current_teacher = $row['teacher'];
              }
           //this block will load the teacher name from the database
              $query  = "SELECT * FROM teachers";
              $result = mysqli_query($connection, $query);


              while($row = mysqli_fetch_assoc($result))
                {
                  $teacher_full_name = $row['first_name']." ".$row['last_name'];
                  if ($current_teacher == $teacher_full_name) {
                    echo  "<option value=\"".$row['teacher_id']."\"". "selected=\"selected\">".$teacher_full_name."</option>";
                  }else{
                    echo  "<option value=\"".$row['teacher_id']."\">".$teacher_full_name."</option>";
                  }
                }
          ?>
         </select>
        </div>
        <label class="col-md-2 col-form-label" for="max-students">Max Students</label>  
          <div class="col-md-1">
            <input class="form-control" id="max-students" required min="1" max="99" type="number" value="<?php echo $student_limit; ?>" name="max_students" placeholder="1">
          </div>
        <label class="col-md-1 col-form-label" for="subject-code">Section</label>  
        <div class="col-md-1">
          <input id="section" type="text" name="section" class="form-control" <?php echo "value=\"".$section."\""; ?> required readonly="">
        </div>
       </div>
        <h2>Input Time and Day</h2>
        <div class="form-group row">          
          <label class="col-md-2 col-form-label" for="time-start">Time Start</label>  
          <div class="col-md-2">
           <input id="time-start" class="form-control" step="1" name="time-start" type="time" min="06:00" max="20:00"
        <?php

          $query  = "SELECT time_start FROM schedule_block WHERE schedule_id = ".$schedule_id;
          $result = mysqli_query($connection, $query);

          while($row = mysqli_fetch_assoc($result))
            {
              echo "value =\"".$row['time_start']."\"";
            }          
        ?>
        class="form-control input-md" required="">
          </div>
          <label class="col-md-2 col-form-label" for="description">Time End</label>  
          <div class="col-md-2">
          <input id="time-end" name="time-end" step="1" class="form-control" type="time" min="06:00" max="20:00"

          <?php

          $query  = "SELECT time_end FROM schedule_block WHERE schedule_id = ".$schedule_id;
          $result = mysqli_query($connection, $query);

          while($row = mysqli_fetch_assoc($result))
            {
              echo "value =\"".$row['time_end']."\"";
            }
          

        ?>

          class="form-control" required="">
       </div>

       <label class="col-md-2 col-form-label" for="description">Select Day(s)</label>  
         <div class="col-md-2">

            <!-- Multiselect dropdown -->
          <select name="day" required data-style="bg-white rounded-pill px-4 py-3 shadow-sm " class="form-control">
            <?php
              $query  = "SELECT * FROM schedule_block WHERE schedule_id = ".$schedule_id;
              $result = mysqli_query($connection, $query);


              while($row = mysqli_fetch_assoc($result))
              {
                  $day = $row['day'];
                  $course = $row['course_id'];

              }
              //Simple looping to get the correct day as selected when editing the text
              $weekdays = array('1', '2', '3', '4', '5', '6', '7');

              for ($i=0; $i < 6 ; $i++) { 
                if ($day == $weekdays[$i]) {
                  echo "<option value=\"".$weekdays[$i]."\" selected=\"selected\">".number_to_day($weekdays[$i])."</option>";
                }else{
                  echo "<option value=\"".$weekdays[$i]."\">".number_to_day($weekdays[$i])."</option>";
                }
              }

            ?>
          </select>
          </div>
      </div>

      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <input type="submit" name="submit" value="Edit Schedule" class="btn btn-primary" />&nbsp;
            <a class="btn btn-secondary"href="view-schedule.php">Cancel</a>
        </div>
      </div>

    </form>

        <?php

        if (isset($_POST['submit'])) {

          $subject_id = (int) $_POST["subject"];
          $teacher = mysql_prep($_POST["teacher"]);
          $room = mysql_prep($_POST["room"]);
          $time_start = ($_POST["time-start"]);
          $time_end = ($_POST["time-end"]);
          $day = mysql_prep($_POST['day']);
          $max_students = (int) $_POST["max_students"];

          // if (is_int($max_students) !== 1) {
          //   die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Max students value is not an integer.</div>");
          // }

          //series of validations to make sure all forms have values
          if (!isset($subject_id) || !isset($teacher) || !isset($room) || !isset($time_start) || !isset($time_end) || !isset($day) || !isset($max_students) || $subject_id == null || $teacher == null || $room == null || $time_start == null || $time_end == null || $day == null || $max_students == null) {
           die ("<div class=\"alert alert-danger\" role=\"alert\">One or more fields are empty.</div>");
          }
          else{

            $query  = "SELECT * FROM schedule_block WHERE CAST('".$time_start."' AS time) BETWEEN time_start AND time_end AND room='".$room."' AND day='".$day."' AND schedule_id <>'".$schedule_id."'";
            $result = mysqli_query($connection, $query);

            $query2  = "SELECT * FROM schedule_block WHERE CAST('".$time_end."' AS time) BETWEEN time_start AND time_end AND room='".$room."' AND day='".$day."' AND schedule_id <>'".$schedule_id."'";
            $result2 = mysqli_query($connection, $query2);

            if (mysqli_num_rows($result) >= 1 OR mysqli_num_rows($result2) >=1) { // logical check for conflicts in time

             echo "<div class=\"alert alert-warning\" role=\"alert\">";
             echo "Conflict in schedule! The time, room and day for this schedule is already taken.";
             echo "</div>";
          }else{

            if ($max_students < $students_enrolled) {
            echo "<script type='text/javascript'>";
            echo "alert('Student limit is less than the currently enrolled students in this subject and schedule')";
            echo "</script>"; 

            }

            else{
              $query  = "UPDATE schedule_block SET subject_id = '{$subject_id}', room = '{$room}', teacher_id = '{$teacher}', time_start = '{$time_start}', time_end = '{$time_end}', day = '{$day}', student_limit = '{$max_students}' WHERE schedule_id='".$schedule_id."' LIMIT 1";
              $result = mysqli_query($connection, $query);

              //another query to overwrite the teacher_id if there are other existing schedules
              $query_update_teacher  = "UPDATE schedule_block SET teacher_id = '{$teacher}' WHERE subject_id='".$subject_id."' AND course_id='".$current_course_id."' AND term='".$term."' AND year='".$year."' AND section='".$section."' AND school_yr='".$sy."'";
              $result_update_teacher = mysqli_query($connection, $query_update_teacher);

              $query_update_teacher_on_grades  = "UPDATE student_grades SET teacher_id = '{$teacher}' WHERE subject_id='".$subject_id."' AND course_id='".$current_course_id."' AND term='".$term."' AND year='".$year."' AND section='".$section."' AND school_yr='".$sy."'";
              $result_update_teacher_on_grades = mysqli_query($connection, $query_update_teacher_on_grades);


              if ($result === TRUE) {
                echo "<script type='text/javascript'>";
                echo "alert('Schedule successfully edited!');";
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
        }
      ?>
    </div>
 </div> 
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>



