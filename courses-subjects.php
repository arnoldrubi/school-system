<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php include 'layout/header.php';?>


  <title>Assign Subjects to Course</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php
  $sidebar_context = "courses";

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="view-courses.php">View Courses</a>
        </li>
        <li class="breadcrumb-item active">
          Assign Subjects to Course
        </li>
      </ol>
      <h1>Assign Subjects to Course</h1>
      <hr>
      <div class="row">

        <div class="col-md-6">
          <h3>Course Info</h3>
          <form id="courses_form" action="process-courses-subjects.php" method="post" >
            <?php

              echo "<div class=\"form-group row\">";
              echo "<label class=\"col-md-2 col-form-label\" for=\"Course\">Course</label><div class=\"col-md-3\"><select class=\"form-control\" name=\"course\">";
              //this block will load the course name from the database
              $query  = "SELECT * FROM courses WHERE course_deleted = 0";
              $result = mysqli_query($connection, $query);

              while($row = mysqli_fetch_assoc($result))
                {
                  echo  "<option value=\"".$row['course_id']."\">".$row['course_code']."</option>";
                }
              echo "</select></div></div>";
            ?>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="Year">Year</label>
                  <div class="col-md-3">
                    <select class="form-control" name="year" id="year">
                      <option value="1st Year">1st Year</option>
                      <option value="2nd Year">2nd Year</option>
                      <option value="3rd Year">3rd Year</option>
                      <option value="4th Year">4th Year</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="Course">Term</label>
                  <div class="col-md-3">
                    <select class="form-control" name="semester">
                      <option value="1st Semester">1st Semester</option>
                      <option value="2nd Semester">2nd Semester</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-2 col-form-label" for="School Year">School Year</label>
                  <div class="col-md-3">
                    <select class="form-control" name="school_yr">
                      <?php
                        $query_school_yr  = "SELECT * FROM school_yr";
                        $result_school_yr = mysqli_query($connection, $query_school_yr);

                        while($row_school_yr = mysqli_fetch_assoc($result_school_yr))
                          {
                            echo  "<option value=\"".$row_school_yr['school_yr']."\">".$row_school_yr['school_yr']."</option>";
                          }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <input type="submit" id="submit" name="submit" value="Build Course Subjects" class="btn btn-primary" /><br> <br>
                </div>   
              <!--Hidden input box to be populated by user interaction-->
              <input type="text" name="array_values" id="array_values" style="display: none">
 

        </form>

      </div>

      <div class="col-md-6">
          <h3>Selected Subjects</h3>
          <ul id="selected-subjects">
          </ul>
      </div>
      <div class="col-md-12">
        <h3>Available Subjects</h3>
        <input class="form-control" id="myInput" type="text" placeholder="Quick Search">
      <?php

        echo "<table id=\"datatable\" class=\"table table-striped table-bordered dataTable\">";
        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Subject Name</th>";
        echo "   <th>Subject Code</th>";
        echo "   <th>Units</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        
        

        $query  = "SELECT * FROM subjects ORDER BY subject_id ASC";
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".$row['subject_name']."</td>";
        echo "<td>".$row['subject_code']."</td>";
        echo "<td>".$row['units']."</td>";
        echo "<td class=\"subject-wrap\"><a class=\"".$row['subject_code']."\" id=\"".$row['subject_id']."\""." href=\"#\">Add Subject</a> </td>";
        echo "</tr>";
        }

        echo "</tbody></table>"; 
      ?>
      </div>
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
  var arrval = new Array();

  $('.subject-wrap a').click(function(){
    var $checker = false;
    $( "#selected-subjects li:contains('"+ $(this).attr('class') +"')" ).each(function(){

        alert('Error! This subject is already selected');
        $checker = true;
      }
    );
    if ($checker === false){
    alert ($(this).attr('class')+ " has been selected!");
    $( "#selected-subjects" ).append( "<li id=\""+$(this).attr('id')+"\">"+$(this).attr('class')+" <a href=\"#\">x</a></li>" );
    $( "#courses_form" ).append( "<input type=\"text\" name=\""+$(this).attr('id')+"\" value=\""+$(this).attr('id')+"\" style=\"display: none\">" );
    arrval.push($(this).attr('id'));
    $("#array_values").val(arrval.join('; '));
    }
    var $count = $("#selected-subjects input").length;

    console.log(arrval.join('; '));


    $("#selected-subjects li a").click(function(){//remove this and place it under a document on load function
        $(this).closest("li").remove();
        alert ("Subject has been removed!");

        var removeItem = $(this).closest("li").attr("id");

        arrval = jQuery.grep(arrval, function(value) {
          return value != removeItem;
        });
        $("#array_values").val(arrval.join('; '));
    });

  });
    
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#datatable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

</script>



