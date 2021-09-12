<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Request for Transfer of Credits</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php

  include 'layout/admin-sidebar.php';

  if (isset($_GET['id'])) {  

  $id = $_GET['id'];

  $query  = "SELECT * FROM transfer_of_credits WHERE id=".$id." LIMIT 1";
  $result = mysqli_query($connection, $query);
  while($row = mysqli_fetch_assoc($result))
  {
    $stud_reg_id = $row['stud_reg_id'];
    $student_number = $row['student_number'];
    $subject_code = $row['subject_desc'];
    $subject_name = $row['subject_name'];
    $school_name = $row['school_name'];
    $term_taken = $row['term_taken'];
    $year_taken = $row['year_taken'];
    $equivalent_subject_id =  $row['equivalent_subject_id'];
    $final_grade =  $row['final_grade'];
    $units =  $row['units'];
  }

  }
  else{
    redirect_to("view-toc.php");
  }



  ?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
         <a href="registrar-services.php">Registrar Services</a>
        </li>
        <li class="breadcrumb-item active">
         Transfer of Credits
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-th-list"></i>
          Transfer of Credits <?php echo "for ".get_student_name($stud_reg_id, $connection); ?></div>
          <div class="card-body">
           <form method="post">
            <h4>Requester's Information</h4> 
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="Student Number">Student Number</label>  
              <div class="col-md-2">

              <?php
                echo "<input id=\"student-number\" value=\"".$student_number."\" name=\"student_number\"  readonly required class=\"form-control\">";
              ?>
              </div>
            </div>

            <hr>
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="LastName">Subject Code</label>  
              <div class="col-md-4">
              <?php
                echo "<input id=\"subject-name\" name=\"subject_name\" type=\"text\" value=\"".$subject_code."\" class=\"form-control\" required>";
              ?>
              </div>

              <label class="col-md-2 col-form-label" for="FirstName">Subject Description</label>  
              <div class="col-md-4">
              <?php
                echo "<input id=\"subject-desc\" name=\"subject_description\" type=\"text\" value=\"".$subject_name."\" class=\"form-control\" required>";
              ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="MiddleName">Name of School</label>  
              <div class="col-md-4">
              <?php
                echo "<input id=\"school-name\" name=\"school_name\" type=\"text\" value=\"".$school_name."\" class=\"form-control\" required>";
              ?>
              </div>

              <label class="col-md-2 col-form-label" for="NameExt">Units</label>  
              <div class="col-md-1">
              <?php
                echo "<input id=\"units\" required name=\"units\" type=\"text\" value=\"".$units."\" class=\"form-control\">";
              ?>
              </div>
            </div>
            <hr>
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="schoolname">School Year Taken</label>  
              <div class="col-md-2">
              <?php
                echo "<input id=\"school-year-taken\" name=\"school_yr_taken\" type=\"text\" value=\"".$year_taken."\" placeholder=\"Input School Year\" class=\"form-control\" required>";
              ?>
              </div>

              <label class="col-md-2 col-form-label" for="NameExt">Term Taken</label>  
              <div class="col-md-2">
                <select id="term-taken" name="term_taken"class="form-control"required>
                  <option readonly>Select Term</option>
                  <?php

                    $terms = array("1st Semester", "2nd Semester", "1st Trimester", "2nd Trimester", "3rd Trimester");

                    for ($i=0; $i < count($terms); $i++) { 
                      if ($term_taken == $terms[$i]) {
                        echo "<option value=\"".$terms[$i]."\" selected>".$terms[$i]."</option>";
                      }
                      else{
                        echo "<option value=\"".$terms[$i]."\">".$terms[$i]."</option>";
                      }
                    }
                  ?>
                </select>
              </div>
              <label class="col-md-2 col-form-label" for="NameExt">Final Grade</label>  
              <div class="col-md-2">
                <input id="final-grade" name="final_grade" type="number" min="1" max="5" step=".25" placeholder="Final Grade" class="form-control" required <?php echo "value=\"".$final_grade."\""; ?> >
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="NameExt">Equivalent Subject</label>  
              <div class="col-md-3">
                <select class="form-control" name="subject_id" id="subject-id" required>
                  <option readonly>Select Subject</option>
                  <?php

                    $query  = "SELECT * FROM subjects ORDER BY subject_code ASC";
                    $result = mysqli_query($connection, $query);

                  while($row = mysqli_fetch_assoc($result))
                    {
                      $subject_units = $row['units'];
                      $subject_code = $row['subject_code'];

                      if ($equivalent_subject_id == $row['subject_id']) {
                        echo "<option value=\"".$row['subject_id']."\" selected>".$subject_code."</option>";
                      }
                      else{
                        echo "<option value=\"".$row['subject_id']."\">".$subject_code."</option>";
                      }
                      
                    }

                  ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
              <input type="submit" name="submit" value="Edit Request" class="btn btn-success" />&nbsp;
              <a class="btn btn-secondary" href="view-toc.php">Cancel</a>
              </div>
            </div>
          </form>

        </div>
      </div>
  </div>
 </div> 
  <!-- /#wrapper -->

<?php 

  if (isset($_POST['submit'])) {

    $student_number = mysql_prep($_POST["student_number"]);
    $student_reg_id = get_student_reg_id($student_number,$connection);
    $subject_desc = mysql_prep($_POST["subject_description"]);
    $subject_name = mysql_prep($_POST["subject_name"]);
    $school_name = mysql_prep($_POST["school_name"]);
    $units = (int) $_POST["units"];
    $school_yr_taken = mysql_prep($_POST["school_yr_taken"]);
    $term_taken = mysql_prep($_POST["term_taken"]);   
    $final_grade = mysql_prep($_POST["final_grade"]);
    $equivalent_subject_id = (int) $_POST["subject_id"];

    $query = "UPDATE transfer_of_credits SET subject_desc = '{$subject_desc}', subject_name = '{$subject_name}', school_name = '{$school_name}', units = '{$units}', year_taken = '{$school_yr_taken}', term_taken = '{$term_taken}', final_grade = '{$final_grade}', equivalent_subject_id = '{$equivalent_subject_id}' WHERE stud_reg_id=".$stud_reg_id." LIMIT 1";
    $result = mysqli_query($connection, $query);

  if ($result === TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('Edit of TOC Successful!');";
    echo "</script>";

    $URL="manage-toc.php?stud_reg_id=".$stud_reg_id;
    echo "<script>location.href='$URL'</script>";
  } else {
      echo "Error updating record: " . $connection->error;
  }
}

  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>


  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>

