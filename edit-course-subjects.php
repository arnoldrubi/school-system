<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>

<?php 
      if (isset($_GET['course_id'])) {
          $course_id = $_GET["course_id"];
          $year = urldecode($_GET["year"]);
          $term = urldecode($_GET["term"]);
          $school_yr = urldecode($_GET["school_yr"]);
        }
        else{
          $course_id = NULL;
          $year = NULL;
          $term = NULL;
        }
        if ($course_id == NULL) {
          redirect_to("view-courses.php");
       }

?>

  <title>Edit Subject Group</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php include 'layout/admin-sidebar.php';?>



    <div id="content-wrapper" class="col-md">
       <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="manage-course-subjects.php">Manage Course's Subjects</a>
        </li>
        <li class="breadcrumb-item active">
          Edit Subjects Groups
        </li>
      </ol>
      <h1>Edit Subject Group</h1>

        <div class="col-md-6">
          
  <?php

            $query  = "SELECT * FROM courses WHERE course_id='".$course_id."' LIMIT 1";
            $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) < 1) {
        echo "<script type='text/javascript'>";
        echo "alert('No records exists!');";
        echo "</script>";

        $URL="admin-dashboard.php";
        echo "<script>location.href='$URL'</script>";
        }
        else{
        echo "<div class=\"form-group\">";
        echo "Course: ";
          while($row = mysqli_fetch_assoc($result))
            {
            echo $row['course_code']."- ";
            echo $row['course_desc'];
            }            
        
        echo "</p>";
        echo "<p>Year: ".$year."</p>";
        echo "<p>Term: ".$term."</p>";
        echo "</div>";
        }
 ?>
      </div>


    <form id="courses_form" action="process-courses-subjects.php" method="post" >          
        

      <?php
        echo "<h3>Current Subjects</h3>";
        echo "<table id=\"datatable\" class=\"table table-striped table-bordered dataTable\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Name</th>";
        echo "   <th>Subject Code</th>";
        echo "   <th>Units</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT subject_id FROM course_subjects WHERE course_id='".$course_id."' AND year='".$year."' AND term ='".$term."'";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        $subject_id = $row['subject_id'];
        $subject_items[] = $row['subject_id'];
          $query2  = "SELECT * FROM subjects WHERE subject_id='".$subject_id."'";
          $result2 = mysqli_query($connection, $query2);
          while($row2 = mysqli_fetch_assoc($result2)){
            echo "<tr>";
            echo "<td>".$row2['subject_name']."</td>";
            echo "<td>".$row2['subject_code']."</td>";
            echo "<td>".$row2['units']."</td>";

            echo "<td class=\"subject-wrap\"><a href=\"javascript:confirmDelete('remove-subject-from-course?course_id=".$course_id."&subject_id=".$subject_id."&year=".urlencode($year)."&term=".urlencode("$term")."&school_yr=".urlencode("$school_yr")."')\"> Remove Subject</a></td>";
            echo "</tr>";
          }
        }
        echo "</tbody></table>"; 
      ?>

        <?php

        echo "<h3>Add New Subjects</h3>";
        echo "<input class=\"form-control\" id=\"myInput\" type=\"text\" placeholder=\"Quick Search\">";
        echo "<table id=\"datatable\" class=\"dataTable2 table table-striped table-bordered dataTable\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Name</th>";
        echo "   <th>Subject Code</th>";
        echo "   <th>Units</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
    $query2  = "SELECT * FROM course_subjects WHERE course_id ={$course_id} AND subject_id = {$subject_id} AND year ='".$year."' AND term ='".$term."'";
    $result2 = mysqli_query($connection, $query2);

    //check if there are still subjects assigned to the selected course, year, and term
    if (mysqli_num_rows($result2) <= 0) {
      echo "<script type='text/javascript'>";
      echo "alert('No assigned subjects for this course, year, and term exists!');";
      echo "</script>";

      $URL="manage-course-subjects.php";
      echo "<script>location.href='$URL'</script>";
    }
    else{
        $query  = "SELECT * FROM subjects WHERE subject_id NOT IN (".implode( ", ", $subject_items ).") ORDER BY subject_name";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".$row['subject_name']."</td>";
        echo "<td>".$row['subject_code']."</td>";
        echo "<td>".$row['units']."</td>";
        echo "<td class=\"subject-wrap\"><a href=\"add-subject-to-course.php?course_id=".$course_id."&subject_id=".$row['subject_id']."&year=".urlencode($year)."&term=".urlencode("$term")."&school_yr=".urlencode("$school_yr")."\">Add Subject</a> </td>";
        echo "</tr>";
        }
      }
        echo "</tbody></table>"; 
      ?>
     </form>
    </div>
  </div>
  <div id="response"></div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


<?php include 'layout/footer.php';?>


<script>
$( document ).ready(function() {
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".dataTable2 tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

</script>


