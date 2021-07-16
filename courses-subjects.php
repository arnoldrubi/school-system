<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Assign Subjects to Course</title>
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
          Assign Subjects to Course
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
           Assign Subjects to Course</div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <h5>Course Info</h5>
                <form id="courses_form" action="" method="post" >
                  <?php

                    echo "<div class=\"form-group row\">";
                    echo "<label class=\"col-md-2 col-form-label\" for=\"Course\">Course</label><div class=\"col-md-3\"><select class=\"form-control\" name=\"course\">";
                    //this block will load the course name from the database
                    $query  = "SELECT * FROM courses WHERE course_deleted = 0";
                    $result = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($result))
                      {
                        echo  "<option value=\"".$row['course_id']."\">".$row['course_code']."</option>";
                      }
                    echo "</select></div></div>";
                  ?>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="Year">Year</label>
                        <div class="col-md-3">
                          <select class="form-control" name="year" id="year">
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="Course">Term</label>
                        <div class="col-md-3">
                          <select class="form-control" name="semester">
                            <option value="1st Semester">1st Semester</option>
                            <option value="2nd Semester">2nd Semester</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="School Year">School Year</label>
                        <div class="col-md-3">
                          <select class="form-control" name="school_yr">
                            <?php
                              $query_school_yr  = "SELECT * FROM school_yr";
                              $result_school_yr = mysqli_query($connection, $query_school_yr);

                              while($row_school_yr = mysqli_fetch_assoc($result_school_yr))
                                {
                                  echo  "<option value=\"".$row_school_yr['school_yr']."\">".$row_school_yr['school_yr']."</option>";
                                }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="Course">Max Units</label>
                        <div class="col-md-3">
                          <?php
                            echo "<input type=\"text\" id=\"max-units\" name=\"max_units\" class=\"form-control\" value=".return_max_units($connection)." readonly>";
                          ?>
                          
                        </div>
                      </div>

                      <div class="col-md-6">
                        <input type="submit" id="submit" name="submit" value="Build Course Subjects" class="btn btn-success" /><br> <br>
                      </div>   
                    <!--Hidden input box to be populated by user interaction-->
                    <input type="text" name="array_values" id="array_values" style="display: none">
       

              

              </div>

            <div class="col-md-6">
                <h5>Selected Subjects</h5>
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
                // // get the subject id from #selected-subjects li
                // // create a loop for the sql insert command
                // // use the count of li elements under #selected-subjects as the max loop
                // insert course id, subject id, year, and term
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


                    $course = $_POST["course"];
                    $year = mysql_prep($_POST["year"]);
                    $semester = mysql_prep($_POST["semester"]);
                    $school_yr = mysql_prep($_POST["school_yr"]);

                    $query  = "SELECT * FROM course_subjects WHERE course_id = '".$course."' AND year = '".$year."' AND term = '".$semester."'";
                    $result = mysqli_query($connection, $query);

                    if (mysqli_num_rows($result)>0) {
                      echo "<script type='text/javascript'>";
                      echo "alert('Subject set already exists for this course, year and term.');";
                      echo "</script>";

                      $URL="manage-course-subjects.php";
                      echo "<script>location.href='$URL'</script>";
                    }

                    else{

                      foreach ($arrVal as $subjects) {
                      $query   = "INSERT INTO course_subjects (course_id, subject_id, year, term, school_yr) VALUES ('{$course}', '{$subjects}', '{$year}', '{$semester}', '{$school_yr}')";
                      $result = mysqli_query($connection, $query);

                      }

                    }

                      if ($result === TRUE) {
                        echo "<script type='text/javascript'>";
                        echo "alert('Create subject set successful!');";
                        echo "</script>";

                        $URL="manage-course-subjects.php";
                        echo "<script>location.href='$URL'</script>";

                        } else {
                          echo "Error updating record: " . $connection->error;
                        }
                    }

                  }


                ?>
          <div class="col-md-12">
            <h3>Available Subjects</h3>
            <input class="form-control" id="myInput" type="text" placeholder="Quick Search">
              <?php

                echo "<table id=\"datatable\" class=\"table table-striped table-bordered dataTable\">";
                echo " <thead>";
                echo "  <tr>";
                echo "   <th>Subject Name</th>";
                echo "   <th>Subject Code</th>";
                echo "   <th>Prerequisite</th>";
                echo "   <th>Lecture Units</th>";
                echo "   <th>Lab Units</th>";
                echo "   <th>Total Units</th>";
                echo "   <th>&nbsp;</th>";   
                echo "  </tr></thead><tbody>";
                
                

                $query  = "SELECT * FROM subjects ORDER BY subject_id ASC";
                $result = mysqli_query($connection, $query);

              while($row = mysqli_fetch_assoc($result))
                {
                echo "<tr>";
                echo "<td>".$row['subject_name']."</td>";
                echo "<td>".$row['subject_code']."</td>";
                echo "<td>".get_subject_code($row['pre_id'],"",$connection)."</td>";
                echo "<td>".$row['lect_units']."</td>";
                echo "<td>".$row['lab_units']."</td>";
                echo "<td class=\"".$row['total_units']."\" id=\"class\">".$row['total_units']."</td>";
                echo "<td class=\"subject-wrap\"><a class=\"".$row['total_units']."-".$row['subject_code']."\" id=\"".$row['subject_id']."\""." href=\"#\">Add Subject</a> </td>";
                echo "</tr>";
                }

                echo "</tbody></table>"; 

                if(isset($connection)){ mysqli_close($connection); }
                //close database connection after an sql command   
              ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="response"></div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>


<?php include 'layout/footer.php';?>

<script>
$( document ).ready(function() {
  var arrval = new Array();

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
        event.stopImmediatePropagation();

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
  });

</script>
