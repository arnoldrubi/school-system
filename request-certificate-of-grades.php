<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Request for Certificate of Grades</title>
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
     <form action="cert-of-grades.php" method="post">
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
        <input id="student-number" value="" name="student_number"  placeholder="Example: 2019-BSCRIM001"  required  class="form-control">
        </div>

        <label class="col-md-2 col-form-label" for="Graduated">Did you graduate from your course?</label>  
        <div class="col-md-2">
          <div class="custom-control custom-radio">
            <input type="radio" id="customRadio1" required name="graduated" value="1" class="custom-control-input">
            <label class="custom-control-label" for="customRadio1">Yes</label>
          </div>
          <div class="custom-control custom-radio">
            <input type="radio" id="customRadio2" required name="graduated" value="0" class="custom-control-input">
            <label class="custom-control-label" for="customRadio2">No</label>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
        <input type="submit" name="submit" value="Process Request" class="btn btn-primary" />&nbsp;
        <a class="btn btn-secondary" href="registrar-services.php">Cancel</a>
        </div>
      </div>

    </form>
      <div class="form-group row">
        <div class="col-md-12">
          <p>Can't remember the Student Number? <br>
          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#student-info" aria-expanded="false" aria-controls="student-info">
            Try searching using his/her name. 
          </button>
          </p>
        </div>
     </div>
      <div class="form-group row collapse" id="student-info">
        <label class="col-md-2 col-form-label" for="Student_LastName">Input Student's Last Name</label>  
        <div class="col-md-10">
        <input id="StudentLastName" name="student_lastname" type="text" placeholder="Input Student's Last Name" class="form-control">
        </div>
        <label class="col-md-12 col-form-label" for="FirstName">OR </label>  
        <label class="col-md-2 col-form-label" for="FirstName">Input Student's First Name</label>  
        <div class="col-md-10">
        <input id="StudentFirstName" name="student_firstname" type="text" placeholder="Input Student's First Name" class="form-control">
        </div>
        <div class="col-md-12" id="student-list">
            
        </div>
      </div>
  </div>
 </div> 
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include 'layout/footer.php';?>


  <script>
  $(document).ready(function() {
    $("#StudentLastName").keyup(function(){
      var StudentLastName = $("#StudentLastName").val();
      //run ajax
      $.post("scan_student_name.php",
        {StudentLastName: StudentLastName}
        ,function(data,status){
        $("#student-list").html(data);
      });
    });
    $("#StudentFirstName").keyup(function(){
      var StudentFirstName = $("#StudentFirstName").val();
      //run ajax
      $.post("scan_student_name.php",{
        StudentFirstName: StudentFirstName
      },function(data,status){
        $("#student-list").html(data);
      });
    });
  });
  </script>