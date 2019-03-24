<?php 
	session_start(); 
	if(!isset($_SESSION['ide']))
	{
		header('Location: check.php');
	}
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
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
			<button id="navhover"><a href="student_page.php" class="accueil_link"><h1 style="color: #339999;"><?php echo $_SESSION['surname']. " " .$_SESSION['name'] ?></h1><h1>Janson de Sailly</h1></a></button>
			<div id="navlink">
				<h3><a href="student_notes.php">Notes</a></h3>
				<h3><a href="student_absences.php">Vie scolaire</a></h3>
				<h3><a href="student_ressources.php">Ressources</a></h3>
				<h3><a href="deco.php">Déconnexion</a></h3>
			</div>
		</div>
	</nav>
	
	<body>
		<div class="page">
			<?php
				$req_class = $bdd->prepare('SELECT class_name FROM classes WHERE id = :id');
				$req_class->execute(array(
				'id' => $_SESSION['class_id']));
				$resultats_class = $req_class->fetch();
				$_SESSION['class_name']=$resultats_class['class_name'];
			?>
			<h1 style="color: #55bbbb; display: inline; background-color: rgba(255,255,255,0.85); border-radius: 5px; padding: 5px;"><?php echo $_SESSION['surname']. " " . $_SESSION['name']. " (".$resultats_class['class_name'] .")"?></h1>
			<div style="position: absolute; right: 0%; top: 0%;"><img src="msgprof.png" alt="12" height="64" width="64"/><img src="msgadmin.png" alt="34" height="64" width="64"/></div>
		</div>
	</body>
</html>