<?php
	session_start();

	if (!isset($_SESSION['logged'])) {
		header('Location: index.php');
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

		<div class="userpage">
			<h1>Witaj <?php echo $_SESSION['username'] ; ?></h1>

			<table>
				<tr>
					<td>e-mail:</td>
					<td><?php echo $_SESSION['email']; ?></td>
				</tr>
				<tr>
					<td>Imię:</td>
					<td><?php echo $_SESSION['name']; ?></td>
				</tr>
				<tr>
					<td>Nazwisko:</td>
					<td><?php echo $_SESSION['surname']; ?></td>
				</tr>
				<tr>
					<td>id:</td>
					<td><?php echo $_SESSION['user_id']; ?></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td><a href="edit.html">edytuj</a></td>
				</tr>
			</table>
		</div>

<br>

		<div class="to_feedback">
			<a href="feedbackpage.php">Feedback</a>
		</div>

		<div class="logout">
			<p><a href="logout.php">Wyloguj</a></p>
		</div>

</body>
</html>
