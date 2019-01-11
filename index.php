<?php
	session_start();

	//sprawdzanie czy zalogowany jest administrator
	if(isset($_SESSION['username']) && ($_SESSION['username'] == 'admin')){
		$admin_logged = true;
	}
 ?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<title> Juwenalia Gdańskie - Witaj</title>
</head>

<body>

	<div class="goto_login">
		<a href="loginpage.php">Zaloguj się</a>
	</div>

	<div class="goto_feedback">
		<a href="feedbackpage.php">Feedback</a>
	</div>



</body>
</html>
