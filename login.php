<?php
  require('api/config.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <?php require('api/head.php') ?>
  </head>
  <body>
    <?php
      require('api/navigation.php');
    ?>

    <div class="container">
      <div class="row">
        <br>
        <form id="login-form" class="col m8 offset-m2 s12">
          <div class="card white">
            <div class="card-content">
              <br>
              <div class="row">
                <div class="input-field col s12">
                  <input placeholder="Enter your username | student id" id="username-input" name="username" type="text" class="validate" required>
                  <label class="blue-grey-text bold" for="username-input">Username | Student ID</label>
                </div>
              </div>
              <div class="row" id="password-container">
                <div class="input-field col s12">
                  <input placeholder="**********" id="password-input" name="password" type="password" class="validate">
                  <label class="blue-grey-text bold" for="password-input">Password</label>
                </div>
              </div>
              <div class="row">
                <div class="container">
                  <div class="col s6">
                    <input class="with-gap" name="accountType" type="radio" id="student" checked />
                    <label class="blue-grey-text bold" for="student">Student</label>
                  </div>
                  <div class="col s6">
                    <input class="with-gap" name="accountType" type="radio" id="administrator" />
                    <label class="blue-grey-text bold" for="administrator">Administrator</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="container">
                  <button type="submit" class="btn btn-large blue-grey waves-effect col s12">Sign in</button>
                </div>
              </div>

            </div>
          </div>
        </form>

      </div>
    </div>

    <div class="footer">
      <div class="center">
        <span class="bold">
          Dynamic Voting System V2
        </span>
        <br>
        <small>
          &copy; Created by <span class="orange-text">Sammuel Lagat Apa</span>
          <br>Bachelor of Science in Computer Science | Class of 2017
        </small>
      </div>
    </div>

    <?php require('api/script.php') ?>
    <script src="js/login.js"></script>
  </body>
</html>
