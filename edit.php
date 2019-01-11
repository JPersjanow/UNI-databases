<?php

  include "dbconnection.php";
  session_start();
  if (!isset($_SESSION['logged'])) {
		header('Location: index.php');
		exit();
	}

  $new_username = $_POST['password'];
  $new_email = $_POST['email'];
  $new_name = $_POST['name'];
  $new_surname = $_POST['surname'];




 ?>
