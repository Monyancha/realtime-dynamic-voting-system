<?php
  if(basename($_SERVER['PHP_SELF']) !== "login.php"){
    if(!isset($_SESSION['fld_id'])){
      header("Location: login.php");
    }
  }else{
    if(isset($_SESSION['fld_id'])){
      header("Location: index.php");
    }
  }

?>
