<?php
    require 'db.php';
    if(!isset($_SESSION['fld_account_type'])){
        header('Content-type: application/json');
        header('HTTP/1.0 403');
        die("{\n\tmessage: Access is forbidden.\n}");
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $student_id = $_SESSION['fld_id'];

        foreach($_POST as $key => $value){
            $position_id = $key;

            for($i=0; $i < count($_POST[$key]); $i++){
                $candidate_id = $_POST[$key][$i]['candidate_id'];
                $values[] = "('$student_id', $candidate_id, $position_id)";
            }     
        }

        $sql = "INSERT INTO tbl_votes (student_id, candidate_id, pos_id) VALUES " . implode(', ', $values);
        
        if($conn->query($sql) === TRUE){

            $_SESSION['fld_voted'] = true;
            
            $sql = "UPDATE tbl_accounts SET fld_voted = 1 WHERE fld_id = $student_id";
            $conn->query($sql);

            die(json_encode(array("status"=>true, "message"=>"Successfully Voted")));
        }else{
            die(json_encode(array("status"=>false, "message"=>$conn->error)));
        }

    }
?>