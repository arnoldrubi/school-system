
<?php
  require_once("includes/functions.php");
  require_once("includes/db_connection.php"); 

  if (isset($_POST['update_enrollment'])) {

    $active_term = mysql_prep($_POST["active_term"]);
    $active_sy = mysql_prep($_POST["active_sy"]);
    $start_of_class = $_POST["start_of_class"];
    $end_of_class = $_POST["end_of_class"]; 

    if ($start_of_class > $end_of_class) {
      die ("<div class=\"alert alert-danger\" role=\"alert\">Error: Check your values (start of class must not be greater than end of class, end of class most not be less than start of class</div>");
    } 

    $query  = "UPDATE site_settings SET active_term = '{$active_term}', active_sy = '{$active_sy}', start_class = '{$start_of_class}', end_class = '{$end_of_class}' WHERE id = 1 LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result === TRUE) {
      echo "<script type='text/javascript'>";
      echo "alert('Enrollment settings saved!');";
      echo "</script>";

      $URL="site-settings.php";
      echo "<script>location.href='$URL'</script>";
      } else {
        echo "Error updating record: " . $connection->error;
      }
    }

  if (isset($_POST['add_sy'])) {

  $current_sy = $_POST["active_sy"];

  $sy_arr = explode("-", $current_sy);
  $increment_sy = (int)$sy_arr[1]+1;
  $new_sy = (int)$sy_arr[1]."-".$increment_sy;

  $query  = "INSERT INTO school_yr (school_yr) VALUES ('{$new_sy}');";
  $result = mysqli_query($connection, $query);

  $query  = "UPDATE site_settings SET active_sy = '{$new_sy}' WHERE id = 1 LIMIT 1";
  $result = mysqli_query($connection, $query);

    if ($result === TRUE) {
      echo "<script type='text/javascript'>";
      echo "alert('New School Year Added!');";
      echo "</script>";

      $URL="site-settings.php";
      echo "<script>location.href='$URL'</script>";
      } else {
        echo "Error updating record: " . $connection->error;
      }
    }
?>


