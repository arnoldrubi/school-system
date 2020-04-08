<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>New Teacher</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "teachers_rooms";

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
         New Teacher
        </li>
      </ol>
      <h1>Add New Teacher Form</h1>
      <hr>
      <!-- Text input-->
     <form action="" method="post" >
      <h2>Teacher's Info</h2>
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="subject-name">First Name</label>  
        <div class="col-md-2">
        <input id="subject-name" name="first-name" type="text" placeholder="Input First Name" class="form-control input-md" required="">
        </div>

        <label class="col-md-2 col-form-label" for="subject-name">Last Name</label>  
        <div class="col-md-2">
        <input id="subject-name" name="last-name" type="text" placeholder="Input Last Name" class="form-control input-md" required="">
        </div>

        <label class="col-md-2 col-form-label" for="subject-name">Department</label>  
        <div class="col-md-2">
        <input id="subject-name" name="dapartment" type="text" placeholder="Input Department" class="form-control input-md" required="">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
          <input type="submit" name="submit" value="Add Teacher" class="btn btn-primary" />&nbsp;
          <a class="btn btn-secondary"href="admin-dashboard.php">Cancel</a>
        </div>
      </div>
    </form>
  </div>
 </div> 
      <?php 

        if (isset($_POST['submit'])) {
          $first_name = mysql_prep($_POST["first-name"]);
          $last_name = mysql_prep($_POST["last-name"]);
          $department = mysql_prep($_POST["dapartment"]);

          if (!isset($first_name) || !isset($last_name) || !isset($department) || $first_name == "" || $last_name == "" || $department == "") {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
          }
          else{
            $query   = "INSERT INTO teachers (first_name, last_name, department) VALUES ('{$first_name}', '{$last_name}', '{$department}')";
            $result = mysqli_query($connection, $query);

            if ($result === TRUE) {
            echo "<script type='text/javascript'>";
            echo "alert('New teacher added!');";
            echo "</script>";

            $URL="view-teachers.php";
            echo "<script>location.href='$URL'</script>";
          } else {
            echo "Error updating record: " . $connection->error;
          }
        }
      }

        if(isset($connection)){ mysqli_close($connection); }
        //close database connection after an sql command
        ?>

  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>