<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Users' Logs</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">
         Users' Logs
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          Users' Logs</div>
          <div class="card-body">
            <div class="table-responsive" id="dataTable_wrapper">
            <?php

              echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
              echo " <thead>";
              echo "  <tr>";
              echo "   <th>Username</th>";
              echo "   <th>I.P. Address</th>";
              echo "   <th>Time Logged In</th>";
              echo "  </tr></thead><tbody>";
              
              

              $query  = "SELECT user_logs.user_id, user_logs.ip_address, user_logs.time_logged_in, users.username FROM user_logs INNER JOIN users ON  user_logs.user_id=users.user_id ORDER BY user_logs.time_logged_in DESC";
              $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result))
              {
              echo "<tr>";
              echo "<td>".$row['username']."</td>";
              echo "<td>".$row['ip_address']."</td>";
              echo "<td>".$row['time_logged_in']."</td>";
              echo "</tr>";
              }

              echo "</tbody></table>"; 
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

<script type="text/javascript">
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#datatable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

</script>