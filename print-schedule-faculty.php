<?php
 require_once("includes/session.php");
 require_once("includes/functions.php");
 require_once("includes/db_connection.php");

  if (isset($_GET['teacher_id']) && isset($_GET['sy']) && isset($_GET['term'])) {
      $teacher_id = $_GET["teacher_id"];
      $term = $_GET["term"];
      $sy = $_GET["sy"];

      $query  = "SELECT * FROM teachers WHERE teacher_id=".$teacher_id." LIMIT 1";
      $result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($result))
      {
        $teacher_name = $row['first_name']." ".$row['last_name'];
        $teacher_dept = $row['department'];
      }
    }
    else{
      redirect_to("view-teachers.php");
    }
?>

<div class="modal-header">
  <h3>Faculty Information</h3>
  <button type="button" class="close" data-dismiss="modal">X</button>
</div>
<div class="modal-body">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row" id="print-enrollment-form">
        <div class="col-md-12" id="theModal">
          <h4>Teacher Info</h4> 
            <table class="table table-hover text-left">
              <tbody>
                <tr>
                  <td>Teacher Name:</td>
                  <td><?php echo $teacher_name ?></td>
                </tr>
                <tr>
                  <td>Department:</td>
                  <td><?php echo $teacher_dept ?></td>
                </tr>
              </tbody>
            </table>
            <h4>Schedule <?php echo "for S.Y. ".$sy.", ".$term; ?></h4>
            <table class="table table-hover text-left">
              <thead>
                <tr>
                  <th>Course</th>
                  <th>Year</th>
                  <th>Section</th>
                  <th>Subject Code</th>
                  <th>Description</th>
                  <th width="3%">Lecture Units</th>
                  <th width="3%">Lab Units</th>
                  <th width="3%">Total Units</th>
                  <th>Time</th>
                  <th>Day</th>
                  <th>Room</th>
                </tr>
              </thead>
              <tbody>

                <?php
                  $unit_count = 0;

                  $query = "SELECT * FROM schedule_block WHERE teacher_id='".$teacher_id."' AND term='".$term."' AND school_yr='".$sy."'";

                  $result = mysqli_query($connection, $query);

                  if (mysqli_num_rows($result)<1) {
                    echo "<tr>No classes and schedule created yet.</tr>";
                  }

                  else{
                      while($row = mysqli_fetch_assoc($result))
                      {       
                        $units_array = get_subject_unit_count($row['subject_id'],"",$connection);
                        // for schedule data, set up variables

                        $course = "";
                        $year = "";

                        $query_section = "SELECT * FROM sections WHERE sec_id=".get_section_name_by_class($row['class_id'],"",$connection);

                        $result_section = mysqli_query($connection, $query_section);
                            while($row_section = mysqli_fetch_assoc($result_section))
                            {
                              $course = get_course_code($row_section['course_id'],"",$connection);
                              $year = $row_section['year'];
                              $section_name = $row_section['sec_name'];
                            }

                        echo "<tr>";
                        echo "<td>".$course."</td>";
                        echo "<td>".$year."</td>";
                        echo "<td>".$section_name."</td>";            
                        echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
                        echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
                        echo "<td>".$units_array[0]."</td>";
                        echo "<td>".$units_array[1]."</td>";
                        echo "<td>".$units_array[2]."</td>";

                        $day = substr(number_to_day($row['day']),0,3);
                        $time =  date("g:i A", strtotime($row['time_start']))."-".date("g:i A", strtotime($row['time_end']));
                        $room = $row['room'];

                        echo "<td>".trim($time,"/")."</td>";
                        echo "<td>".rtrim($day,"/")."</td>";
                        echo "<td>".rtrim($room,"/")."</td>";
                        echo "</tr>";
                        }
                    }    

                ?>
              </tbody>
            </table>
        </div>
      </div>
  </div>
</div>

