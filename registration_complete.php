<?php
  //usunięcie zmiennych sesyjnych zapamiętywania formularza
  if (isset($_SESSION['form_nick'])) {unset($_SESSION['form_nick']);}
  if (isset($_SESSION['form_email'])) {unset($_SESSION['form_email']);}
  if (isset($_SESSION['form_name'])) {unset($_SESSION['form_name']);}
  if (isset($_SESSION['form_surname'])) {unset($_SESSION['form_surname']);}
  if (isset($_SESSION['form_agree'])) {unset($_SESSION['form_agree']);}

  //usunięcie zmiennych sesyjnych dot błędów
  if (isset($_SESSION['username_error'])) {unset($_SESSION['username_error']);}
  if (isset($_SESSION['email_error'])) {unset($_SESSION['email_error']);}
  if (isset($_SESSION['agree_error'])) {unset($_SESSION['agree_error']);}
  if (isset($_SESSION['captcha_error'])) {unset($_SESSION['captcha_error']);}
  if (isset($_SESSION['password_error'])) {unset($_SESSION['password_error']);}
 ?>

 <!DOCTYPE html>
 <html lang="pl">
   <head>
     <meta charset="utf-8">
     <title>Rejestracja Udana</title>
   </head>
   <body>

     <h1>Witaj Nowy Użytkowniku</h1>

     <div class="login">
       <a href="index.php">Możesz już się zalogować</a>
     </div>

   </body>
 </html>
