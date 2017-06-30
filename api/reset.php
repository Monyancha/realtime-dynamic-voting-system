<?php
    require 'db.php';
    
    if(isset($_SESSION['fld_account_type'])){
        if($_SESSION['fld_account_type'] != 'administrator'){
            notfound();
        }
    }else{
        notfound();
    }

    $sql = "TRUNCATE tbl_votes";
    $conn->query($sql);

    $sql = "TRUNCATE tbl_candidates";
    $conn->query($sql);

    $sql = "DELETE FROM tbl_accounts WHERE fld_account_type != 'administrator'";
    $conn->query($sql);
    
    echo "<script>
        window.location.replace('../voters.php');
    </script>";
?>