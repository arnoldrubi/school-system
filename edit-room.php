<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
      if (isset($_GET['room_id'])) {
          $room_id = $_GET["room_id"]; //Refactor this validation later
        }
        else{
          $room_id = NULL;
        }
        if ($room_id == NULL) {
          redirect_to("view-room.php");
       }

?>

  <title>Edit Room</title>
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
         Edit Room
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-pencil-square-o"></i>
          Edit Room</div>
          <div class="card-body">
           <form class="form-horizontal" action="" method="post" >
            <?php

              $query  = "SELECT * FROM rooms WHERE room_id = ".$room_id;
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
                  $old_room_name = $row['room_name'];

                  $room_label_arr = explode("-", $old_room_name);

                  echo "<div class=\"form-group row\">";
                  echo "<label class=\"col-md-2 col-form-label\" for=\"room-prefix\">Room Prefix</label><div class=\"col-md-6\">";
                  echo "<select id=\"room-prefix\" name=\"room-prefix\" class=\"form-control\" required>";

                  $room_prefix = array("FM","FA","FL","FP");
                  for ($i=0; $i < count($room_prefix) ; $i++) { 
                    if ($room_prefix[$i] == $room_label_arr[0] ) {
                       echo "<option value=\"".$room_prefix[$i]."\" selected>$room_prefix[$i]</option>";
                    }
                    else{
                    echo "<option value=\"".$room_prefix[$i]."\">$room_prefix[$i]</option>";
                   }
                  }
                  echo "</select></div></div>";
                  echo  "<div class=\"form-group row\"><label class=\"col-md-2 col-form-label\" for=\"room-name\">Room Name</label>";
                  echo  "<div class=\"col-md-6\">";
                  echo "<input id=\"room-name\" name=\"room-name\" type=\"text\" placeholder=\"Input Room Name\" class=\"form-control\" required=\"\" value=\"".$room_label_arr[1]."\">";
                  echo "</div></div>";
                  echo  "<div class=\"form-group row\"><label class=\"col-md-2 col-form-label\" for=\"description\">Description</label>";
                  echo  "<div class=\"col-md-6\">";
                  echo "<input id=\"description\" name=\"description\" type=\"text\" placeholder=\"Input Subject Code\" class=\"form-control\" required=\"\" value=\"".$row['description']."\">";
                  echo "</div>";

                }
      ?>
            </div>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
              <input type="submit" name="submit" value="Edit Subject" class="btn btn-success" />&nbsp;
              <a class="btn btn-secondary"href="view-room.php">Cancel</a>
              </div>
            </div>
          </form>
          <div class="col-md-12">
            <h4>Prefix Guide</h4>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">FM - (FCAT Main) Gil Carlos St.o</li>
              <li class="list-group-item">FA -  (FCAT Annex) RE Chico St.</li>
              <li class="list-group-item">FL - (FCAT La Rosa) La Rosa St.</li>
              <li class="list-group-item">FP - (FCAT pinagbarilan) Pinagbarilan</li>
            </ul>
          </div>
      </div>
    </div>
    <?php

      if (isset($_POST['submit'])) {
        
          $room_name = mysql_prep($_POST["room-prefix"])."-".ltrim(rtrim(mysql_prep($_POST["room-name"])));
          $description = mysql_prep($_POST["description"]);

        if (!isset($room_name) || !isset($description)) {
          die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
        }
        else{

          if ($old_room_name !== $room_name) {
            $row_count = return_duplicate_entry("rooms","room_name",$room_name,"",$connection);

            if ($row_count > 0) {
              die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Room name ".$room_name." already exists.</div>");
            }
          }


          $query  = "UPDATE rooms SET room_name = '{$room_name}', description = '{$description}' WHERE room_id = {$room_id} LIMIT 1";
          $result = mysqli_query($connection, $query);

          if ($result === TRUE) {
            echo "<script type='text/javascript'>";
            echo "alert('Edit room successful!');";
            echo "</script>";

            $URL="view-room.php";
            echo "<script>location.href='$URL'</script>";
          } else {
            echo "Error updating record: " . $connection->error;
          }
        }
      }
    ?>


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



