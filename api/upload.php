<?php
  require 'db.php'; 
  if(!isset($_SESSION['fld_account_type'])){
      header('Content-type: application/json');
      header('HTTP/1.0 403');
      die("{\n\tmessage: Access is forbidden.\n}");
  }

  if(isset($_FILES[0])){
    $file = $_FILES[0];

    if(!move_uploaded_file($file['tmp_name'], '../resources/db.csv')){
      die(json_encode(array("status"=> false, "message"=>"Sorry, something went wrong while uploading the file.")));
    }

  }else{
    die(json_encode(array("status"=> false, "message"=>"Sorry, something went wrong while uploading the file.")));
  }

  $sql = "DELETE FROM tbl_accounts WHERE fld_account_type != 'administrator'";

  if(!$conn->query($sql)){
    die(json_encode(array("status"=> false, "message"=>"Sorry, something went wrong while removing the database.")));
  }

  $sql = "LOAD DATA INFILE '/xampp/htdocs/Systems/Dynamic Voting System V2/resources/db.csv' INTO TABLE tbl_accounts FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' (fld_id, fld_name, fld_course, fld_year_level)";

  if(!$conn->query($sql)){

    die(json_encode(array("status"=> $conn->error, "message"=>"Sorry, something went wrong while importing the file.")));
  }

  $sql = "TRUNCATE tbl_votes";
  $conn->query($sql);

  $sql = "TRUNCATE tbl_candidates";
  $conn->query($sql);

  $sql = "UPDATE tbl_accounts SET fld_account_type='student' WHERE fld_account_type != 'administrator'";
  $conn->query($sql);

  die(json_encode(array("status"=>true, "message"=>"Records successfully added.")));
?>
