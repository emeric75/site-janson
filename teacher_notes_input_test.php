<?php 
	session_start();
	$_SESSION['classc'] = & $_POST['class'];
	$bdd = new PDO('mysql:host=localhost;dbname=main;charset=utf8', 'root', 'root');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Goupil-jcvd Notes</title>
		<link rel="icon" href=""/>
		<link rel="stylesheet" href="index.css"/>
	</head>
	
	<nav>
		<div id="nav">
			<button id="navhover"><h1>La gestion des notes<h1></button>
			<div id="navlink">
				<h3><a href="teacher_notes.php">Notes</a></h3>
				<h3><a href="">Absences</a></h3>
				<h3><a href="">Retards</a></h3>
			</div>
		</div>
	</nav>
	
	<body>
		<div class="page">
			<form action="teacher_notes_send_test.php" method="post">
				<input type="submit" name="Valider"></input>
			</form>
		</div>
	</body>
</html>