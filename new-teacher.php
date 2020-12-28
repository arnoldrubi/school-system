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
        <label class="col-md-2 col-form-label" for="first-name">First Name</label>  
        <div class="col-md-2">
        <input id="first-name" name="first-name" type="text" placeholder="Input First Name" class="form-control input-md" required="">
        </div>

        <label class="col-md-2 col-form-label" for="last-name">Last Name</label>  
        <div class="col-md-2">
        <input id="last-name" name="last-name" type="text" placeholder="Input Last Name" class="form-control input-md" required="">
        </div>

        <label class="col-md-2 col-form-label" for="department">Department</label>  
        <div class="col-md-2">
        <input id="department" name="dapartment" type="text" placeholder="Input Department" class="form-control input-md" required="">
        </div>
      </div>
      <hr>
      <div class="form-group">

        <h3>User Login Info</h3>
        <label for="username">Username</label>
        <input type="text" value="" class="form-control" id="username" required name="username" placeholder="Username">
        <p id="warning-text"></p>
        <label for="exampleInputPassword1">Password</label>
        <input type="password" value="" class="form-control" id="InputPassword1" required name="password1" placeholder="Password">
        <label for="exampleInputPassword1">Repeat Password</label>
        <input type="password" value="" class="form-control" id="InputPassword2" required name="password2" placeholder="Repeat Password">
      </div>
      <hr>
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp" name="email" value="" placeholder="Enter email">
        <br>
        <label for="role">Role:</label>
        <select class="form-control" name="role" required>
          <option value="faculty">Faculty</option>
        </select>
      </div>
      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
          <input type="submit" id="submit" name="submit" value="Add Teacher" class="btn btn-primary" />&nbsp;
          <a class="btn btn-secondary"href="admin-dashboard.php">Cancel</a>
        </div>
      </div>
    </form>

      <?php 

        if (isset($_POST['submit'])) {
          $first_name = mysql_prep($_POST["first-name"]);
          $last_name = mysql_prep($_POST["last-name"]);
          $department = mysql_prep($_POST["dapartment"]);

          $password1 = mysql_prep($_POST["password1"]);
          $password2 = mysql_prep($_POST["password2"]);

          if ($password1 !== $password2) {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Repeat password mistmatch</div>");
          }


          if (!isset($first_name) || !isset($last_name) || !isset($department) || $first_name == "" || $last_name == "" || $department == "") {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
          }
          else{
            $query   = "INSERT INTO teachers (first_name, last_name, department) VALUES ('{$first_name}', '{$last_name}', '{$department}')";
            $result = mysqli_query($connection, $query);

            $teacher_id = mysqli_insert_id($connection); //this is for the new user account creation
            //create new user for faculty

            $username = mysql_prep($_POST["username"]);
            $hashed_password = password_hash($_POST["password1"], PASSWORD_DEFAULT);
            $email = mysql_prep($_POST["email"]);
            $role = mysql_prep($_POST["role"]);
            //query check to make sure no duplicate username are created

            $query_check_user  = "SELECT username FROM users WHERE username='".$username."'";
            $result_check_user = mysqli_query($connection, $query_check_user);

            if (mysqli_num_rows($result_check_user)>0) {
              die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Username: ".$username." is already taken</div>");
            }
            else{

                $query  = "INSERT INTO users (teacher_id, username, password, email, role) VALUES ('{$teacher_id}','{$username}', '{$hashed_password}', '{$email}', '{$role}')";
                $result = mysqli_query($connection, $query);

              if ($result === TRUE) {
                echo "<script type='text/javascript'>";
                echo "alert('New user successfully created!');";
                echo "</script>";

                $URL="view-users.php";
                  echo "<script>location.href='$URL'</script>";
                    }
                  else{
                  echo "Error updating record: " . $connection->error;
                }
            }
            //end create new user

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
  </div>
 </div> 
  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>

  <script>
  $(document).ready(function() {
    $("#submit").click(function() {
      if($("#InputPassword1").val() !== $("#InputPassword2").val()) {
        alert("Repeat password mistmatch");
        location.href='new-teacher.php';
      }
    });

    $("#username").keyup(function(){
      var username = $("#username").val();

      //run ajax
      $.post("scan_username.php",{
        user_input: username
      },function(data,status){
        $("#warning-text").html(data);

      });

    });


  });
  </script>