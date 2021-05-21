<?php
 require_once("includes/session.php");
 require_once("includes/functions.php");
 require_once("includes/db_connection.php");

  if (isset($_GET["student_reg_id"]) ) {
    $student_reg_id = urldecode($_GET["student_reg_id"]);
    $irregular_student = urldecode($_GET["irregular"]);
  }
  if (!isset($_GET["student_reg_id"]) || $_GET["student_reg_id"] == "") {
    redirect_to("students.php");
  }

      $query_student_reg_id = "SELECT * FROM enrollment WHERE stud_reg_id='".$student_reg_id."'";
      $result_student_reg_id = mysqli_query($connection, $query_student_reg_id);

      while($row_student_reg_id = mysqli_fetch_assoc($result_student_reg_id))
    	 {
    	  $student_reg_id = $row_student_reg_id['stud_reg_id'];
    	  $student_number = $row_student_reg_id['student_number'];
    	  $course_id = $row_student_reg_id['course_id'];
    	  $school_yr = $row_student_reg_id['school_yr'];
    	  $year = $row_student_reg_id['year'];
    	  $term = $row_student_reg_id['term'];
    	  $section = $row_student_reg_id['sec_id'];
    	  $irregular = $row_student_reg_id['irregular'];
    	 }

	$student_name = get_student_name($student_reg_id,$connection);

	if ($irregular == 0) {
		// create an array of all the class ID of the given section
		$query_get_class_ids = "SELECT * FROM classes WHERE sec_id ='".$section."'";
		$result_get_class_ids = mysqli_query($connection, $query_get_class_ids);

		$classes = array();

		while($row_get_class_ids = mysqli_fetch_assoc($result_get_class_ids))
    	 {
    	 	array_push($classes, $row_get_class_ids['class_id']);
    	 }
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
	<div class="row" id="print-enrollment-form">
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
				<h3>Enrollment Certificate</h3>
				<p><?php echo "SY".return_current_sy($connection,"").", ".return_current_term($connection,""); ?></p>
			</div>					
					<hr>
					<h4>Student Info</h4> 
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
						</tbody>
					</table>
					<h4>Course Subjects</h4>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Subject Code</th>
								<th>Description</th>
								<th width="3%">Lecture Units</th>
								<th width="3%">Lab Units</th>
								<th width="3%">Total Units</th>
								<th>Time</th>
								<th>Day(s)</th>
								<th>Room</th>
								<th>Teacher</th>
							</tr>
						</thead>
						<tbody>

							<?php
								$unit_count = 0;
							if ($irregular_student == 1) {

							 	$query = "SELECT * FROM irreg_manual_sched WHERE stud_reg_id='".$student_reg_id."'";
							 	$result = mysqli_query($connection, $query);
							}
							else{
								$query = "SELECT * FROM course_subjects WHERE course_id='".$course_id."' AND term='".$term."' AND year='".$year."' AND school_yr='".$school_yr."'";
						    }

						        

								$result = mysqli_query($connection, $query);
						        while($row = mysqli_fetch_assoc($result))
						        {
						        	$note_on_credit = "";

							        $check_if_subject_is_credited = is_subject_credited($row['subject_id'],$student_reg_id,"",$connection);
							        if ($check_if_subject_is_credited == TRUE) {
							        	$note_on_credit = "<br>(Unit is credited ***)";
							        }



							        $units_array = get_subject_unit_count($row['subject_id'],"",$connection);
							        // for schedule data, set up variables
							        $time = NULL;
							        $day = NULL;
							        $room = NULL;
							        $teacher = NULL;
							        
							        echo "<tr>";			        
									echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
									echo "<td>".get_subject_name($row['subject_id'],"",$connection)." ".$note_on_credit."</td>";
									echo "<td>".$units_array[0]."</td>";
									echo "<td>".$units_array[1]."</td>";
									echo "<td>".$units_array[2]."</td>";

									for ($i=0; $i < count($classes) ; $i++) { 

										$schedule_id = find_schedule_data($row['subject_id'],$classes[$i],$connection,"");
										if ($schedule_id !== NULL) {

											$query_get_schedule_data = "SELECT * FROM schedule_block WHERE schedule_id in(".$schedule_id.") ORDER BY day ASC, time_start ASC";
											$result_get_schedule_data = mysqli_query($connection, $query_get_schedule_data);

											while($row_get_schedule_data = mysqli_fetch_assoc($result_get_schedule_data))
											{
												$time =  date("g:i A", strtotime($row_get_schedule_data['time_start']))."-".date("g:i A", strtotime($row_get_schedule_data['time_end']));
												$day = number_to_day($row_get_schedule_data['day']);
												$room = $row_get_schedule_data['room'];
												$teacher = get_teacher_name($row_get_schedule_data['teacher_id'],"",$connection);
											}

										}
									}

									echo "<td>".$time."</td>";
									echo "<td>".$day."</td>";
									echo "<td>".$room."</td>";
									echo "<td>".$teacher."</td>";
									echo "</tr>";

									$unit_count += $units_array[2];

						     }

							?>
						</tbody>
						<tfoot>
							<tr class="table-active">
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
						      <td>Grand Total Units</td>
						      <td><?php echo $unit_count; ?></td>
						      <td>&nbsp;</td>
						      <td>&nbsp;</td>
						      <td>&nbsp;</td>
						      <td>&nbsp;</td>
						    </tr>
						</tfoot>
					</table>
			<h5>Form Processed by:</h5>
			<p><?php echo ucwords($_SESSION["username"]); ?></p>
		    <center>
		      <button id="preview-print" class="btn btn-primary no-print"><i class="fa fa-print" aria-hidden="true"></i></i></i> Print Enrollment Certificate</button>
		    </center><br>
			<div class="alert alert-info" role="alert">
				This form is not valid as an official receipt.
			</div>
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