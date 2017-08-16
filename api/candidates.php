<?php
    require 'db.php';
    
    if(!isset($_SESSION['fld_account_type'])){
        header('Content-type: application/json');
        header('HTTP/1.0 403');
        die("{\n\tmessage: Access is forbidden.\n}");
    }
    
    $_METHOD = $_SERVER['REQUEST_METHOD'];

    if($_METHOD === 'POST'){
        if(!isset($_POST['student_id']) OR !isset($_POST['position_id'])){
            echo json_encode(false);
        }
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
        $position_id = mysqli_real_escape_string($conn, $_POST['position_id']);
        $candidate_image = null;

        if(isset($_FILES['candidate_image'])){
            $file = $_FILES['candidate_image'];
            $check = getimagesize($file['tmp_name']);

            if($check !== false) {
                 if(file_exists("../resources/" . $student_id . "." . pathinfo(basename($file['name']),PATHINFO_EXTENSION))){
                     unlink("../resources/" . $student_id . "." . pathinfo(basename($file['name']),PATHINFO_EXTENSION));
                 }

                if(!move_uploaded_file($file['tmp_name'], "../resources/" . $student_id . "." . pathinfo(basename($file['name']),PATHINFO_EXTENSION))){
                    die(json_encode(array("status"=> false, "message"=>"Sorry, something went wrong while uploading the file.")));
                }else{
                    $candidate_image = "resources/" . $student_id . "." . pathinfo(basename($file['name']),PATHINFO_EXTENSION);
                }
            }else{
                die(json_encode(array("status"=>false, "message"=>"The file you uploaded is not an image.")));
            }

            $sql = "INSERT INTO tbl_candidates SET student_id = '$student_id', position_id = $position_id, candidate_image = '$candidate_image'";
        }else{
            $sql = "INSERT INTO tbl_candidates SET student_id = '$student_id', position_id = $position_id";
        }

        if($conn->query($sql) === TRUE){
            die(json_encode(array("status"=>true, "message"=>"Student successfully added as a candidate.")));
        }else{
            if($conn->error === "Duplicate entry '$student_id' for key 'student_id'"){
                die(json_encode(array("status"=>false, "message"=>"Sorry, student is already a candidate.")));
            }
            die(json_encode(array("status"=>false, "message"=>"Oops, an unknown error occured while adding a candidate.")));
        }
    }

    if($_METHOD === 'GET'){
        if(isset($_GET['position_id'])){
            $position_id = mysqli_real_escape_string($conn, $_GET['position_id']);            
            $sql = "SELECT tbl_candidates.*, tbl_accounts.fld_name FROM tbl_candidates LEFT JOIN tbl_accounts ON tbl_candidates.student_id = tbl_accounts.fld_id WHERE position_id = $position_id";
        }else{
            $sql = "SELECT tbl_candidates.*, tbl_accounts.fld_name, tbl_positions.pos_name, tbl_positions.pos_max_vote, tbl_positions.pos_level_vote FROM tbl_candidates LEFT JOIN tbl_accounts ON tbl_candidates.student_id = tbl_accounts.fld_id LEFT JOIN tbl_positions ON tbl_positions.pos_id = tbl_candidates.position_id WHERE tbl_positions.pos_level_vote = 'ALL' OR tbl_positions.pos_level_vote='" . $_SESSION['fld_course']  . "' ORDER BY position_id";
        }

        $result = $conn->query($sql);

        if($result->num_rows > 0){
            $status = true;
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }else{
            $status = false;
            $data = "No added candidate found on the server.";
        }

        die(json_encode(array("status"=>$status, "message"=>$data)));

    }

     if($_METHOD === 'DELETE'){
        $candidate_id = mysqli_real_escape_string($conn, $_REQUEST['c_id']);

        $sql = "DELETE FROM tbl_candidates WHERE candidate_id = $candidate_id";
        if($conn->query($sql) === TRUE){
            die(json_encode(array("status"=>true, "message"=>"Successfully removed.")));
        }else{
            die(json_encode(array("status"=>false, "message"=>"Unable to remove this candidate.")));
        }

        die(json_encode($candidate_id));
     }
?>