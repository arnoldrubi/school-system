<?php
 require_once("includes/session.php");
 require_once("includes/functions.php");
 require_once("includes/db_connection.php");

  if (isset($_GET['stud_reg_id'])) {
    $stud_reg_id = $_GET['stud_reg_id'];
  }
  else{
    redirect_to("view-teachers.php");
  }
?>

<div class="modal-header">
  <h3>Student Information</h3>
  <button type="button" class="close" data-dismiss="modal">X</button>
</div>
<div class="modal-body">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">
        <?php
        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

        $query  = "SELECT * FROM students_reg WHERE is_active = 1 AND stud_reg_id='".$stud_reg_id."'";
        $result = mysqli_query($connection, $query);

        $name = "";
        $address = "";
        $birthdate = "";
        $age = "";
        $contact_num = "";
        $email = "";
        $photo = $root."school-system/uploads/";

        while($row = mysqli_fetch_assoc($result))
        {
          $name = $row['first_name']." ".$row['middle_name']." ".$row['last_name']." ".$row['name_ext'];
          $photo .= $row['photo_url'];
          $birthdate = $row['birth_date'];
          $address = $row['barangay']." ".$row['municipality'].", ".$row['province'];
          $contact_num = $row['phone_number'];
          $email = $row['email'];
          $guardian_name = $row['guardian_name'];
          $guardian_phone_number = $row['guardian_phone_number'];
          $guardian_relationship = $row['guardian_relationship'];
        }
        ?>
        <div class="container-fluid">
          <div class="row text-left">
            <div class="col-sm-6 text-center">
              <img <?php echo "src=\"".$photo."\""; ?>>
            </div>
            <div class="col-sm-6">
              <p>Student Name: <?php echo $name; ?> </p> 
              <p>Student Number: <?php echo get_student_number($stud_reg_id,$connection); ?> </p>
              <p>Birthdate: <?php echo date("M-d-Y",strtotime($birthdate)); ?> </p>
              <p>Address: <?php echo $address; ?> </p>
              <p>Contact Number: <?php echo $contact_num; ?> </p>
              <p>Email: <?php echo "<a href=mailto:".$email.">".$email."</a>";?> </p>                    
            </div>
            <div class="col-sm-12">
              <h5>Other Info:</h5>
              <p>Guardian: <?php echo $guardian_name; ?> </p> 
              <p>Guardian's Contact Number: <?php echo $guardian_phone_number; ?> </p>
              <p>Relationship: <?php echo $guardian_relationship; ?> </p>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>

