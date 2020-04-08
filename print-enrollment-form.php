<?php
 require_once("includes/session.php");
 require_once("includes/functions.php");
 require_once("includes/db_connection.php");

  if (isset($_GET["student_id"]) ) {
    $student_id = urldecode($_GET["student_id"]);
  }
  if (!isset($_GET["student_id"]) || $_GET["student_id"] == "") {
    redirect_to("students.php");
  }

      $query_student_reg_id = "SELECT * FROM enrollment WHERE student_id=".$student_id;
      $result_student_reg_id = mysqli_query($connection, $query_student_reg_id);

      while($row_student_reg_id = mysqli_fetch_assoc($result_student_reg_id))
    	 {
    	  $student_reg_id = $row_student_reg_id['stud_reg_id'];
    	  $student_number = $row_student_reg_id['student_number'];
    	  $course_id = $row_student_reg_id['course_id'];
    	  $school_yr = $row_student_reg_id['school_yr'];
    	  $year = $row_student_reg_id['year'];
    	  $term = $row_student_reg_id['term'];
    	 }

	$student_name = get_student_name($student_reg_id,$connection);

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
	<div class="row" id="print-enrollment-form">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4">

    <?php

      $query  = "SELECT * FROM site_settings LIMIT 1";
      $result = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($result))
      {
        $school_name = $row['school_name'];
        $school_address = $row['school_address'];
        $phone_number = $row['phone_number'];
      }
      ?>
					<h2><?php echo $school_name ?></h2> 
					<address>
						<p><strong>Main Campus</strong><br /><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $school_address; ?><br>
						<i class="fa fa-phone" aria-hidden="true"></i><abbr title="Phone"></abbr> <?php echo $phone_number; ?></p>
					</address>
					<h4>Form Processed by:</h4>
					<p>Registrar Name</p>
					<p><strong>Date Processed: </strong><?php echo date("m/d/Y"); ?></p>
					<div class="alert alert-info" role="alert">
					 This form is not valid as an official receipt.
					</div>
				</div>
				<div class="col-md-8">
					<h1>Enrollment Certificate</h1>
					<hr>
					<h2>Student Info</h2> 
					<table class="table table-hover">
						<tbody>
							<tr>
								<td>Student Name:</td>
								<td><?php echo $student_name; ?></td>
							</tr>
							<tr>
								<td>Student Number:</td>
								<td><?php echo $student_number;?></td>
							</tr>
							<tr>
								<td>Course:</td>
								<td>
								<?php
									echo get_course_code($course_id,"",$connection);
								?>

								</td>
							</tr>
							<tr>
								<td>Year:</td>
								<td><?php echo $year;?></td>
							</tr>
							<tr>
								<td>Term:</td>
								<td><?php echo $term;?></td>
							</tr>
							<tr>
								<td>School Year:</td>
								<td><?php echo $school_yr;?></td>
							</tr>
						</tbody>
					</table>
					<h3>Course Subjects</h3>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Subject Code</th>
								<th>Description</th>
								<th>Units</th>
							</tr>
						</thead>
						<tbody>

							<?php
								$unit_count = 0;
								$query = "SELECT * FROM course_subjects WHERE course_id='".$course_id."' AND term='".$term."' AND year='".$year."' AND school_yr='".$school_yr."'";
						        $result = mysqli_query($connection, $query);
						        while($row = mysqli_fetch_assoc($result))
						        {
						        echo "<tr>";			        
								echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
								echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
								echo "<td>".get_subject_unit_count($row['subject_id'],"",$connection)."</td>";
								echo "</tr>";

								$unit_count = $unit_count + get_subject_unit_count($row['subject_id'],"",$connection);
						        }


							?>
						</tbody>
						<tfoot>
							<tr class="table-active">
							  <td>&nbsp;</td>
						      <td>Total Units</td>
						      <td><?php echo $unit_count; ?></td>
						    </tr>
						</tfoot>
					</table>
				</div>
			</div>
		    <center>
		      <button id="preview-print" class="btn btn-primary no-print"><i class="fa fa-print" aria-hidden="true"></i></i></i> Print Enrollment Certificate</button>
		    </center><br>
		</div>
	</div>
</div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
  
  $('#preview-print').click(function () {
    window.print("print-enrollment-form");
  });

</script>