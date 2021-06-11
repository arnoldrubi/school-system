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

      if (isset($_GET['error'])) {
        $error_code = $_GET['error'];
      }
    }
    else{
      redirect_to("irregular-manual-enrollment.php");
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
      <?php
        if (isset($error_code) && $error_code == 1) {
          echo "<div class=\"row\"><div class=\" col-md-12 alert alert-danger\" role=\"alert\"><p>Error: Over the max units allowed</p></div></div>";
        }
      ?>
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
<!--               <label class="col-md-2 col-form-label" for="Course">Max Units</label> -->
              <div class="col-md-3" style="display: inline-grid;">
                <?php
                  // echo "<input type=\"text\" id=\"max-units\" name=\"max_units\" class=\"form-control\" value=".return_max_units($connection)." readonly>";
                  echo "<a class=\"btn btn-warning btn-xs\" title=\"Print Enrollment Form\" target=\"_blank\" href=\"print-enrollment-form.php?student_reg_id=".$stud_reg_id."&irregular=1\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a>";
                ?>
<!--                 <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="allow-overload">
                  <label class="form-check-label" for="flexCheckIndeterminate">
                  Allow Overload
                  </label>
                </div> -->
              </div>
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
            <table class="table table-bordered mt-3" id="" width="50%" cellspacing="0" style="width: 100%;">
              <thead>
                <tr>
                  <th>Subject Name</th><th>Subject Code</th><th width="10%">&nbsp;</th>
                </tr>
              </thead>
            
            <?php
            // note: create array for pushing class_id
              $current_units = 0;
              $class_array = array();
              $subjects_array = array();
              $query_subject_info = "SELECT * FROM irreg_manual_sched WHERE stud_reg_id='".$stud_reg_id."'";
              $result_subject_info = mysqli_query($connection, $query_subject_info);

              while($row_subject_info = mysqli_fetch_assoc($result_subject_info))
              {
                $teacher_class_delete = get_teacher_id_by_class($row_subject_info['class_id'],"",$connection);

                $subject_id = get_subject_id_by_class("",$row_subject_info['class_id'],$connection);
                echo "<tr><td>".get_subject_name($subject_id,"",$connection)."</td><td>".get_subject_code($subject_id,"",$connection)."</td><td style=\"text-align: center\"><a title=\"Delete Subject\" class=\"btn btn-danger btn-xs\" href=\"delete-irreg-subjects.php?regid=".$stud_reg_id."&student_num=".urlencode($student_num)."&classid=".$row_subject_info['class_id']."&year=".urlencode($year)."&term=".urlencode($term)."&sy=".urlencode($sy)."&course=".$course."&teacherid=".$teacher_class_delete."\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td></tr>";
                $current_units = $current_units + get_subject_total_unit($subject_id,"",$connection);

                array_push($class_array,$row_subject_info['class_id']);
                array_push($subjects_array,get_subject_id_by_class("",$row_subject_info['class_id'],$connection));
              }

            ?>
            </table>
            </ul>
            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="Course">Current Units</label>
              <div class="col-md-3">
                <input type="text" name="current_units" class="form-control" id="current-units" <?php echo "value=".$current_units; ?> readonly="">                    
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

      if (mysqli_num_rows($result)>0) {
        echo "<script type='text/javascript'>";
        echo "alert('Student has subjects assigned for this year, and term');";
        echo "</script>";

        $URL="irregular-manual-enrollment.php";
        echo "<script>location.href='$URL'</script>";
      }

      else{


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
        
    

        if (count($class_array)<1) {
          $query3 = "SELECT * FROM classes WHERE students_enrolled < student_limit"; 
        } 
        else{
        $query3 = "SELECT * FROM classes WHERE students_enrolled < student_limit AND class_id NOT IN(".implode(",", $class_array).") AND subject_id NOT IN(".implode(",", $subjects_array).")";
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
              echo "<td class=\"subject-wrap\"><a class=\"".get_subject_total_unit($row3['subject_id'],"",$connection)."-".get_subject_code($row3['subject_id'],"",$connection)."\" id=\"".$row3['class_id']."\""." href=\"add-subject-to-irreg.php?regid=".$stud_reg_id."&student_num=".urlencode($student_num)."&classid=".$row3['class_id']."&year=".urlencode($year)."&term=".urlencode($term)."&sy=".urlencode($sy)."&course=".$course."&teacherid=".$row3['teacher_id']."\">Add Subject</a> </td>";
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


