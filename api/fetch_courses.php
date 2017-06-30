<?php
  require 'db.php';
  if(!isset($_SESSION['fld_account_type'])){
      header('Content-type: application/json');
      header('HTTP/1.0 403');
      die("{\n\tmessage: Access is forbidden.\n}");
  }

  $sql = "SELECT DISTINCT fld_course FROM tbl_accounts WHERE fld_account_type != 'administrator'";
  $result=$conn->query($sql);

  if($result->num_rows > 0){
    while($row=$result->fetch_assoc()){
      $data[] = $row;
    }
  }else{
    $data = false;
  }

  echo json_encode($data);
?>
