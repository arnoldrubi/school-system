<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>

  <?php 
    if (isset($_GET['sec_id'])) {
      $sec_id = $_GET["sec_id"];
      $term = $_GET["term"];
      $school_yr = $_GET["school_yr"];      

      $query  = "SELECT * FROM sections WHERE sec_id='".$sec_id."'";
      $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
      {
        $course_id = $row['course_id'];
        $year = $row['year'];
      }
    }
    else{
      redirect_to("sections-and-classes.php");
    }
  ?>


  <title>Class Management</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "scheduling";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="sections-and-classes.php">Sections and Classes</a>
        </li>
        <li class="breadcrumb-item active">
          Classes
        </li>
      </ol>
      <div class="row">
        <div class="col-md-6">
          <h4><i class="fa fa-bell" aria-hidden="true"></i> View All Classes Available for <?php 

          echo get_course_code($course_id,"",$connection).", ".$year.", Section ".get_section_name($sec_id,"",$connection);

          ?></h4>
        </div>
        <div class="col-md-6">
          <div class="button-flt-right">
            <?php echo "<a href=\"add_new_class.php?sec_id=".urlencode($sec_id)."\" class=\"btn btn-success btn-sm\">Add New Class</a>"; ?>
          </div>
        </div>  
      </div>
        <hr>
      <div class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject</th>";
        echo "   <th>Course</th>";
        echo "   <th>Year</th>";
        echo "   <th>Section</th>";
        echo "   <th>Teacher</th>";
        echo "   <th>Students (Current/Limit)</th>";
        echo "   <th>Options</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT classes.class_id,classes.sec_id, classes.subject_id, classes.teacher_id, classes.students_enrolled, classes.student_limit, sections.sec_name, sections.year, sections.course_id FROM classes INNER JOIN sections ON classes.sec_id=sections.sec_id WHERE classes.sec_id='".$sec_id."' AND classes.school_yr='".$school_yr."' AND classes.term='".$term."'";

        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".get_subject_code($row['subject_id'],"",$connection)." (".get_subject_name($row['subject_id'],"",$connection).")</td>";
        echo "<td>".get_course_code($row['course_id'],"",$connection)."</td>";
        echo "<td>".$row['year']."</td>";
        echo "<td>".$row['sec_name']."</td>";
        echo "<td>".get_teacher_name($row['teacher_id'],"",$connection)."</td>";
        echo "<td>".$row['students_enrolled']."/".$row['student_limit']."</td>";
        echo "<td class=\"option-grp\">";
        echo "<a href=\"view-schedule.php?class_id=".urlencode($row['class_id'])."\" class=\"btn btn-success btn-sm\">View Schedule</a>&nbsp;";

        echo "<a class=\"btn btn-warning btn-xs\" title=\"Edit\" href=\"edit-class.php?class_id=".$row['class_id']."\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a> <a title=\"Delete\" class=\"btn btn-danger btn-xs\" href=\"javascript:confirmDelete('delete-class.php?class_id=".$row['class_id']."')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td>";
        echo "</tr>";
        }

        echo "</tbody></table>"; 
      ?>

     </div>
     <hr>
     <h6>The following subjects have no classes created yet:</h6>
      <ul class="list-group">
        <?php
          $classes_subjects = array();
          $query_check_classes  = "SELECT * FROM classes WHERE sec_id='".$sec_id."'";
          $result_check_classes = mysqli_query($connection, $query_check_classes);

          while($row_check_classes = mysqli_fetch_assoc($result_check_classes))
          {
            array_push($classes_subjects, $row_check_classes['subject_id']);
          }

          $subjects_from_course = array();

          $query  = "SELECT * FROM course_subjects WHERE course_id='".$course_id."' AND year='".$year."' AND term='".return_current_term($connection,"")."' AND school_yr='".return_current_sy($connection,"")."'";
          $result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($result))
          {
            array_push($subjects_from_course, $row['subject_id']);
          }

            $missing_subjects = array_diff($subjects_from_course, $classes_subjects);

            //get the subject_id that have no classes yet and output them in a list below

            $new_array = array_values($missing_subjects);

            for ($i=0; $i < sizeof($missing_subjects); $i++) { 
              echo"<li class=\"list-group-item d-flex justify-content-between align-items-center\">";
              echo get_subject_code($new_array[$i],"",$connection)." (".get_subject_name($new_array[$i],"",$connection).")";
              echo "<a href=\"add_missing_class?sec_id=".urlencode($sec_id)."&term=".urlencode($term)."&school_yr=".$school_yr."&subject_id=".$new_array[$i]."\" class=\"btn btn-success btn-sm\">Create Class</a>";

            }
        ?>
      </ul>
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
