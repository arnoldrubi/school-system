<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>


  <title>Add New Class</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php include 'layout/admin-sidebar.php';?>

  <?php

  if (isset($_GET['class_id'])) {
    $class_id = $_GET["class_id"]; //Refactor this validation later
  }
  else{
    $class_id = NULL;
  }
  if ($class_id == NULL) {
    redirect_to("view-teachers-and-rooms.php");
  }

   $query  = "SELECT * FROM classes WHERE class_id =".$class_id." LIMIT 1";
   $result = mysqli_query($connection, $query);

   while($row = mysqli_fetch_assoc($result))
    {
      $sec_id = $row['sec_id'];
      $subject_id = $row['subject_id'];
      $teacher_id = $row['teacher_id'];
      $current_limit = $row['student_limit'];
    }

   $query  = "SELECT * FROM sections WHERE sec_id =".$sec_id." LIMIT 1";
   $result = mysqli_query($connection, $query);

   while($row = mysqli_fetch_assoc($result))
    {
      $course_id = $row['course_id'];
      $year = $row['year'];
    }
  ?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="view-teachers-and-rooms.php">Faculty and Room Management</a>
        </li>
        <li class="breadcrumb-item active">
          <a href="classes.php">Classes</a>
        </li>
        <li class="breadcrumb-item active">
          Edit Class
        </li>
      </ol>
          <h4><i class="fa fa-bell" aria-hidden="true"></i> Edit Class</h4> 
          <hr>

      <form class="form-horizontal block-area" action="" method="post">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Course">Course:</label>
          <div class="col-sm-10">
            <select id="course" class="form-control" name="course">
              <?php
              //this block will load the course name from the database
              $query  = "SELECT * FROM courses WHERE course_deleted = 0";
              $result = mysqli_query($connection, $query);


              while($row = mysqli_fetch_assoc($result))
                {
                  $course_code = $row['course_code'];
                  if ($row['course_id'] == $course_id) {
                   echo  "<option value=\"".$row['course_id']."\" readonly selected>".$course_code."</option>";
                  }

                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Year">Year:</label>
          <div class="col-sm-10">
            <select id="select-yr" class="form-control" name="year">
              <?php
              echo "<option value=\"".$year."\" readonly selected>".$year."</option>";
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Term">Term:</label>
          <div class="col-sm-10">
            <select id="term" readonly class="form-control" name="term">
                <?php
                  $term = return_current_term($connection,"");
                  echo  "<option readonly selected value=\"".$term."\">".$term."</option>";
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Year">School Year:</label>
          <div class="col-sm-10">
            <select readonly id="school_yr" class="form-control" name="school_yr">
              <?php
                  $sy = return_current_sy($connection,"");
                  echo  "<option readonly selected value=\"".$sy."\">".$sy."</option>";
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Section">Section:</label>
          <div class="col-sm-10">
            <select id="section" class="form-control" name="section">
              <?php
                  $section_name = get_section_name($sec_id,"",$connection);
                  echo  "<option readonly selected value=\"".$sec_id."\">".$section_name."</option>";
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Section">Subject:</label>
          <div class="col-sm-10">
            <select id="subject" class="form-control" name="subject">
              <?php
                $school_yr = return_current_sy($connection,"");
                $query  = "SELECT * FROM course_subjects WHERE course_id=".$course_id." AND year='".$year."' AND term='".$term."' AND school_yr='".$school_yr."'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result)< 1) {
                  echo "<option value=\"N/A\">No Section Created Yet Under This Course and Year</option>";
                }
                else{
                   while($row = mysqli_fetch_assoc($result))
                    { 
                     if ($subject_id == $row['subject_id']) {
                      echo "<option selected value=\"".$row['subject_id']."\">".get_subject_code($row['subject_id'],"",$connection).": ".get_subject_name($row['subject_id'],"",$connection)."</option>";
                     }
                     else{
                      echo "<option value=\"".$row['subject_id']."\">".get_subject_code($row['subject_id'],"",$connection).": ".get_subject_name($row['subject_id'],"",$connection)."</option>";
                     }
                    }
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Section">Teacher:</label>
          <div class="col-sm-10">
            <select id="teacher" class="form-control" name="teacher">
              <?php
              //this block will load the course name from the database
              $query  = "SELECT * FROM teachers";
              $result = mysqli_query($connection, $query);


              while($row = mysqli_fetch_assoc($result))
                {
                  if ($row['teacher_id'] == $teacher_id) {
                  echo  "<option selected value=\"".$row['teacher_id']."\">".get_teacher_name($row['teacher_id'],"",$connection)."</option>";
                  }
                  else{
                  echo  "<option value=\"".$row['teacher_id']."\">".get_teacher_name($row['teacher_id'],"",$connection)."</option>";
                  }
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Section">Max Students:</label>
          <div class="col-sm-2">
          <?php        
            echo "<input id=\"max-students\" name=\"max_students\" type=\"number\" min=\"1\" max=\"99\" value=\"".$current_limit."\" placeholder=\"Max: 99\" class=\"form-control\" required>";
          ?>            
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6 offset-md-3">
            <button id="submit" name="submit" type="submit" class="btn btn-success form-control btn-sm">Submit</button>
          </div>
        </div>
      </form>

     </div>
    </div>

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

    <?php

      if (isset($_POST['submit'])) {
          $course_id = $_POST["course"];
          $section = $_POST["section"];
          $subject = $_POST["subject"];
          $teacher = $_POST["teacher"];
          $year = $_POST["year"];
          $term = $_POST["term"];
          $school_yr = $_POST["school_yr"];
          $sec_name = get_section_name($section,"",$connection);

          $max_students_enrolled = (int)$_POST["max_students"];
          $current_students = get_enrolled_regular_students($connection,"",$course_id,$year,$term,$sec_name,$school_yr);

          if (!isset($course_id) || !isset($section) || !isset($subject) || !isset($teacher)) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
          }
          else{
            $query  = "UPDATE classes SET sec_id = '{$section}', subject_id = '{$subject}', teacher_id = '{$teacher}', students_enrolled = '{$current_students}', student_limit = '{$max_students_enrolled}' WHERE class_id ='".$class_id."' LIMIT 1";
            $result = mysqli_query($connection, $query);

            if ($result === TRUE) {
            echo "<script type='text/javascript'>";
            echo "alert('Class is now updated!');";
            echo "</script>";

            $URL="classes.php";
            echo "<script>location.href='$URL'</script>";
            } else {
            echo "Error updating record: " . $connection->error;
            }
          }
         }

     if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>

     </div>
    </div>
  </div>
<?php include 'layout/footer.php';?>
