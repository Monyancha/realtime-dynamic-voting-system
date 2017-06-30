<?php
  require "db.php";

  $username = "";
  $password = "";
  $accountType = "";


  if(isset($_POST['username'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
  }

  if(isset($_POST['password'])){
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = md5($password);
  }

  if(isset($_POST['accountType'])){
    $accountType = mysqli_real_escape_string($conn, $_POST['accountType']);
    if($accountType === "student"){
      $sql = "SELECT fld_id, fld_name, fld_year_level, fld_course, fld_account_type, fld_voted FROM tbl_accounts WHERE fld_account_type = '$accountType' AND fld_id = '$username' LIMIT 1";
    }else{
      $sql = "SELECT fld_id, fld_name, fld_year_level, fld_course, fld_account_type FROM tbl_accounts WHERE fld_account_type = '$accountType' AND fld_id = '$username' AND fld_password = '$password' LIMIT 1";
    }
  }
  $result = $conn->query($sql);

  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      if($row['fld_id'] === $username){
        /*$row['fld_name'] = htmlentities($row['fld_name']));*/
        $data = $row;
        $_SESSION = $row;
      }else{
        $data = false;
      }
    }
  }else{
    $data = false;
  }

  echo json_encode($data);
?>
