<?php
  require 'db.php';
  if(!isset($_SESSION['fld_account_type'])){
      header('Content-type: application/json');
      header('HTTP/1.0 403');
      die("{\n\tmessage: Access is forbidden.\n}");
  }

  $_method = $_SERVER['REQUEST_METHOD'];

  if($_method === 'GET'){
    $student_name = mysqli_real_escape_string($conn, $_GET['student_name']);

    $sql = "SELECT fld_id, fld_name, fld_course, fld_year_level FROM tbl_accounts WHERE fld_account_type != 'administrator' AND UPPER(fld_name) LIKE UPPER('%$student_name%') LIMIT 3";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $data[] = $row;
      }
    }else{
      $data = false;
    }

    echo json_encode($data);
  }
?>
