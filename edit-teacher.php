<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
      if (isset($_GET['teacher_id'])) {
          $teacher_id = $_GET["teacher_id"]; //Refactor this validation later
        }
        else{
          $teacher_id = NULL;
        }
        if ($teacher_id == NULL) {
          redirect_to("view-teachers.php");
       }

?>

  <title>Edit Faculty Info</title>
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
          Edit Teacher
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-pencil-square-o"></i>
          Edit Teacher Info</div>
          <div class="card-body">
           <form class="form-horizontal" action="" method="post" >           
            <?php

              $query  = "SELECT * FROM teachers WHERE teacher_id = ".$teacher_id;
              $result = mysqli_query($connection, $query);

              if ($result === !TRUE) {
                    echo "<script type='text/javascript'>";
                    echo "alert('No record exists!');";
                    echo "</script>";

                    $URL="view-teaschers.php";
                    echo "<script>location.href='$URL'</script>";

              }

              while($row = mysqli_fetch_assoc($result))
                {
                  $old_first_name = $row['first_name'];
                  $old_last_name = $row['last_name'];

                  echo  "<div class=\"form-group row\">";
                  echo  "<label class=\"col-md-2 col-form-label\" for=\"first-name\">First Name</label>";
                  echo  "<div class=\"col-md-6\">";
                  echo "<input id=\"first-name\" name=\"first-name\" type=\"text\" placeholder=\"Input First Name\" class=\"form-control input-md\" required=\"\" value=\"".$old_first_name."\">";
                  echo "</div></div>";

                  echo  "<div class=\"form-group row\"><label class=\"col-md-2 col-form-label\" for=\"last-name\">Last Name</label>";
                  echo  "<div class=\"col-md-6\">";
                  echo "<input id=\"last-name\" name=\"last-name\" type=\"text\" placeholder=\"Input First Name\" class=\"form-control input-md\" required=\"\" value=\"".$old_last_name."\">";
                  echo "</div></div>";

                  echo  "<div class=\"form-group row\"><label class=\"col-md-2 col-form-label\" for=\"department\">Department</label>";
                  echo  "<div class=\"col-md-6\">";
                  echo "<input id=\"department\" type=\"text\" name=\"department\" placeholder=\"Input Department\" class=\"form-control input-md\" required=\"\" value=\"".$row['department']."\">";
                  echo "</div></div>";

                    $query  = "SELECT * FROM users where teacher_id='".$teacher_id."' LIMIT 1";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($result))
                    {
                      $user_id = $row["user_id"];
                    }

                }

              if (isset($_POST['submit'])) {
                $first_name = rtrim(ltrim(mysql_prep($_POST["first-name"])));
                $last_name = rtrim(ltrim(mysql_prep($_POST["last-name"])));
                $department = mysql_prep($_POST["department"]);

                if (!isset($first_name) || !isset($last_name)) {
                  die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
                }
                else{

                  // run a query to check if the faculty name is already in the system
                  $query_check_faculty  = "SELECT * FROM teachers WHERE last_name='".$last_name."' AND first_name='".$first_name."'";
                  $result_check_faculty = mysqli_query($connection, $query_check_faculty);

                  if (mysqli_num_rows($result_check_faculty)>0 && $old_last_name !== $last_name && $old_first_name !== $first_name) {
                   echo "<div class=\"alert alert-danger\" role=\"alert\">Error: ".$first_name." ".$last_name." is already in the system.</div>";
                  }
                  else{
                  $query  = "UPDATE teachers SET first_name = '{$first_name}', last_name = '{$last_name}', department = '{$department}' WHERE teacher_id = {$teacher_id} LIMIT 1";
                  $result = mysqli_query($connection, $query);

                  if ($result === TRUE) {
                    echo "<script type='text/javascript'>";
                    echo "alert('Updating teacher info successful!');";
                    echo "</script>";

                    $URL="view-teachers.php";
                    echo "<script>location.href='$URL'</script>";
                    } else {
                      echo "Error updating record: " . $connection->error;
                    }
                  }
                }
              }
                  //removed the redirect function and replaced it with javascript alert above
                  //redirect_to("new-subject.php");

            ?>

            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
                <input type="submit" name="submit" value="Edit Teacher" class="btn btn-success" />&nbsp;
                <a class="btn btn-secondary"href="view-teachers.php">Cancel</a>
              </div>
            <?php
                echo  "<div class=\"col-md-12 text-center mt-5\">";
                echo "<a href=\"edit-user.php?user_id=".$user_id."\">Change User Password or Email</a>";
                echo "</div>";
            ?>
            </div>
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


<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>

<?php include 'layout/footer.php';?>



