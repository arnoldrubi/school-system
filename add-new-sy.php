
<?php
  require_once("includes/functions.php");
  require_once("includes/db_connection.php"); 


  if (isset($_POST['add_sy'])) {

  $current_sy = $_POST["current_sy"];

  $sy_arr = explode("-", $current_sy);
  $new_sy = $sy_arr[1]."-".$sy_arr[1]+1;

  echo "<option selected value=\"".$new_sy."\">".$new_sy."</option>";

    $query  = "INSERT INTO school_yr (school_yr) VALUES '{$new_sy}';";
    $result = mysqli_query($connection, $query);

    if ($result === TRUE) {
      echo "<script type='text/javascript'>";
      echo "alert(New School Year Added!');";
      echo "</script>";

      $URL="site-settings.php";
      echo "<script>location.href='$URL'</script>";
      } else {
        echo "Error updating record: " . $connection->error;
      }
    }
?>


