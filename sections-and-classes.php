<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Group Scheduling Dashboard</title>
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
        <li class="breadcrumb-item active">
          Sections and Classes
        </li>
      </ol>
      <h1>Sections and Classes</h1>

      <?php

        $term = return_current_term($connection, "");
        $school_yr = return_current_sy($connection, "");

        echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Courses Name</th>";
        echo "   <th>Courses Code</th>";
        echo "   <th>Year</th>";
        echo "   <th>Section</th>";
        echo "   <th>Term</th>";
        echo "   <th>Year</th>";
        echo "   <th>School Year</th>";
        echo "   <th>Total Enrollment</th>";
        echo "   <th>Option</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT sections.sec_id, sections.course_id, sections.sec_name, sections.year, courses.course_id, courses.course_code, courses.course_desc FROM sections INNER JOIN courses ON sections.course_id=courses.course_id ORDER BY courses.course_code;";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {

            echo "<tr>";

            echo "<td>".$row['course_desc']."</td>";
            echo "<td>".$row['course_code']."</td>";         
            echo "<td>".$row['year']."</td>";
            echo "<td>".$row['sec_name']."</td>";
            echo "<td>".$term."</td>";
            echo "<td>".$row['year']."</td>";
            echo "<td>".$school_yr."</td>";
            $enrolled_students = get_enrolled_regular_students($row['sec_id'],$term,$school_yr,"",$connection);
            echo "<td>".$enrolled_students."</td>";
            echo "<td class=\"option-grp\"><a class=\"btn btn-success btn-sm\" href=\"classes.php?sec_id=".urlencode($row['sec_id'])."&term=".urlencode($term)."&school_yr=".urlencode($school_yr)."\">Create Classes</a>";
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
