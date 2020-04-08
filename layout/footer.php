      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <p><span>

<?php include("includes/db_connection.php"); ?>

              <?php

                $query  = "SELECT * FROM site_settings LIMIT 1";
                $result = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($result))
              {
                $school_name = $row['school_name'];
                $school_address = $row['school_address'];
                $phone_number = $row['phone_number'];
              }

              if(isset($connection)){ mysqli_close($connection); }
              
                echo "Copyright <sup>&copy;</sup> ".date("Y")."<br>".$school_name;
              ?>
              <p><?php echo $school_address; ?><br>
                <?php echo $phone_number;?>
              </p>
          </div>
        </div>
      </footer>


   <!-- Boostrap Core hosted via CDN-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
  <!-- Core plugin JavaScript-->
  <script src="static/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="static/jquery.dataTables.js"></script>
  <script src="static/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="static/sb-admin.min.js"></script>
  <script src="static/custom.js"></script>

    <!-- Demo scripts for tables-->
  <script src="static/datatables-demo.js"></script>

  </body>
</html>