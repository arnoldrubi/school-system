<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>

<?php

    if (isset($_GET['regid']) && isset($_GET['course']) && isset($_GET['year']) && isset($_GET['term']) && isset($_GET['sy']) && $_GET['regid'] !== "" && $_GET['course'] !== "" && $_GET['year'] !== "" && $_GET['term'] !== "" && $_GET['sy'] !== "") {
      $course_id = $_GET["course"];
      $student_num = $_GET["student_num"];
      $course = $_GET["course"];
      $stud_reg_id = $_GET["regid"];
      $year = urldecode($_GET["year"]);
      $term = urldecode($_GET["term"]);
      $sy = urldecode($_GET["sy"]);
    }
  else{
    redirect_to("view-enrolled-students.php");
  }

?>


  <title>View Schedule <?php echo $student_num ?></title>
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
            View Schedule of Irregular Student
        </li>
      </ol>
      <h1>View Schedule of Irregular Student</h1>
      <hr>
      <div class="row">

        <div class="col-md-6">
          <h2>Student Info</h2>
          <form id="courses_form" action="process-irreg-schedule.php" method="post" >
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
<!--             <div class="col-md-6">
              <input type="submit" id="submit" name="submit" value="Build Schedule" class="btn btn-primary" />
            </div>

              <input type="text" name="stud_reg_id" value ="<?php echo $stud_reg_id; ?>" style="display: none">
              <input type="text" name="course" value ="<?php echo $course; ?>" style="display: none">
              <input type="text" name="year" value ="<?php echo $year; ?>" style="display: none">
              <input type="text" name="term" value ="<?php echo $term; ?>" style="display: none">
              <input type="text" name="sy" value ="<?php echo $sy; ?>" style="display: none">
              <input type="text" name="array_values" id="array_values" style="display: none"> -->
        </form>

      </div>

      <div class="col-md-12">
       <div style="margin-top: 1em;" class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Code</th>";
        echo "   <th class=\"skip-filter\">Subject</th>";
        echo "   <th>Course</th>";
        echo "   <th>Year</th>";
        echo "   <th>Term</th>";
        echo "   <th class=\"skip-filter\">Room</th>";
        echo "   <th class=\"skip-filter\">Teacher</th>";
        echo "   <th class=\"skip-filter\">Day</th>";        
        echo "   <th class=\"skip-filter\">Time Start</th>";
        echo "   <th class=\"skip-filter\">Time End</th>";
        echo "  </tr></thead><tbody>";
        
        $class_list = array();


        $query_class =  "SELECT * FROM irreg_manual_sched WHERE stud_reg_id='".$stud_reg_id."'";
        $result_class = mysqli_query($connection, $query_class);
          while($row_class = mysqli_fetch_assoc($result_class))
            {

            array_push($class_list, $row_class['class_id']);
            $class_set = implode(",", $class_list);

          }

            $query = "SELECT * FROM schedule_block WHERE class_id IN (".$class_set.") ORDER BY day, time_start ";;
            $result = mysqli_query($connection, $query);
            while($row= mysqli_fetch_assoc($result))
        {

          $day = number_to_day($row['day']);
          $teacher_name = get_teacher_name($row['teacher_id'],"",$connection);
          echo "<tr>";
          echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>"; 
          echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>"; 
          echo "<td>".get_course_code($row['course_id'],"",$connection)."</td>";
          echo "<td>".$row['year']."</td>";
          echo "<td>".$row['term']."</td>";
          echo "<td>".$row['room']."</td>";
          echo "<td>".$teacher_name."</td>";
          echo "<td>".$day."</td>";
          echo "<td>".date("g:i A", strtotime($row['time_start']))."</td>";
          echo "<td>".date("g:i A", strtotime($row['time_end']))."</td>";
          echo "</tr>";
        }

        echo "</tbody></table>"; 


      ?>
       </div>
      </div>
    </div>
   </div>
  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>
<?php include 'layout/footer.php';?>
<!-- 
<script>
$( document ).ready(function() {
    console.log( "ready!" );

  var arrval = new Array();

  $('.subject-wrap a').click(function(){
    var $checker = false;
    $( "#selected-subjects li:contains('"+ $(this).attr('class') +"')" ).each(function(){

        alert('Error! This subject is already selected');
        $checker = true;
      }
    );
    if ($checker === false){
    alert ($(this).attr('class')+ " has been selected!");
    $( "#selected-subjects" ).append( "<li id=\""+$(this).attr('id')+"\">"+$(this).attr('class')+" <a href=\"#\">x</a></li>" );
    $( "#courses_form" ).append( "<input type=\"text\" name=\""+$(this).attr('id')+"\" value=\""+$(this).attr('id')+"\" style=\"display: none\">" );
    arrval.push($(this).attr('id'));
    $("#array_values").val(arrval.join('; '));
    }
    var $count = $("#selected-subjects input").length;

    console.log(arrval.join('; '));

    $("#selected-subjects li a").click(function(){//remove this and place it under a document on load function
        $(this).closest("li").remove();
        alert ("Schebule block has been removed!");

        var removeItem = $(this).closest("li").attr("id");

        arrval = jQuery.grep(arrval, function(value) {
          return value != removeItem;
        });
        $("#array_values").val(arrval.join('; '));
    });

  });   
});
</script> -->