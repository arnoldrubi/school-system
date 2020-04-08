<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Print Schedule Dashboard</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "scheduling";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="view-schedule.php">View All Schedule</a>
        </li>
        <li class="breadcrumb-item active">
         Group Scheduling
        </li>
      </ol>
      <h1>Print Schedule Dashboard</h1>

      <?php

        echo "<table id=\"datatable\" class=\"table table-striped table-bordered table-sm\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Courses Name</th>";
        echo "   <th>Courses Code</th>";
        echo "   <th>Year</th>";
        echo "   <th>Term</th>";
        echo "   <th>School Year</th>";
        echo "   <th>Total Enrollment</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT DISTINCT course_id, year, section, term, school_yr FROM course_subjects";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {

            echo "<tr>";
              $query2  = "SELECT * FROM courses WHERE course_id='".$row['course_id']."'";
              $result2 = mysqli_query($connection, $query2);
              while($row2 = mysqli_fetch_assoc($result2)){
                echo "<td>".$row2['course_desc']."</td>";
                echo "<td>".$row2['course_code']."</td>";
              }
            echo "<td>".$row['year']."</td>";
            echo "<td>".$row['term']."</td>";
            echo "<td>".$row['school_yr']."</td>";
              $query3  = "SELECT COUNT(*) AS num FROM enrollment WHERE course_id='".$row['course_id']."' AND year='".$row['year']."'";
              $result3 = mysqli_query($connection, $query3);
              while($row3 = mysqli_fetch_assoc($result3)){
                echo "<td>".$row3['num']."</td>";
              }
            echo "<td><a href=\"preview-print-schedule.php?course_id=".$row['course_id']."&year=".urlencode($row['year'])."&term=".urlencode($row['term'])."&section=".urlencode($row['section'])."&sy=".urlencode($row['school_yr'])."\">Print Schedule</a>";
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
