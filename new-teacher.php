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
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-plus-square"></i>
          New Teacher</div>
          <div class="card-body">
           <form class="form-horizontal" action="" method="post" >
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="first-name">First Name</label>  
              <div class="col-sm-6">
                <input id="first-name" name="first-name" type="text" placeholder="Input First Name" class="form-control input-md" required="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="last-name">Last Name</label>
              <div class="col-sm-6">   
                <input id="last-name" name="last-name" type="text" placeholder="Input Last Name" class="form-control input-md" required="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="department">Department</label>  
              <div class="col-sm-6">
                <input id="department" name="dapartment" type="text" placeholder="Input Department" class="form-control input-md" required="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="exampleInputEmail1">Email address</label>
              <div class="col-sm-6">
                <input type="email" id="email-faculty" class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp" name="email" value="" placeholder="Enter email">
                <div id="warning-text-email"></div>
              </div>      
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"><button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                   Faculty Number: Manual Encode
                  </button>
                Optional*
              </label>
              <div class="col-sm-6">               
                <div class="collapse" id="collapseExample">
                  <input type="text" class="form-control" id="manual-encode-faculty-num" name="manual_encode_encode_num" placeholder="xxxx-xxxx">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
                <input type="submit" name="submit" value="New Teacher" class="btn btn-success" />&nbsp;
                <a class="btn btn-secondary"href="view-room.php">Cancel</a>
              </div>
            </div> 
          </form>

      <?php 

        if (isset($_POST['submit'])) {
          $first_name = rtrim(ltrim(mysql_prep($_POST["first-name"])));
          $last_name = rtrim(ltrim(mysql_prep($_POST["last-name"])));
          $department = mysql_prep($_POST["dapartment"]);
          $manual_faculty_num = mysql_prep($_POST["manual_encode_encode_num"]);

          if (!isset($first_name) || !isset($last_name) || !isset($department) || $first_name == "" || $last_name == "" || $department == "") {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
          }
          else{

            //create new user for faculty
            $rand_password = password_generate(8);
            $hashed_password = password_hash($rand_password, PASSWORD_DEFAULT);
            $email = mysql_prep($_POST["email"]);
            $role = mysql_prep("faculty");

            $query_check_user  = "SELECT username FROM users WHERE username='".$manual_faculty_num."'";
            $result_check_user = mysqli_query($connection, $query_check_user);

            if (mysqli_num_rows($result_check_user)>0) {
              die ("<br><div class=\"alert alert-danger\" role=\"alert\">Error: Employee Code: ".$manual_faculty_num." is already used</div>");
            }

            $query_check_email  = "SELECT username FROM users WHERE email='".$email."'";
            $result_check_email = mysqli_query($connection, $query_check_email);

            if (mysqli_num_rows($result_check_email)>0) {
              die ("<br><div class=\"alert alert-danger\" role=\"alert\">Error: Email: ".$email." is already used</div>");
            }

            else{

              // run a query to check if the faculty name is already in the system
              $query_check_faculty  = "SELECT * FROM teachers WHERE last_name='".$last_name."' AND first_name='".$first_name."'";
              $result_check_faculty = mysqli_query($connection, $query_check_faculty);

              if (mysqli_num_rows($result_check_faculty)>0) {
               echo "<div class=\"alert alert-danger\" role=\"alert\">Error: ".$first_name." ".$last_name." is already in the system.</div>";
              }
              else{

                $query  = "INSERT INTO teachers (last_name, first_name, department, active) VALUES ('{$last_name}','{$first_name}', '{$department}', 1)";
                $result = mysqli_query($connection, $query);

                // created a function that generates the emp_code
                // ran two queries 1. for inserting new teacher info, 2. for updating the emp_code with the auto generated emp_code
                $teacher_id = mysqli_insert_id($connection); //this is for the new user account creation         

                if (isset($manual_faculty_num) && !empty($manual_faculty_num)){
                  $emp_code = $manual_faculty_num;

                  // do a check here to make sure manually entered emp code is not duplicate
                }
                else{                     
                  $emp_code = generate_emp_code($teacher_id,"");                  
                }
                $query   = "UPDATE teachers SET emp_code = '".$emp_code."' WHERE teacher_id = ".$teacher_id;
                $result = mysqli_query($connection, $query);

                $username = $emp_code;
                //query check to make sure no duplicate username and emails were added
                $query_check_user  = "SELECT username FROM users WHERE username='".$username."'";
                $result_check_user = mysqli_query($connection, $query_check_user);

                if (mysqli_num_rows($result_check_user)>0) {
                  die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Username: ".$username." is already taken</div>");
                }

                $query  = "INSERT INTO users (teacher_id, username, password, email, role, active) VALUES ('{$teacher_id}','{$username}', '{$hashed_password}', '{$email}', '{$role}', 1)";
                $result = mysqli_query($connection, $query);


              //create the email

              $to = $email;

              $subject = "AIMS Account Registration";

              $message = "<p>You have been registered to the AIMS Portal. Below are your credentials:</p>";
              $message .= "<p>U: ".$username."<br> P: ".$rand_password."</p>";
              $message .= "<p>Please change the password by logging in to <a href=\"https://fcat.com.ph/aims/\">AIMS</a>, go \"My Account\" after log in</p>";
              $message .= "<p>Sincerely,<br> AIMS Admin</p>";
              $headers = "From: AIMS Admin <admin@aims.fcat.com.ph>\r\n";
              $headers .="Reply-To: <admin@aims.fcat.com.ph>\r\n";
              $headers .="Content-type: text/html\r\n";

              mail($to, $subject, $message, $headers);

              if ($result === TRUE) {
                echo "<script type='text/javascript'>";
                echo "alert('New user successfully created! Login credentials were sent to registered email');";
                echo "</script>";

                $URL="view-teachers.php";
                  echo "<script>location.href='$URL'</script>";
                    }
                  else{
                  echo "Error updating record: " . $connection->error;
                }

              }

            }
            //end create new user

        }
      }

        if(isset($connection)){ mysqli_close($connection); }
        //close database connection after an sql command
        ?>
      </div>
    </div>
  </div>
 </div> 
  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>

  <script>
  $(document).ready(function() {
    $("#email-faculty").keyup(function(){
      
      var email = $("#email-faculty").val();
      //run ajax
      $.post("scan_email.php",{
        user_input_email: email
      },function(data,status){
        $("#warning-text-email").html(data);
      });
    });

  });
  </script>