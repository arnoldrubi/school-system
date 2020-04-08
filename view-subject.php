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
      <h1>View All Subject</h1>
      <hr>
      <input class="form-control" id="myInput" type="text" placeholder="Quick Search">
      <?php

        echo "<table id=\"datatable\" class=\"table table-striped table-bordered dataTable\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Name</th>";
        echo "   <th>Subject Code</th>";
        echo "   <th>Units</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT * FROM subjects ORDER BY subject_id ASC";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".$row['subject_name']."</td>";
        echo "<td>".$row['subject_code']."</td>";
        echo "<td>".$row['units']."</td>";
        echo "<td><a href=\"edit-subject.php?subject_id=".$row['subject_id']."\"".">Edit Subject</a> | ";
        echo "<a href=\"javascript:confirmDelete('delete-subject.php?subject_id=".$row['subject_id']."')\"> Delete Subject</a></td>";
        //echo "<a href=\"delete-subject.php?subject_id=".$row['subject_id']."\""." onclick=\"confirm('Are you sure?')\"> Delete Subject</a></td>";
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