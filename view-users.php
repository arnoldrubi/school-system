<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Manage Schedule</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          View All Users</div>
          <div class="card-body">
            <?php

              $role = $_SESSION["role"];

              if ($role == "administrator") {

                echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
                echo " <thead>";
                echo "  <tr>";
                echo "   <th>Username</th>";
                echo "   <th>Email</th>";
                echo "   <th>Role</th>";
                echo "   <th>Options</th>";   
                echo "  </tr></thead><tbody>";

                $query  = "SELECT * FROM users WHERE user_id NOT IN(1)";
                $result = mysqli_query($connection, $query);

              while($row = mysqli_fetch_assoc($result))
                {
                 
                  echo "<td>".$row['username']."</td>"; 
                  echo "<td>".$row['email']."</td>"; 
                  echo "<td>".$row['role']."</td>"; 
                
                  echo "<td class=\"options-td\"><a class=\"btn btn-warning btn-xs a-modal\" title=\"Edit\" href=\"edit-user.php?user_id=".$row['user_id']."\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a> ";
                  echo "<a title=\"Delete\" class=\"btn btn-danger btn-xs a-modal\" href=\"delete-user.php?user_id=".$row['user_id']."\"><i class=\"fa fa-trash\" aria-hidden=\"true\" onclick=\"return confirm('Are you sure you want to delete?')\"></i></a></td>";
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
