<?php
  require("api/config.php");
  session_unset();
  session_destroy();

  header("Location: index.php");
?>
