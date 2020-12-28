<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Faculty and Room Management</title>
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
        <li class="breadcrumb-item active">
          Faculty and Room Management
        </li>
      </ol>
      <h1>Faculty and Room Management</h1>
      <hr>
      <h2>Faculty Info</h2>
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>First Name</th>";
        echo "   <th>Last Name</th>";
        echo "   <th>Department</th>";  
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT * FROM teachers ORDER BY teacher_id ASC";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['department']."</td>";
        echo "</tr>";
        }

        echo "</tbody></table>"; 
      ?>

      <h2>Rooms Info</h2>
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Room Name</th>";
        echo "   <th>Description</th>"; 
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT * FROM rooms ORDER BY room_id ASC";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".$row['room_name']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "</tr>";
        }

        echo "</tbody></table>"; 
      ?>


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
