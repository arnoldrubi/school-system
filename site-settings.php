<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Manage Site Settings</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php include 'layout/admin-sidebar.php';?>

  <?php

  $query  = "SELECT * FROM site_settings WHERE id = 1";
  $result = mysqli_query($connection, $query);

  if ($result === !TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('No record exists!');";
    echo "</script>";

    $URL="view-subject.php";
    echo "<script>location.href='$URL'</script>";

 }

  while($row = mysqli_fetch_assoc($result))
    {
      $school_name = $row['school_name'];
      $school_address = $row['school_address'];
      $phone_number = $row['phone_number'];
      $site_logo = $row['site_logo']; 
      $active_term = $row['active_term'];
      $active_sy = $row['active_sy'];
      $max_units = $row['max_units'];
    }
 
?>

    <div id="content-wrapper" class="col-md">
      <h1>Site Settings</h1>
      <hr>
      <h2>Manage Site Info</h2>
    <div class="col-md-9 col-md-offset-3">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="School Name">School Name</label>
          <input type="text" value="<?php echo $school_name; ?>" class="form-control col-md-5" id="school_name" required name="school_name">
        </div>
        <div class="form-group">
          <label for="School Address">School Address</label>
          <input type="text" value="<?php echo $school_address; ?>" class="form-control col-md-5" id="school_address" required name="school_address">
        </div>
        <div class="form-group">
          <label for="Phone Number">Phone Number</label>
          <input type="text" value="<?php echo $phone_number; ?>" class="form-control col-md-3" id="phone_number" required name="phone_number">
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label" for="Max Units">Max Units Per Term</label>
          <div class="col-md-1">
            <input type="number" name="max_units" value="<?php echo $max_units; ?>" class="form-control" id="max_units" required>
          </div>
        </div>
        <div class="form-group">
        <label class="col-md-2 col-form-label" for="photoupload">Upload Logo</label>
        <div class="col-md-2">
          <input id="photoupload" name="photoupload" class="input-file" type="file" accept="file_extension/.gif, .jpg, .png, image/*">
        </div>
          <p style="margin-top: 1em;">Current logo: <br><img style="max-width: 200px;" src="uploads/<?php echo $site_logo; ?>" /></p>
        </div>
        <div class="form-group">
          <div class="">
           <input type="submit" name="submit" value="Update Settings" class="btn btn-primary" />&nbsp;
           <a class="btn btn-secondary"href="admin-dashboard.php">Cancel</a>
          </div>
        </div>
      </form>
    </div>
    <hr>
    <h2>Manage Enrollment Settings</h2>
    <div class="col-md-9 col-md-offset-3">      
      <form action="update_enrollment_settings.php" method="post">        
        <div class="form-group row">
          <label class="col-md-2 col-form-label" for="Active Semester">Active Semester</label>
          <div class="col-md-2">
            <select id="active-term" name="active_term" class="form-control">
            <?php 
              $terms = array("1st Semester", "2nd Semester");
              for ($i=0; $i < count($terms); $i++) { 
               if ($terms[$i] == $active_term) {
                 echo "<option value=\"".$terms[$i]."\" selected>".$terms[$i]."</option>";
               }
               else{
                echo "<option value=\"".$terms[$i]."\" >".$terms[$i]."</option>";  
               }
              }
            ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label" for="Active School Year">Current School Year</label>
          <div class="col-md-2">
            <select id="current-school-yr" name="active_sy" class="form-control">
             <?php
                $query_sy  = "SELECT * FROM school_yr ORDER BY id DESC LIMIT 1";
                $result_sy = mysqli_query($connection, $query_sy);

                while($row_sy = mysqli_fetch_assoc($result_sy))
                  {
                    echo "<option selected>".$row_sy['school_yr']."</option>";
                  }

             ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="">
           <input type="submit" name="update_enrollment" value="Update Enrollment Settings" class="btn btn-primary" />&nbsp;
           <a class="btn btn-secondary"href="admin-dashboard.php">Cancel</a>
          </div>
        </div>

      <hr>

          <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#dropdown-add-sy" aria-expanded="false" aria-controls="collapseExample">
            Change School Year
          </button><br><br>
        <div class="collapse" id="dropdown-add-sy">
          <div class="card card-body col-md-4">
           <h5 class="card-title">Add and Update Current School Year</h5>
            <p class="card-text">Warning: Saving your changes for the current school year will affect the future enrollment.</p>
             <button type="submit" name="add_sy" id="add-sy" type="submit" class="btn btn-danger">Add New School Year</button>
          </div>
        </div>
        <br>
      </form>
    </div>
  
  <!-- /#wrapper -->

<?php
  if (isset($_POST['submit'])) {
    $filename = $_FILES["photoupload"]["name"];
    $targetdir = "uploads/".$filename;
    $targetfilepath = $targetdir . $filename;
    $filetype = pathinfo($targetfilepath,PATHINFO_EXTENSION);
      // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
        // get the file size
    $filesize = $_FILES['photoupload']['size'];

    $school_name = mysql_prep($_POST["school_name"]);
    $school_address = mysql_prep($_POST["school_address"]);
    $phone_number = mysql_prep($_POST["phone_number"]);
    $max_units = $_POST["max_units"];

    if (!isset($school_name) || !isset($school_address) || !isset($phone_number)) {
      die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
    }

    else{

      if ($filename = "" || !isset($filename) || $filename == null) {
        $query  = "UPDATE site_settings SET school_name = '{$school_name}', school_address = '{$school_address}', phone_number = '{$phone_number}', max_units = '{$max_units}' WHERE id = 1 LIMIT 1";
        $result = mysqli_query($connection, $query);
      }
      else{

        move_uploaded_file($_FILES["photoupload"]["tmp_name"], $targetdir);

        $filename = $_FILES["photoupload"]["name"];

        if (!in_array($extension, ['jpg','png','gif'])) {
          die ("<div class=\"row alert alert-danger\" role=\"alert\">Error: Logo must be in .jpg or .png or .gif format.</div>");
        }

        $query  = "UPDATE site_settings SET school_name = '{$school_name}', school_address = '{$school_address}', phone_number = '{$phone_number}',site_logo = '{$filename}', max_units = '{$max_units}' WHERE id = 1 LIMIT 1";
        $result = mysqli_query($connection, $query);


      }
      if ($result === TRUE) {
        echo "<script type='text/javascript'>";
        echo "alert('Edit site settings successful!');";
        echo "</script>";

        $URL="admin-dashboard.php";
        echo "<script>location.href='$URL'</script>";
      } else {
        echo "Error updating record: " . $connection->error;
      }
    }
  }

?>
</div>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>
<?php include 'layout/footer.php';?>

  <script>
  $(document).ready(function() {
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

      // var current_sy = $("#current-school-yr").val(); 
      //  $("#select-deleted").click(function(){
      //     $("#add-sy").load("add-new-sy.php",{
      //       current_sy: current_sy
      //     }); 
      //  });

  });
  </script>

