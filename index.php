<?php

require_once("includes/session.php");
require_once("includes/db_connection.php");
require_once("includes/functions.php");

  $query = "SELECT * FROM site_settings";

  $result = mysqli_query($connection, $query);

  while($row = mysqli_fetch_assoc($result))
        {    
         $school_name = $row['school_name'];
         $site_logo = $row['site_logo'];
        }

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Google Fonts Roboto and Open Sans -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="static/custom.css">
    <title>Log in</title>
  </head>
  <body class="bg-dark" id="login-page">

  <div class="container-fluid login-container">
    <div class="row">
      <div class="col-sm-12">
        <div id="site-name-container" class="col-md-3 login-form-1 center-block" style="margin: auto; text-align: center;">

          <!-- <h3 class="site-name"><?php echo $school_name; ?></h3> -->
        </div>
      </div>
    </div>
  <div class="container">
        <div class="col-md-5 center-block-e" style="margin: auto">
          <p class="login-form-intro"><img width="100" height="100" src="<?php echo "uploads/".$site_logo; ?>"></p>
            <div class="card-body">
              <form action="authenticate.php" method="post">
                <div class="form-group">
                  <div class="form-label-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username *" value="" />
                    <i class="fa fa-user" aria-hidden="false"></i>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-label-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Your Password *" value="" />
                    <i class="fa fa-unlock-alt" aria-hidden="false"></i>
                  </div>
                </div>
                <input type="submit" name="submit" id="submit" class="btn btn-success form-control" value="Login" />
                <p class="text-center"><small><a href="reset-password.php">Forgot Password</a></small></p>
              </form>
            </div>
          <?php
            if (isset($_SESSION["message"])) {
              echo "<div class=\"alert alert-danger\" role=\"alert\">";
              echo $_SESSION["message"];
              unset ($_SESSION["message"]);
              echo "</div>";
            }
            if (isset($_GET["newpwd"])) {

              if ($_GET["newpwd"] == "passwordupdated") {
                echo "<div class=\"alert alert-success\" role=\"alert\">Your password has been reset!</div>";
              }
             
            }
            if (isset($_GET["error"])) {

              if ($_GET["error"] == 1) {
                echo "<div class=\"alert alert-danger\" role=\"alert\">You are currently logged in to another device. If this isn't you, please contact the admin immediately</div>";
              }
             
            }
          // if (isset($_SESSION["user_id"])) {
          //   redirect_to("admin-dashboard.php");
          // }
          ?>
          <div class="login-form-bottom clearfix">
            <div class="text-center decent-margin-top">
              <div class="btn-group btn-group-fb">
                <a href="https://www.facebook.com/fcat.fernandez/" class="btn btn-flat-social-fb">
                <i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
              </div>
              <div class="btn-group btn-group-web">
                <a href="http://www.fcat.com.ph/" class="btn btn-flat-social-fb">
                <i class="fa fa-globe" aria-hidden="true"></i>Official Website</a>
              </div>
             </div>
            </div>
        </div>
      </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
  <script>
  $(document).ready(function() {
    $("#submit").click(function() {
      if($("#password").val() == "" && $("#username").val() == "") {
        alert("Username and Password are empty!");
      }
      else if($("#password").val() == ""){
        alert("Password is empty!");
      }
      else if($("#username").val() == ""){
        alert("Username is empty!");
      }
    });
  });
  </script>
</html>