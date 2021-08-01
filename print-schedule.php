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
  <style type="text/css">
    span.hide-date:nth-child(2),span.hide-date:nth-child(3),span.hide-date:nth-child(4),span.hide-date:nth-child(5) {
      display: none;
  }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row" id="print-enrollment-form">
    <div class="col-md-12">
  
        <h4>Class Info</h4> 
          <table class="table table-hover">
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
                              $time = $time." "."<span class=\"hide-date\">".date("g:i A", strtotime($row_check_schedule_data['time_start']))."-".date("g:i A", strtotime($row_check_schedule_data['time_end']))."</span>";
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
    <center>
      <button id="preview-print" class="btn btn-primary no-print"><i class="fa fa-print" aria-hidden="true"></i></i></i> Print Schedule</button>
    </center><br>
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