<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

  <title>Request for Transfer of Credits</title>
  </head>

  <body>

  <?php include 'layout/admin-nav.php';?>

  <div id="wrapper">

  <?php

    if (isset($_GET['stud_reg_id'])) {    
        $stud_reg_id = $_GET['stud_reg_id'];
    }
    else{
      redirect_to("view-toc.php");
    }

  include 'layout/admin-sidebar.php';?>

    <div id="content-wrapper" class="col-md">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="admin-dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
         <a href="registrar-services.php">Registrar Services</a>
        </li>
        <li class="breadcrumb-item">
         <a href="view-toc.php">Dashboard - Transfer of Credits</a>
        </li>
        <li class="breadcrumb-item active">
         Manage Transfer of Credits
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
          Manage Transfer of Credits <?php echo "for ".get_student_name($stud_reg_id, $connection); ?></div>
          <div class="card-body">
            <a type="button" <?php echo "href=\"request-transfer-of-credits.php?stud_reg_id=".$stud_reg_id."\""; ?>  class="btn btn-primary">+Add New</a>
            <div class="table-responsive" id="dataTable_wrapper">
            <?php

            if (isset($_GET['stud_reg_id'])) {    

                echo "<table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
                echo " <thead>";
                echo "  <tr>";
                echo "   <th>Subject Code</th>";
                echo "   <th>Subject Name/Description</th>";
                echo "   <th>Equivalent Subject Code</th>";
                echo "   <th>Equivalent Subject Description</th>";
                echo "   <th>School</th>";
                echo "   <th>S.Y. Taken</th>";
                echo "   <th>Term</th>";
                echo "   <th>Final Grade</th>";
                echo "   <th>Options</th>";   
                echo "  </tr></thead><tbody>";
                
                

                $query  = "SELECT * FROM transfer_of_credits WHERE stud_reg_id=".$stud_reg_id;
                $result = mysqli_query($connection, $query);

              while($row = mysqli_fetch_assoc($result))
                {

                echo "<tr>";
                echo "<td>".$row['subject_name']."</td>";
                echo "<td>".$row['subject_desc']."</td>";
                echo "<td>".get_subject_name($row['equivalent_subject_id'],"",$connection)."</td>";
                echo "<td>".get_subject_code($row['equivalent_subject_id'],"",$connection)."</td>";
                echo "<td>".$row['school_name']."</td>";
                echo "<td>".$row['year_taken']."</td>";
                echo "<td>".$row['term_taken']."</td>";
                echo "<td>".$row['final_grade']."</td>";
                echo "<td class=\"options-td\"><a class=\"btn btn-warning btn-xs a-modal\" title=\"Edit\" href=\"edit-transfer-of-credits.php?id=".$row['id']."\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a> ";
                echo "<a title=\"Delete\" class=\"btn btn-danger btn-xs a-modal\" href=\"javascript:confirmDelete2('delete-toc.php?id=".$row['id']."&stud_reg_id=".$stud_reg_id."')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td>";
                echo "</tr>";
                }

                echo "</tbody></table>"; 
              }
            ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

<?php 
  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>
<?php include 'layout/footer.php';?>

<script type="text/javascript">
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#datatable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

</script>