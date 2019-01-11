<?php
  session_start();
  include "dbconnect.php";

  if(!isset($_SESSION['logged'])){
    header("Location: index.php");
  }

  $feedback_text = $_POST['feedback_text'];
  $feedback_time = date('Y-m-d');
  $user_id = $_SESSION['user_id'];
  $flag = true;

  if (strlen($feedback_text) > 10) {
    $flag = false;
    $_SESSION['feedback_error'] = "Tekst jest zbyt długi";
    header("Location: feedbackpage.php");
  }

  if($flag == true){

    //przesyłanie do bazy danych
    if ($connection->query("INSERT INTO feedback VALUES (NULL, '$user_id', '$feedback_text', '$feedback_time')")) {

          $_SESSION['feedback_added'] = true;
          header("Location: feedbackpage.php");

    } else {
       throw new Exception($connection->error);
    }

  $connection->close();
  }

 ?>
