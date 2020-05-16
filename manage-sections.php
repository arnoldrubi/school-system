<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Manage Sections</title>
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
          <a href="view-teachers-and-rooms.php">Faculty and Room Management</a>
        </li>
        <li class="breadcrumb-item active">
          Manage Sections
        </li>
      </ol>
      <h1>Manage Sections</h1>
      <hr>
      <h2>Create New Section</h2>
     <form action="" method="post" >
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="subject-name">Section Name</label>  
        <div class="col-md-2">
        <input id="section-name" name="section_name" type="text" placeholder="Input Section Name" class="form-control input-md" required="">  
        </div>
        <label class="col-md-1 col-form-label" for="Course">Year</label>
        <div class="col-md-2">
          <select class="form-control" name="year" id="select-yr">
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>  
          </select>
        </div>
<?php
          echo "<label class=\"col-md-1 col-form-label\" for=\"Course\">Course</label><div class=\"col-md-2\"><select class=\"form-control\" name=\"course\">";
        
           //this block will load the course name from the database
              $query  = "SELECT * FROM courses WHERE course_deleted = 0";
              $result = mysqli_query($connection, $query);


              while($row = mysqli_fetch_assoc($result))
                {
                  $course_code = $row['course_code'];
                  echo  "<option value=\"".$row['course_id']."\">".$course_code."</option>";
                }

          echo "</select></div>";
?>
      </div>

      <?php 

        if (isset($_POST['submit'])) {
                  $section_name = mysql_prep($_POST["section_name"]);
                  $year = mysql_prep($_POST["year"]);
                  $course = $_POST["course"];

                    $query   = "INSERT INTO sections (sec_name, course_id, year) VALUES ('{$section_name}','{$course}','{$year}')";
                    $result = mysqli_query($connection, $query);


                    if ($result === TRUE) {
                      echo "<script type='text/javascript'>";
                      echo "alert('Create section successful!');";
                      echo "</script>";

                      $URL="manage-sections.php";
                      echo "<script>location.href='$URL'</script>";
                    } else {
                        echo "Error updating record: " . $connection->error;
                        print_r($query);
                    }
                  
                }

        ?>
      <div class="col-md-4">
        <input type="submit" name="submit" value="Create Section" class="btn btn-primary" />
        <a class="btn btn-secondary" href="admin-dashboard.php">Cancel</a>
      </div>
    </form>
    <br><br>
    <h2>View Existing Sections</h2>
      <hr>
      <?php

        echo "<table id=\"datatable\" class=\"table table-striped table-bordered table-sm\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Section Name</th>";
        echo "   <th>Course</th>";
        echo "   <th>Year</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT * FROM sections";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".$row['sec_name']."</td>";
        echo "<td>".get_course_code($row['course_id'],"",$connection)."</td>";
        echo "<td>".$row['year']."</td>";
        echo "<td><a href=\"javascript:confirmDelete('delete-section.php?sec_id=".$row['sec_id']."')\"> Delete Section</a></td>";
        echo "</tr>";
        }

        echo "</tbody></table>"; 

        if(isset($connection)){ mysqli_close($connection); }
        //close database connection after an sql command
      ?>

  </div>
 </div> 
  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>