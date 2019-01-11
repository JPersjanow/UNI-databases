<?php

//Obsługa sesji
	session_start();

	if ((!isset($_POST['username'])) || (!isset($_POST['password']))) {
		header('Location: index.php');
		exit();

	}

//Obsługa połączenia
include "dbconnect.php";

			//Pobrane z formularza index.php
			$username = $_POST['username'];
			$password = $_POST['password'];

			//tymczasowa bramka zapobiegająca injection
			$username = htmlentities($username, ENT_QUOTES, "UTF-8");


			if($result = @$connection->query(sprintf("SELECT * FROM users WHERE username = '%s'",
			mysqli_real_escape_string($connection, $username))))
			//blad zapytania przyjmuje false dla blednego zapytania
			{
				$number = $result->num_rows;

				if($number>0)
				{
					$index = $result->fetch_assoc();
					//weryfikacja hasha
					if (password_verify($password,$index['password'])) {
						$_SESSION['logged'] = true; //Zmienna zalogowania użytkownika jeśli tak to TRUE

						//Pobranie wartości użytkownika
						$_SESSION['user_id'] = $index['user_id'];
						$_SESSION['username'] = $index['username'];
						$_SESSION['email'] = $index['email'];
						$_SESSION['name'] = $index['name'];
						$_SESSION['surname'] = $index['surname'];

						unset($_SESSION['error']);
						$result->free_result();
						//echo $_SESSION['user_id'];
						header("Location: userpage.php");
					} else {
						//Przesłanie błędu do strony index.php
						$_SESSION['error'] = '<span>BLAD LOGOWANIA</span>';
						header('Location: loginpage.php');
					}


				}

				elseif ($number == 0) {
					header('Location: nouser.html');
				}

				else {

					//Przesłanie błędu do strony index.php
					$_SESSION['error'] = '<span>BLAD LOGOWANIA</span>';
					header('Location: loginpage.php');

				}
			}

			echo "connection successfull";


		$connection->close();


?>
