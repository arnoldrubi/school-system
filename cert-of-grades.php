<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>



<?php

  $query = "SELECT * FROM site_settings";

  $result = mysqli_query($connection, $query);
  while($row = mysqli_fetch_assoc($result))
        {    
         $school_name = $row['school_name'];
         $site_logo = $row['site_logo'];
         $school_address = $row['school_address'];
         $phone_number = $row['phone_number'];
        }

//Validation, making sure all required fields are entered

if (!isset($graduated) && !isset($student_number) && !isset($_POST["submit"])) {
	redirect_to("request-certificate-of-grades.php");
}
else{
	if (isset($_POST["submit"])) {
	    $student_number = mysql_prep($_POST["student_number"]);
	    $graduated = $_POST["graduated"];
	    //Requester's name
		$requesters_name =  $_POST["firstname"]." ".substr($_POST["middlename"], 0, 1).". ".$_POST["lastname"]." ".$_POST["nameext"];


		//Set the status of the student
		$student_graduate = "";

		if ($graduated == 1) {
			$student_graduate = "Graduate";
		}
		else{
			$student_graduate = "Student";
		}

	    $query   = "SELECT * FROM enrollment WHERE student_number='".$student_number."' LIMIT 1";
	    $result = mysqli_query($connection, $query);

	   while($row = mysqli_fetch_assoc($result))
	        {    
	         $stud_reg_id = $row['stud_reg_id'];
	        }

	   $query_student_name = "SELECT * FROM students_reg WHERE stud_reg_id=".$stud_reg_id;
	   $result_student_name = mysqli_query($connection, $query_student_name);
	   while($row_student_name = mysqli_fetch_assoc($result_student_name))
	    {
	     $student_name = $row_student_name['last_name'].", ".$row_student_name['first_name'].", ".substr($row_student_name['middle_name'], 0,1.).".";
	    }
	}
}
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4" style="text-align: center;">
					<?php echo "<img src=\""."uploads/".$site_logo."\" width=\"200\" height=\"200\" />"; ?>
				</div>
				<div class="col-md-8">
					<h1>
					 <?php echo $school_name; ?>
					</h1> 
					<address>

						 <strong>Address:</strong><br /> <?php echo $school_address; ?><br /> <abbr title="Phone">P: </abbr><?php echo $phone_number; ?>
					</address>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
							<?php

							$query_check_if_grades_exists = "SELECT * FROM student_grades WHERE stud_reg_id ='".$stud_reg_id."' AND grade_posted =1";
							$result_check_if_grades_exists = mysqli_query($connection, $query_check_if_grades_exists);

							if (mysqli_num_rows($result_check_if_grades_exists) < 1) {
								echo "No posted grades. Please contact the registar.";
							} 
							// end if for no grades found

							else{

								$query_distinct_term_sy_first = "SELECT DISTINCT term, school_yr FROM student_grades WHERE stud_reg_id ='".$stud_reg_id."' ORDER BY school_yr, term LIMIT 1" ;
								$result_distinct_term_sy_first = mysqli_query($connection, $query_distinct_term_sy_first);

								while($row_distinct_term_sy_first = mysqli_fetch_assoc($result_distinct_term_sy_first)){
									$first_term_and_sy = $row_distinct_term_sy_first["term"]." ".$row_distinct_term_sy_first["school_yr"];
								}

								$query_distinct_term_sy_last = "SELECT DISTINCT term, school_yr FROM student_grades WHERE stud_reg_id ='".$stud_reg_id."' ORDER BY school_yr, term DESC LIMIT 1" ;
								$result_distinct_term_sy_last = mysqli_query($connection, $query_distinct_term_sy_last);

								while($row_distinct_term_sy_last = mysqli_fetch_assoc($result_distinct_term_sy_last)){
									$last_term_and_sy = $row_distinct_term_sy_last["term"]." ".$row_distinct_term_sy_last["school_yr"];
								} 

								echo "<h2 class=\"text-center text-primary\">Certification Of Grades</h2>";
								echo "<p class=\"text-left\">TO WHOM IT MAY CONCERN:</p>";
								echo "<p>This is to certify that based on the records on file, <strong>".$student_name."</strong>, a ". $student_graduate.", took the following subjects and obtained the grades set opposite it, for ".$first_term_and_sy.", up to ".$last_term_and_sy." .</p>";
								echo "<div class=\"table-grades-container\">";

								$query_distinct_term_sy = "SELECT DISTINCT term, school_yr FROM student_grades WHERE stud_reg_id ='".$stud_reg_id."' ORDER BY school_yr, term" ;
								$result_distinct_term_sy = mysqli_query($connection, $query_distinct_term_sy);

								while($row_distinct_term_sy = mysqli_fetch_assoc($result_distinct_term_sy)){

									$term = $row_distinct_term_sy["term"];
									$school_yr = $row_distinct_term_sy["school_yr"];

									echo "<h5>".$term.", ".$school_yr."</h5>";
									echo "<table class=\"table table-bordered table-hover table-sm\"> <thead><tr><th width=\"20%\">Subject Code</th><th width=\"50%\">Subject Description</th><th width=\"15%\">Grade</th><th width=\"5%\">Lecture Units</th><th width=\"5%\">Lab Units</th><th width=\"5%\">Total Units</th></tr></thead><tbody>";

									$query_student_grades = "SELECT * FROM student_grades WHERE stud_reg_id ='".$stud_reg_id."' AND term ='".$term."' AND school_yr='".$school_yr."' AND grade_posted =1";
									$result_student_grades = mysqli_query($connection, $query_student_grades);
									  while($row_student_grades = mysqli_fetch_assoc($result_student_grades))
									        {
									         $units_array = get_subject_unit_count($row_student_grades['subject_id'],"",$connection);
									         echo "<tr>";
									         echo "<td>".get_subject_code($row_student_grades['subject_id'],"",$connection)."</td>";
									         echo "<td>".get_subject_name($row_student_grades['subject_id'],"",$connection)."</td>";
									         echo "<td>".$row_student_grades['final_grade']."</td>";
									         echo "<td>".$units_array[0]."</td>";
									         echo "<td>".$units_array[1]."</td>";
									         echo "<td>".$units_array[2]."</td>";
									         echo "</tr>";
									        }
									echo "</tbody></table></div>";								
								 }

								$query_student_credited_subjects = "SELECT * FROM transfer_of_credits WHERE stud_reg_id='".$stud_reg_id."'";
								$result_student_credited_subjects = mysqli_query($connection, $query_student_credited_subjects);

								if (mysqli_num_rows($result_student_credited_subjects) > 0) {
									echo "<h5>Credits</h5>";
									echo "<table class=\"table table-bordered table-hover table-sm\"> <thead><tr><th width=\"20%\">Subject Description</th><th width=\"30%\">Subject Name</th><th width=\"15%\">School</th><th width=\"15%\">Term Taken</th><th width=\"5%\">Year Taken</th><th width=\"5%\">Final Grade</th><th width=\"15%\">Equivalent Subject</th></tr></thead><tbody>";
									while($row_student_credited_subjects = mysqli_fetch_assoc($result_student_credited_subjects))
									{
										echo "<tr>";
										echo "<td>".$row_student_credited_subjects['subject_desc']."</td>";
										echo "<td>".$row_student_credited_subjects['subject_name']."</td>";
										echo "<td>".$row_student_credited_subjects['school_name']."</td>";
										echo "<td>".$row_student_credited_subjects['term_taken']."</td>";
										echo "<td>".$row_student_credited_subjects['year_taken']."</td>";
										echo "<td>".$row_student_credited_subjects['final_grade']."</td>";
										echo "<td>".get_subject_code($row_student_credited_subjects['equivalent_subject_id'],"",$connection)."</td>";
										echo "</tr>";
									}
									echo "</tbody></table>";	
								}


								 echo "<p>This certification is being issued to ".$requesters_name." for whatever purpose it may serve him best.</p>";
							 }
							 // End else of grades are found
							?>						
					</div>
			</div>
		</div>
	</div>
    <center>
      <button id="preview-print" class="btn btn-primary no-print"><i class="fa fa-print" aria-hidden="true"></i></i></i> Print Certificate</button>
    </center><br>
</div>

<div style="display: none;">
	<?php include 'layout/footer.php';?>
</div>
<script type="text/javascript">
  $('#preview-print').click(function () {
    window.print("cert-of-grades");
  });
</script>