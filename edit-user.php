<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php
  $role = $_SESSION["role"];
  $user_id = $_GET["user_id"];
  if ($role == "administrator") {

  $query  = "SELECT * FROM users where user_id='".$user_id."' LIMIT 1";
  $result = mysqli_query($connection, $query);
  while($row = mysqli_fetch_assoc($result))
  {
    $email = $row["email"];
    $username = $row["username"];
  }      
}
  else{
    echo "<script type='text/javascript'>";
    echo "alert('Access restricted!');";
    echo "</script>";

    $URL="admin-dashboard.php";
    echo "<script>location.href='$URL'</script>";
  }
?>

  <title>Edit User</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-pencil-square-o"></i>
          Manage User info for <?php echo ucfirst($username) ?></div>
          <div class="card-body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#sub-menu1" role="tab" aria-controls="home" aria-selected="true">Change Password</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#sub-menu2" role="tab" aria-controls="profile" aria-selected="false">Change Email</a>
              </li>
            </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="sub-menu1" role="tabpanel" aria-labelledby="sub-menu">
              <form class="form-horizontal" method="post">
                <div class="form-group mt-3">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" value="" class="form-control col-md-3" id="InputPassword1" required name="password1" placeholder="Password">
                  <label for="exampleInputPassword1">Repeat Password</label>
                  <input type="password" value="" class="form-control col-md-3" id="InputPassword2" required name="password2" placeholder="Repeat Password">
                </div>
                <button id="submit" name="submit_password" type="submit" class="btn btn-success">Change Password</button>
              </form>
            </div>
          <div class="tab-pane fade" id="sub-menu2" role="tabpanel" aria-labelledby="profile-tab">
              <form method="post">
                <div class="form-group mt-3">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control col-md-3" id="exampleInputEmail1" required aria-describedby="emailHelp" name="email" value="<?php echo $email; ?>" placeholder="Enter email">
                </div>
                <button id="submit" name="submit_email" type="submit" class="btn btn-success">Change Email</button>
              </form>
              <?php if (isset($_SESSION["message"]) && $_SESSION["message"] !== "") {
                echo "<br><div class=\"alert alert-success\" role=\"alert\">";
                echo $_SESSION["message"];
                $_SESSION["message"] = "";
                echo "</div>";
              } ?>
          </div>
        </div> 

        <?php 

          if (isset($_POST['submit_password'])) {
            if (!isset($_POST["password1"]) || !isset($_POST["password2"]) || $_POST["password1"] == null || $_POST["password2"] == null) {
               die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
            }
            else{
              $_SESSION["message"] = "";
              $hashed_password = password_hash($_POST["password1"], PASSWORD_DEFAULT);

              $query  = "UPDATE users SET username = '{$username}', password = '{$hashed_password}' WHERE user_id =".$user_id." LIMIT 1";
              $result = mysqli_query($connection, $query);

              if ($result && mysqli_affected_rows($connection) == 1) {
                // Success
                $_SESSION["message"] = "Account info updated.";
                redirect_to("view-users.php");
              } else {
                // Failure
                $_SESSION["message"] = "Account update failed.";
              }
            }
          }

          if (isset($_POST['submit_email'])) {
            $email = mysql_prep($_POST["email"]);

            $query  = "UPDATE users SET email = '{$email}' WHERE user_id =".$user_id." LIMIT 1";
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_affected_rows($connection) == 1) {
              // Success
              $_SESSION["message"] = "Account info updated.";
              redirect_to("view-users.php");
            } else {
              // Failure
              $_SESSION["message"] = "Account update failed.";
            }

          }

        ?>

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
      }
    });
  });
  </script>