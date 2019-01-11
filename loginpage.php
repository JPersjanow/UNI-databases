<?php
	session_start();
	if (isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
		header('Location: userpage.php');
		exit();
	}
 ?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<title> Juwenalia Gdańskie - Witaj</title>
</head>

<body>
		<div class="login_form">
			<p>LOGIN</p>
			<form  action="login.php" method="post">
			Login:<br /><input type="text" name="username" required/><br />
			Hasło:<br /><input type="password" name="password" required /><br />
			<input type = "submit" values = "login" />
			</form>
		</div>

<?php
	if (isset($_SESSION['error'])) {
		echo $_SESSION['error'];
	}

 ?>

		<br>
		<div class="not_user_info">
			<h1>NOT A USER? REGISTER BELOW</h1>
			<a href="register.php">Zarejestruj</a>
		</div>



</body>
</html>
