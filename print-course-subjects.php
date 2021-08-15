<?php
 require_once("includes/session.php");
 require_once("includes/functions.php");
 require_once("includes/db_connection.php");

  if (isset($_GET['course_id'])) {
      $course_id = $_GET["course_id"];
      $school_yr = return_current_sy($connection,"");

      $query  = "SELECT * FROM courses WHERE course_id ='".$course_id."'";
      $result = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($result))
      {
        $course_desc = $row['course_desc'];
      }

    }
  else{
    redirect_to("new-group-schedule.php");
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="static/custom.css">
</head>
<body>
<div class="container-fluid">
  <div class="row" id="print-courses-subject">
    <div class="col-md-12">
      <?php

        $query  = "SELECT * FROM site_settings LIMIT 1";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($result))
        {
          $school_name = $row['school_name'];
          $school_address = $row['school_address'];
          $phone_number = $row['phone_number'];
          $site_logo = $row['site_logo'];
        }
        ?>
        <div style="text-align: center;" class="justify-content-center">
              <img width="100" class="site-logo" src="uploads/<?php echo  $site_logo." " ?>">
          <h2><?php echo $school_name ?></h2> 
          <address>
            <p><strong>Main Campus</strong><br /><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $school_address; ?><br>
            <i class="fa fa-phone" aria-hidden="true"></i><?php echo $phone_number; ?></p>
          </address>
          <p><strong>Date Processed: </strong><?php echo date("m/d/Y"); ?></p>
          <p><?php echo "SY".return_current_sy($connection,"").", ".return_current_term($connection,""); ?></p>
        </div>          
        <table class="table table-hover">
          <tbody>
            <tr>
              <td>Course:</td>
              <td><?php echo $course_desc; ?></td>
            </tr>
            <tr>
              <td>Course Code:</td>
              <td><?php echo get_course_code($course_id,"",$connection); ?></td>
            </tr>
            <tr>
              <td>S.Y:</td>
              <td>
              <?php
                echo $school_yr;
              ?>
              </td>
            </tr>
          </tbody>
        </table>

        <h4 class="mt-3">First Year</h4>
        <h5 class="mt-3">First Semester</h5> 
          <table class="table table-hover">
            <thead>
              <tr role="row">
                <th width="25%">Subject Code</th>
                <th width="25%">Subject Name</th>
                <th width="10%">Lecture Units</th>
                <th width="10%">Lab Units</th>
                <th width="10%">Total Units</th>
                <th width="20%">Prerequisite</th>
              </tr>
            </thead>
            <tbody>
              <?php

                $query  = "SELECT * FROM course_subjects WHERE course_id ='".$course_id."' AND year='1st Year' AND term ='1st Semester'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) < 1) {
                echo "<tr>";
                echo "<td>No Data</td>";
                echo "</tr>";    
                }

                else{
                  while($row = mysqli_fetch_assoc($result))
                    {
                      $array_units = array();
                      $array_units = get_subject_unit_count($row['subject_id'],"",$connection);
                    echo "<tr>";
                    echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".$array_units[0]."</td>";
                    echo "<td>".$array_units[1]."</td>";
                    echo "<td>".$array_units[2]."</td>";
                    echo "<td>".get_subject_code(get_prerequisite_id($row['subject_id'],"",$connection),"",$connection)."</td>";
                    echo "</tr>";
                    }     
                }



              ?>
            </tbody>
          </table>

        <h5 class="mt-5">Second Semester</h5> 
          <table class="table table-hover">
            <thead>
              <tr role="row">
                <th width="25%">Subject Code</th>
                <th width="25%">Subject Name</th>
                <th width="10%">Lecture Units</th>
                <th width="10%">Lab Units</th>
                <th width="10%">Total Units</th>
                <th width="20%">Prerequisite</th>
              </tr>
            </thead>
            <tbody>
              <?php

                $query  = "SELECT * FROM course_subjects WHERE course_id ='".$course_id."' AND year='1st Year' AND term ='2nd Semester'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) < 1) {
                echo "<tr>";
                echo "<td>No Data</td>";
                echo "</tr>";    
                }

                else{
                  while($row = mysqli_fetch_assoc($result))
                    {
                      $array_units = array();
                      $array_units = get_subject_unit_count($row['subject_id'],"",$connection);
                    echo "<tr>";
                    echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".$array_units[0]."</td>";
                    echo "<td>".$array_units[1]."</td>";
                    echo "<td>".$array_units[2]."</td>";
                    echo "<td>".get_subject_code(get_prerequisite_id($row['subject_id'],"",$connection),"",$connection)."</td>";
                    echo "</tr>";
                    }     
                }

              ?>
            </tbody>
          </table>

        <h4 class="mt-5">Second Year</h4> 
        <h5 class="mt-3">First Semester</h5>
          <table class="table table-hover">
            <thead>
              <tr role="row">
                <th width="25%">Subject Code</th>
                <th width="25%">Subject Name</th>
                <th width="10%">Lecture Units</th>
                <th width="10%">Lab Units</th>
                <th width="10%">Total Units</th>
                <th width="20%">Prerequisite</th>
              </tr>
            </thead>
            <tbody>
              <?php

                $query  = "SELECT * FROM course_subjects WHERE course_id ='".$course_id."' AND year='2nd Year' AND term ='1st Semester'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) < 1) {
                echo "<tr>";
                echo "<td>No Data</td>";
                echo "</tr>";    
                }

                else{
                  while($row = mysqli_fetch_assoc($result))
                    {
                      $array_units = array();
                      $array_units = get_subject_unit_count($row['subject_id'],"",$connection);
                    echo "<tr>";
                    echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".$array_units[0]."</td>";
                    echo "<td>".$array_units[1]."</td>";
                    echo "<td>".$array_units[2]."</td>";
                    echo "<td>".get_subject_code(get_prerequisite_id($row['subject_id'],"",$connection),"",$connection)."</td>";
                    echo "</tr>";
                    }     
                }

              ?>
            </tbody>
          </table>

        <h5 class="mt-5">Second Semester</h5>
          <table class="table table-hover">
            <thead>
              <tr role="row">
                <th width="25%">Subject Code</th>
                <th width="25%">Subject Name</th>
                <th width="10%">Lecture Units</th>
                <th width="10%">Lab Units</th>
                <th width="10%">Total Units</th>
                <th width="20%">Prerequisite</th>
              </tr>
            </thead>
            <tbody>
              <?php

                $query  = "SELECT * FROM course_subjects WHERE course_id ='".$course_id."' AND year='2nd Year' AND term ='second Semester'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) < 1) {
                echo "<tr>";
                echo "<td>No Data</td>";
                echo "</tr>";    
                }

                else{
                  while($row = mysqli_fetch_assoc($result))
                    {
                      $array_units = array();
                      $array_units = get_subject_unit_count($row['subject_id'],"",$connection);
                    echo "<tr>";
                    echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".$array_units[0]."</td>";
                    echo "<td>".$array_units[1]."</td>";
                    echo "<td>".$array_units[2]."</td>";
                    echo "<td>".get_subject_code(get_prerequisite_id($row['subject_id'],"",$connection),"",$connection)."</td>";
                    echo "</tr>";
                    }     
                }

              ?>
            </tbody>
          </table>
        <h4 class="mt-5">Third Year</h4> 
        <h5 class="mt-3">First Semester</h5>
          <table class="table table-hover">
            <thead>
              <tr role="row">
                <th width="25%">Subject Code</th>
                <th width="25%">Subject Name</th>
                <th width="10%">Lecture Units</th>
                <th width="10%">Lab Units</th>
                <th width="10%">Total Units</th>
                <th width="20%">Prerequisite</th>
              </tr>
            </thead>
            <tbody>
              <?php

                $query  = "SELECT * FROM course_subjects WHERE course_id ='".$course_id."' AND year='3rd Year' AND term='1st Semester'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) < 1) {
                echo "<tr>";
                echo "<td>No Data</td>";
                echo "</tr>";    
                }

                else{
                  while($row = mysqli_fetch_assoc($result))
                    {
                      $array_units = array();
                      $array_units = get_subject_unit_count($row['subject_id'],"",$connection);
                    echo "<tr>";
                    echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".$array_units[0]."</td>";
                    echo "<td>".$array_units[1]."</td>";
                    echo "<td>".$array_units[2]."</td>";
                    echo "<td>".get_subject_code(get_prerequisite_id($row['subject_id'],"",$connection),"",$connection)."</td>";
                    echo "</tr>";
                    }     
                }

              ?>
            </tbody>
          </table>

        <h5 class="mt-5">Second Semester</h5>
          <table class="table table-hover">
            <thead>
              <tr role="row">
                <th width="25%">Subject Code</th>
                <th width="25%">Subject Name</th>
                <th width="10%">Lecture Units</th>
                <th width="10%">Lab Units</th>
                <th width="10%">Total Units</th>
                <th width="20%">Prerequisite</th>
              </tr>
            </thead>
            <tbody>
              <?php

                $query  = "SELECT * FROM course_subjects WHERE course_id ='".$course_id."' AND year='3rd Year' AND term='2nd Semester'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) < 1) {
                echo "<tr>";
                echo "<td>No Data</td>";
                echo "</tr>";    
                }

                else{
                  while($row = mysqli_fetch_assoc($result))
                    {
                      $array_units = array();
                      $array_units = get_subject_unit_count($row['subject_id'],"",$connection);
                    echo "<tr>";
                    echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".$array_units[0]."</td>";
                    echo "<td>".$array_units[1]."</td>";
                    echo "<td>".$array_units[2]."</td>";
                    echo "<td>".get_subject_code(get_prerequisite_id($row['subject_id'],"",$connection),"",$connection)."</td>";
                    echo "</tr>";
                    }     
                }

              ?>
            </tbody>
          </table>

        <h4 class="mt-5">Fourth Year</h4> 
        <h5 class="mt-3">First Semester</h5>
          <table class="table table-hover">
            <thead>
              <tr role="row">
                <th width="25%">Subject Code</th>
                <th width="25%">Subject Name</th>
                <th width="10%">Lecture Units</th>
                <th width="10%">Lab Units</th>
                <th width="10%">Total Units</th>
                <th width="20%">Prerequisite</th>
              </tr>
            </thead>
            <tbody>
              <?php

                $query  = "SELECT * FROM course_subjects WHERE course_id ='".$course_id."' AND year='4th Year' AND term='1st Semester'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) < 1) {
                echo "<tr>";
                echo "<td>No Data</td>";
                echo "</tr>";    
                }

                else{
                  while($row = mysqli_fetch_assoc($result))
                    {
                      $array_units = array();
                      $array_units = get_subject_unit_count($row['subject_id'],"",$connection);
                    echo "<tr>";
                    echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".$array_units[0]."</td>";
                    echo "<td>".$array_units[1]."</td>";
                    echo "<td>".$array_units[2]."</td>";
                    echo "<td>".get_subject_code(get_prerequisite_id($row['subject_id'],"",$connection),"",$connection)."</td>";
                    echo "</tr>";
                    }     
                }

              ?>
            </tbody>
          </table>

        <h5 class="mt-5">Second Semester</h5>
          <table class="table table-hover">
            <thead>
              <tr role="row">
                <th width="25%">Subject Code</th>
                <th width="25%">Subject Name</th>
                <th width="10%">Lecture Units</th>
                <th width="10%">Lab Units</th>
                <th width="10%">Total Units</th>
                <th width="20%">Prerequisite</th>
              </tr>
            </thead>
            <tbody>
              <?php

                $query  = "SELECT * FROM course_subjects WHERE course_id ='".$course_id."' AND year='4th Year' AND term='2nd Semester'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) < 1) {
                echo "<tr>";
                echo "<td>No Data</td>";
                echo "</tr>";    
                }

                else{
                  while($row = mysqli_fetch_assoc($result))
                    {
                      $array_units = array();
                      $array_units = get_subject_unit_count($row['subject_id'],"",$connection);
                    echo "<tr>";
                    echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
                    echo "<td>".$array_units[0]."</td>";
                    echo "<td>".$array_units[1]."</td>";
                    echo "<td>".$array_units[2]."</td>";
                    echo "<td>".get_subject_code(get_prerequisite_id($row['subject_id'],"",$connection),"",$connection)."</td>";
                    echo "</tr>";
                    }     
                }

              ?>
            </tbody>
          </table>
    <center>
      <button id="preview-print" class="btn btn-primary no-print"><i class="fa fa-print" aria-hidden="true"></i></i></i> Print Course Subjects</button>
    </center><br>
  </div>
</div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
  
  $('#preview-print').click(function () {
    window.print("print-courses-subject");
  });

</script>