<?php
  session_start();

  if (isset($_POST['email'])) {
    //udana walidacja
    $flag = true;

    //pobranie zmiennych
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];

    //sprawdzanie $username

    //dlugosc
    if (strlen($username)>20 || strlen($username)<3) {
      $flag = false;
      $_SESSION['username_error'] = "Login musi posiadać od 3 do 20 znaków";
    }
    //znaki specjalne w niku
    if (ctype_alnum($username)==false) {
      $flag = false;
      $_SESSION['username_error'] = "Login może składać się tylko z liter i cyfr";
    }

    //sprawdzanie emiala

    //sanityzacja
    $email_safe = filter_var($email, FILTER_SANITIZE_EMAIL);

    if(filter_var($email_safe, FILTER_VALIDATE_EMAIL) == false || ($email_safe != $email)){
      $flag = false;
      $_SESSION['email_error'] = "Podaj poprawny adres email";
    }

    //sprawdzanie $password

    $password_a = $_POST['password_a'];
    //dlugość
    if (strlen($password)<8) {
      $flag = false;
      $_SESSION['password_error'] = "Hasło musi posiadać minimum 8 znaków";
    }
    //czy takie same
    if($password != $password_a){
      $flag = false;
      $_SESSION['password_error'] = "Podane hasła są różne";
    }
    //hashowanie hasła
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //checkboxy
    if (!isset($_POST['agree'])) {
      $flag = false;
      $_SESSION['agree_error'] = "Zaakceptuj regulamin";

    }

    //recaptcha
    $captcha_skey = "6Ld4togUAAAAAHmD-oBiOU-08FafZd-lOKX6PrwU";
    $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$captcha_skey.'&response='.$_POST['g-recaptcha-response']);
    $answer = json_decode($check);

    if ($answer->success == false) {
      $flag = false;
      $_SESSION['captcha_error'] = "Potwierdź captche";
    }

    //Zapamiętaj wprowadzone Dane
    $_SESSION['form_nick'] = $username;
    $_SESSION['form_email'] = $email;
    $_SESSION['form_name'] = $name;
    $_SESSION['form_surname'] = $surname;
    if (isset($_POST['agree'])) {
      $_SESSION['form_agree'] = true;
    }


    //polaczenie z bazą sprawdzanie email i username
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT); //reportowanie przez exception

    try {
      $connection = new mysqli($host, $db_user,$db_password,$db_name);

      if ($connection->connect_errno!=0) {
        throw new Exception(mysqli_connect_errno());
      } else {
        //czy istnieje email w bazie danych
        $result = $connection->query("SELECT user_id FROM users WHERE email='$email'");

        if (!$result) throw new Exception($connection->error);//blad result

        $number_emails = $result->num_rows; //pobranie z bazy danych

        if($number_emails>0){
          $flag = false;
          $_SESSION['email_error'] = "Istnieje konto przypisane do podanego adresu email";
        }

        //czy istnieje username w bazie danych
        $result = $connection->query("SELECT user_id FROM users WHERE username='$username'");

        if (!$result) throw new Exception($connection->error);//blad result

        $number_username = $result->num_rows; //pobranie z bazy danych

        if($number_username>0){
          $flag = false;
          $_SESSION['username_error'] = "Taka nazwa użytkownika już istnieje";
          }

          //BRAK BŁĘDÓW
          if($flag == true){
            //przesyłanie do bazy danych

            if ($connection->query("INSERT INTO users VALUES (NULL, '$username', '$hashed_password', '$email', '$name', '$surname')")) {

                  $_SESSION['registration_complete'] = true;
                  header("Location: registration_complete.php");

            } else {
               throw new Exception($connection->error);
            }

          $connection->close();

        }


      }

    } catch (Exception $e) {
      echo "Błąd serwera, prosimy spróbować później";
      echo "dev debug:".$e;
    }
  }

 ?>

 <!DOCTYPE html>
 <html lang="pl">
   <head>
     <meta charset="utf-8">
     <title>JG19 Rejestracja</title>
     <script src='https://www.google.com/recaptcha/api.js'></script>
   </head>
   <body>

     <div class="register_from">
 			<p>Rejestracja</p>
 			<form method="post">


        Login:<br/><input type = "text" value="<?php if (isset($_SESSION['form_nick'])) { echo $_SESSION['form_nick']; unset($_SESSION['form_nick']);} ?>" name="username" required /><br/>
        <?php
          if (isset($_SESSION['username_error'])) {
            echo '<div class="error">'.
                  $_SESSION['username_error']
                  .'</div>';
            unset($_SESSION['username_error']);
          }
         ?>

  			Hasło:<br/><input type = "password" name="password" required  /><br/>
        <?php
          if (isset($_SESSION['password_error'])) {
            echo '<div class="error">'.
                  $_SESSION['password_error']
                  .'</div>';
            unset($_SESSION['password_error']);
          }
         ?>

        Powrórz Hasło:<br/><input type = "password" name="password_a" required  /><br/>
        <?php
          if (isset($_SESSION['password_error'])) {
            echo '<div class="error">'.
                  $_SESSION['password_error']
                  .'</div>';
            unset($_SESSION['password_error']);
          }
         ?>

        email:<br/><input type = "email" value="<?php if (isset($_SESSION['form_email'])) { echo $_SESSION['form_email']; unset($_SESSION['form_email']);} ?>" name= "email"  required /><br/>
        <?php
          if (isset($_SESSION['email_error'])) {
            echo '<div class="error">'.
                  $_SESSION['email_error']
                  .'</div>';
            unset($_SESSION['email_error']);
          }
         ?>

  			name:<br/><input type = "text" value="<?php if (isset($_SESSION['form_name'])) { echo $_SESSION['form_name']; unset($_SESSION['form_name']);} ?>" name= "name" required /><br/>
  			surname:<br/><input type = "text" value="<?php if (isset($_SESSION['form_surname'])) { echo $_SESSION['form_surname']; unset($_SESSION['form_surname']);} ?>" name= "surname" /><br/>

        <label>
          <input type="checkbox" <?php if(isset($_SESSION['form_agree'])){echo "checked"; unset($_SESSION['form_agree']);} ?> name="agree" required/> Akceptuje Regulamin
        </label>
        <?php
          if (isset($_SESSION['agree_error'])) {
            echo '<div class="error">'.
                  $_SESSION['agree_error']
                  .'</div>';
            unset($_SESSION['agree_error']);
          }
         ?>


        <br/><br/>
        <div class="g-recaptcha" data-sitekey="6Ld4togUAAAAAC_SaQveSJOctmTePsIBVNiRi7xS"></div>
        <?php
          if (isset($_SESSION['captcha_error'])) {
            echo '<div class="error">'.
                  $_SESSION['captcha_error']
                  .'</div>';
            unset($_SESSION['captcha_error']);
          }
         ?>

        <input type = "submit" values = "rejestruj" />
 			</form>
 		</div>

   </body>
 </html>
