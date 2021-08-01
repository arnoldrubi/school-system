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
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-pencil-square-o"></i>
          Edit Subjects</div>
          <div class="card-body">
           <form class="form-horizontal" action="" method="post" >
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
                  $old_subject_name = $row['subject_name'];
                  $old_subject_code = $row['subject_code'];

                  echo  "<div class=\"form-group row\">";
                  echo  "<label class=\"col-md-2 col-form-label\" for=\"subject-name\">Subject Name:</label>";
                  echo  "<div class=\"col-md-10\">";
                  echo "<input id=\"subject-name\" name=\"subject-name\" type=\"text\" placeholder=\"Input Subject Name\" class=\"form-control\" required value=\"".$old_subject_name."\">";
                  echo "</div></div>";

                  echo  "<div class=\"form-group row\"><label class=\"col-md-2 col-form-label\" for=\"subject-name\">Subject Code:</label>";
                  echo  "<div class=\"col-md-10\">";
                  echo "<input id=\"subject-code\" name=\"subject-code\" type=\"text\" placeholder=\"Input Subject Code\" class=\"form-control\" required value=\"".$old_subject_code."\">";
                  echo "<span class=\"help-block\">Input the code for the subject (example: IT1)</span> ";
                  echo "</div></div>";

                  echo  "<div class=\"form-group row\"><label class=\"col-md-2 col-form-label\" for=\"subject-name\">Lecture Units:</label>";
                  echo  "<div class=\"col-md-1\">";
                  echo "<input id=\"subject-units\" min=\"0\" max=\"6\" type=\"number\" name=\"lect_units\" placeholder=\"\" class=\"form-control\" required value=\"".$row['lect_units']."\">";
                  echo "</div>";

                  echo  "<label class=\"col-md-2 col-form-label\" for=\"subject-name\">Lab Units:</label>";
                  echo  "<div class=\"col-md-1\">";
                  echo "<input id=\"subject-units\" min=\"0\" max=\"6\" type=\"number\" name=\"lab_units\" placeholder=\"0\" class=\"form-control\" required value=\"".$row['lab_units']."\">";
                  echo "</div></div>";
                  echo  "<div class=\"form-group row\">";
                  echo  "<label class=\"col-md-2 col-form-label\" for=\"pre_id\">Prerequisite Subject:</label>";
                  echo  "<div class=\"col-md-5\">";
                  echo "<select class=\"form-control\" name=\"pre_id\">";
                  echo "<option value=\"\">None</option>";

                    $query2  = "SELECT * FROM subjects ORDER BY subject_code";
                    $result2 = mysqli_query($connection, $query2);

                    while($row2 = mysqli_fetch_assoc($result2)){
                      if ($row2['subject_id'] == $row1['subject_id']) {
                        echo "<option value=\"".$row2['subject_id']."\" selected>".$row2['subject_code'].": ".$row2['subject_name']."</option>";
                      }
                      else{
                        echo "<option value=\"".$row2['subject_id']."\">".$row2['subject_code'].": ".$row2['subject_name']."</option>";
                      }
                    }
                  echo "</select></div></div>";
                }

          ?>

            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
               <input type="submit" name="submit" value="Edit Subject" class="btn btn-success" />&nbsp;
               <a class="btn btn-secondary"href="view-subject.php">Cancel</a>
              </div>
            </div>
          </form>

          <?php
            if (isset($_POST['submit'])) {
              $subject_name = ltrim(rtrim(mysql_prep($_POST["subject-name"])));
              $subject_code = ltrim(rtrim(strtoupper(mysql_prep($_POST["subject-code"]))));
              $lect_units = (int) $_POST["lect_units"];
              $lab_units = (int) $_POST["lab_units"];
              $total_units = $lect_units + $lab_units;
              $pre_id = (int) $_POST["pre_id"];

              if (!isset($subject_name) || !isset($subject_code) || $subject_name == "" || $subject_code == "") {
                die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
              }
              elseif (is_int($total_units) == 0) {
                die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Units value should be integer.</div>");
              }

              else{

                if ($old_subject_code !== $subject_code) {
                  $row_count = return_duplicate_entry("subjects","subject_code",$subject_code,"",$connection);

                  if ($row_count > 0) {
                    die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Subject code ".$subject_code." already exists.</div>");
                  }
                }
                if ($old_subject_name !== $subject_name) {
                  $row_count = return_duplicate_entry("subjects","subject_name",$subject_name,"",$connection);

                  if ($row_count > 0) {
                    die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Subject name ".$subject_name." already exists.</div>");
                  }
                }

                $query  = "UPDATE subjects SET subject_name = '{$subject_name}', subject_code = '{$subject_code}', lect_units = '{$lect_units}', lab_units = '{$lab_units}', total_units = '{$total_units}', pre_id = '{$pre_id}' WHERE subject_id = {$subject_id} LIMIT 1";
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

      </div>
    </div>
  </div>
 </div> 
  <!-- /#wrapper -->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>


<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>

<?php include 'layout/footer.php';?>



