<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>


  <title>Add New Class</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <?php 
    if (isset($_GET['sec_id'])) {
      $sec_id = $_GET["sec_id"];
      $sec_name = get_section_name($sec_id,"",$connection);
      $year = get_section_year($sec_id,"",$connection);

      $query  = "SELECT * FROM sections WHERE sec_id='".$sec_id."'";
      $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
      {
        $course_id = $row['course_id'];
      }

    }
    else{
      redirect_to("sections-and-classes.php");
    }
    if (isset($_GET['subject_id'])) {
     $subject_id = $_GET['subject_id'];
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
          <a href="view-teachers-and-rooms.php">Faculty and Room Management</a>
        </li>
        <li class="breadcrumb-item active">
          <a href="classes.php">Classes</a>
        </li>
        <li class="breadcrumb-item active">
          Add New Class
        </li>
      </ol>
          <h4><i class="fa fa-bell" aria-hidden="true"></i> New Class</h4> 
          <hr>

      <form class="form-horizontal block-area" action="" method="post">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Course">Course:</label>
          <div class="col-sm-10">
            <select id="course" class="form-control" name="course">
              <?php
                $course_code = get_course_code($course_id,"",$connection);
                echo  "<option value=\"".$course_id."\">".$course_code."</option>";
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Year">Year:</label>
          <div class="col-sm-10">
            <select id="select-yr" class="form-control" name="year">
              <?php 
                 echo  "<option value=\"".$year."\">".$year."</option>";
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
                  echo  "<option value=\"".$term."\">".$term."</option>";
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
                  echo  "<option value=\"".$sy."\">".$sy."</option>";
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Section">Section:</label>
          <div class="col-sm-10">
            <select id="section" class="form-control" name="section">
              <?php 
                echo  "<option value=\"".$sec_id."\">".$sec_name."</option>";
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Section">Subject:</label>
          <div class="col-sm-10">
            <select id="subject" class="form-control" name="subject">
              <?php
                echo  "<option value=\"".$subject_id."\">".get_subject_code($subject_id,"",$connection).": ".get_subject_name($subject_id,"",$connection)."</option>";
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
                  echo  "<option value=\"".$row['teacher_id']."\">".get_teacher_name($row['teacher_id'],"",$connection)."</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label control-label" for="Section">Max Students:</label>
          <div class="col-sm-2">
            <input id="max-students" name="max_students" type="number" min="1" max="99" placeholder="Max: 99" class="form-control" required="">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6 offset-md-3">
            <button id="submit" name="submit" type="submit" class="btn btn-success form-control btn-sm">Submit</button>
          </div>
        </div>
      </form>

    

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
          $current_students = get_enrolled_regular_students($sec_id,$term,$school_yr,"",$connection);

          if (!isset($course_id) || !isset($section) || !isset($subject) || !isset($teacher)) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
          }
          else{

            $query_check= "SELECT * FROM classes WHERE sec_id='".$section."' AND subject_id='".$subject."'";
            $result_check = mysqli_query($connection, $query_check);

            if (mysqli_num_rows($result_check) > 0) {
                echo "<div class=\"alert alert-danger\" role=\"alert\">Error: Class for this subject has already been created.</div>";
            }
            else{
              $query   = "INSERT INTO classes (sec_id, subject_id, teacher_id, students_enrolled, student_limit, term, school_yr) VALUES ('{$section}', '{$subject}', '{$teacher}', '{$current_students}','{$max_students_enrolled}', '{$term}', '{$school_yr}')";
              $result = mysqli_query($connection, $query);

              if ($result === TRUE) {
              redirect_to("classes.php?sec_id=".urlencode($sec_id)."&term=".urlencode($term)."&school_yr=".urlencode($school_yr));
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
  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


     </div>
    </div>
  </div>
<?php include 'layout/footer.php';?>
