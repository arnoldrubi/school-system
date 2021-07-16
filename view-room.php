<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Manage Rooms</title>
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
          Manage Rooms
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          View All Rooms</div>
          <div class="card-body">
            <div class="table-responsive" id="dataTable_wrapper">
            <?php

              echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
              echo " <thead>";
              echo "  <tr>";
              echo "   <th>Room Name</th>";
              echo "   <th>Description</th>";
              echo "   <th>Options</th>";   
              echo "  </tr></thead><tbody>";
              
              

              $query  = "SELECT * FROM rooms ORDER BY room_id ASC";
              $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result))
              {
              echo "<tr>";
              echo "<td>".$row['room_name']."</td>";
              echo "<td>".$row['description']."</td>";
              echo "<td class=\"options-td\"><a class=\"btn btn-warning btn-xs a-modal\" title=\"Edit\" href=\"edit-room.php?room_id=".$row['room_id']."\""."><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a> ";
              echo "<a title=\"Delete\" class=\"btn btn-danger btn-xs a-modal\" href=\"javascript:confirmDelete('delete-room.php?room_id=".$row['room_id']."')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td>";
              echo "</tr>";
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
    <i class="fa fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>
<?php include 'layout/footer.php';?>
