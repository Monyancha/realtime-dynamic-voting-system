<div class="navbar-fixed">
  <nav class="" style="background: rgba(0,0,0,.2)">
    <div class="nav-wrapper">
      <a href="index.php" class="brand-logo center white-text bold"><span class="hide-on-med-and-down bold">Gordon College's</span> Dynamic Voting System V2</a>
      <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>

      <ul class="right hide-on-med-and-down">
        <?php
          if(!isset($_SESSION['fld_id'])){
        ?>

        <?php }else{ ?>
        <li class="red waves-effect"><a href="javascript: app.logout();" class="white-text"><i class="material-icons">power</i> Logout - <?php echo $_SESSION['fld_name']; ?> </a></li>

        <?php } ?>
      </ul>

      <ul id="slide-out" class="side-nav">
        <?php
        if(!isset($_SESSION['fld_id'])){
        ?>
        <li class="waves-effect"><a href="#!"><i class="material-icons">lock</i> Login</a></li>

        <?php }else{ ?>

        <li class="red waves-effect"><a href="javascript: app.logout();" class="white-text"><i class="material-icons">power</i> Logout</a></li>

        <?php } ?>
      </ul>

    </div>
  </nav>
</div>
