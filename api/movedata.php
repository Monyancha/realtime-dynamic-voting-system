<?php
  require 'db.php';

  $sql = "SELECT DISTINCT(student_id) AS student_id FROM tbl_votes";
  $result = $conn->query($sql);

  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      $sql1 = "UPDATE tbl_accounts SET fld_voted = 1 WHERE fld_id = '" . $row['student_id'] . "'";
      $conn->query($sql1);
    }
  }
?>
