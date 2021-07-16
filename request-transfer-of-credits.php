<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Request for Transfer of Credits</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php

  include 'layout/admin-sidebar.php';?>

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
          Certificate Transfer of Credits</div>
          <div class="card-body">
           <form method="post">
            <h4>Requester's Information</h4> 
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="Student Number">Student Number</label>  
              <div class="col-md-2">
              <input id="student-number" value="" name="student_number"  placeholder="Example: 2019-BSCRIM001"  required  class="form-control">
              </div>
            </div>

            <hr>
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="LastName">Subject Name</label>  
              <div class="col-md-4">
              <input id="subject-name" name="subject_name" type="text" placeholder="Input Subject Name" class="form-control" required>
              </div>

              <label class="col-md-2 col-form-label" for="FirstName">Subject Description</label>  
              <div class="col-md-4">
              <input id="subject-desc" name="subject_description" type="text" placeholder="Input Subject Description" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="MiddleName">Name of School</label>  
              <div class="col-md-4">
              <input id="school-name" name="school_name" type="text" placeholder="Input Name of School" class="form-control" required>
              </div>

              <label class="col-md-2 col-form-label" for="NameExt">Units</label>  
              <div class="col-md-1">
                <input id="units" name="units" type="text" placeholder="Units" class="form-control">
              </div>
            </div>
            <hr>
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="MiddleName">School Year Taken</label>  
              <div class="col-md-2">
              <input id="school-year-taken" name="school_yr_taken" type="text" placeholder="Input School Year" class="form-control" required>
              </div>

              <label class="col-md-2 col-form-label" for="NameExt">Term Taken</label>  
              <div class="col-md-2">
                <select id="term-taken" name="term_taken"class="form-control"required>
                  <option readonly>Select Term</option>
                  <option value="1st Semester">1st Semester</option>
                  <option value="2nd Semester">2nd Semester</option>
                  <option value="1st Trimester">1st Trimester</option>
                  <option value="2nd Trimester">2nd Trimester</option>
                  <option value="3rd Trimester">3rd Trimester</option>
                </select>
              </div>
              <label class="col-md-2 col-form-label" for="NameExt">Final Grade</label>  
              <div class="col-md-2">
                <input id="final-grade" name="final_grade" type="number" step=".01" placeholder="Final Grade" class="form-control" required>
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

                      echo "<option value=\"".$row['subject_id']."\">";
                      echo $subject_code;
                      echo "</option>";
                    }

                  ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
              <input type="submit" name="submit" value="Process Request" class="btn btn-success" />&nbsp;
              <a class="btn btn-secondary" href="registrar-services.php">Cancel</a>
              </div>
            </div>
          </form>
          <div class="form-group row">
            <div class="col-md-12">
              <p>Can't remember the Student Number? <br>
              <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#student-info" aria-expanded="false" aria-controls="student-info">
                Try searching using his/her name. 
              </button>
              </p>
            </div>
         </div>
          <div class="form-group row collapse" id="student-info">
            <label class="col-md-2 col-form-label" for="Student_LastName">Input Student's Last Name</label>  
            <div class="col-md-10">
            <input id="StudentLastName" name="student_lastname" type="text" placeholder="Input Student's Last Name" class="form-control">
            </div>
            <label class="col-md-12 col-form-label" for="FirstName">OR </label>  
            <label class="col-md-2 col-form-label" for="FirstName">Input Student's First Name</label>  
            <div class="col-md-10">
            <input id="StudentFirstName" name="student_firstname" type="text" placeholder="Input Student's First Name" class="form-control">
            </div>
            <div class="col-md-12" id="student-list">            
            </div>
          </div>
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
    $final_grade = (int) $_POST["final_grade"];
    $equivalent_subject_id = (int) $_POST["subject_id"];

    $query   = "INSERT INTO transfer_of_credits (stud_reg_id, student_number, subject_desc, subject_name, school_name, term_taken, year_taken, equivalent_subject_id, final_grade) VALUES ('{$student_reg_id}', '{$student_number}', '{$subject_desc}', '{$subject_name}', '{$school_name}', '{$term_taken}', '{$school_yr_taken}', '{$equivalent_subject_id}', '{$final_grade}')";
    $result = mysqli_query($connection, $query);

  if ($result === TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('Transfer of Credits Successful!');";
    echo "</script>";

    $URL="registrar-services.php";
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


  <script>
  $(document).ready(function() {
    $("#StudentLastName").keyup(function(){
      var StudentLastName = $("#StudentLastName").val();
      //run ajax
      $.post("scan_student_name.php",
        {StudentLastName: StudentLastName}
        ,function(data,status){
        $("#student-list").html(data);
      });
    });
    $("#StudentFirstName").keyup(function(){
      var StudentFirstName = $("#StudentFirstName").val();
      //run ajax
      $.post("scan_student_name.php",{
        StudentFirstName: StudentFirstName
      },function(data,status){
        $("#student-list").html(data);
      });
    });
  });
  </script>