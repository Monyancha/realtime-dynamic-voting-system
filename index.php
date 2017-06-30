<?php
  require('api/config.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <?php
      require('api/head.php');
    ?>
  </head>
  <body>
    <?php
      require('api/navigation.php');
    ?>

    <!--Administrator Menu-->
    <?php
      if($_SESSION['fld_account_type'] === "administrator"){
    ?>

    <br><br><br><br>
    <div class="container center">
      <div class="row">
        <div class="col m4 s12" style="text-align: center">

           <div class="menu circle white valign-wrapper">
            <div class="container center">
            <a href="candidates.php" class="valign">
            <i class="material-icons medium">group</i>
            <br>
            Manage Candidates</a>
            </div>
          </div>

        </div>
        <div class="col m4 s12 center">

          <div class="menu circle white valign-wrapper">
            <div class="container center">
              <a href="results-public.php" class="valign">
                <i class="material-icons medium">poll</i>
                <br>
                Election Results</a>
            </div>
          </div>

        </div>
        <div class="col m4 s12 center">

          <div class="menu circle white valign-wrapper">
            <div class="container center">
              <a href="voters.php" class="valign">
                <i class="material-icons medium">settings</i>
                <br>
                Manage Voters</a>
            </div>
          </div>

        </div>
      </div>

    </div>
    <br><br><br><br>

    <?php }else{
      require 'vote.php';
    } ?>
    <?php require('api/script.php');
      if($_SESSION['fld_account_type'] !== "administrator"){
    ?>
    <script src="js/vote.js"></script>
    <?php
      }
    ?>
    
  </body>
</html>
