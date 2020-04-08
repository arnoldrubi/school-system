<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
      if (isset($_GET['stud_reg_id'])) {
          $stud_reg_id = $_GET["stud_reg_id"]; //Refactor this validation later
        }
        else{
          $stud_reg_id = NULL;
        }
        if ($stud_reg_id == NULL) {
          redirect_to("view-registered-students.php");
       }

?>

  <title>Edit Student Info</title>
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
          Edit Student Info
        </li>
      </ol>
      <h1>Edit Student Info Form</h1>
      <hr>
      <form action="" method="post" enctype="multipart/form-data">
        <h2>Basic Info</h2>
      <?php

        $query  = "SELECT * FROM students_reg WHERE stud_reg_id = '".$stud_reg_id."'";
        $result = mysqli_query($connection, $query);

        if ($result === !TRUE) {
              echo "<script type='text/javascript'>";
              echo "alert('No record exists!');";
              echo "</script>";

              $URL="view-subject.php";
              echo "<script>location.href='$URL'</script>";

        }

        while($row = mysqli_fetch_assoc($result))
          {

          echo "<div class=\"form-group row\">";
          echo "<label class=\"col-md-2 col-form-label\" for=\"LastName\">Last Name</label>"; 
          echo "<div class=\"col-md-4\">";
          echo "<input id=\"LastName\" name=\"lastname\" type=\"text\" value=\"".$row['last_name']. "\" class=\"form-control input-md\" required></div>";

          echo "<label class=\"col-md-2 col-form-label\" for=\"FirstName\">First Name</label>"; 
          echo "<div class=\"col-md-4\">";
          echo "<input id=\"FirstName\" name=\"firstname\" type=\"text\" value=\"".$row['first_name']. "\" class=\"form-control input-md\" required></div></div>";

          echo "<div class=\"form-group row\">";
          echo "<label class=\"col-md-2 col-form-label\" for=\"MiddleName\">Middle Name</label>"; 
          echo "<div class=\"col-md-4\">";
          echo "<input id=\"MiddleName\" name=\"middlename\" type=\"text\" value=\"".$row['middle_name']. "\" class=\"form-control input-md\" required></div>";

          echo "<label class=\"col-md-2 col-form-label\" for=\"NameExt\">Name Extension</label>"; 
          echo "<div class=\"col-md-1\">";
          echo "<input id=\"NameExt\" placeholder=\"Name Ext.\" name=\"nameext\" type=\"text\" value=\"".$row['name_ext']. "\" class=\"form-control input-md\">";
          echo "</div><label class=\"col-md-1 col-form-label\" for=\"NameExt\">Gender</label>  ";
          echo "<div class=\"col-md-2\">";
          echo "<select class=\"form-control\" name=\"gender\">";
          echo "<option value=\"Male\">Male</option>";
          echo " <option value=\"Female\">Female</option></select></div></div>";

          echo "<hr><h2>Additional Info</h2>";

          echo "<div class=\"form-group row\">";
          echo "<label class=\"col-md-2 col-form-label\" for=\"BirthDay\">Birthday</label>"; 
          echo "<div class=\"col-md-2\">";
          echo "<input id=\"BirthDay\" name=\"birthday\" type=\"date\" min=\"1900-01-01\" max=\"2019-12-31\" value=\"".$row['birth_date']. "\" class=\"form-control input-md\" required></div>";
          echo "<label class=\"col-md-1 col-form-label\" for=\"Address\">Address</label>"; 
          echo "<div class=\"col-md-3\">";
          echo "<input id=\"Address\" name=\"Barangay\" type=\"text\" placeholder=\"Add Street and/or Barangay...\" class=\"form-control\" value=\"".$row['barangay']."\"></div>";
          echo "<div class=\"col-md-2\">";
          echo "<select class=\"form-control\" name=\"city\" id=\"city\" required></select></div>";
          echo "<input id=\"current_city\" name=\"municipality\" style=\"display: none;\" type=\"text\" placeholder=\"City/Municipality...\" class=\"form-control\" value=\"".$row['municipality']."\" required>";
          echo "<div class=\"col-md-2\">";
          echo "<select class=\"form-control\" name=\"province\" id=\"province\" required></select></div>";
          echo "<input id=\"current_province\" type=\"text\" style=\"display: none;\" placeholder=\"Province...\" class=\"form-control\" value=\"".$row['province']."\" required>";
          echo "</div>";
          echo "<div class=\"form-group row\">";
          echo "<label class=\"col-md-2 col-form-label\" for=\"PhoneNum\">Phone Number</label>"; 
          echo "<div class=\"col-md-2\">";
          echo "<input id=\"PhoneNum\" name=\"phonenum\" type=\"tel\" pattern=\"[0-9]{4}-[0-9]{3}-[0-9]{4}\"  value=\"".$row['phone_number']. "\" class=\"form-control input-md\" >";
          echo "<span class=\"help-block\">Format: 09xx-xxx-xxxx</span></div>";

          echo "<label class=\"col-md-1 col-form-label\" for=\"Email\">Email</label>"; 
          echo "<div class=\"col-md-2\">";
          echo "<input id=\"Email\" name=\"email\" type=\"email\" value=\"".$row['email']. "\" class=\"form-control input-md\"></div>";

          //File Button -->
          $current_picture = "http://" . $_SERVER['SERVER_NAME']."/school-system/uploads/".$row['photo_url']; //I hardcoded the url of the site, this should be automatic, much better to use the SERVER_NAME then just hard code the /uploads path
          $old_filename = $row['photo_url'];
          echo "<label class=\"col-md-2 col-form-label\" for=\"photoupload\">Upload Photo</label>";
          echo "<div class=\"col-md-2\"><input id=\"photoupload\" name=\"photoupload\" class=\"input-file\" type=\"file\" accept=\"file_extension/.gif, .jpg, .png, image/*\"></div></div>";

          echo "<div class=\"form-group row\">";
          echo "<div class=\"offset-md-8 col-md-4\"><p>Current Photo:</p>";
          echo "<p style=\"text-align: center\"><img class=\"current-pic\" src=\"".$current_picture."\"></p>";
          echo "<div class=\"alert alert-primary\" role=\"alert\">Warning: Uploading a new file will replace the current photo.</div>";
          echo "</div></div>";
          }
  ?>
      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
        <input type="submit" name="submit" value="Update Student Info" class="btn btn-primary" />&nbsp;
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

    //Sets of validation function for the file upload

    if (!in_array($extension, ['jpg','png','gif']) && $filesize > 1000000) {
      echo "<div class=\"alert alert-warning\">";
      echo "ERROR"."<br>"."File must be less than 1MB"."<br>"."File should be in jpg or png or gif format";
      echo "</div>";
    }
    elseif (file_exists($targetdir) && $filename !== "")//this one checks if the file already exists on the /uploads folder
    { 
      echo "<div class=\"alert alert-warning\">";
      echo "The file ".$filename." already exists!"; //do you want to reuse this file? add validation
      echo "</div>";
    } 

    else{

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

      if (!isset($lastname) || !isset($firstname) || !isset($middlename) || !isset($birthday) ||  !isset($municipality) ||  !isset($province) || !isset($filename) || $lastname == "" || $firstname == "" || $middlename == "" || $birthday == "" || $municipality == "" || $province == "") {
        die ("<div class=\"alert alert-danger\" role=\"alert\">Error: One or more fields are empty.</div>");
      }
      else{
        
        if ($filename == "") { //logical check if user did not upload a new photo, it will use the current one. Run a query and will not update the photo_url column
          $query = "UPDATE students_reg SET last_name = '{$lastname}', first_name = '{$firstname}', middle_name = '{$middlename}', name_ext = '{$nameext}', gender = '{$gender}', birth_date = '{$birthday}', Barangay = '{$Barangay}', municipality = '{$municipality}', province = '{$province}', phone_number = '{$phonenum}', email = '{$email}' WHERE stud_reg_id = '{$stud_reg_id}' LIMIT 1"; 

        }
        //if user uploads a new photo, move that file to the uploads folder
        else{
          move_uploaded_file($_FILES["photoupload"]["tmp_name"], $targetdir); // Upload file to server
          $filename = mysql_prep($filename);
          $query = "UPDATE students_reg SET last_name = '{$lastname}', first_name = '{$firstname}', middle_name = '{$middlename}', name_ext = '{$nameext}', gender = '{$gender}', birth_date = '{$birthday}', Barangay = '{$Barangay}', municipality = '{$municipality}', province = '{$province}', phone_number = '{$phonenum}', email = '{$email}', photo_url = '{$filename}' WHERE stud_reg_id = '{$stud_reg_id}' LIMIT 1"; 

        }
      }


      $result = mysqli_query($connection, $query);


      if ($result === TRUE) {
        echo "<script type='text/javascript'>";
        echo "alert('Edit student info successful!');";
        echo "</script>";

        $URL="view-registered-students.php";
        echo "<script>location.href='$URL'</script>";
      } else {
        print_r($query);
        echo "Error updating record: " . $connection->error;
        }
      }
    }       //removed the redirect function and replaced it with javascript alert above
            //redirect_to("new-subject.php");

      ?>


  </div>
 </div> 
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>


<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>

<?php include 'layout/footer.php';?>


<script src="static/city.js"></script> 

<script>  
window.onload = function() {  

    var current_province = document.getElementById("current_province").value;

    var current_city = document.getElementById("current_city").value;


  // ---------------
  // basic usage
  // ---------------
  var $ = new City();
  $.showProvinces("#province");
  $.showCities(current_province,"#city");

  // ------------------
  // additional methods 
  // -------------------

///loop and find the matching value for province and city then, add selected value

  // will return all provinces 
  console.log($.getProvinces());
  
  // will return all cities 
  console.log($.getAllCities());
  
  // will return all cities under specific province (e.g Batangas)
  console.log($.getCities(current_province)); 

  function setSelectedIndex(s, v) {

    for ( var i = 0; i < s.options.length; i++ ) {

        if ( s.options[i].text == v ) {

            s.options[i].selected = true;

            return;

        }

    }

}

setSelectedIndex(document.getElementById('province'),current_province);
setSelectedIndex(document.getElementById('city'),current_city);
}

</script>

