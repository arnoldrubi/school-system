<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Enroll Students</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "students";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="#">Students</a>
        </li>
        <li class="breadcrumb-item active">
          Enroll Students
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          Registered Students</div>
          <div class="card-body">
            <div class="table-responsive" id="dataTable_wrapper">
            <?php

              echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
              echo " <thead>";
              echo "  <tr>";
              echo "   <th>Last Name</th>";
              echo "   <th>First Name</th>";
              echo "   <th>Middle Name</th>";
              echo "   <th>Address</th>";
              echo "   <th>Email</th>";
              echo "   <th>Phone Number</th>";
              echo "   <th width=\"9%\">Option</th>";   
              echo "  </tr></thead><tbody>";
              
              

              $query  = "SELECT * FROM students_reg WHERE is_active = 1 ORDER BY last_name ASC";
              $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result))
              {
              echo "<tr>";
              echo "<td>".$row['last_name']."</td>";
              echo "<td>".$row['first_name']."</td>";
              echo "<td>".$row['middle_name']."</td>"; 
              echo "<td>".$row['barangay']." ".$row['municipality'].", ".$row['province']."</td>"; 
              echo "<td>".$row['email']."</td>";      
              echo "<td>".$row['phone_number']."</td>";
              echo "<td style=\"text-align: center;\"><a class=\"btn btn-success btn-sm\" href=\"process-enrollment.php?stud_reg_id=".$row['stud_reg_id']."\"".">Enroll Student</a>";
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
<script type="text/javascript">
  
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>

<script type="text/javascript"> 
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#example tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>