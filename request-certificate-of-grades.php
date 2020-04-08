<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Register New Student</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
         <a href="registrar-services.php">Registrar Services</a>
        </li>
        <li class="breadcrumb-item active">
         Certificate of Grades Request Form
        </li>
      </ol>
      <h1>Certificate of Grades Request</h1>
      <hr>
     <form action="" method="post" enctype="multipart/form-data">
      <h2>Requester's Information</h2>
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
      </div>

      <hr>
      <h2>Academic Info</h2>   
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="Student Number">Student Number</label>  
        <div class="col-md-2">
        <input id="PhoneNum" name="student_number"  placeholder="Example: 2019-BSCRIM001"  class="form-control">
        </div>

        <label class="col-md-1 col-form-label" for="Course">Course</label>  
        <div class="col-md-2">
        <input id="Course" name="course" placeholder="Example: BSCRIM" class="form-control">
        </div>

        <label class="col-md-2 col-form-label" for="Graduated">Did you graduate from your course?</label>  
        <div class="col-md-2">
          <div class="custom-control custom-radio">
            <input type="radio" id="customRadio1" name="graduated" value="1" class="custom-control-input">
            <label class="custom-control-label" for="customRadio1">Yes</label>
          </div>
          <div class="custom-control custom-radio">
            <input type="radio" id="customRadio2" name="graduated" value="0" class="custom-control-input">
            <label class="custom-control-label" for="customRadio2">No</label>
          </div>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="School Year">School Year Began</label>  
        <div class="col-md-2">
        <input id="PhoneNum" name="sy"  placeholder="2019-2020"  class="form-control">
        </div>

        <label class="col-md-1 col-form-label" for="term">Term Began</label>  
        <div class="col-md-2">
          <select class="form-control" id="term" name="term">
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
          </select>
        </div>

      </div>

      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
        <input type="submit" name="submit" value="Process Request" class="btn btn-primary" />&nbsp;
        <a class="btn btn-secondary" href="registrar-services.php">Cancel</a>
        </div>
      </div>
    </form>
    <?php

      if (isset($_POST['submit'])) {



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


