<?php
  session_start();

  include "dbconnect.php"; //połaczenie z bazą danych

      $sql = "SELECT feedback.user_id, feedback.feedback_text, feedback.feedback_date, users.email, users.username FROM feedback INNER JOIN users ON feedback.user_id = users.user_id";
      $result = @$connection->query($sql);

 ?>

<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Feedback Juwenalia Gdańskie 2019</title>
  </head>
  <body>


    <div class="add_feedback">
      <h1>Cenimy twoje zdanie! Podziel się nim:</h1>
        <form class="feedback" action="feedbackadd.php" method="post">
          Feedback:<input type="text" name="feedback_text">
          <input type="submit" name="feedback_send" value="Wyślij Feedback">
        </form>
    </div>

    <?php if (isset($_SESSION['feedback_added'])){
      echo '<div class="feedback_added">
            <p>Dziękujemy za opinię!</p>
            </div>';
      unset($_SESSION['feedback_added']);
    } ?>




    <table>
      <tr>
        <td>Użytkownik:</td>
        <td>E-mail:</td>
        <td>Feedback:</td>
        <td>Data:</td>
        <td></td>
      </tr>



        <?php
        if ($result->num_rows> 0) {
          while ($index = $result->fetch_assoc()) {

            $_SESSION['feedback_id'] = $index['feedback_id'];

            echo "<tr>
              <td>".$index['username']."</td>
              <td>".$index['email']."</td>
              <td>".$index['feedback_text']."</td>
              <td>".$index['feedback_date']."</td>";

              if (isset($_SESSION['username']) && (($_SESSION['user_id'] == $index['user_id']) || ($_SESSION['username'] == 'admin')) )
              {
                echo "<td><a href='*'>Usuń</a></td>";
                echo "<td><a href='*'>Edytuj</a></td>";
            }



            echo "</tr>";
          }}
         ?>


  </body>
</html>
