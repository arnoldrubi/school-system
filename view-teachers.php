<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Manage Teachers</title>
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
          Manage Teachers
        </li>
      </ol>
      <h1>View All Teachers</h1>
      <hr>
      <div class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>First Name</th>";
        echo "   <th>Last Name</th>";
        echo "   <th>Department</th>";
        echo "   <th>Options</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT * FROM teachers ORDER BY teacher_id ASC";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['department']."</td>";
        echo "<td style=\"text-align: center;\"><a class=\"btn btn-warning btn-xs\" title=\"Edit\" href=\"edit-teacher.php?teacher_id=".$row['teacher_id']."\""."><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a> ";
        echo "<a title=\"Delete\" class=\"btn btn-danger btn-xs\" href=\"javascript:confirmDelete('delete-teacher.php?teacher_id=".$row['teacher_id']."')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td>";
        //echo "<a href=\"delete-teacher.php?teacher_id=".$row['teacher_id']."\""." onclick=\"confirm('Are you sure?')\"> Delete Info</a></td>";
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