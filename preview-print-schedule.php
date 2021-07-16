<?php
 require_once("includes/session.php");
 require_once("includes/functions.php");
 require_once("includes/db_connection.php");

  if (isset($_GET['sec_id'])) {
      $sec_id = $_GET["sec_id"];
      $term = $_GET["term"];
      $school_yr = $_GET["school_yr"];
    }
    else{
      redirect_to("new-group-schedule.php");
    }

    //get all available classes

  $query_get_classes  = "SELECT * FROM classes WHERE sec_id='".$sec_id."'";
  $result_get_classes = mysqli_query($connection, $query_get_classes);

  $class_id = array();
  while($row_get_classes = mysqli_fetch_assoc($result_get_classes)){
    array_push($class_id, $row_get_classes['class_id']);
  }

  $query_get_section  = "SELECT * FROM sections WHERE sec_id='".$sec_id."'";
  $result_get_section = mysqli_query($connection, $query_get_section);

  while($row_get_section = mysqli_fetch_assoc($result_get_section)){
    $course_id = $row_get_section['course_id'];
    $year = $row_get_section['year'];
    $section = $row_get_section['sec_name'];
  } 

?>

<div class="modal-header">
  <h4>Preview Schedule</h4>
  <button type="button" class="close" data-dismiss="modal">X</button>
</div>
<div class="modal-body">
  <div class="panel panel-default">
    <div class="panel-body">
  <div class="row" id="print-schedule-form">
    <div class="col-md-12">
  
        <h4>Class Info</h4> 
          <table class="table table-hover text-left">
            <tbody>
              <tr>
                <td>Course:</td>
                <td><?php echo get_course_code(get_course_id_from_section($sec_id,"",$connection),"",$connection) ?></td>
              </tr>
              <tr>
                <td>Section:</td>
                <td><?php echo get_section_name($sec_id,"",$connection) ?></td>
              </tr>
              <tr>
                <td>Year:</td>
                <td><?php echo $year;?></td>
              </tr>
              <tr>
                <td>Semester:</td>
                <td><?php echo $term;?></td>
              </tr>
              <tr>
                <td>S.Y:</td>
                <td>
                <?php
                  echo $school_yr;
                ?>
                </td>
              </tr>
            </tbody>
          </table>

          <h4>Course Subjects</h4>
          <table class="table table-hover small">
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

                $query = "SELECT * FROM course_subjects WHERE course_id='".$course_id."' AND term='".$term."' AND year='".$year."' AND school_yr='".$school_yr."'";
                    

                $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($result))
                    {         

                      $units_array = get_subject_unit_count($row['subject_id'],"",$connection);
                      // for schedule data, set up variables
                      $time = NULL;
                      $day = NULL;
                      $room = NULL;
                      $teacher = NULL;
                      
                  echo "<tr>";              
                  echo "<td>".get_subject_code($row['subject_id'],"",$connection)."</td>";
                  echo "<td>".get_subject_name($row['subject_id'],"",$connection)."</td>";
                  echo "<td>".$units_array[0]."</td>";
                  echo "<td>".$units_array[1]."</td>";
                  echo "<td>".$units_array[2]."</td>";

                  for ($i=0; $i < count($class_id) ; $i++) { 

                    $schedule_id = find_schedule_data($row['subject_id'],$class_id[$i],$connection,"");
                    if ($schedule_id !== NULL) {

                      $query_get_schedule_data = "SELECT * FROM schedule_block WHERE schedule_id in(".$schedule_id.") ORDER BY day ASC, time_start ASC";
                      $result_get_schedule_data = mysqli_query($connection, $query_get_schedule_data);

                      while($row_get_schedule_data = mysqli_fetch_assoc($result_get_schedule_data))
                      {

                        $query_check_schedule_data = "SELECT * FROM schedule_block WHERE subject_id =".$row_get_schedule_data['subject_id']." AND class_id=".$row_get_schedule_data['class_id'];
                        $result_check_schedule_data = mysqli_query($connection, $query_check_schedule_data);
                        while($row_check_schedule_data = mysqli_fetch_assoc($result_check_schedule_data))
                        {
                          if (mysqli_num_rows($result_check_schedule_data)>1) {
                            $prev_day_check = NULL;
                            $prev_time_start_check = "00:00:00";
                            $prev_time_end_check = "00:00:00";
                            $prev_room_check = NULL;
                            if ($prev_day_check !== $row_check_schedule_data['day']) {
                              $day = $day.substr(number_to_day($row_check_schedule_data['day']),0,3)."/";
                            }
                            if ($row_check_schedule_data['time_start'] !== $prev_time_start_check && $row_check_schedule_data['time_end'] !== $prev_time_end_check)  {
                              $time = $time."/".date("g:i A", strtotime($row_check_schedule_data['time_start']))."-".date("g:i A", strtotime($row_check_schedule_data['time_end']));
                            }
                            if ($prev_room_check !== $row_check_schedule_data['room']) {
                              $room = $room.$row_check_schedule_data['room']."/";
                            }
                            $prev_time_start_check = $row_check_schedule_data['time_start'];
                            $prev_time_end_check = $row_check_schedule_data['time_end'];  
                            $prev_day_check = $row_check_schedule_data['day'];
                            $room = $row_check_schedule_data['room'];
                          }
                          else{
                            $day = substr(number_to_day($row_check_schedule_data['day']),0,3);
                            $time =  date("g:i A", strtotime($row_check_schedule_data['time_start']))."-".date("g:i A", strtotime($row_check_schedule_data['time_end']));
                            $room = $row_get_schedule_data['room'];
                          }
                        }                                       
                        $teacher = get_teacher_name($row_get_schedule_data['teacher_id'],"",$connection);
                      }

                    }
                  }

                  echo "<td>".trim($time,"/")."</td>";
                  echo "<td>".rtrim($day,"/")."</td>";
                  echo "<td>".rtrim($room,"/")."</td>";
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
    </div>
  </div>
</div>

