  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <?php

      $query  = "SELECT * FROM site_settings LIMIT 1";
      $result = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($result))
      {
        $school_name = $row['school_name'];
        $school_address = $row['school_address'];
        $phone_number = $row['phone_number'];
        $site_logo = $row['site_logo'];
      }
      ?>
    <img class="site-logo" src="uploads/<?php echo  $site_logo." " ?>">

      <?php

        if ($_SESSION["role"] == "administrator" || $_SESSION["role"] == "registrar") {
        echo "<a class=\"navbar-brand mr-1\" href=\"admin-dashboard.php\">";
        }
        elseif ($_SESSION["role"] == "faculty") {
        echo "<a class=\"navbar-brand mr-1\" href=\"faculty-dashboard.php\">";
        }
        echo  $school_name." " ?><br><small>Academic Information Management System (AIMS)</small></a>

<!--     <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fa fa-bars"></i>
    </button> -->

    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
<!--       <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div> -->
    </form>

    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1"><label style="color: #fff;" class="col-form-label"><?php echo "Welcome back, ".ucwords($_SESSION["username"]); ?></label></li>
<!--       <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
      <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <?php 
              if ($_SESSION["role"] == "administrator" || $_SESSION["role"] == "registrar") {
               echo "<a class=\"dropdown-item\" href=\"user-account.php\">My Account</a>";
               echo "<a class=\"dropdown-item\" href=\"view-users.php\">Manage Users</a>";
              }
              elseif ($_SESSION["role"] == "faculty") {
               echo "<a class=\"dropdown-item\" href=\"faculty-account.php\">My Account</a>";
              }
              
            ?>
  <!--           <a class="dropdown-item" href="#">Activity Log</a> -->
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
      </li>
    </ul>

  </nav>
<div class="row bg-dark" id="term-sy-indicator" style="margin: 0 auto !important;">
<?php
  $query  = "SELECT * FROM site_settings WHERE id = 1";
  $result = mysqli_query($connection, $query);

  while($row = mysqli_fetch_assoc($result))
    {
      $active_term = $row['active_term'];
      $active_sy = $row['active_sy'];
      echo "<div class=\"col-md-12\"><p>Current S.Y and Term: <span id=\"active-sy\">".$active_sy."</span>, <span id=\"active-term\">".$active_term."</span></p></div>";
    }
?>
  
</div>