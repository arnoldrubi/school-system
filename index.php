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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Google Fonts Roboto and Open Sans -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="static/custom.css">
    <title>Log in</title>
  </head>
  <body class="bg-dark">

  <div class="container-fluid login-container">
    <div class="row">
      <div class="col-sm-12">
        <div id="site-name-container" class="col-md-3 login-form-1 center-block" style="margin: auto; text-align: center;">
          <img width="100" height="100" src="<?php echo "uploads/".$site_logo; ?>">
          <h3 class="site-name"><?php echo $school_name; ?></h3>
        </div>
      </div>
    </div>
  <div class="container" style="max-width: 443px;">
        <div class="card card-login mx-auto mt-5" style="margin: auto">
          <form action="authenticate.php" method="post">
            <div class="card-header">Login</div>
            <div class="card-body">
              <form action="authenticate.php" method="post">
                <div class="form-group">
                  <div class="form-label-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username *" value="" />
                    <label for="inputEmail">Username</label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-label-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Your Password *" value="" />
                    <label for="inputPassword">Password</label>
                  </div>
                </div>
                <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Login" />
              </form>
            </div>
          </form>
          <?php if (isset($_SESSION["message"])) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">";
            echo $_SESSION["message"];
            unset ($_SESSION["message"]);
            echo "</div>";
          }
          if (isset($_SESSION["user_id"])) {
            redirect_to("admin-dashboard.php");
          }
          ?>
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