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
      <h1>Enrollment Process</h1>
      <hr>
     <form action="" method="post">
      <h2>Student Info</h2>
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
          echo "<hr><h2>Additional Info</h2>";
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

          echo "<hr><h2>Enrollment Info</h2><div class=\"form-group row\">";
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
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label" for="Course">Remarks</label>
      <div class="col-md-6">
      <textarea class="form-control" rows="3" name="remarks"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 d-flex justify-content-center">
        <input type="submit" name="submit" value="Enroll Student" class="btn btn-primary" />&nbsp;
        <a class="btn btn-secondary"href="enrollment.php">Cancel</a>
      </div>
     </div>
  </form>
<?php
  if (isset($_POST['submit'])) {

  $course = mysql_prep($_POST["course"]);
  $section = mysql_prep($_POST["section"]);
  $sy = mysql_prep($_POST["school-year"]);
  $term = mysql_prep($_POST["term"]);
  $regirreg = (int) ($_POST["regirreg"]);
  $remarks = mysql_prep($_POST["remarks"]);
  $year = mysql_prep($_POST["year"]);

  $query  = "SELECT * FROM enrollment WHERE stud_reg_id = '".$stud_reg_id."' AND term ='".$term."' AND school_yr ='".$sy."'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    echo "<script type='text/javascript'>";
    echo "alert('Record for ".$_POST["firstname"]." ".$_POST["lastname"]." for School Year ".$sy." and ".$term." already exists!');";
    echo "</script>";

    $URL="enrollment.php";
    echo "<script>location.href='$URL'</script>";

  }
  else{

    if ($regirreg == "1") {
        echo "<script type='text/javascript'>";
        echo "alert('Student is irregular. Manual subject assignment is needed to complete the enrollment!');";
        echo "</script>";
        $section = "N/A";
    }
    else{

      $query  = "SELECT subject_id FROM course_subjects WHERE course_id ='".$course."' AND term ='".$term."' AND year ='".$year."' AND section='".$section."'";
      $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
          $subject_id = (int) $row['subject_id'];

          //get value of teacher id from existing records on the grades table

          $query_get_teacher_id  =  "SELECT teacher_id FROM student_grades WHERE subject_id ='".$subject_id."' AND course_id ='".$course."' AND term ='".$term."' AND year ='".$year."' AND section ='".$section."' AND school_yr='".$sy."'";
          $result_get_teacher_id = mysqli_query($connection, $query_get_teacher_id); 

          if (mysqli_num_rows($result_get_teacher_id)) {
            while($row_get_teacher_id = mysqli_fetch_assoc($result_get_teacher_id ))
              {     
                $teacher_id = $row_get_teacher_id['teacher_id'];
              }

            $query2  = "INSERT INTO student_grades (stud_reg_id, subject_id, teacher_id, course_id, year, term, section, school_yr, grade_posted) VALUES ('{$reg_id_enroll}', '{$subject_id}', '{$teacher_id}', '{$course}', '{$year}', '{$term}','{$section}', '{$sy}', '0');";

          }

          else{
            
            $query2  = "INSERT INTO student_grades (stud_reg_id, subject_id, course_id, year, term, section, school_yr, grade_posted) VALUES ('{$reg_id_enroll}', '{$subject_id}', '{$course}', '{$year}', '{$term}','{$section}', '{$sy}', '0');";
          }

          print_r($query2);

          $result2 = mysqli_query($connection, $query2);

          //another query for inserting the grades of the student, will loop around all subject for that year, sy, term, and course

          $query3  = "SELECT * FROM student_grades WHERE subject_id='".$row['subject_id']."'";
          $result3 = mysqli_query($connection, $query3);
          $students_enrolled = mysqli_num_rows($result3);

          if ($students_enrolled > 0) {
          $query4  = "UPDATE schedule_block  SET students_enrolled = '{$students_enrolled}' WHERE course_id ='".$course."' AND term ='".$term."' AND year ='".$year."' AND subject_id='".$row['subject_id']."'";
          $result4 = mysqli_query($connection, $query4);
          }

        }
    }
      //NEXT MANAGE CONFLICT IN STUDENT NUMBER FOR MULTIPLE ENROLLMENT
  
        $query3  = "SELECT course_code FROM courses WHERE course_id='".$course."' LIMIT 1";
        $result3 = mysqli_query($connection, $query3);
        $students_enrolled = mysqli_num_rows($result3);

        while($row3 = mysqli_fetch_assoc($result3))
        { 
            $course_code = $row3['course_code'];
        }    

       $new_student_number = generate_student_number($sy,$course_code,strval($stud_reg_id));

      $query  = "INSERT INTO enrollment (stud_reg_id, student_number, course_id, year, section, school_yr, term, irregular, remarks) VALUES ('{$reg_id_enroll}', '{$new_student_number}', '{$course}', '{$year}', '{$section}', '{$sy}', '{$term}', '{$regirreg}', '{$remarks}')";
      //query for enrolling the student

      $result = mysqli_query($connection, $query);
      $query_get_last_id   = mysqli_insert_id($connection);
      if ($result === TRUE) {
          if ($regirreg == "1") {
          $URL="irregular-manual-enrollment.php";
          echo "<script>location.href='$URL'</script>";
            }
          else{
            $redirect_url = "enrollment-successful.php?success=1&student_id=".urlencode($query_get_last_id)."&term=".urlencode($term)."&sy=".urlencode($sy);
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

<!--Simle script to disable the select section function when a student is irregular -->
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

$(document).ready(function() {

var course = $("#course").val();
var year = $("#select-yr").val();
load_section(course,year);

  $('#exampleRadios2').click(function(){
    $("#section").attr("disabled", true);
    $("#section").append($("<option>", {value:"N/A", text:"N/A"}));
    $("#section").val("N/A");
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
});

</script>