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
    <title>Forgot Password</title>
  </head>
  <body class="bg-dark" id="login-page">

  <div class="container-fluid login-container">
    <div class="row">
      <div class="col-sm-12">
        <div id="site-name-container" class="col-md-3 login-form-1 center-block" style="margin: auto; text-align: center;">
        </div>
      </div>
    </div>
  <div class="container">
        <div class="col-md-5 center-block-e" style="margin: auto">
          <p class="login-form-intro"><img width="100" height="100" src="<?php echo "uploads/".$site_logo; ?>"></p>
            <div class="card-body">
              <h2 style="text-align: center">Reset Password</h2>
              <p>A reset password link will be sent to your email.</p>
              <form action="includes/reset-request.php" method="post">
                <div class="form-group">
                  <div class="form-label-group">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email address" value="" />
                  </div>
                </div>
                <input type="submit" name="reset-request-submit" id="reset-request-submit" class="btn btn-success form-control" value="Reset" />
              </form>
              <?php
                if (isset($_GET["reset"])) {
                  // a simple notice that when the user sent a request for reset, it will be redirected again to reset password page with this message
                  if ($_GET["reset"] == "success") {
                    echo "<p>Please check your email.</p>";
                  }
                }
              ?>
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
    $("#reset-request-submit").click(function() {
      if($("#email").val() == "") {
        alert("Email is empty!");
      }
    });
  });
  </script>
</html>