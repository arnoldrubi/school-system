<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Manage Subjects</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "courses";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="view-courses.php">View Courses</a>
        </li>
        <li class="breadcrumb-item active">
          Manage Subjects
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          View Subjects</div>
          <div class="card-body">
            <div class="table-responsive" id="dataTable_wrapper">
            <?php

              echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
              echo " <thead>";
              echo "  <tr>";
              echo "   <th>Subject Name</th>";
              echo "   <th>Subject Code</th>";
              echo "   <th>Lecture Units</th>";
              echo "   <th>Lab Units</th>";
              echo "   <th>Total Units</th>";
              echo "   <th>Prerequisite</th>";
              echo "   <th>Options</th>";   
              echo "  </tr></thead><tbody>";
              
              

              $query  = "SELECT * FROM subjects ORDER BY subject_id ASC";
              $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result))
              {
              echo "<tr>";
              echo "<td>".$row['subject_name']."</td>";
              echo "<td>".$row['subject_code']."</td>";
              echo "<td>".$row['lect_units']."</td>";
              echo "<td>".$row['lab_units']."</td>";
              echo "<td>".$row['total_units']."</td>";
              echo "<td>".get_subject_name($row['pre_id'],"",$connection)."</td>";
              echo "<td class=\"options-td\"><a class=\"btn btn-warning btn-xs a-modal\" title=\"Edit\" href=\"edit-subject.php?subject_id=".$row['subject_id']."\""."><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a> ";
              echo "<a title=\"Delete\" class=\"btn btn-danger btn-xs a-modal\" href=\"javascript:confirmDelete('delete-subject.php?subject_id=".$row['subject_id']."')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td>";
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