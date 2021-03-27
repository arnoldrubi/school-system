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

    $query = "UPDATE students_reg SET is_active = 0 WHERE stud_reg_id = '{$stud_reg_id}' LIMIT 1"; 
    $result = mysqli_query($connection, $query);

    //delete first the grades, then enrollment, then student registration

    // $query  = "DELETE FROM student_grades WHERE stud_reg_id ='".$stud_reg_id."'";
    // $result = mysqli_query($connection, $query);

    // //query for irreg student

    // $query_irreg = "SELECT * FROM irreg_manual_sched WHERE stud_reg_id ='".$stud_reg_id."'";
    // $result_irreg = mysqli_query($connection, $query_irreg);

    // $query_irreg2 = "SELECT * FROM irreg_manual_subject WHERE stud_reg_id ='".$stud_reg_id."'";
    // $result_irreg2 = mysqli_query($connection, $query_irreg2);

    // if (mysqli_num_rows($result_irreg)>0 && mysqli_num_rows($result_irreg2)>0) {

    // $query_del_irreg  = "DELETE FROM irreg_manual_sched WHERE stud_reg_id ='".$stud_reg_id."'";
    // $result_del_irreg = mysqli_query($connection, $query_del_irreg);

    // $query_del_irreg2  = "DELETE FROM irreg_manual_subject WHERE stud_reg_id ='".$stud_reg_id."'";
    // $result_del_irreg2 = mysqli_query($connection, $query_del_irreg2);

    // }

    // $query  = "DELETE FROM enrollment WHERE stud_reg_id ='".$stud_reg_id."'";
    // $result = mysqli_query($connection, $query);

    // $query  = "DELETE FROM students_reg WHERE stud_reg_id ='".$stud_reg_id."' LIMIT 1";
    // $result = mysqli_query($connection, $query);

// next query: update the student count of the deleted student on the scheduling blocks

  //close database connection after an sql command

  if ($result === TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('Delete student info successful!');";
    echo "</script>";

    $URL="view-registered-students.php";
    echo "<script>location.href='$URL'</script>";
  } else {
    echo "Error updating record: " . $connection->error;
  }
            //removed the redirect function and replaced it with javascript alert above
            //still need to use the redirect function in case javascript is turned off
            //redirect_to("new-subject.php");

  if(isset($connection)){ mysqli_close($connection); }

?>


<?php 

  ?>




