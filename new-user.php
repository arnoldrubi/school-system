<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>


  <title> Add New User</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-plus-square"></i>
          New User</div>
          <div class="card-body">
            <div class="col-md-2 col-md-offset-5">
              <form action="" method="post">
                <div class="form-group">
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
                  <input type="email" id="email" class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp" name="email" value="" placeholder="Enter email">
                  <p id="warning-text-email"></p>
                  <label for="role">Role:</label>
                  <select class="form-control" name="role" required>
                    <option value="administrator">Administrator</option>
                    <option value="registrar">Registrar</option>
                  </select>
                </div>
                <button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>

  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

    <?php

    if (isset($_POST['submit'])) {
      if (!isset($_POST["email"]) || !isset($_POST["password1"]) || !isset($_POST["password2"]) || !isset($_POST["role"]) || $_POST["email"] == null || $_POST["password1"] == null || $_POST["password2"] == null || $_POST["role"] == null) {
       die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
      }
      else{
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
            $query  = "INSERT INTO users (username, password, email, role) VALUES ('{$username}', '{$hashed_password}', '{$email}', '{$role}')";
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

       }
      }

  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>
      </div>
     </div>
    </div>
  </div>
<?php include 'layout/footer.php';?>

  <script>
  $(document).ready(function() {
    $("#submit").click(function() {
      if($("#InputPassword1").val() !== $("#InputPassword2").val()) {
        alert("Repeat password mistmatch");
        location.href='user-account.php';
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

    $("#email").keyup(function(){
      console.log("true");
      var email = $("#email").val();

      //run ajax
      $.post("scan_email.php",{
        user_input_email: email
      },function(data,status){
        $("#warning-text-email").html(data);

      });

    });

  });
  </script>