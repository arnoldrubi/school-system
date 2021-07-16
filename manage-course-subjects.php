<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Manage Courses Subjects</title>
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
          Manage Subjects Group
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
           Manage Subjects Group</div>
          <div class="card-body">
            <?php

              echo "<table id=\"example\" class=\"table table-striped table-bordered dataTable\">";
              echo " <thead>";
              echo "  <tr>";
              echo "   <th>Course</th>";
              echo "   <th>Year</th>";
              echo "   <th>Term</th>";
              echo "   <th>Options</th>";   
              echo "  </tr></thead><tbody>";
              
              

              $query  = "SELECT DISTINCT course_id, year, term, school_yr from course_subjects ORDER BY year ASC, term ASC";
              $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result))
              {
              echo "<tr>";

              $course_id = $row['course_id'];
              $query2 = "SELECT course_code FROM courses WHERE course_id='".$course_id."'";
              $result2 = mysqli_query($connection, $query2);
              while($row2 = mysqli_fetch_assoc($result2))
              {
                echo "<td>".$row2['course_code']."</td>";
              }

              echo "<td>".$row['year']."</td>";     
              echo "<td>".$row['term']."</td>";

              $yearurl = urlencode($row['year']);
              $termurl = urlencode($row['term']); 
              $school_yr = urlencode($row['school_yr']); 
              echo "<td class=\"options-td\"><a class=\"btn btn-warning btn-xs a-modal\" href=\"edit-course-subjects.php?course_id=".$row['course_id']."&year=".$yearurl."&term=".$termurl."&school_yr=".$school_yr."\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\" title=\"Edit\"></i></a>  ";
              echo "<a title=\"Delete\" class=\"btn btn-danger btn-xs a-modal\" href=\"javascript:confirmDelete('delete-course-subjects.php?course_id=".$row['course_id']."&year=".$yearurl."&term=".$termurl."&school_yr=".$school_yr."')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></a>";
              echo "</tr>";
              }

              echo "</tbody></table>"; 
            ?>

            <div class="alert alert-warning" role="alert">
              Attention: Deleting info will remove all subjects associated with the selected subject and its associated year and term.
            </div>
        </div>
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
<script type="text/javascript">
  
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>