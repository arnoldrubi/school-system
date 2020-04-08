<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Register New Student</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "students";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="students.php">Students</a>
        </li>
        <li class="breadcrumb-item active">
            Register New Student
        </li>
      </ol>
      <h1>Register New Student Form</h1>
      <hr>
     <form action="" method="post" enctype="multipart/form-data">
      <h2>Basic Info</h2>
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="LastName">Last Name</label>  
        <div class="col-md-4">
        <input id="LastName" name="lastname" type="text" placeholder="Input Last Name" class="form-control" required>
        </div>

        <label class="col-md-2 col-form-label" for="FirstName">First Name</label>  
        <div class="col-md-4">
        <input id="FirstName" name="firstname" type="text" placeholder="Input First Name" class="form-control" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="MiddleName">Middle Name</label>  
        <div class="col-md-4">
        <input id="MiddleName" name="middlename" type="text" placeholder="Input Middle Name" class="form-control" required>
        </div>

        <label class="col-md-2 col-form-label" for="NameExt">Name Extension</label>  
        <div class="col-md-1">
          <input id="NameExt" name="nameext" type="text" placeholder="Name Ext." class="form-control">
        </div>
        <label class="col-md-1 col-form-label" for="NameExt">Gender</label>  
        <div class="col-md-2">
          <select class="form-control" name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
      </div>

      <hr>
      <h2>Additional Info</h2>
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="BirthDay">Birthday</label>  
        <div class="col-md-2">
        <input id="BirthDay" name="birthday" type="date" class="form-control" min="1900-01-01" max="2019-12-31" required>
        </div>
        <label class="col-md-1 col-form-label" for="Address">Address</label>
        <div class="col-md-3">
         <input id="Address" name="Barangay" type="text" placeholder="Add Street and/or Barangay..." class="form-control">
        </div>
        <div class="col-md-2">         
         <select class="form-control" name="municipality" id="city" required></select>
        </div>
        <div class="col-md-2">        
         <select class="form-control" name="province" id="province" required></select>
        </div>
      </div>    
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="PhoneNum">Phone Number</label>  
        <div class="col-md-2">
        <input id="PhoneNum" name="phonenum" type="tel" pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}" placeholder="Add recent phone number..." class="form-control">
        <span class="help-block">Format: 09xx-xxx-xxxx</span>  
        </div>

        <label class="col-md-1 col-form-label" for="Email">Email</label>  
        <div class="col-md-2">
        <input id="Email" name="email" type="email" placeholder="Add a valid email addresss" class="form-control">
        </div>

      <!-- File Button --> 

        <label class="col-md-2 col-form-label" for="photoupload">Upload Photo</label>
        <div class="col-md-2">
          <input id="photoupload" name="photoupload" class="input-file" type="file" accept="file_extension/.gif, .jpg, .png, image/*">
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
        <input type="submit" name="submit" value="Register Student" class="btn btn-primary" />&nbsp;
        <a class="btn btn-secondary"href="view-registered-students.php">Cancel</a>
        </div>
      </div>
    </form>
    <?php

      if (isset($_POST['submit'])) {

        // File upload path, for uploading image
        $filename = $_FILES["photoupload"]["name"];
        $targetdir = "uploads/".$filename;
        $targetfilepath = $targetdir . $filename;
        $filetype = pathinfo($targetfilepath,PATHINFO_EXTENSION);
        // get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        // get the file size
        $filesize = $_FILES['photoupload']['size'];

        $lastname = mysql_prep($_POST["lastname"]);
        $firstname = mysql_prep($_POST["firstname"]);
        $middlename = mysql_prep($_POST["middlename"]);
        $nameext = mysql_prep($_POST["nameext"]);
        $gender = mysql_prep($_POST["gender"]);
        $birthday = $_POST["birthday"];        
        $Barangay = mysql_prep($_POST["Barangay"]);
        $municipality = mysql_prep($_POST["municipality"]);
        $province = mysql_prep($_POST["province"]);
        $phonenum = mysql_prep($_POST["phonenum"]);
        $email = mysql_prep($_POST["email"]);

        if (!isset($lastname) || !isset($firstname) || !isset($middlename) || !isset($birthday) || !isset($municipality) ||  !isset($province) || !isset($filename) || $lastname == "" || $firstname == "" || $middlename == "" || $birthday == "" || $municipality == "" || $province == "") {
            die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
        }
        else{
          //Sets of validation function for the file upload


        
          // if (file_exists($targetdir))//this one checks if the file already exists on the /uploads folder
          // { 
          //   echo "<script type='text/javascript'>";
          //   echo "confirm('The file ".$filename." already exists! Would you like to overwrite the existing file?')";
          //   echo "</script>";
          // } 

          // // elseif ($filesize > 100000) {
          // //   echo "<div class=\"alert alert-warning\">";
          // //   echo "ERROR"."<br>"."File must be less than 1MB"."<br>"."File should be in jpg or png or gif format";
          // //   echo "</div>";
          // // }
          // // elseif (!in_array($extension, ['jpg','png','gif'])){
          // //   echo "<div class=\"alert alert-warning\">";
          // //   echo "ERROR"."<br>"."File extension must be .jpg, .png or .gif";
          // //   echo "</div>";
          // //   }
          // else{

            // Upload file to server
            move_uploaded_file($_FILES["photoupload"]["tmp_name"], $targetdir);
          // }



          if ($filename == "" || $filename == null) {
          $filename = "default.jpg";
          }
        
            $query   = "INSERT INTO students_reg (last_name, first_name, middle_name, name_ext, gender, birth_date, Barangay, municipality, province, phone_number, email, photo_url) VALUES ('{$lastname}', '{$firstname}', '{$middlename}', '{$nameext}', '{$gender}', '{$birthday}', '{$Barangay}', '{$municipality}', '{$province}', '{$phonenum}', '{$email}', '{$filename}')";
            $result = mysqli_query($connection, $query);

            if ($result === TRUE) {
            //special query to get the last inserted row for student registration table

            $query_get_last_id   = "SELECT stud_reg_id FROM students_reg ORDER BY stud_reg_id DESC LIMIT 1";
            $result_get_last_id = mysqli_query($connection, $query_get_last_id);
            while($row_get_last_id = mysqli_fetch_assoc($result_get_last_id))
            {
              $stud_reg_id = $row_get_last_id['stud_reg_id'];
            }

              $redirect_url = "registration-successful.php?success=1&stud_reg_id=".urlencode($stud_reg_id);
              redirect_to($redirect_url);
            } else {
              echo "Error updating+ record: " . $connection->error;
            }

            if(isset($connection)){ mysqli_close($connection); }



      }
    }

  ?>
  </div>
 </div> 
  <!-- /#wrapper -->



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>

<script src="static/city.js"></script> 

<script>  
window.onload = function() {  

  // ---------------
  // basic usage
  // ---------------
  var $ = new City();
  $.showProvinces("#province");
  $.showCities("#city");

  // ------------------
  // additional methods 
  // -------------------

  // will return all provinces 
  console.log($.getProvinces());
  
  // will return all cities 
  console.log($.getAllCities());
  
  // will return all cities under specific province (e.g Batangas)
  console.log($.getCities("Batangas")); 
  
}
</script>