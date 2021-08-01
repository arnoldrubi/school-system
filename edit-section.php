<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>

<?php 
      if (isset($_GET['sec_id'])) {
          $sec_id = $_GET["sec_id"];
        }
        else{
          redirect_to("manage-sections.php");
       }

?>

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
        <li class="breadcrumb-item">
          <a href="manage-sections.php">Manage Sections</a>
        </li>
        <li class="breadcrumb-item active">
          Edit Section
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-pencil-square-o"></i>
          Edit Section</div>
          <div class="card-body">
          <h2>Edit Section</h2>
           <form action="" method="post">

            <?php

              $query  = "SELECT * FROM sections WHERE sec_id = ".$sec_id;
              $result = mysqli_query($connection, $query);

              if ($result === !TRUE) {
                redirect_to("manage-sections.php");
              }
              else{
                while($row = mysqli_fetch_assoc($result))
                {
                  $old_sec_name = $row['sec_name'];
                  $old_sec_year = $row['year'];
                  $course_id = $row['course_id'];
                }
              }
            ?>

            <div class="form-group row">
              <label class="col-md-2 col-form-label" for="subject-name">Section Name</label>  
              <div class="col-md-2">
              <input id="section-name" <?php echo "value=\"".$old_sec_name."\""; ?> name="section_name" type="text" placeholder="Input Section Name" class="form-control input-md" required="">  
              </div>
              <label class="col-md-1 col-form-label" for="Course">Year</label>
              <div class="col-md-2">
                <select class="form-control" name="year" id="select-yr">
                  <?php
                    for ($i=1; $i < 5 ; $i++) { 
                      $year_label = $i."st Year";

                      if ($i == 1) {
                        $year_label = $i."st Year";
                      }
                      else if ($i == 2) {
                        $year_label = $i."nd Year";
                      }
                      else if ($i == 3) {
                        $year_label = $i."rd Year";
                      }
                      else if ($i == 4) {
                        $year_label = $i."th Year";
                      }

                      if ($old_sec_year == $year_label) {
                       echo "<option "."value=\"".$old_sec_year."\" selected>".$old_sec_year."</option>";
                      }
                      else{
                        echo "<option "."value=\"".$year_label."\">".$year_label."</option>";
                      }
                      
                    }                    
                  ?>
                </select>
              </div>
      <?php
          echo "<label class=\"col-md-1 col-form-label\" for=\"Course\">Course</label><div class=\"col-md-2\"><select class=\"form-control\" name=\"course\">";
        

            $course_code = $row['course_code'];
            echo  "<option value=\"".$course_id."\">".get_course_code($course_id,"",$connection)."</option>";

          echo "</select></div>";
      ?>
            </div>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
              <input type="submit" name="submit" value="Edit Section" class="btn btn-success" />&nbsp;
              <a class="btn btn-secondary"href="manage-sections.php">Cancel</a>
              </div>
            </div>
            <?php 

              if (isset($_POST['submit'])) {
                $section_name = mysql_prep($_POST["section_name"]);
                $year = mysql_prep($_POST["year"]);
                $course = $_POST["course"];

                if ($old_sec_name !== $section_name){

                  $query  = "SELECT * FROM sections WHERE sec_name='".$section_name."' AND year='".$year."' AND course_id='".$course."'";
                  $result = mysqli_query($connection, $query);

                  if (mysqli_num_rows($result) > 0) {
                    die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Section Name ".$section_name." under ".$year." ".get_course_code($course,"",$connection)."  already exists. Press the browser's back button.</div>");
                  }
                }

                  $query   = "UPDATE sections SET sec_name = '{$section_name}', year = '{$year}', course_id = '{$course}' WHERE sec_id='".$sec_id."' LIMIT 1";
                  $result = mysqli_query($connection, $query);


                  if ($result === TRUE) {
                    echo "<script type='text/javascript'>";
                    echo "alert('Edit section successful!');";
                    echo "</script>";

                    $URL="manage-sections.php";
                    echo "<script>location.href='$URL'</script>";
                  } else {
                      echo "Error updating record: " . $connection->error;
                      print_r($query);
                  }
                
              }

              ?>
        </form>
      </div>
    </div>
  </div>
 </div> 
  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>