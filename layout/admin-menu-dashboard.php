<?php

if ($_SESSION["role"] == "administrator" || $_SESSION["role"] == "registrar") {

  echo "<div class=\"row\">";
  echo "<div class=\"col-xl-3 col-sm-6 mb-3\">";
  echo "<div class=\"card text-white bg-warning o-hidden h-100\">";         
  echo "<div class=\"card-body\">";            
  echo "<div class=\"card-body-icon\">";              
  echo "<i class=\"fa fa-fw fa-list\"></i>";                
  echo "</div>";                
  echo "<div class=\"mr-5\">Course Management</div>";              
  echo "</div>";            
  echo "<a class=\"card-footer text-white clearfix small z-1\" href=\"view-courses.php\">";            
  echo "<span class=\"float-left\">Go to Course Management</span>";              
  echo "<span class=\"float-right\">";              
  echo "<i class=\"fa fa-angle-right\"></i>";                
  echo "</span></a></div></div>";              
  echo "<div class=\"col-xl-3 col-sm-6 mb-3\">";            
  echo "<div class=\"card text-white bg-success o-hidden h-100\">";          
  echo "<div class=\"card-body\">";        
  echo "<div class=\"card-body-icon\">";        
  echo "<i class=\"fa fa-fw fa-id-card\"></i>";          
  echo "</div><div class=\"mr-5\">Faculty and Room Management</div></div>";                            
  echo "<a class=\"card-footer text-white clearfix small z-1\" href=\"view-teachers-and-rooms\">";                
  echo "<span class=\"float-left\">Go to Faculty and Room Management</span>";                              
  echo "<span class=\"float-right\">";            
  echo "<i class=\"fa fa-angle-right\"></i></span></a></div></div>";            
  echo "<div class=\"col-xl-3 col-sm-6 mb-3\">";              
  echo "<div class=\"card text-white bg-primary o-hidden h-100\">";              
  echo "<div class=\"card-body\">";                                
  echo "<div class=\"card-body-icon\">";            
  echo "<i class=\"fa fa-fw fa-graduation-cap\"></i>";
  echo "</div><div class=\"mr-5\">Students</div></div>";        
  echo "<a class=\"card-footer text-white clearfix small z-1\" href=\"view-registered-students.php\">";        
  echo "<span class=\"float-left\">Go to Students Menu</span>";
  echo "<span class=\"float-right\">";                            
  echo "<i class=\"fa fa-angle-right\"></i></span></a></div></div>";                
  echo "<div class=\"col-xl-3 col-sm-6 mb-3\">";              
  echo "<div class=\"card text-white bg-danger o-hidden h-100\">";              
  echo "<div class=\"card-body\">";            
  echo "<div class=\"card-body-icon\">";            
  echo "<i class=\"fa fa-fw fa-calendar\"></i></div>";                              
  echo "<div class=\"mr-5\">Classes and Schedule Management</div></div>";                
  echo "<a class=\"card-footer text-white clearfix small z-1\" href=\"new-group-schedule.php\">";              
  echo "<span class=\"float-left\">Go to Classes and Schedule Management</span>";            
  echo "<span class=\"float-right\"><i class=\"fa fa-angle-right\"></i></span></a></div></div></div>";          
  echo "<div class=\"row\">";  

  echo "<div class=\"col-xl-3 col-sm-6 mb-3\">";        
  echo "<div class=\"card text-white bg-success o-hidden h-100\">";          
  echo "<div class=\"card-body\">";            
  echo "<div class=\"card-body-icon\">";
  echo "<i class=\"fa fa-table\" aria-hidden=\"true\"></i></div>";        
  echo "<div class=\"mr-5\">Grading System</div></div>";          
  echo "<a class=\"card-footer text-white clearfix small z-1\" href=\"grading-portal.php\">";            
  echo "<span class=\"float-left\">Go to Students' Grades</span>";              
  echo "<span class=\"float-right\">";                
  echo "<i class=\"fa fa-angle-right\"></i></span></a></div></div>";
                
  echo "<div class=\"col-xl-3 col-sm-6 mb-3\">";        
  echo "<div class=\"card text-white bg-info o-hidden h-100\">";          
  echo "<div class=\"card-body\">";            
  echo "<div class=\"card-body-icon\">";
  echo "<i class=\"fa fa-users\" aria-hidden=\"true\"></i></div>";        
  echo "<div class=\"mr-5\">Users</div></div>";          
  echo "<a class=\"card-footer text-white clearfix small z-1\" href=\"view-users.php\">";            
  echo "<span class=\"float-left\">Manage Users</span>";              
  echo "<span class=\"float-right\">";                
  echo "<i class=\"fa fa-angle-right\"></i></span></a></div></div>";            
                      
                
  echo "<div class=\"col-xl-3 col-sm-6 mb-3\">";        
  echo "<div class=\"card text-white bg-secondary o-hidden h-100\">";          
  echo "<div class=\"card-body\">";            
  echo "<div class=\"card-body-icon\">";
  echo "<i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></div>";        
  echo "<div class=\"mr-5\">Registrar Services</div></div>";          
  echo "<a class=\"card-footer text-white clearfix small z-1\" href=\"registrar-services.php\">";            
  echo "<span class=\"float-left\">Go to Registar Services</span>";              
  echo "<span class=\"float-right\">";                
  echo "<i class=\"fa fa-angle-right\"></i></span></a></div></div>";           
            
  echo "<div class=\"col-xl-3 col-sm-6 mb-3\">";        
  echo "<div class=\"card text-white bg-dark o-hidden h-100\">";          
  echo "<div class=\"card-body\">";            
  echo "<div class=\"card-body-icon\">";
  echo "<i class=\"fa fa-cogs\" aria-hidden=\"true\"></i></div>";        
  echo "<div class=\"mr-5\">Site Settings</div></div>";          
  echo "<a class=\"card-footer text-white clearfix small z-1\" href=\"site-settings.php\">";            
  echo "<span class=\"float-left\">Manage Settings</span>";              
  echo "<span class=\"float-right\">";                
  echo "<i class=\"fa fa-angle-right\"></i></span></a></div></div>";       

}

else{
  echo "<div class=\"row\"><div class=\"col-xl-3 col-sm-6 mb-3\">";        
  echo "<div class=\"card text-white bg-success o-hidden h-100\">";          
  echo "<div class=\"card-body\">";            
  echo "<div class=\"card-body-icon\">";
  echo "<i class=\"fa fa-table\" aria-hidden=\"true\"></i></div>";        
  echo "<div class=\"mr-5\">Grading System</div></div>";          
  echo "<a class=\"card-footer text-white clearfix small z-1\" href=\"faculty-grading-portal.php\">";            
  echo "<span class=\"float-left\">Go to Students' Grades</span>";              
  echo "<span class=\"float-right\">";                
  echo "<i class=\"fa fa-angle-right\"></i></span></a></div></div></div>";
}

?>    
