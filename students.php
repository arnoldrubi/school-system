<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>View Registered Students</title>
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
            <li class="breadcrumb-item active">
            Students
            </li>
      </ol>
      <h1>Students Overview</h1>
      <hr>

      <h2>Students Registration</h2>
      <div class="table-responsive" id="dataTable_wrapper">
      <?php

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Last Name</th>";
        echo "   <th>First Name</th>";
        echo "   <th>Middle Name</th>";
        echo "   <th>Name Ext.</th>";
        echo "   <th>Gender</th>";
        echo "   <th>Address</th>";
        echo "   <th>Email</th>";
        echo "   <th>Phone Number</th>"; 
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT * FROM students_reg ORDER BY last_name ASC";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['middle_name']."</td>"; 
        echo "<td>".$row['name_ext']."</td>"; 
        echo "<td>".$row['gender']."</td>"; 
        echo "<td>".$row['barangay']." ".$row['municipality'].", ".$row['province']."</td>"; 
        echo "<td>".$row['email']."</td>";      
        echo "<td>".$row['phone_number']."</td>";
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