<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<title></title>
	</head>
	<body>
		<div class="register_form">
			<p>REGISTER</p>
			<form method="post">
			Login:<br/><input type = "text" name="username" required /><br/>
			Hasło:<br/><input type = "password" name="password" required  /><br/>
			email:<br/><input type = "email" name="email"  required /><br/>
			name:<br/><input type = "text" name="name" /><br/>
			surname:<br/><input type = "text" name="surname" /><br/>
			<input type="submit" values="register" />
			</form>
		</div>
	</body>
</html>

<?php

	session_start();

	if (isset($_POST['$username'])) {

	}
	require_once "connect.php";//dane do polaczenia

	$ok = true;
	$connection = new mysqli($host, $db_user,$db_password,$db_name);

		if($connection->connect_errno)
		{
			echo "ERROR:".$connection->connect_errno."OPIS: ".$connection->connect_errno;
		}
		else
		{

			//bidnowanie i przygotowanie zapytania
			$stm = $connection->prepare("INSERT INTO users (username, password, email, name, surname) VALUES (?,?,?,?,?)");
			$stm->bind_param("sssss",$username, $password_hash, $email, $name, $surname);

			$username = $_POST['username'];
			if (ctype_alnum($username)==false) {
				echo "Nazwa uzytkownika moze zawierac tylko z liter bez znakow specjalnych";
				$ok = false;
			}
			$password = $_POST['password'];
			$password_hash = $password;//haszowanie hasła
			$email = $_POST['email'];
			$name = $_POST['name'];
			$surname = $_POST['surname'];

			if ($ok == true) {
				$stm->execute();

				echo "User added succesfully";
			}
			else {

			}

			$stm->close();
			$connection->close();

		}


?>
