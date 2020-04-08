<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
      if (isset($_GET['subject_id'])) {
          $subject_id = $_GET["subject_id"]; //Refactor this validation later
        }
        else{
          $subject_id = NULL;
        }
        if ($subject_id == NULL) {
          redirect_to("view-subject.php");
       }

?>

  <title>Edit Subject</title>
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
          <a href="view-courses.php">View Courses</a>
        </li>
        <li class="breadcrumb-item active">
          Edit Subject
        </li>
      </ol>
      <h1>Edit Subject Form</h1>
      <hr>
     <form action="" method="post" >
      <h2>Edit Subject Info</h2>
      <?php

        $query  = "SELECT * FROM subjects WHERE subject_id = ".$subject_id;
        $result = mysqli_query($connection, $query);

        if ($result === !TRUE) {
              echo "<script type='text/javascript'>";
              echo "alert('No record exists!');";
              echo "</script>";

              $URL="view-subject.php";
              echo "<script>location.href='$URL'</script>";

        }

        while($row = mysqli_fetch_assoc($result))
          {
            echo  "<div class=\"form-group row\">";
            echo  "<label class=\"col-md-2 col-form-label\" for=\"subject-name\">Subject Name</label>";
            echo  "<div class=\"col-md-3\">";
            echo "<input id=\"subject-name\" name=\"subject-name\" type=\"text\" placeholder=\"Input Subject Name\" class=\"form-control\" required value=\"".$row['subject_name']."\">";
            echo "</div>";

            echo  "<label class=\"col-md-2 col-form-label\" for=\"subject-name\">Subject Code</label>";
            echo  "<div class=\"col-md-2\">";
            echo "<input id=\"subject-code\" name=\"subject-code\" type=\"text\" placeholder=\"Input Subject Code\" class=\"form-control\" required value=\"".$row['subject_code']."\">";
            echo "<span class=\"help-block\">Input the code for the subject (example: IT1)</span> ";
            echo "</div>";

            echo  "<label class=\"col-md-1 col-form-label\" for=\"subject-name\">Subject Units</label>";
            echo  "<div class=\"col-md-2\">";
            echo "<input id=\"subject-units\" min=\"1\" max=\"6\" type=\"number\" name=\"units\" placeholder=\"1\" class=\"form-control\" required value=\"".$row['units']."\">";
            echo "</div>";

          }

    ?>
      </div>
      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
         <input type="submit" name="submit" value="Edit Subject" class="btn btn-primary" />&nbsp;
         <a class="btn btn-secondary"href="view-subject.php">Cancel</a>
        </div>
      </div>
    </form>
  </div>
 </div> 
  <!-- /#wrapper -->
<?php
  if (isset($_POST['submit'])) {
    $subject_name = $_POST["subject-name"];
    $subject_code = $_POST["subject-code"];
    $units = (int) $_POST["units"];

    if (!isset($subject_name) || !isset($subject_code) || !isset($units) || $subject_name == "" || $subject_code == "" || $units == "") {
      die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
    }
    elseif (is_int($units) == 0) {
      die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Units value should be integer.</div>");
    }

    else{
      $query  = "UPDATE subjects SET subject_name = '{$subject_name}', subject_code = '{$subject_code}', units = '{$units}' WHERE subject_id = {$subject_id} LIMIT 1";
      $result = mysqli_query($connection, $query);

      if ($result === TRUE) {
        echo "<script type='text/javascript'>";
        echo "alert('Edit subject successful!');";
        echo "</script>";

        $URL="view-subject.php";
        echo "<script>location.href='$URL'</script>";
      } else {
                echo "Error updating record: " . $connection->error;
      }
    }
  }

?>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>

<?php include 'layout/footer.php';?>



