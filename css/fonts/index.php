<?php
    if(!isset($_SESSION['fld_account_type'])){
      header('Content-type: application/json');
      header('HTTP/1.0 403');
      die("{\n\tmessage: Access is forbidden.\n}");
  }
?>