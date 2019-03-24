<?php 
	session_start();
	if(!isset($_SESSION['idp']))
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
									<button id="navhover"><a href="teacher_page.php" class="accueil_link"><h1 style="color: #339999;"><?php echo $_SESSION['surname']. " " .$_SESSION['name'] ?></h1><h1>Janson de Sailly</h1></a></button>
			<div id="navlink">
				<h3><a href="teacher_notes.php">Notes</a></h3>
				<h3><a href="teacher_absences.php">Absences</a></h3>
				<h3><a href="">Retards</a></h3>
				<h3><a href="teacher_ressources.php">Ressources</a></h3>
				<h3><a href="deco.php">Déconnexion</a></h3>
			</div>
		</div>
	</nav>
	
	<body>
		<div class="page">
		<strong><h1 style="color: white;">Saisie des notes</h1></strong>
		<form action="teacher_notes_send.php" method="post" style="background-color: #d1fff3; display: inline-block; padding: 5px;">
			<table style="margin: 0 auto;">
				<tr><td><em>Nom évaluation : </em></td><td><input type="text" name="nom_interro"></td></tr>
				<tr><td><em>Coefficient : </em></td><td><input type="text" name="coeff" placeholder="1 par défaut"/></td></tr>
				<tr><td><em>Date :</em></td><td><input type="date" name="date"/></td></tr>
			</table>
			<h3><strong>Notes :</strong></h3>
			<table style="margin: 0 auto;">
		<?php
			
			$req_eleves = $bdd->prepare('SELECT name,surname,id FROM eleves WHERE class_id = :class_id ORDER BY name');
			$req_eleves->execute(array(
			'class_id' => $_POST['class']));
			while($eleve = $req_eleves->fetch())
			{
				$_SESSION['eleves'][]=$eleve['id'];
		?>
			<tr><td><?php echo $eleve['surname'] . " " . $eleve['name'] . " : ";?></td><td><input type="text" onchange='if(this.value > 20 || this.value < 0){this.style.background = "red";}else{this.style.background = "white";}' name="<?php echo $eleve['id'];?>"></input></td></tr>
		<?php
			}
		?>
			</table>
			<input type="hidden" name="storage" value="<?php echo $_POST['class'] ?>">
			<input type="submit" name="Valider"></input>
		</form>
		</div>
	</body>
</html>