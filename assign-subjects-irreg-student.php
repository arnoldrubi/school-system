<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>

<?php 
      if (isset($_GET['regid']) && isset($_GET['student_num']) && isset($_GET['course']) && isset($_GET['year']) && isset($_GET['sy']) && isset($_GET['term'])) {
          $stud_reg_id = $_GET["regid"];
          $student_num = $_GET["student_num"];
          $course = $_GET["course"];
          $year = $_GET["year"];
          $sy = $_GET["sy"];
          $term = $_GET["term"];
        }
        else{
          redirect_to("irregular-manual-enrollment.php");
        }

?>

<?php

    $query  = "SELECT * FROM student_grades WHERE stud_reg_id = '".$stud_reg_id."' AND course_id='".$course."' AND year = '".$year."' AND term = '".$term."' AND school_yr='".$sy."'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result)>0) {
      echo "<script type='text/javascript'>";
      echo "alert('Student has subjects assigned for this year, and term');";
      echo "</script>";
      
      $URL="irregular-manual-enrollment.php";
      echo "<script>location.href='$URL'</script>";
    }

?>

  <title>Assign Subjects to <?php echo $student_num; ?></title>
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
            Assign Subjects for Irregular Students
        </li>
      </ol>
      <h1>Assign Subjects to Student Number: <?php echo $student_num; ?></h1>
      <hr>
      <div class="row">

        <div class="col-md-6">
         <h3>Student Info</h2>
          <form id="courses_form" action="" method="post" >
            <?php
              echo "<label class=\"col-md-6 col-form-label\" for=\"Course\">Name: ";

              $query = "SELECT * FROM students_reg WHERE stud_reg_id='".$stud_reg_id."'";
              $result = mysqli_query($connection, $query);
              while($row = mysqli_fetch_assoc($result))
              {
                echo $row['last_name'].", ".$row['first_name']." ".substr($row['middle_name'],0,1).".";
              }
              echo "</label><br>";
            ?>
            <?php
              echo "<label class=\"col-md-6 col-form-label\" for=\"Course\">Course: ";

              $query2 = "SELECT course_code FROM courses WHERE course_id='".$course."'";
              $result2 = mysqli_query($connection, $query2);
              while($row2 = mysqli_fetch_assoc($result2))
              {
                $course_code = $row2['course_code'];
                echo $course_code;
              }
              echo "</label><br>";
            ?>
            <label class="col-md-6 col-form-label" for="Year">Year: <?php echo $year; ?></label><br>
            <label class="col-md-6 col-form-label" for="Year">Term: <?php echo $term; ?></label><br>
            <div class="form-group">
              <label class="col-md-2 col-form-label" for="Course">Max Units</label>
              <div class="col-md-3" style="display: inline-grid;">
                <?php
                  echo "<input type=\"text\" id=\"max-units\" name=\"max_units\" class=\"form-control\" value=".return_max_units($connection)." readonly>";
                ?>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="allow-overload">
                  <label class="form-check-label" for="flexCheckIndeterminate">
                  Allow Overload
                  </label>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <input type="submit" id="submit" name="submit" value="Build Subject Group" class="btn btn-primary" />
            </div>

              <input type="text" name="stud_reg_id" value ="<?php echo $stud_reg_id; ?>" style="display: none">
              <input type="text" name="course" value ="<?php echo $course; ?>" style="display: none">
              <input type="text" name="year" value ="<?php echo $year; ?>" style="display: none">
              <input type="text" name="term" value ="<?php echo $term; ?>" style="display: none">
              <input type="text" name="sy" value ="<?php echo $sy; ?>" style="display: none">
              <input type="text" name="array_values" id="array_values" style="display: none">
        

        </div>

        <div class="col-md-6">
            <h3>Selected Subjects</h3>
            <ul id="selected-subjects">
            </ul>
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="Course">Current Units</label>
              <div class="col-md-3">
                <input type="text" name="current_units" class="form-control" id="current-units" value="0" readonly="">                    
              </div>
            </div>
        </div>

      </form>
      <?php

  if (isset($_POST['submit'])) {

    $max_units = $_POST['max_units'];
    $current_total_units = $_POST['current_units'];

    if ($current_total_units > $max_units || $current_total_units <=0) {
     echo "<div class=\"col-md-12\"><div class=\"alert alert-danger\" role=\"alert\">Error: Current units exceeds the allotted max units or no subject was selected.</div></div>";
    }

    else{


      $data = $_POST['array_values'];
      $arrVal = explode(";",$data);
      $arrLength = count($arrVal);
      $arrPreId = array();

      $stud_reg_id = (int) $_POST["stud_reg_id"];
      $course = (int) $_POST["course"];
      $year = mysql_prep($_POST["year"]);
      $term = mysql_prep($_POST["term"]);
      $sy = mysql_prep($_POST["sy"]);

      $query  = "SELECT * FROM student_grades WHERE stud_reg_id = '".$stud_reg_id."' AND course_id='".$course."' AND year = '".$year."' AND term = '".$term."' AND school_yr='".$sy."'";
      $result = mysqli_query($connection, $query);

      if (mysqli_num_rows($result)>0) {
        echo "<script type='text/javascript'>";
        echo "alert('Student has subjects assigned for this year, and term');";
        echo "</script>";

        $URL="irregular-manual-enrollment.php";
        echo "<script>location.href='$URL'</script>";
      }

      else{

      foreach ($arrVal as $class_arr_for_check) {

        $query_class_info_for_check = "SELECT * FROM classes WHERE class_id='".$class_arr_for_check."'";
        $result_class_info_for_check = mysqli_query($connection, $query_class_info_for_check);

        while($row_class_info_for_check = mysqli_fetch_assoc($result_class_info_for_check))
        {
          $subject_id = $row_class_info_for_check['subject_id'];
        }

        // do a check if a student choose a subject with prerequisite

        $subject_has_prerequisite = get_prerequisite_id($subject_id,"",$connection);

        if ($subject_has_prerequisite !== NULL) {
        $check_if_student_passed = check_if_student_passed($subject_has_prerequisite,$stud_reg_id,"",$connection);

          if ($check_if_student_passed == "no grade") {

            array_push($arrPreId, $subject_id);
          }
        }
      }
      // end foreach ($arrVal as $class_arr_for_check)

        foreach ($arrVal as $class_id) {


          //insert irreg student schedule based on class_id

          $query_class_info = "SELECT * FROM classes WHERE class_id='".$class_id."'";
          $result_class_info = mysqli_query($connection, $query_class_info);

          while($row_class_info = mysqli_fetch_assoc($result_class_info))
          {
            $subject_id = $row_class_info['subject_id'];
            $teacher_id = $row_class_info['teacher_id'];
            $current_students = $row_class_info['students_enrolled'];
          }

            if (count($arrPreId)<=0) {
                // do these batch of insert commands, dapat zero ang array ng mga pre_id, meaning walang pre requisite na tinamaan yung query sa taas

                //insert irreg student and record his/her schedule
                $query3   = "INSERT INTO irreg_manual_sched (stud_reg_id, schedule_id, year, term, school_yr) VALUES ('{$stud_reg_id}', '{$class_id}', '{$year}', '{$term}', '{$sy}')";
                $result3 = mysqli_query($connection, $query3);

                //update all selected schedule block's current students 
                $current_students = $current_students + 1;

                $query_update_current_students  = "UPDATE classes SET students_enrolled = '{$current_students}' WHERE class_id='".$class_id."' LIMIT 1";
                $result_update_current_students = mysqli_query($connection, $query_update_current_students);

                //insert irreg student and record his/her subjects/classes
                $query3  = "INSERT INTO irreg_manual_sched (stud_reg_id, class_id, year, term, school_yr) VALUES ('{$stud_reg_id}', '{$class_id}', '{$year}', '{$term}', '{$sy}')";
                $result3 = mysqli_query($connection, $query3);

                $query2   = "INSERT INTO irreg_manual_subject (stud_reg_id, subject_id, year, term, school_yr) VALUES ('{$stud_reg_id}', '{$subject_id}', '{$year}', '{$term}', '{$sy}')";
                $result2 = mysqli_query($connection, $query2);

                //insert irreg student to the grading tables
                $query   = "INSERT INTO student_grades (stud_reg_id, course_id, subject_id, teacher_id, year, term, sec_id, school_yr,grade_posted) VALUES ('{$stud_reg_id}', '{$course}', '{$subject_id}', '{$teacher_id}', '{$year}', '{$term}','0', '{$sy}', '0')";      

                $result = mysqli_query($connection, $query);
              }
            } 
          // end foreach ($arrVal as $class_id)

        if (count($arrPreId)>=1){

            echo "<div class=\"col-md-12 mt-3\"><div class=\"alert alert-danger\" role=\"alert\">Cannot enroll this student. The following prerequisite has not been fulfilled. " ;

            // create a list displaying all the prerequisite not yet fulfilled
            // place this in a conditional so it will not appear if everything is succesful
            echo "<ul>";


            foreach ($arrPreId as $pre_id_for_table) {
            echo "<li>".get_subject_code(get_prerequisite_id($pre_id_for_table,"",$connection),"",$connection)."</li>";
            }

            echo "</ul>Please contact the registrar.</div></div>";

          }
          // end if (count($arrPreId)>=1)

        if ($result === TRUE) {
          echo "<script type='text/javascript'>";
          echo "alert('Create subject set successful!');";
          echo "</script>";

          $URL="irregular-manual-enrollment.php";
          echo "<script>location.href='$URL'</script>";
          } else {

            echo "Error updating record: " . $connection->error;
          }
        }
      }
    }
      ?>

      <div class="col-md-12">
      <?php

        $arr_subj_id_in_grades = array();

        $query_get_subj_from_grades = "SELECT subject_id FROM student_grades WHERE stud_reg_id='".$stud_reg_id."'";
        $result_get_subj_from_grades = mysqli_query($connection, $query_get_subj_from_grades);

        while($row_get_subj_from_grades = mysqli_fetch_assoc($result_get_subj_from_grades)){
          array_push($arr_subj_id_in_grades, $row_get_subj_from_grades['subject_id']);
        }
        


        echo "<table class=\"table table-bordered mt-3\" id=\"\" width=\"100%\" cellspacing=\"0\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Name</th>";
        echo "   <th>Subject Code</th>";
        echo "   <th>Prerequisite</th>";
        echo "   <th>Teacher</th>";
        echo "   <th>Section</th>";
        echo "   <th>Units</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>";    
        
        if (count($arr_subj_id_in_grades)>0) {
           $query3 = "SELECT DISTINCT class_id, subject_id, teacher_id, sec_id FROM classes WHERE subject_id NOT IN (".implode(",",$arr_subj_id_in_grades).")";
        }
        else{
           $query3 = "SELECT DISTINCT class_id, subject_id, teacher_id, sec_id FROM classes";
        }

       
        $result3 = mysqli_query($connection, $query3);

        if (mysqli_num_rows($result3)< 1) {
          echo "<br><div class=\"alert alert-danger\" role=\"alert\">";
          echo "No subjects assigned for ".$course_code.", ".$year.", ".$term.".<br>";
          echo "Please assign subjects using the \"Assign Subjects\" form under the \"Courses\" menu.";
          echo "</div><br>";
        }

          while($row3 = mysqli_fetch_assoc($result3))
            {

              echo "<tr>";
              echo "<td>".get_subject_name($row3['subject_id'],"",$connection)."</td>";
              echo "<td>".get_subject_code($row3['subject_id'],"",$connection)."</td>";
              echo "<td>".get_subject_code(get_prerequisite_id($row3['subject_id'],"",$connection),"",$connection)."</td>";
              echo "<td>".get_teacher_name($row3['teacher_id'],"",$connection)."</td>";
              echo "<td>".get_section_name($row3['sec_id'],"",$connection)."</td>";             
              echo "<td>".get_subject_total_unit($row3['subject_id'],"",$connection)."</td>";
              echo "<td class=\"subject-wrap\"><a class=\"".get_subject_total_unit($row3['subject_id'],"",$connection)."-".get_subject_code($row3['subject_id'],"",$connection)."\" id=\"".$row3['class_id']."\""." href=\"#\">Add Subject</a> </td>";
              echo "</tr>";
              } 

        echo "</tbody></table>"; 

      ?>
      <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Reminder</h4>
        <p>Subjects listed above are those where classes were created.</p>
        <hr>
        <p>If a subject is missing in the list, it's because no classes has been created for it yet. Kindly go to the <a href="sections-and-classes.php">classes</a> page to fix this.</p>
      </div>
      </div>
    </div>
  </div>
  <div id="response"></div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


<?php include 'layout/footer.php';?>

<script>
$( document ).ready(function() {
  var arrval = new Array();
  var old_units = $("#max-units").val();
  $('.subject-wrap a').click(function(){
    var $checker = false;
    var class_and_unit = $(this).attr('class');
    var arr_class_and_unit = class_and_unit.split("-");
    $( "#selected-subjects li:contains('"+ arr_class_and_unit[1] +"')" ).each(function(){
        alert('Error! This subject is already selected');
        $checker = true;
      }
    );
    if ($checker === false){
        if (parseInt($("#current-units").val()) >= parseInt($("#max-units").val())) {
          alert('Error! Total units is more than the max units allowed for this term.');
        }
        else if (parseInt($("#current-units").val()) < parseInt($("#max-units").val())) {
          var current_units = parseInt($("#current-units").val())+parseInt(arr_class_and_unit[0]);
          $("#current-units").val(current_units);

          alert (arr_class_and_unit[1]+ " has been selected!");
          $( "#selected-subjects" ).append( "<li id=\""+$(this).attr('id')+"\">"+arr_class_and_unit[1]+" <a href=\"#\" class=\""+arr_class_and_unit[0]+"\">x</a></li>" );
          $( "#courses_form" ).append( "<input type=\"text\" name=\""+$(this).attr('id')+"\" value=\""+$(this).attr('id')+"\" style=\"display: none\">" );
          arrval.push($(this).attr('id'));
          $("#array_values").val(arrval.join('; '));
        }
      
    }
    var $count = $("#selected-subjects input").length;
    console.log(arrval.join('; '));

    $("#selected-subjects li a").click(function(){//remove this and place it under a document on load function

      var confirm_remove = confirm("Do you want to remove a subject from the list?");

      if (confirm_remove == true) {
        $(this).closest("li").remove();
        var current_units = parseInt($("#current-units").val())-parseInt($(this).attr('class'));
        $("#current-units").val(current_units);

        alert ("Subject has been removed!");

        var removeItem = $(this).closest("li").attr("id");

        arrval = jQuery.grep(arrval, function(value) {
          return value != removeItem;
        });
        $("#array_values").val(arrval.join('; '));

        // basic check to make sure current units stays 0 as min value
        if ($("#current-units").val() < 0) {
          $("#current-units").val(0);
        }

      }

    });

  });
    
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#datatable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
    $("#allow-overload").change(function(){

      if ($(this).is(":checked")) {
        $("#max-units").val(99);
      }
      else{
        $("#max-units").val(old_units);
      }
    });
  });

</script>


