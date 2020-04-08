
<?php include 'header.php';?>

    <div class="container" style="margin: auto">
      <div class="col-md-6">
        <form class="form-horizontal" action='create-user.php' method="post">
          <fieldset>
            <div id="legend">
              <legend class="">Register</legend>
            </div>
            <div class="control-group">
              <!-- Username -->
              <label class="control-label"  for="username">Username</label>
              <div class="controls">
                <input type="text" id="username" name="username" placeholder="" class="input-xlarge" required>
                <p class="help-block">Username can contain any letters or numbers, without spaces</p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- E-mail -->
              <label class="control-label" for="email">E-mail</label>
              <div class="controls">
                <input type="text" id="email" name="email" placeholder="" class="input-xlarge" required> 
                <p class="help-block">Please provide your E-mail</p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- Password-->
              <label class="control-label" for="password">Password</label>
              <div class="controls">
                <input type="password" id="password" name="password" placeholder="" class="input-xlarge" required>
                <p class="help-block">Password should be at least 4 characters</p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- Password -->
              <label class="control-label"  for="password_confirm">Password (Confirm)</label>
              <div class="controls">
                <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge" required>
                <p class="help-block">Please confirm password</p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- Button -->
              <div class="controls">
                <submit class="btn btn-primary">Register</submit>
              </div>
            </div>
          </fieldset>
        </form>
     </div>
    </div>

<?php
      //inserts the new user to the user database

?>

<?php include 'footer.php';?>