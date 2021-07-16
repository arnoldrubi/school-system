<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Add New Course</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "courses";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="view-courses.php">View All Courses</a>
        </li>
        <li class="breadcrumb-item active">
            Create New Course
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-plus-square"></i>
          New Course</div>
          <div class="card-body">
           <form class="form-horizontal" action="" method="post" >
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="course-name">Course Description</label>  
              <div class="col-md-8">
                <input id="course-name" name="course-desc" type="text" placeholder="Input Course Description" class="form-control input-md" required="">                
              </div>
            </div>

            <div class="form-group row">
            <!-- Text input-->
              <label class="col-md-2 col-form-label" for="course-code">Course Code</label>  
              <div class="col-md-4">
                <input id="course-code" name="course-code" type="text" placeholder="Course Code" class="form-control input-md" required="">
                <span class="help-block">Input the Course Code (example: BSCRIM)</span>  
              </div>
            </div>

            <?php 

              if (isset($_POST['submit'])) {
                $course_desc = ltrim(rtrim(mysql_prep($_POST["course-desc"])));
                $course_code = ltrim(rtrim(strtoupper(mysql_prep($_POST["course-code"]))));

                $row_count = return_duplicate_entry("courses","course_code",$course_code,"",$connection);

                if ($row_count > 0) {
                  die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Course Code: \"".$course_code."\" already exists.</div>");
                }

                $row_count = return_duplicate_entry("courses","course_desc",$course_desc,"",$connection);

                if ($row_count > 0) {
                  die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Course Description: \"".$course_desc."\" already exists.</div>");
                }

                $query  = "SELECT * FROM courses WHERE course_code = '".$course_code."'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result)>0) {
                  echo "<script type='text/javascript'>";
                  echo "alert('Course already exists!');";
                  echo "</script>";

                  $URL="new-course.php";
                  echo "<script>location.href='$URL'</script>";
                }

                else{
                  $query   = "INSERT INTO courses (course_desc, course_code, course_deleted) VALUES ('{$course_desc}', '{$course_code}', 0)";
                  $result = mysqli_query($connection, $query);


                  if ($result === TRUE) {
                    echo "<script type='text/javascript'>";
                    echo "alert('Create course successful!');";
                    echo "</script>";

                    $URL="new-course.php";
                    echo "<script>location.href='$URL'</script>";
                  } else {
                      echo "Error updating record: " . $connection->error;
                  }
                }
              }

              if(isset($connection)){ mysqli_close($connection); }
              //close database connection after an sql command
              ?>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
              <input type="submit" name="submit" value="Create Course" class="btn btn-success" />&nbsp;
              <a class="btn btn-secondary"href="view-courses.php">Cancel</a>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
 </div> 
  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>