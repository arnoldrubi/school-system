<!DOCTYPE html>
<html>
<head>
	<title>Certificate of Grades</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Google Fonts Roboto and Open Sans -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap" rel="stylesheet">
    <!-- Custom CSS to overide default CSS -->
    <link rel="stylesheet" type="text/css" href="/static/custom.css">

</head>
<body>



<?php require_once("includes/db_connection.php");
require_once("includes/functions.php");

  $query = "SELECT * FROM site_settings";

  $result = mysqli_query($connection, $query);
  while($row = mysqli_fetch_assoc($result))
        {    
         $school_name = $row['school_name'];
         $site_logo = $row['site_logo'];
         $school_address = $row['school_address'];
         $phone_number = $row['phone_number'];
        }

if (isset($_POST["submit"])) {
    $student_number = mysql_prep($_POST["student_number"]);
    $graduated = $_POST["graduated"];
}
//Set the status of the student
$student_graduate = "";

if ($graduated == 1) {
	$student_graduate = "Graduate";
}
else{
	$student_graduate = "Student";
}
//END
echo $student_number."<br>";
echo get_student_reg_id($student_number,$connection)."<br>";

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
					<h2 class="text-center text-primary">Certification Of Grades</h2>
					<p class="text-left">TO WHOM IT MAY CONCERN:</p>
					<p>This is to certify that based on the records on file, <strong><?php echo $student_name; ?></strong>, a <?php echo $student_graduate; ?>, took the following subjects and obtained the grades set opposite it, for First Semester, Data: First SY up to First Semester,  Data: Last SY.</p>
					<div class="table-grades-container">
						<h5>Data: Semester and School Year</h5>
						<table class="table table-bordered table-hover table-sm">
							<thead>
								<tr>
									<th>Subject Code</th>
									<th>Subject Description</th>
									<th>Grade</th>
									<th>Unit</th>
								</tr>
							</thead>
							<tbody>
							<!-- NEXT: Group Data Set by School Year and Semester, Separate table per SY and Term -->
							<?php 
								$query_student_grades = "SELECT * FROM student_grades WHERE stud_reg_id ='".$stud_reg_id."' ORDER BY school_yr AND term";
								$result_student_grades = mysqli_query($connection, $query_student_grades);
								  while($row_student_grades = mysqli_fetch_assoc($result_student_grades))
								        {
								         echo "<tr>";
								         echo "<td>".get_subject_code($row_student_grades['subject_id'],"",$connection)."</td>";
								         echo "<td>".get_subject_name($row_student_grades['subject_id'],"",$connection)."</td>";
								         echo "<td>".$row_student_grades['final_grade']."</td>";
								         echo "<td>".get_subject_unit_count($row_student_grades['subject_id'],"",$connection)."</td>";
								         echo "</tr>";
								        }
							?>
							</tbody>
						</table>
					</div>	

					<p>This certification is being issued to Data: Student Name (Surname Only) for whatever purpose it may serve him best.</p>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>