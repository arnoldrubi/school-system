<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
      if (isset($_GET['course_id'])) {
          $course_id = $_GET["course_id"]; //Refactor this validation later
        }
        else{
          $course_id = NULL;
        }
        if ($course_id == NULL) {
          redirect_to("view-courses.php");
       }

?>

  <title>Edit Course Info</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php include 'layout/admin-sidebar.php';?>
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
          <i class="fa fa-pencil-square-o"></i>
            Edit Course</div>
        <div class="card-body">
         <form class="form-horizontal" action="" method="post" >
          <?php

            $query  = "SELECT * FROM courses WHERE course_id = ".$course_id;
            $result = mysqli_query($connection, $query);

            if ($result === !TRUE) {
                  echo "<script type='text/javascript'>";
                  echo "alert('No record exists!');";
                  echo "</script>";

                  $URL="view-courses.php";
                  echo "<script>location.href='$URL'</script>";

            }

            while($row = mysqli_fetch_assoc($result))
              {

                $old_course_code = $row['course_code'];
                $old_course_desc = $row['course_desc'];
                echo  "<div class=\"form-group row\">";
                echo  "<label class=\"col-md-2 col-form-label\" for=\"course-desc\">Course Description</label>";
                echo  "<div class=\"col-md-8\">";
                echo "<input id=\"course-desc\" name=\"course-desc\" type=\"text\" placeholder=\"Input Course Description\" class=\"form-control input-md\" required=\"\" value=\"".$old_course_code."\">";
                echo "</div></div>";

                echo  "<div class=\"form-group row\">";
                echo  "<label class=\"col-md-2 col-form-label\" for=\"course-code\">Course Code</label>";
                echo  "<div class=\"col-md-4\">";
                echo "<input id=\"course-code\" name=\"course-code\" type=\"text\" placeholder=\"Course Code\" class=\"form-control input-md\" required=\"\" value=\"".$old_course_desc."\">";
                echo "</div></div>";

              }

      if (isset($_POST['submit'])) {
        $course_desc = ltrim(rtrim(mysql_prep($_POST["course-desc"])));
        $course_code = ltrim(rtrim(mysql_prep($_POST["course-code"])));

        if ($old_course_code !== $course_code) {
          $row_count = return_duplicate_entry("courses","course_code",$course_code,"",$connection);

          if ($row_count > 0) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Course Code: \"".$course_code."\" already exists.</div>");
          }
        }

        if ($old_course_desc !== $course_desc) {
          $row_count = return_duplicate_entry("courses","course_desc",$course_desc,"",$connection);

          if ($row_count > 0) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Course Description: \"".$course_desc."\" already exists.</div>");
          }
        }

        $query  = "UPDATE courses SET course_desc = '{$course_desc}', course_code = '{$course_code}' WHERE course_id = {$course_id} LIMIT 1";
        $result = mysqli_query($connection, $query);


        if ($result === TRUE) {
          echo "<script type='text/javascript'>";
          echo "alert('Edit course successful!');";
          echo "</script>";

          $URL="view-courses.php";
          echo "<script>location.href='$URL'</script>";
        } else {
            echo "Error updating record: " . $connection->error;
        }

      }
    ?>

            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
              <input type="submit" name="submit" value="Edit Course" class="btn btn-success" />&nbsp;
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


<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>

<?php include 'layout/footer.php';?>



