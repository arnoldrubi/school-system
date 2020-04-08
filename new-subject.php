<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>New Subject</title>
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
          New Subject
        </li>
      </ol>
      <h1>Create New Subject Form</h1>
      <hr>
      <!-- Text input-->
     <form action="" method="post" >
      <h2>Build Subject Info</h2>
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="subject-name">Subject Name</label>  
        <div class="col-md-3">
         <input id="subject-name" name="subject-name" type="text" placeholder="Input Subject Name" class="form-control" required>            
        </div>
        <label class="col-md-2 col-form-label" for="subject-code">Subject Code</label>  
        <div class="col-md-2">
         <input id="subject-code" name="subject-code" type="text" placeholder="Subject Code" class="form-control" required>
         <span class="help-block">Input the code for the subject (example: IT1)</span>  
        </div>
        <label class="col-md-1 col-form-label" for="subject-code">Subject Units</label>  
        <div class="col-md-2">
         <input id="subject-units" class="form-control" min="1" max="6" type="number" name="units" placeholder="1" required>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
        <input type="submit" name="submit" value="Create Subject" class="btn btn-primary" />&nbsp;
        <a class="btn btn-secondary"href="view-subject.php">Cancel</a>
        </div>
      </div>
    </form>
  </div>
 </div> 
      <?php 

        if (isset($_POST['submit'])) {
          $subject_name = mysql_prep($_POST["subject-name"]);
          $subject_code = strtoupper(mysql_prep($_POST["subject-code"]));
          $units = (int) $_POST["units"];

          if (!isset($subject_name) || !isset($subject_code) || !isset($units) || $subject_name == "" || $subject_code == "" || $units == "") {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
          }
          elseif (is_int($units) == 0) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Units value should be integer.</div>");
          }
          else{
              $query   = "INSERT INTO subjects (subject_name, subject_code, units) VALUES ('{$subject_name}', '{$subject_code}', '{$units}')";
              $result = mysqli_query($connection, $query);

            if ($result === TRUE) {
              echo "<script type='text/javascript'>";
              echo "alert('Create subject successful!');";
              echo "</script>";

              $URL="new-subject.php";
              echo "<script>location.href='$URL'</script>";
            } else {
                echo "Error updating record: " . $connection->error;
            }
        }
      }

        if(isset($connection)){ mysqli_close($connection); }
        //close database connection after an sql command
        ?>
  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>