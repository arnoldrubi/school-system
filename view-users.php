<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Manage Schedule</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <h1>View All Users</h1>
      <hr>
      <?php

        $role = $_SESSION["role"];

        if ($role == "administrator") {

          echo "<table id=\"datatable\" class=\"table table-striped table-bordered table-sm\">";
          echo " <thead>";
          echo "  <tr>";
          echo "   <th>Username</th>";
          echo "   <th>Email</th>";
          echo "   <th>Role</th>";
          echo "   <th>&nbsp;</th>";   
          echo "  </tr></thead><tbody>";

          $query  = "SELECT * FROM users";
          $result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($result))
          {
           
            echo "<td>".$row['username']."</td>"; 
            echo "<td>".$row['email']."</td>"; 
            echo "<td>".$row['role']."</td>"; 
          
            echo "<td><a href=\"edit-user.php?user_id=".$row['user_id']."\">Edit User</a> | ";
            echo "<a href=\"delete-user.php?user_id=".$row['user_id']."\"> Delete User</a></td>";
            echo "</tr>";
          }

          echo "</tbody></table>"; 
          echo "<a href=\"new-user.php\" type=\"button\" class=\"btn btn-primary\">+ Add New User</a>";
        }
      else{
          echo "<script type='text/javascript'>";
          echo "alert('Access restricted!');";
          echo "</script>";

          $URL="admin-dashboard.php";
          echo "<script>location.href='$URL'</script>";
      }
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
