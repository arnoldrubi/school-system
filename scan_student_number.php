<?php
	require_once("includes/db_connection.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");

	if (!isset($_POST['StudentNumber'])) {
		$StudentNumber = "";
	}
	else{
		$StudentNumber = $_POST['StudentNumber'];
	}

if (isset($_POST['StudentNumber'])) {


	$query  = "SELECT DISTINCT students_reg.last_name, students_reg.first_name, students_reg.middle_name, students_reg.name_ext, enrollment.student_number FROM students_reg INNER JOIN enrollment ON students_reg.stud_reg_id=enrollment.stud_reg_id WHERE enrollment.student_number='".$StudentNumber."'";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){

        echo "<div class=\"form-group row\">";
        echo "  <label class=\"col-md-2 col-form-label\" for=\"LastName\">Last Name</label> "; 
        echo "  <div class=\"col-md-4\">";
        echo "  <input id=\"LastName\" name=\"lastname\" value =\"".$row['last_name']."\" type=\"text\" placeholder=\"Input Last Name\" class=\"form-control\" required>";
        echo "  </div>";

        echo "<label class=\"col-md-2 col-form-label\" for=\"FirstName\">First Name</label>  ";
        echo "<div class=\"col-md-4\">";
        echo "<input id=\"FirstName\" name=\"firstname\" value =\"".$row['first_name']."\" type=\"text\" placeholder=\"Input First Name\" class=\"form-control\" required>";
        echo "</div>";
        echo "</div>";

        echo "<div class=\"form-group row\">";
        echo "<label class=\"col-md-2 col-form-label\" for=\"MiddleName\">Middle Name</label>  ";
        echo "<div class=\"col-md-4\">";
        echo "<input id=\"MiddleName\" value=\"".$row['middle_name']."\" name=\"middlename\" type=\"text\" placeholder=\"Input Middle Name\" class=\"form-control\" required>";
        echo "</div>";

        echo "<label class=\"col-md-2 col-form-label\" value=\"".$row['name_ext']."\" for=\"NameExt\">Name Extension</label>  ";
        echo "<div class=\"col-md-1\">";
        echo "  <input id=\"NameExt\" name=\"nameext\" type=\"text\" placeholder=\"Name Ext.\" class=\"form-control\">";
        echo "</div>";
        echo "</div>";

        }  
    }

    else{
        echo "<div class=\"form-group row\">";
        echo "  <label class=\"col-md-2 col-form-label\" for=\"LastName\">Last Name</label> "; 
        echo "  <div class=\"col-md-4\">";
        echo "  <input id=\"LastName\" name=\"lastname\" type=\"text\" placeholder=\"Input Last Name\" class=\"form-control\" required>";
        echo "  </div>";

        echo "<label class=\"col-md-2 col-form-label\" for=\"FirstName\">First Name</label>  ";
        echo "<div class=\"col-md-4\">";
        echo "<input id=\"FirstName\" name=\"firstname\" type=\"text\" placeholder=\"Input First Name\" class=\"form-control\" required>";
        echo "</div>";
        echo "</div>";

        echo "<div class=\"form-group row\">";
        echo "<label class=\"col-md-2 col-form-label\" for=\"MiddleName\">Middle Name</label>  ";
        echo "<div class=\"col-md-4\">";
        echo "<input id=\"MiddleName\" name=\"middlename\" type=\"text\" placeholder=\"Input Middle Name\" class=\"form-control\" required>";
        echo "</div>";

        echo "<label class=\"col-md-2 col-form-label\" for=\"NameExt\">Name Extension</label>  ";
        echo "<div class=\"col-md-1\">";
        echo "  <input id=\"NameExt\" name=\"nameext\" type=\"text\" placeholder=\"Name Ext.\" class=\"form-control\">";
        echo "</div>";
        echo "</div>";
    }

}

?>
