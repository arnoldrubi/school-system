<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Class Management</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "teachers_rooms";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="view-teachers-and-rooms.php">Faculty and Room Management</a>
        </li>
        <li class="breadcrumb-item active">
          Classes
        </li>
      </ol>
      <div class="row">
        <div class="col-md-6">
          <h4><i class="fa fa-bell" aria-hidden="true"></i> View All Classes Available</h4>
        </div>
        <div class="col-md-6">
          <div class="button-flt-right">
            <a href="add_new_class.php" class="btn btn-success btn-sm">Add New Class</a>
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
        echo "   <th>Options</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT classes.class_id,classes.sec_id, classes.subject_id, classes.teacher_id, classes.students_enrolled, classes.student_limit, sections.sec_name, sections.year, sections.course_id FROM classes INNER JOIN sections ON classes.sec_id=sections.sec_id;";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
        echo "<td>".get_course_code($row['course_id'],"",$connection)."</td>";
        echo "<td>".$row['year']."</td>";
        echo "<td>".$row['sec_name']."</td>";
        echo "<td>".get_teacher_name($row['teacher_id'],"",$connection)."</td>";
        echo "<td class=\"option-grp\"><a class=\"btn btn-warning btn-xs\" title=\"Edit\" href=\"edit-class.php?class_id=".$row['class_id']."\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a> <a title=\"Delete\" class=\"btn btn-danger btn-xs\" href=\"javascript:confirmDelete('delete-class.php?class_id=".$row['class_id']."')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td>";
        //sample buttons, need to create my own set
        // echo "<td><a href=\"#\" class=\"btn btn-primary btn-xs\">View</a> <a href=\"#\" class=\"btn btn-warning btn-xs\" data-toggle=\"tooltip\ data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"glyphicon glyphicon-cog\"></span></a> <a href=\"#\" class=\"btn btn-danger btn-xs\" onclick=\"return confirm('Are you sure you want to delete this?')\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"glyphicon glyphicon-trash\"></span></a></td>";
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
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>
<?php include 'layout/footer.php';?>
