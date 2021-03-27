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
        <li class="breadcrumb-item">
          <a href="students.php">Students</a>
        </li>
        <li class="breadcrumb-item active">
            View Registered Students
        </li>
      </ol>
      <h1>View Registered Students</h1>
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
        echo "   <th>Legal Guardian</th>";
        echo "   <th>Guardian's Phone Number</th>";
        echo "   <th>Relationship</th>";
        echo "   <th>Options</th>";   
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
        echo "<td>".$row['guardian_name']."</td>";
        echo "<td>".$row['guardian_phone_number']."</td>";
        echo "<td>".$row['guardian_relationship']."</td>";
        echo "<td style=\"text-align: center;\"><a class=\"btn btn-warning btn-xs\" title=\"Edit\" href=\"edit-student.php?stud_reg_id=".$row['stud_reg_id']."\""."><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a> ";
        echo "<a title=\"Set to Inactive\" class=\"btn btn-danger btn-xs\" href=\"javascript:confirmDelete('delete-student.php?stud_reg_id=".$row['stud_reg_id']."')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></a></td>";
        //echo "<a href=\"delete-student.php?stud_reg_id=".$row['stud_reg_id']."\""." onclick=\"confirm('Are you sure?')\"> Delete Info</a></td>";
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