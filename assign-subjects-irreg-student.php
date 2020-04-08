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
         <h2>Student Info</h2>
          <form id="courses_form" action="process-irreg-subjects.php" method="post" >
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
            <div class="col-md-4">
              <input type="submit" id="submit" name="submit" value="Build Subject Group" class="btn btn-primary" />
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
          <h2>Selected Subjects</h2>
          <ul id="selected-subjects">
          </ul>
      </div>

      <div class="col-md-12">
      <?php

        echo "<table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Name</th>";
        echo "   <th>Subject Code</th>";
        echo "   <th>Units</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>";    
        

        $query3 = "SELECT * FROM subjects";
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
              echo "<td>".$row3['subject_name']."</td>";
              echo "<td>".$row3['subject_code']."</td>";
              echo "<td>".$row3['units']."</td>";
              echo "<td class=\"subject-wrap\"><a class=\"".$row3['subject_code']."\" id=\"".$row3['subject_id']."\""." href=\"#\">Add Subject</a> </td>";
              echo "</tr>";
              } 

        echo "</tbody></table>"; 

      ?>
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
    console.log( "ready!" );

  var arrval = new Array();

  $("#dataTable").on("click",".subject-wrap a",function(){
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

    $("#selected-subjects li a").click(function(){
        $(this).closest("li").remove();
        alert ("Subject has been removed!");

        var removeItem = $(this).closest("li").attr("id");

        arrval = jQuery.grep(arrval, function(value) {
          return value != removeItem;
        });
        $("#array_values").val(arrval.join('; '));
    });

  });   
});
</script>



