<?php
  require 'db.php';
  if(!isset($_SESSION['fld_account_type'])){
      header('Content-type: application/json');
      header('HTTP/1.0 403');
      die("{\n\tmessage: Access is forbidden.\n}");
  }

  //Get positions
  if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = "SELECT * FROM tbl_positions";
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

  //Insert new position
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $position_name  = mysqli_real_escape_string($conn, $_POST['position_name']);

    if($position_name){
      $sql = "INSERT INTO tbl_positions SET pos_name='$position_name', pos_max_vote = '1', pos_level_vote = 'ALL'";
      if($conn->query($sql) === TRUE){
        echo json_encode(array(true, $conn->insert_id));
      }else{
        echo json_encode(array(false, $conn->error));
      }
    }else{
      echo json_encode(array(false, "Invalid data"));
    }
  }

  //Delete Position
  if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

    $id = mysqli_real_escape_string($conn, $_REQUEST['id']);
    $sql = "DELETE FROM tbl_positions WHERE pos_id=$id";

    if($conn->query($sql)){
      echo json_encode(true);
    }else{
      echo json_encode(false);
    }
  }

  //Update Position
  if($_SERVER['REQUEST_METHOD'] === 'PUT'){
    $id = mysqli_real_escape_string($conn, $_REQUEST['id']);
    if(isset($_REQUEST['pos_level'])){
      $pos_level = mysqli_real_escape_string($conn, $_REQUEST['pos_level']);
      $sql = "UPDATE tbl_positions SET pos_level_vote='$pos_level' WHERE pos_id=$id";
    }else{
      $max_vote = mysqli_real_escape_string($conn, $_REQUEST['max_vote']);
      $sql = "UPDATE tbl_positions SET pos_max_vote='$max_vote' WHERE pos_id=$id";
    }

    if($conn->query($sql) === TRUE){
      echo json_encode("Configuration updated successfully.");
    }else{
      echo json_encode($conn->error);
    }
  }

?>
