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

    $query  = "SELECT * FROM irreg_manual_sched WHERE stud_reg_id = '".$stud_reg_id."' AND year = '".$year."' AND term = '".$term."' AND school_yr='".$sy."'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result)>0) {
      echo "<script type='text/javascript'>";
      echo "alert('Student has schedule assigned for this year, and term');";
      echo "</script>";
      
      $URL="irregular-manual-enrollment.php";
      echo "<script>location.href='$URL'</script>";
    }

?>


  <title>Manage Schedule <?php echo $student_num ?></title>
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
            Assign Schedule for Irregular Students
        </li>
      </ol>
      <h1>Assign Schedule to Irregular Student</h1>
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
            <div class="col-md-6">
              <input type="submit" id="submit" name="submit" value="Build Schedule" class="btn btn-primary" />
            </div>

              <input type="text" name="stud_reg_id" value ="<?php echo $stud_reg_id; ?>" style="display: none">
              <input type="text" name="course" value ="<?php echo $course; ?>" style="display: none">
              <input type="text" name="year" value ="<?php echo $year; ?>" style="display: none">
              <input type="text" name="term" value ="<?php echo $term; ?>" style="display: none">
              <input type="text" name="sy" value ="<?php echo $sy; ?>" style="display: none">
              <input type="text" name="array_values" id="array_values" style="display: none">
        </form>

      </div>

      <div class="col-md-6">
        <h2>Selected Schedule Blocks</h2>
          <ul id="selected-subjects">
          </ul>
      </div>

      <div class="col-md-12">
       <div style="margin-top: 1em;" class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject</th>";
        echo "   <th>Course</th>";
        echo "   <th>Year</th>";
        echo "   <th>Term</th>";
        echo "   <th>Section</th>";
        echo "   <th>Room</th>";
        echo "   <th>Teacher</th>";
        echo "   <th>Day</th>";        
        echo "   <th>Time Start</th>";
        echo "   <th>Time End</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>"; 
        

        $query3 =  "SELECT * FROM irreg_manual_subject WHERE stud_reg_id='".$stud_reg_id."'";
        $result3 = mysqli_query($connection, $query3);

          while($row3 = mysqli_fetch_assoc($result3))
            {
            
            $subject_id = $row3['subject_id'];

            $query4  = "SELECT * FROM subjects WHERE subject_id='".$subject_id."'";
            $result4 = mysqli_query($connection, $query4);
            while($row4 = mysqli_fetch_assoc($result4))
              {
                $subject_code = $row4['subject_code'];
              }
            $query1  = "SELECT * FROM schedule_block WHERE subject_id='".$subject_id."'";
            $result1 = mysqli_query($connection, $query1);
            while($row1= mysqli_fetch_assoc($result1))
              {
                

                $teacher_id = $row1['teacher_id'];
                $course_id = $row1['course_id'];
                $year = $row1['year'];
                $term = $row1['term'];
                $student_enrolled = $row1['students_enrolled'];
                $student_limit = $row1['student_limit'];

              if ($student_enrolled >= $student_limit) {
                echo "<tr><td colspan=\"12\">Schedule for ".$subject_code." for ".number_to_day($row1['day'])." has reached the maximum students allowed. Please contact the administrator.</td></tr>";
              }
              else{
              $query_teacher  = "SELECT * FROM teachers WHERE teacher_id='".$teacher_id."'";
              $result_teacher = mysqli_query($connection, $query_teacher);
              while($row_teacher= mysqli_fetch_assoc($result_teacher))
                {
                  $teacher_name = $row_teacher['first_name']." ".$row_teacher['last_name'];
                }
              
              echo "<tr>";
              echo "<td>".$subject_code."</td>";
              echo "<td>".$course_code."</td>";
              echo "<td>".$year."</td>";
              echo "<td>".$term."</td>";
              echo "<td>".$row1['section']."</td>";
              echo "<td>".$row1['room']."</td>";
              echo "<td>".$teacher_name."</td>";
              echo "<td>".number_to_day($row1['day'])."</td>";
              echo "<td>".date("g:i A", strtotime($row1['time_start']))."</td>";
              echo "<td>".date("g:i A", strtotime($row1['time_end']))."</td>";
              echo "<td class=\"subject-wrap\"><a class=\"".$subject_code." - ".number_to_day($row1['day'])."\" id=\"".$row1['schedule_id']."\""." href=\"#\">Add Schedule</a> </td>";
              echo "</tr>";
              }
            }
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
</script>