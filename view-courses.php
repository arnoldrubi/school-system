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
      
      <h1>View All Courses</h1>
      <hr>
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Courses Name</th>";
        echo "   <th>Courses Code</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT * FROM courses WHERE course_deleted = 0  ORDER BY course_code ASC ";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".$row['course_desc']."</td>";
        echo "<td>".$row['course_code']."</td>";
        echo "<td><a href=\"edit-course.php?course_id=".$row['course_id']."\"".">Edit Course</a> | ";
        echo "<a href=\"javascript:confirmDelete('delete-course.php?course_id=".$row['course_id']."')\"> Delete Course</a></td>";
        //echo "<a href=\"delete-subject.php?subject_id=".$row['subject_id']."\""." onclick=\"confirm('Are you sure?')\"> Delete Subject</a></td>";
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