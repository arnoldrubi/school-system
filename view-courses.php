<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Manage Courses</title>
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
        <li class="breadcrumb-item active">
            View All Courses
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          View All Courses</div>
          <div class="card-body">
            <?php

              echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
              echo " <thead>";
              echo "  <tr>";
              echo "   <th>Courses Name</th>";
              echo "   <th>Courses Code</th>";
              echo "   <th>Options</th>";   
              echo "  </tr></thead><tbody>";
              
              

              $query  = "SELECT * FROM courses WHERE course_deleted = 0  ORDER BY course_code ASC ";
              $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result))
              {
              echo "<tr>";
              echo "<td>".$row['course_desc']."</td>";
              echo "<td>".$row['course_code']."</td>";
              echo "<td class=\"options-td\"><a class=\"btn btn-warning btn-xs a-modal\" title=\"Edit Course\" href=\"edit-course.php?course_id=".$row['course_id']."\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a><a class=\"btn btn-success btn-xs \" title=\"Print Course Subjects\" target=\"_blank\" href=\"print-course-subjects.php?course_id=".urlencode($row['course_id'])."\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a>";
              echo "<a class=\"btn btn-danger btn-xs a-modal\" title=\"Set to inactive\" href=\"javascript:confirmDelete('delete-course.php?course_id=".$row['course_id']."')\"><i class=\"fa fa-window-close\" aria-hidden=\"true\"></i></a></td>";
              echo "</tr>";
              }

              echo "</tbody></table>"; 
            ?>

            <form>
              <div class="form-group row">
                <label class="col-md-2 col-form-label" for="ShowDeletedCourses">Show Deleted Courses</label>  
                <div class="col-md-2">
                  <select id="select-deleted" class="form-control">
                    <option selected disabled>Confirm Selection</option>
                    <option value = "1">Yes</option> 
                    <option value = "0">No</option>              
                  </select>
                </div>
              </div> 
            </form>
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
    $(document).ready(function(){
      $("#select-deleted").change(function(){
        var show_deleted = $("#select-deleted").val();
        //run ajax
        $.post("include-deleted-courses.php",{
          show_deleted: show_deleted
        },function(data,status){
          $("#dataTable").html(data);
        });
      });
    });
  </script>