<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Grading Portal</title>
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
        <li class="breadcrumb-item active">
         Grading Portal
        </li>
      </ol>
      <h1>View Available Subjects</h1>

 <button class="btn btn-secondary" data-toggle="collapse" data-target="#advance-search">View Grades from Previous Term and School Year</button>
      <div id="advance-search" class="collapse">
          <div class="form-group row">
            <label class="col-md-2 col-form-label" for="Course">Select Term, and School Year:</label>
            <div class="col-md-3">
              <select class="form-control" id="sy-and-term" name="sy_and_term">
                <?php

                  echo "<option value=\"0\">Please select</option>";

                  $query_distinct_term_sy = "SELECT DISTINCT term, school_yr FROM student_grades ORDER BY school_yr, term" ;
                  $result_distinct_term_sy = mysqli_query($connection, $query_distinct_term_sy);

                  while($row_distinct_term_sy = mysqli_fetch_assoc($result_distinct_term_sy)){
                    $term_and_sy = $row_distinct_term_sy["term"].", ".$row_distinct_term_sy["school_yr"];

                    echo "<option value=\"".$term_and_sy."\">".$term_and_sy."</option>";
                  }

                ?>
              </select>
            </div>            
         </div>
      </div>

      <div class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered\" id=\"dataTable2\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Code</th>";
        echo "   <th class=\"skip-filter\">Description</th>";
        echo "   <th>Course</th>";
        echo "   <th>Year</th>";
        echo "   <th>Semester</th>";
        echo "   <th>Section</th>";
        echo "   <th>Teacher</th>";
        echo "   <th>Status</th>";
        echo "   <th class=\"skip-filter\">&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT DISTINCT course_id,subject_id, year, term, sec_id, teacher_id, grade_posted FROM student_grades WHERE term='".return_current_term($connection,"")."' AND school_yr='".return_current_sy($connection,"")."'";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";

        $subject_id = $row['subject_id'];
        $grade_posted = $row['grade_posted'];

        $query2 = "SELECT subject_name, subject_code FROM subjects WHERE subject_id='".$subject_id."'";
        $result2 = mysqli_query($connection, $query2);
        while($row2 = mysqli_fetch_assoc($result2))
        {
          echo "<td>".$row2['subject_code']."</td>";
          echo "<td>".$row2['subject_name']."</td>";
        }
        echo "<td>".get_course_code($row['course_id'],"",$connection)."</td>"; 
        echo "<td>".$row['year']."</td>"; 
        echo "<td>".$row['term']."</td>"; 

        if ($row['sec_id'] == "0") {
           echo "<td>N/A (Irregular Students)</td>"; 
        }
        else{
        echo "<td>".get_section_name($row['sec_id'],"",$connection)."</td>"; 
        }
        if ($row['teacher_id'] == "") {
        echo "<td><small>No teacher assigned. Used the scheduling menu to assign a teacher to this subject.</small></td>"; 
        }
        else{
        echo "<td>".get_teacher_name($row['teacher_id'],"",$connection)."</td>"; 
       }
       if ($grade_posted == 1) {
         echo "<td>Posted</td>";
       }
       else{
         echo "<td>Pending</td>";
       }
       
        echo "<td><a href=\"encode-grades.php?subject_id=".$subject_id."&term=".urlencode($row['term'])."&school_yr=".urlencode(return_current_sy($connection,""))."&course_id=".urlencode($row['course_id'])."&year=".urlencode($row['year'])."&section=".urlencode($row['sec_id'])."&teacher_id=".urlencode($row['teacher_id'])."\">Encode Grades</a></td>";
        echo "</tr>";
        }

        echo "</tbody></table>"; 
      ?>


     </div>
    </div>
  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>
<?php include 'layout/footer.php';?>

<script src="static/lisenme.js"></script>

<script type="text/javascript"> 
$(document).ready(function(){

  $('#dataTable2').ddTableFilter();

  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#example tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

    $("#sy-and-term").change(function(){
      var sy_and_term = $("#sy-and-term").val();
      //run ajax
      $.post("load_available_subject_for_grades.php",
        {sy_and_term: sy_and_term}
        ,function(data,status){
        $("#dataTable_wrapper").html(data);
      });
    });

});

</script>