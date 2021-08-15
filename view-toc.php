<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Request for Transfer of Credits</title>
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
        <li class="breadcrumb-item">
         <a href="registrar-services.php">Registrar Services</a>
        </li>
        <li class="breadcrumb-item active">
         Dashboard - Transfer of Credits
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          List - Transfer of Credits</div>
          <div class="card-body">
            <a type="button" href="request-transfer-of-credits.php" class="btn btn-primary">+Add New</a>

            <div class="table-responsive" id="dataTable_wrapper">
            <?php

              echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
              echo " <thead>";
              echo "  <tr>";
              echo "   <th>Student Number</th>";
              echo "   <th>Last Name</th>";
              echo "   <th>First Name</th>";
              echo "   <th>Middle Name</th>";
              echo "   <th>Name Ext.</th>";
              echo "   <th>Options</th>";   
              echo "  </tr></thead><tbody>";
              
              

              $query  = "SELECT DISTINCT student_number,stud_reg_id FROM transfer_of_credits";
              $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result))
              {
                $reg_id = $row['stud_reg_id'];
                $last_name = "";
                $first_name = "";
                $middle_name = "";
                $name_ext = "";

                $query_name = "SELECT * FROM students_reg WHERE stud_reg_id='".$reg_id."'";
                $result_name = mysqli_query($connection, $query_name);
                while($row_name = mysqli_fetch_assoc($result_name))
                  {
                    $last_name = $row_name['last_name'];
                    $first_name = $row_name['first_name'];
                    $middle_name = $row_name['middle_name'];
                    $name_ext = $row_name['name_ext'];
                  }
              echo "<tr>";
              echo "<td>".$row['student_number']."</td>";
              echo "<td>".$last_name."</td>";
              echo "<td>".$first_name."</td>";
              echo "<td>".$middle_name."</td>";
              echo "<td>".$name_ext."</td>";
              echo "<td class=\"options-td\"><a class=\"btn btn-success btn-xs a-modal\" title=\"Manage TOC\" href=\"manage-toc.php?stud_reg_id=".$reg_id."\">Manage TOC</a></td>";
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