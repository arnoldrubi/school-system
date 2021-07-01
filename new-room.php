<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>New Room</title>
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
         Add New Room
        </li>
      </ol>
      <h1>Add New Room Form</h1>
      <hr>
      <!-- Text input-->
    <form action="" method="post" >
      <h2>Basic Room Info</h2>
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="room-prefix">Room Prefix</label>  
        <div class="col-md-2">
          <select id="room-prefix" name="room-prefix" class="form-control" required>
            <option value="FM-">FM</option>
            <option value="FA-">FA</option>
            <option value="FL-">FL</option>
            <option value="FP-">FP</option>
          </select>
        </div>
        <label class="col-md-2 col-form-label" for="room-name">Room Name</label>  
        <div class="col-md-2">
          <input id="subject-name" name="room-name" type="text" placeholder="Input Room Name" class="form-control" required>
        </div>

        <label class="col-md-2 col-form-label" for="description">Description</label>  
        <div class="col-md-2">
          <input id="subject-name" name="description" type="text" placeholder="Input Short Description" class="form-control" required>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
          <input type="submit" name="submit" value="Add Room" class="btn btn-primary" />&nbsp;
          <a class="btn btn-secondary"href="view-room.php">Cancel</a>
        </div>
      </div>   
    </form>
  <div class="col-md-3">
    <p>Prefix Guide</p>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">FM - (FCAT Main) Gil Carlos St.o</li>
      <li class="list-group-item">FA -  (FCAT Annex) RE Chico St.</li>
      <li class="list-group-item">FL - (FCAT La Rosa) La Rosa St.</li>
      <li class="list-group-item">FP - (FCAT pinagbarilan) Pinagbarilan</li>
    </ul>
  </div>
      <!-- Integer input-->

      <?php 

        if (isset($_POST['submit'])) {
            $room_name = mysql_prep($_POST["room-prefix"]).mysql_prep($_POST["room-name"]);
            $description = mysql_prep($_POST["description"]);

          if (!isset($room_name) || !isset($description) || $room_name == "" || $description == "") {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
          }
          else{

          $row_count = return_duplicate_entry("rooms","room_name",$room_name,"",$connection);

          if ($row_count > 0) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Room name ".$room_name." already exists.</div>");
          }


            $query   = "INSERT INTO rooms (room_name, description) VALUES ('{$room_name}', '{$description}')";
            $result = mysqli_query($connection, $query);

            if ($result === TRUE) {
            echo "<script type='text/javascript'>";
            echo "alert('New room added!');";
            echo "</script>";

            $URL="view-room.php";
            echo "<script>location.href='$URL'</script>";
            } else {
            echo "Error updating record: " . $connection->error;
            }
          }
         }

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