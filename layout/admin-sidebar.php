<?php
    echo "<ul class=\"sidebar navbar-nav\">";
    echo "<li class=\"nav-item active\">";
    echo "<a class=\"nav-link\" href=\"admin-dashboard.php\">";
    echo "<i class=\fa fa-tachometer\" aria-hidden=\"true\"></i>";
    echo "<span>Dashboard</span></a></li><hr>";

    if ($sidebar_context == "scheduling") {
      echo "<li class=\"nav-item dropdown\">";
      echo "  <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
      echo "   <i class=\"fa fa-users\" aria-hidden=\"true\"></i>";
      echo "   <span>Class Management</span></a>";
        
      echo " <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">";
      echo "    <a class=\"dropdown-item\" href=\"manage-sections.php\">Sections</a>";
      echo "    <a class=\"dropdown-item\" href=\"classes.php\">Classes</a></div></li>";

      echo "<li class=\"nav-item dropdown\">";
      echo "  <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
      echo "   <i class=\"fa fa-calendar-o\" aria-hidden=\"true\"></i>";
      echo "   <span>Block Scheduling</span></a>";
        
      echo " <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">";
      echo "    <a class=\"dropdown-item\" href=\"new-group-schedule.php\">View All</a>";
    }

    if ($sidebar_context == "teachers_rooms") {
      echo "<li class=\"nav-item dropdown\">";
      echo "  <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
      echo "   <i class=\"fa fa-building-o\" aria-hidden=\"true\"></i>";
      echo "    <span>Rooms</span></a>";
       
      echo " <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">";
      echo "    <a class=\"dropdown-item\" href=\"new-room.php\">Add New Room</a>";
      echo "    <a class=\"dropdown-item\" href=\"view-room.php\">View All Rooms</a>";
      echo "<li class=\"nav-item dropdown\">";
      echo "  <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
      echo "    <i class=\"fa fa-address-card-o\" aria-hidden=\"true\"></i><span>Teachers</span></a>";

      echo " <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">";
      echo "    <a class=\"dropdown-item\" href=\"new-teacher.php\">Add New</a>";
      echo "    <a class=\"dropdown-item\" href=\"view-teachers.php\">View All</a></div></li>";
      
  }

  if ($sidebar_context == "students") {
  
      echo "<li class=\"nav-item dropdown\">";
      echo "   <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
      echo "   <i class=\"fa fa-file\" aria-hidden=\"true\"></i>";
      echo "     <span>Student Registration</span></a>";        
      echo "    <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">";
      echo "      <a class=\"dropdown-item\" href=\"register-student.php\">Add New</a>";
      echo "      <a class=\"dropdown-item\" href=\"view-registered-students.php\">View All</a></div></li>";
      
      echo "<li class=\"nav-item dropdown\">";
      echo "  <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
      echo "    <i class=\"fa fa-clipboard\" aria-hidden=\"true\"></i>";
      echo "    <span>Enrollment</span></a>";        
      echo "  <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">";
      echo "  <a class=\"dropdown-item\" href=\"enrollment.php\">Enroll Student</a>";
      echo "<a class=\"dropdown-item\" href=\"view-enrolled-students.php\">View All</a></div></li>";
      
      echo "<li class=\"nav-item dropdown\">";
      echo "  <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
      echo "   <i class=\"fa fa-clipboard\" aria-hidden=\"true\"></i>";
      echo "<span>Irregular Students</span></a>";
      echo "<div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">";
      echo "<a class=\"dropdown-item\" href=\"irregular-manual-enrollment.php\">Manual Enrollment</a></div></li>";
    }

  if ($sidebar_context == "courses") {
    echo "  <li class=\"nav-item dropdown\">";
    echo "    <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
    echo "      <i class=\"fa fa-file\" aria-hidden=\"true\"></i>";
    echo "      <span>Courses</span></a>";
    echo " <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">";
    echo "   <a class=\"dropdown-item\" href=\"new-course.php\">Add New</a>";
    echo "   <a class=\"dropdown-item\" href=\"view-courses.php\">View All Courses</a>";
    echo "   <a class=\"dropdown-item\" href=\"courses-subjects.php\">Assign Subjects</a>";
    echo "   <a class=\"dropdown-item\" href=\"manage-course-subjects.php\">Subject Groups</a></div></li>";
  
    echo "  <li class=\"nav-item dropdown\">";
    echo "    <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
    echo "      <i class=\"fa fa-file\" aria-hidden=\"true\"></i>";
    echo "      <span>Subjects</span></a>";
    echo " <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">";
    echo "   <a class=\"dropdown-item\" href=\"new-subject.php\">Add New</a>";
    echo "   <a class=\"dropdown-item\" href=\"view-subject.php\">View All Subjects</a>";
  }
  if ($sidebar_context == "grading") {
    echo "<li class=\"nav-item dropdown\">";
    echo "    <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
    echo "     <i class=\"fa fa-calculator\" aria-hidden=\"true\"></i>";
    echo "       <span>Grading System</span></a>";
    echo "<div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">";
    echo "<a class=\"dropdown-item\" href=\"grading-portal.php\">Grading Wizard</a></div></li>";      
}
echo "</ul>";
?>