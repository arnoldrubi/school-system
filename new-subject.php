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
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-plus-square"></i>
          New Subject</div>
          <div class="card-body">
           <form class="form-horizontal" action="" method="post" >
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="subject-name">Subject Name:</label>  
              <div class="col-md-10">
               <input id="subject-name" name="subject-name" type="text" placeholder="Input Subject Name" class="form-control" required>            
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="subject-code">Subject Code:</label>  
              <div class="col-md-10">
               <input id="subject-code" name="subject-code" type="text" placeholder="Subject Code" class="form-control" required>
               <span class="help-block">Input the code for the subject (example: IT1)</span>  
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="subject-name">Lecture Units:</label>  
              <div class="col-md-1">
               <input id="lect-units" name="lect_units" min="1" max="6" type="number" class="form-control" placeholder="1" required>            
              </div>
              <label class="col-md-2 col-form-label" for="subject-code">Lab Units:</label>  
              <div class="col-md-1">
               <input id="lab-units" name="lab_units" min="0" max="6" type="number" class="form-control" placeholder="0">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="pre_id">Prerequisite Subject:</label>  
              <div class="col-md-5">
               <select class="form-control" name="pre_id">
                <option value="">None</option>
                  <?php
                    $query  = "SELECT * FROM subjects ORDER BY subject_code";
                    $result = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($result)){
                      echo "<option value=\"".$row['subject_id']."\">".$row['subject_code'].": ".$row['subject_name']."</option>";
                    }
                  ?>              
               </select>        
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
              <input type="submit" name="submit" value="Create Subject" class="btn btn-success" />&nbsp;
              <a class="btn btn-secondary"href="view-subject.php">Cancel</a>
              </div>
            </div>
          </form>

      <?php 

        if (isset($_POST['submit'])) {
          // character trims are done to make sure the whitespaces at the start and end of string for Subject Name and Code are removed
          // this will help the validation of duplicat values
          $subject_name = ltrim(rtrim(mysql_prep($_POST["subject-name"])));
          $subject_code = ltrim(rtrim(strtoupper(mysql_prep($_POST["subject-code"]))));
          $lect_units = (int) $_POST["lect_units"];
          $lab_units = (int) $_POST["lab_units"];
          $total_units = $lab_units + $lect_units;
          $pre_id = (int) $_POST["pre_id"];

          $row_count = return_duplicate_entry("subjects","subject_name",$subject_name,"",$connection);

          if ($row_count > 0) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Subject name: ".$subject_name." already exists.</div>");
          }

          $row_count = return_duplicate_entry("subjects","subject_code",$subject_code,"",$connection);

          if ($row_count > 0) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Subject code: ".$subject_code." already exists.</div>");
          }

          if (!isset($subject_name) || !isset($subject_code) || $subject_name == "" || $subject_code == "") {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
          }
          elseif (is_int($total_units) == 0) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Units value should more than 0.</div>");
          }
          else{
              $query   = "INSERT INTO subjects (subject_name, subject_code, lect_units, lab_units, total_units,pre_id) VALUES ('{$subject_name}', '{$subject_code}', '{$lect_units}', '{$lab_units}', '{$total_units}', '{$pre_id}')";
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
        </div>
      </div>
    </div>
 </div> 
  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>


<script type="text/javascript">
  
  $("#lect-units,#lab-units").change(function () {
    var = total_units;
    total_units = $("#lect-units").val() + $("#lab-units");
    $("#total-units").value(total_units);
  });

</script>