<?php
	require_once("includes/db_connection.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");



if (isset($_POST['subject_id'])) {

  $subject_id = $_POST['subject_id'];
  // $subject_id_array = $_POST['subject_id_array'];

	$query  = "SELECT * FROM subjects WHERE subject_id='".$subject_id."'";
    $result = mysqli_query($connection, $query);

  while($row = mysqli_fetch_assoc($result))
    {
    echo "<li>".$row['subject_code'].": ".$row['subject_name']."<a href=\"#\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></a></i></li>";
    $units = $row['total_units'];
    }
    echo "<input type=\"text\" id=\"current_units\" value=\"".$units."\" style=\"display: none\">";
}
?>

