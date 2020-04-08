<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php 

    $subject_id = $_GET["subject_id"];
    $term = $_GET["term"];
    $year = $_GET["year"];


  $query = "SELECT * FROM subjects WHERE subject_id ='".$subject_id."'";

  $result = mysqli_query($connection, $query);

  while($row = mysqli_fetch_assoc($result))
        {    
         $subject_name = $row['subject_name'];
         $subject_code = $row['subject_code'];
        }
?>

 <?php  
      //export.php  
 if(isset($_POST["export"]))  
 {  
      header("Content-Type: text/csv; charset=utf-8");  
      header("Content-Disposition: attachment; filename=".$subject_name."data.csv");  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('Student ID', 'Name', 'Prelim', 'Midterm', 'Semis', 'Finals', 'Final Grade','Remarks'));  
        $query = "SELECT student_grades.stud_reg_id, student_grades.prelim, student_grades.midterm, student_grades.semis, student_grades.finals, student_grades.final_grade,student_grades.remarks, students_reg.first_name, students_reg.middle_name, students_reg.last_name FROM student_grades INNER JOIN students_reg ON student_grades.stud_reg_id = students_reg.stud_reg_id WHERE student_grades.subject_id ='".$subject_id."'";

      $result = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?>  