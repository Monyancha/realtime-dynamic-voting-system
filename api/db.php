<?php
  session_start();
  date_default_timezone_set("Asia/Manila");

  // if($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_SESSION['fld_id'])){
  //   notfound();
  // }
  $db_name = 'db_dvsv2';
  define('server', 'localhost');
  define('user', 'root');
  define('pass', '');
  define('db', $db_name);
  

  $date = date("M d, Y");
  $time = date("h:i:s a");

  $conn = mysqli_connect(server, user, pass);

  $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'";
  $result = $conn->query($sql);
  
  if($result->num_rows > 0){
    $conn = mysqli_connect(server, user, pass, db);
    $conn->query("SET NAMES 'utf8'");
    $conn->query("SET CHARACTER_SET 'utf8'");
    
    if($conn->connect_error){
      notfound();
    }

  }else{
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name;";
    if($conn->query($sql) === TRUE){
      
      $conn = mysqli_connect(server, user, pass, $db_name);
      $conn->select_db(db);

      $conn->query("SET NAMES 'utf8'");
      $conn->query("SET CHARACTER_SET 'utf8'");

      $tbl_accounts = "CREATE TABLE `tbl_accounts` (
      `fld_id` text NOT NULL,
      `fld_password` text,
      `fld_name` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
      `fld_course` text,
      `fld_year_level` text,
      `fld_account_type` text NOT NULL,
      `fld_voted` tinyint(1) DEFAULT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
      $conn->query($tbl_accounts);
      
      $tbl_candidates = "CREATE TABLE `tbl_candidates` (
        `candidate_id` int(11) NOT NULL,
        `student_id` int(11) NOT NULL,
        `position_id` int(11) NOT NULL,
        `candidate_image` text
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
      $conn->query($tbl_candidates);

      $tbl_positions = "CREATE TABLE `tbl_positions` (
        `pos_id` int(11) NOT NULL,
        `pos_name` text NOT NULL,
        `pos_max_vote` text NOT NULL,
        `pos_level_vote` text NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
      $conn->query($tbl_positions);
      
      $tbl_votes = "CREATE TABLE `tbl_votes` (
        `vote_id` int(11) NOT NULL,
        `student_id` int(11) NOT NULL,
        `candidate_id` int(11) NOT NULL,
        `pos_id` int(11) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
      $conn->query($tbl_votes);

      $alter_tbl_accounts = "ALTER TABLE `tbl_accounts`
        ADD PRIMARY KEY (`fld_id`(255));";
      $conn->query($alter_tbl_accounts);
      
      $alter_tbl_candidates = "ALTER TABLE `tbl_candidates`
        ADD PRIMARY KEY (`candidate_id`),
        ADD UNIQUE KEY `student_id` (`student_id`);";
      $conn->query($alter_tbl_candidates);

      $alter_tbl_positions = "ALTER TABLE `tbl_positions`
        ADD PRIMARY KEY (`pos_id`);";
      $conn->query($alter_tbl_positions);
      
      $alter_tbl_votes = "ALTER TABLE `tbl_votes`
        ADD PRIMARY KEY (`vote_id`),
        ADD UNIQUE KEY `uniqueid` (`student_id`,`candidate_id`);";
      $conn->query($alter_tbl_votes);

      $modify_tbl_candidates = "ALTER TABLE `tbl_candidates`
        MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;";
      $conn->query($modify_tbl_candidates);

      $modify_tbl_positions = "ALTER TABLE `tbl_positions`
        MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;";
      $conn->query($modify_tbl_positions);
      
      $modify_tbl_votes = "ALTER TABLE `tbl_votes`
        MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7";
      $conn->query($modify_tbl_votes);
    
    }
  }

  function notfound(){
    die(header("HTTP/1.1 404"));
  }

?>
