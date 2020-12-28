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
        <label class="col-md-1 col-form-label" for="subject-name">Subject Name</label>  
        <div class="col-md-2">
         <input id="subject-name" name="subject-name" type="text" placeholder="Input Subject Name" class="form-control" required>            
        </div>
        <label class="col-md-1 col-form-label" for="subject-code">Subject Code</label>  
        <div class="col-md-2">
         <input id="subject-code" name="subject-code" type="text" placeholder="Subject Code" class="form-control" required>
         <span class="help-block">Input the code for the subject (example: IT1)</span>  
        </div>
        <label class="col-md-1 col-form-label" for="subject-name">Lecture Units</label>  
        <div class="col-md-2">
         <input id="lect-units" name="lect_units" min="1" max="6" type="number" class="form-control" placeholder="1" required>            
        </div>
        <label class="col-md-1 col-form-label" for="subject-code">Lab Units</label>  
        <div class="col-md-2">
         <input id="lab-units" name="lab_units" min="0" max="6" type="number" class="form-control" placeholder="0" required>
        </div>
      </div>
<!--       <div class="form-group row">
        <label class="col-md-1 col-form-label" for="subject-name">Lecture Units</label>  
        <div class="col-md-2">
         <input id="lect-units" name="lect-units" min="1" max="6" type="number" name="lect_units" class="form-control" required>            
        </div>
        <label class="col-md-1 col-form-label" for="subject-code">Lab Units</label>  
        <div class="col-md-2">
         <input id="lab-units" name="lab-units" min="1" max="6" type="number" name="lab_units" class="form-control" required>
        </div>
        <label class="col-md-1 col-form-label" for="subject-code">Total Units</label>  
        <div class="col-md-2">
         <input id="total-units" class="form-control" min="1" max="6" type="number" name="units" placeholder="1" required>
        </div>
      </div> -->
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
          $lect_units = (int) $_POST["lect_units"];
          $lab_units = (int) $_POST["lab_units"];
          $total_units = $lab_units + $lect_units;

          if (!isset($subject_name) || !isset($subject_code) || !isset($lect_units) || !isset($lab_units) || $subject_name == "" || $subject_code == "" || $lect_units == "" || $lab_units == "") {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
          }
          elseif (is_int($total_units) == 0) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Units value should more than 0.</div>");
          }
          else{
              $query   = "INSERT INTO subjects (subject_name, subject_code, lect_units, lab_units, total_units) VALUES ('{$subject_name}', '{$subject_code}', '{$lect_units}', '{$lab_units}', '{$total_units}')";
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


<script type="text/javascript">
  
  $("#lect-units,#lab-units").change(function () {
    var = total_units;
    total_units = $("#lect-units").val() + $("#lab-units");
    $("#total-units").value(total_units);
  });

</script>