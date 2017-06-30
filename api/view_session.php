<?php
  if(!isset($_SESSION['fld_account_type'])){
      header('Content-type: application/json');
      header('HTTP/1.0 403');
      die("{\n\tmessage: Access is forbidden.\n}");
  }

 /* $myfile = fopen("../resources/db.csv", "r") or die("Unable to open file!");
  while(!feof($myfile)){
    echo fgets($myfile);
  }

  fclose($myfile);*/

?>
<!--
  $name = "Santiago, Jayson, Ri�o";
echo str_replace("�", "ñ",fgets($myfile));-->


<!--�ñ-->
