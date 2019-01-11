<?php
  require_once "connect.php";
  $connection = @new mysqli($host, $db_user,$db_password,$db_name);

    if($connection->connect_errno!=0)
    {
      echo "ERROR:".$connection->connect_errno."OPIS: ".$connection->connect_errno;
    }

 ?>
