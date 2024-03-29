<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
      if (isset($_GET['stud_reg_id'])) {
          $stud_reg_id = $_GET["stud_reg_id"]; //Refactor this validation later
        }
        else{
          $stud_reg_id = NULL;
        }
        if ($stud_reg_id == NULL) {
          redirect_to("view-registered-students.php");
       }

?>

  <title>Process Student Enrollment</title>
  </head>
  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "students";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="students.php">Students</a>
        </li>
        <li class="breadcrumb-item active">
          Process Enrollment
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          Enroll Student</div>
          <div class="card-body">
           <form id="enrollment-form" action="" method="post">
            <h4>Student Info</h4>
            <?php

              $query  = "SELECT * FROM students_reg WHERE stud_reg_id = '".$stud_reg_id."'";
              $result = mysqli_query($connection, $query);

              if ($result === !TRUE) {
                    echo "<script type='text/javascript'>";
                    echo "alert('No record exists!');";
                    echo "</script>";

                    $URL="enrollment.php";
                    echo "<script>location.href='$URL'</script>";

              }

              while($row = mysqli_fetch_assoc($result))
                {
                $reg_id_enroll = $row['stud_reg_id'];//assign student registration ID to a variable to be saved to the enrollment table later

                echo "<div class=\"form-group row\">";
                echo "<label class=\"col-md-2 col-form-label\" for=\"LastName\">Last Name</label>"; 
                echo "<div class=\"col-md-4\">";
                echo "<input id=\"LastName\" name=\"lastname\" type=\"text\" value=\"".$row['last_name']. "\" class=\"form-control\" readonly></div>";

                echo "<label class=\"col-md-2 col-form-label\" for=\"FirstName\">First Name</label>"; 
                echo "<div class=\"col-md-4\">";
                echo "<input id=\"FirstName\" name=\"firstname\" type=\"text\" value=\"".$row['first_name']. "\" class=\"form-control\" readonly></div></div>";

                echo "<div class=\"form-group row\">";
                echo "<label class=\"col-md-2 col-form-label\" for=\"MiddleName\">Middle Name</label>"; 
                echo "<div class=\"col-md-4\">";
                echo "<input id=\"MiddleName\" name=\"middlename\" type=\"text\" value=\"".$row['middle_name']. "\" class=\"form-control\" readonly></div>";

                echo "<label class=\"col-md-2 col-form-label\" for=\"NameExt\">Name Extension</label>"; 
                echo "<div class=\"col-md-2\">";
                echo "<input id=\"NameExt\" name=\"nameext\" type=\"text\" value=\"".$row['name_ext']. "\" class=\"form-control\" readonly>";
                echo "</div></div>";
                echo "<hr><h4>Additional Info</h4>";
                echo "<div class=\"form-group row\">";
                echo "<label class=\"col-md-2 col-form-label\" for=\"BirthDay\">Birthday</label>"; 
                echo "<div class=\"col-md-2\">";
                echo "<input id=\"BirthDay\" name=\"birthday\" type=\"date\" min=\"1900-01-01\" max=\"2019-12-31\" value=\"".$row['birth_date']. "\" class=\"form-control input-md\" required readonly></div>";
                echo "<label class=\"col-md-1 col-form-label\" for=\"Address\">Address</label>"; 
                echo "<div class=\"col-md-3\">";
                echo "<input id=\"Address\" name=\"barangay\" type=\"text\" placeholder=\"Add Street and barangay...\" class=\"form-control\" required readonly value=\"".$row['barangay']."\"></div>";
                echo "<div class=\"col-md-2\">";
                echo "<input id=\"province\" name=\"province\" type=\"text\" placeholder=\"Province...\" class=\"form-control\" value=\"".$row['province']."\" required readonly></div>";
                echo "<div class=\"col-md-2\">";
                echo "<input id=\"province\" name=\"province\" type=\"text\" placeholder=\"City/Municipality...\" class=\"form-control\" value=\"".$row['municipality']."\" required readonly></div>"; 
                echo "</div>";

                echo "<div class=\"form-group row\">";
                echo "<label class=\"col-md-2 col-form-label\" for=\"PhoneNum\">Phone Number</label>"; 
                echo "<div class=\"col-md-2\">";
                echo "<input id=\"PhoneNum\" name=\"phonenum\" type=\"tel\" pattern=\"[0-9]{4}-[0-9]{3}-[0-9]{4}\"  value=\"".$row['phone_number']. "\" class=\"form-control\" readonly>";
                echo "</div>";

                echo "<label class=\"col-md-2 col-form-label\" for=\"Email\">Email</label>"; 
                echo "<div class=\"col-md-2\">";
                echo "<input id=\"Email\" name=\"email\" type=\"email\" value=\"".$row['email']. "\" class=\"form-control\" readonly></div>";

                //File Button -->
                $current_picture = "http://" . $_SERVER['SERVER_NAME']."/school-system/uploads/".$row['photo_url']; //I hardcoded the url of the site, this should be automatic, much better to use the SERVER_NAME then just hard code the /uploads path

                echo "<div class=\"col-md-4\"><p>Current Photo:</p>";
                echo "<p style=\"text-align: center\"><img class=\"current-pic\" src=\"".$current_picture."\"></p>";
                echo "</div></div>";
                }

                echo "<hr><h4>Enrollment Info</h4><div class=\"form-group row\">";
                echo "<label class=\"col-md-2 col-form-label\" for=\"Course\">Course</label><div class=\"col-md-2\"><select id=\"course\" class=\"form-control\" name=\"course\">";
              
                 //this block will load the course name from the database
                    $query  = "SELECT * FROM courses WHERE course_deleted = 0";
                    $result = mysqli_query($connection, $query);


                    while($row = mysqli_fetch_assoc($result))
                      {
                        $course_code = $row['course_code'];
                        echo  "<option value=\"".$row['course_id']."\">".$course_code."</option>";
                      }

                echo "</select></div>";
                echo "<label class=\"col-md-2 col-form-label\" for=\"Course\">School Year</label><div class=\"col-md-2\"><input class=\"form-control\" id=\"current_sy\" name=\"school-year\" type=\"text\" value=\"\" readonly></div>";

        ?>
           <label class="col-md-2 col-form-label" for="Course">Year</label>
            <div class="col-md-2">
              <select class="form-control" name="year" id="select-yr">
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>  
              </select>
            </div>
            </div>
          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="Course">Term</label>
            <div class="col-md-2">
              <input class="form-control" type="text" name="term" id="term" value="" readonly="">
            </div>
            <label class="col-md-2 col-form-label" for="Course">Regular or Irregular Student?</label>
            <div class="col-md-2">
              <div class="form-check">
                <input class="form-control-md" type="radio" name="regirreg" id="exampleRadios1" value="0" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Regular
                </label>
              </div>
              <div class="form-check">
                <input class="form-control-md" type="radio" name="regirreg" id="exampleRadios2" value="1" >
                <label class="form-check-label" for="exampleRadios2">
                  Irregular
                </label>
              </div>
            </div>
            <label class="col-md-2 col-form-label" for="Course">Section</label>
            <div class="col-md-2">
              <select class="form-control" id="section" name="section">
                <?php
                  $query_section  = "SELECT * FROM sections ORDER BY sec_name ASC";
                  $result_section = mysqli_query($connection, $query_section);

                  while($row_section = mysqli_fetch_assoc($result_section))
                  {
                    echo "<option value=\"".$row_section['sec_name']."\">".$row_section['sec_name']."</option>";
                  }
                ?>
              </select>
            </div>
           <div id="class-limit" class="col-md-12">
             
           </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="Course">Remarks</label>
            <div class="col-md-6">
              <textarea class="form-control" rows="5" name="remarks"></textarea>
            </div>
            <div class="col-md-4">
              <p>Optional*<br><button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                 Student Number: Manual Encode
                </button>
              </p>
              <div class="collapse" id="collapseExample">
                <input type="text" class="form-control" id="manual-encode-student-num" name="manual_encode_student_num" placeholder="xxxx-xxxx">        
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
              <input type="submit" name="submit" value="Enroll Student" class="btn btn-success" />&nbsp;
              <a class="btn btn-secondary"href="enrollment.php">Cancel</a>
            </div>
          </div>
        </form>
<?php
  if (isset($_POST['submit'])) {

  $course = mysql_prep($_POST["course"]);
  $sec_id = $_POST["section"];
  $sy = mysql_prep($_POST["school-year"]);
  $term = mysql_prep($_POST["term"]);
  $regirreg = (int) ($_POST["regirreg"]);
  $remarks = mysql_prep($_POST["remarks"]);
  $year = mysql_prep($_POST["year"]);
  $manual_stud_number = mysql_prep($_POST["manual_encode_student_num"]);

// do a simple validation in case manual encoding of student number was made and there is a duplicate
  $query_stud_for_check = "SELECT * FROM enrollment WHERE student_number='".$manual_stud_number."'";
  $result_stud_for_check = mysqli_query($connection, $query_stud_for_check);

  if (mysqli_num_rows($result_stud_for_check)>0) {
   die("<div class=\"alert alert-warning\" role=\"alert\">Error. Encoded Student Number already exists.</div>");
  }
  

  $arrPreId = array();

  $query_subject_for_check = "SELECT * FROM course_subjects WHERE course_id='".$course."' AND year='".$year."' AND term='".$term."'";
  $result_subject_for_check = mysqli_query($connection, $query_subject_for_check);

  while($row_subject_for_check = mysqli_fetch_assoc($result_subject_for_check))
    {
      $subject_id = $row_subject_for_check['subject_id'];

      // do a check if a student choose a subject with prerequisite
      // the logic is the same as the validation on the assign subjects irreg student. This one gets the array of subject id from the course subjects table

      $subject_has_prerequisite = get_prerequisite_id($subject_id,"",$connection);

      if ($subject_has_prerequisite !== NULL) {

        $check_if_student_passed = check_if_student_passed($subject_has_prerequisite,$stud_reg_id,"",$connection);

        if ($check_if_student_passed == "no grade") {
          array_push($arrPreId, $subject_id);
        }
      }

    }

  if (count($arrPreId)>=1){

      echo "<div class=\"col-md-12 mt-3\"><div class=\"alert alert-danger\" role=\"alert\">Cannot enroll this student. The following prerequisite has not been fulfilled. " ;

      // create a list displaying all the prerequisite not yet fulfilled
      // place this in a conditional so it will not appear if everything is succesful
      echo "<ul>";
      foreach ($arrPreId as $pre_id_for_table) {
      echo "<li>".get_subject_code(get_prerequisite_id($pre_id_for_table,"",$connection),"",$connection)."</li>";
      }
      echo "</ul>";
      die("Error. Please contact the registrar");
      echo "</div></div>";
    }
  //End validation for checking if a student has unfulfilled prerequsite subject

  $query  = "SELECT * FROM enrollment WHERE stud_reg_id = '".$stud_reg_id."' AND term ='".$term."' AND school_yr ='".$sy."'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    echo "<script type='text/javascript'>";
    echo "alert('Record for ".$_POST["firstname"]." ".$_POST["lastname"]." for School Year ".$sy." and ".$term." already exists!');";
    echo "</script>";

    $URL="enrollment.php";
    echo "<script>location.href='$URL'</script>";

  }
  // end validation in checking if a student has record for the set year and term
  else{

    if ($regirreg == "1") {
        echo "<script type='text/javascript'>";
        echo "alert('Student is irregular. Manual subject assignment is needed to complete the enrollment!');";
        echo "</script>";
    }
    else{

    //Validation, to make sure the proper section is selected
     if ($sec_id == 0) {
        echo "<script>alert('Please select a section!');";
        $URL="process-enrollment.php?stud_reg_id=".$stud_reg_id;
        echo "location.href='$URL';";
        echo "document.getElementById('section').focus()</script>";
      }
    //End Validation

    //validation: Enrollment will not proceed if there subjects w/o classes for the chosen course, and year
      $classes_subjects = array();
      $query_check_classes  = "SELECT * FROM classes WHERE sec_id='".$sec_id."' AND term='".$term."' AND school_yr='". $sy."'";
      $result_check_classes = mysqli_query($connection, $query_check_classes);

      while($row_check_classes = mysqli_fetch_assoc($result_check_classes))
      {
        array_push($classes_subjects, $row_check_classes['subject_id']);
      }

      $subjects_from_course = array();
      $query  = "SELECT * FROM course_subjects WHERE course_id='".$course."' AND year='".$year."' AND term='".return_current_term($connection,"")."' AND school_yr='".return_current_sy($connection,"")."'";
      $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
          array_push($subjects_from_course, $row['subject_id']);
        }

      $missing_subjects = array_diff($subjects_from_course, $classes_subjects);

      if (sizeof($missing_subjects) > 0) {
       $redirect_class = "classes.php?sec_id=".urlencode($sec_id);
       die("<div class=\"alert alert-danger\" role=\"alert\">Class for this course and year is incomplete! Go to the <a href=\"sections-and-classes.php\">Classes Page to Create</a></div>".$query);
      }
      //End validation
        $query  = "SELECT * FROM classes WHERE sec_id ='".$sec_id."' AND term='".$term."' AND school_yr='". $sy."'";
        $result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($result))
          {
            $subject_id = $row['subject_id'];
            $teacher_id = $row['teacher_id'];
            $class_id = $row['class_id'];
            $check_if_subject_is_credited = is_subject_credited($subject_id,$stud_reg_id,"",$connection);

            if ($check_if_subject_is_credited == FALSE) {
              $query2  = "INSERT INTO student_grades (stud_reg_id, subject_id, teacher_id, course_id, year, term, sec_id, school_yr, grade_posted) VALUES ('{$reg_id_enroll}', '{$subject_id}', '{$teacher_id}', '{$course}', '{$year}', '{$term}','{$sec_id}', '{$sy}', '0');";
              $result2 = mysqli_query($connection, $query2); 
            }          
          }
      }
      // end else from if ($regirreg == "1")

      //NEXT MANAGE CONFLICT IN STUDENT NUMBER FOR MULTIPLE ENROLLMENT
  
      $query3  = "SELECT course_code FROM courses WHERE course_id='".$course."' LIMIT 1";
      $result3 = mysqli_query($connection, $query3);
      $students_enrolled = mysqli_num_rows($result3);

      while($row3 = mysqli_fetch_assoc($result3))
      { 
          $course_code = $row3['course_code'];
      }    

      if (!isset($manual_stud_number)) {
        //Generate student number
        $new_student_number = generate_student_number($sy,$course_code,strval($stud_reg_id));
      }
      else{
        $new_student_number = $manual_stud_number;
      }
      


      if ($regirreg == "1") {
      $query  = "INSERT INTO enrollment (stud_reg_id, student_number, course_id, year, sec_id, school_yr, term, irregular, remarks) VALUES ('{$reg_id_enroll}', '{$new_student_number}', '{$course}', '{$year}', '0', '{$sy}', '{$term}', '{$regirreg}', '{$remarks}')";
      //query for enrolling the regular student
      $result = mysqli_query($connection, $query);
      $query_get_last_id   = mysqli_insert_id($connection);
      }else{

      $query  = "INSERT INTO enrollment (stud_reg_id, student_number, course_id, year, sec_id, school_yr, term, irregular, remarks) VALUES ('{$reg_id_enroll}', '{$new_student_number}', '{$course}', '{$year}', '{$sec_id}', '{$sy}', '{$term}', '{$regirreg}', '{$remarks}')";
      //query for enrolling the regular student
      $result = mysqli_query($connection, $query);
      $query_get_last_id   = mysqli_insert_id($connection);

      //start updating current students for classes under the section enrolled

      $query_get_class_ids = "SELECT * from classes WHERE sec_id='".$sec_id."' AND term='".$term."' AND school_yr='".$sy."'";
      $result_get_class_ids = mysqli_query($connection, $query_get_class_ids);

      $class_ids = array();
      while($row_get_class_ids = mysqli_fetch_assoc($result_get_class_ids))
      {
        array_push($class_ids, $row_get_class_ids['class_id']);
      }

     for ($i=0; $i < sizeof($class_ids); $i++) { 
        
        $query_get_irreg_count  = "SELECT COUNT(*) AS num FROM irreg_manual_sched WHERE class_id='".$class_ids[$i]."'";
        $result_get_enrolled = mysqli_query($connection, $query_get_irreg_count);
        while($row_get_enrolled = mysqli_fetch_assoc($result_get_enrolled)){
           $irreg_count = $row_get_enrolled['num'];
         }

        $sec_id = get_section_name_by_class($class_ids[$i],"",$connection);
        $count_regular_student = get_enrolled_regular_students($sec_id,$term,$sy,"",$connection);

        $current_students_total = $irreg_count + $count_regular_student;

        $query4  = "UPDATE classes SET students_enrolled = '{$current_students_total}' WHERE class_id ='".$class_ids[$i]."'";
        print_r($query4);
        echo "<br>";
        $result4 = mysqli_query($connection, $query4);
        }
      //End updating current students enrolled for each classes under this section

    }

      if ($result === TRUE) {
          if ($regirreg == "1") {
          $URL="irregular-manual-enrollment.php";
          echo "<script>location.href='$URL'</script>";
            }
          else{
            $redirect_url = "enrollment-successful.php?success=1&stud_reg_id=".urlencode($stud_reg_id)."&term=".urlencode($term)."&sy=".urlencode($sy)."&irregular=".urlencode($regirreg);
            redirect_to($redirect_url);
          }
        
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

<!--Simple script to disable the select section function when a student is irregular -->
<script type="text/javascript">

function load_section(course,year){
  //run ajax
  $.post("load-available-section.php",{
    course: course,
    year: year
  },function(data,status){
    $("#section").html(data);
  });
}
function check_classes_limit(sec_id){
  var section_id = sec_id;
  //run ajax
  $.post("check_class_limit.php",{
    section_id: section_id
  },function(data,status){
    $("#class-limit").html(data);
  });
}
$(document).ready(function() {

var course = $("#course").val();
var year = $("#select-yr").val();
load_section(course,year);
var section_id = $("#section").val();

// check_classes_limit($("#section").val());

  $('#exampleRadios2').click(function(){
    $("#section").attr("disabled", true);
    $("#section").append($("<option>", {value:"0", text:"N/A"}));
    $("#section").val("0");
  })
  $('#exampleRadios1').click(function(){
    $("#section").attr("disabled", false);
      var course = $("#course").val();
      var year = $("#select-yr").val();
      load_section(course,year);
  }
    )
  var current_sem = $("#active-term").text();
  var current_sy = $("#active-sy").text();
    $("#term").val(current_sem);
    $("#current_sy").val(current_sy);

    $("#username").keyup(function(){
      var username = $("#username").val();

      //run ajax
      $.post("scan_username.php",{
        user_input: username
      },function(data,status){
        $("#warning-text").html(data);

      });

    });

    $("#course").change(function(){
      var course = $("#course").val();
      var year = $("#select-yr").val();
      load_section(course,year);
    });

    $("#select-yr").change(function(){
      var course = $("#course").val();
      var year = $("#select-yr").val();
      load_section(course,year);
    });
    $("#section").change(function(){
      check_classes_limit($("#section").val());
    });
});

</script>