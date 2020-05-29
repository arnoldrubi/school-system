<?php include 'layout/header-faculty.php';?>
<?php require_once("includes/db_connection.php"); ?>

      <?php
        $user_id = $_SESSION["user_id"];

        $query  = "SELECT * FROM users where user_id='".$user_id."' LIMIT 1";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($result))
        {
          $email = $row["email"];
          $username = $row["username"];
        }
      

        if (isset($_POST['submit'])) {
          $_SESSION["message"] = "";
          $hashed_password = password_hash($_POST["password1"], PASSWORD_DEFAULT);
          // $hashed_password = password_encrypt($_POST["password1"]);
          $email = $_POST["email"];

          $query  = "UPDATE users SET username = '{$username}', password = '{$hashed_password}', email = '{$email}' WHERE user_id =".$user_id." LIMIT 1";
          $result = mysqli_query($connection, $query);

          if ($result && mysqli_affected_rows($connection) == 1) {
            // Success
            $_SESSION["message"] = "Account info updated.";
            redirect_to("user-account.php");
          } else {
            // Failure
            $_SESSION["message"] = "Account update failed.";
          }
        }
      ?>

  <title>Manage Schedule</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <h1>Manage User info for <?php


      echo ucfirst($username);

      ?></h1>
    <div class="col-md-2 col-md-offset-5">
      <form action="" method="post">
        <div class="form-group">
          <p>Change password:</p>
          <label for="exampleInputPassword1">Password</label>
          <input type="password" value="" class="form-control" id="InputPassword1" required name="password1" placeholder="Password">
          <label for="exampleInputPassword1">Repeat Password</label>
          <input type="password" value="" class="form-control" id="InputPassword2" required name="password2" placeholder="Repeat Password">
        </div>
        <hr>
        <div class="form-group">
          <p>Change Email:</p>
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?php echo $email; ?>" placeholder="Enter email">
        </div>
        <button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
      </form>
      <?php if (isset($_SESSION["message"]) && $_SESSION["message"] !== "") {
        echo "<br><div class=\"alert alert-success\" role=\"alert\">";
        echo $_SESSION["message"];
        $_SESSION["message"] = "";
        echo "</div>";
      } ?>
     </div>
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

  <script>
  $(document).ready(function() {
    $("#submit").click(function() {
      if($("#InputPassword1").val() !== $("#InputPassword2").val()) {
        alert("Repeat password mistmatch");
        location.href='user-account.php';
      }
    });
  });
  </script>