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
      <h1>Edit Subject Form</h1>
     <form action="" method="post" >
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
            echo  "<div class=\"form-group\">";
            echo  "<label class=\"col-md-4 control-label\" for=\"course-desc\">Course Description</label>";
            echo  "<div class=\"col-md-4\">";
            echo "<input id=\"course-desc\" name=\"course-desc\" type=\"text\" placeholder=\"Input Course Description\" class=\"form-control input-md\" required=\"\" value=\"".$row['course_desc']."\">";
            echo "</div></div>";

            echo  "<div class=\"form-group\">";
            echo  "<label class=\"col-md-4 control-label\" for=\"course-code\">Course Code</label>";
            echo  "<div class=\"col-md-4\">";
            echo "<input id=\"course-code\" name=\"course-code\" type=\"text\" placeholder=\"Course Code\" class=\"form-control input-md\" required=\"\" value=\"".$row['course_code']."\">";
            echo "</div></div>";

          }

  if (isset($_POST['submit'])) {
            $course_desc = $_POST["course-desc"];
            $course_code = $_POST["course-code"];

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

      <div class="col-md-4">
        <input type="submit" name="submit" value="Edit Course" class="btn btn-primary" />
        <a class="btn btn-secondary"href="view-courses.php">Cancel</a>
      </div>

    </form>
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



