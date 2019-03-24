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
		<h1 style="color: white;">Modifier <?php echo $_POST['nom_interro'];?> (<?php echo $_POST['class_name']; ?>)</h1>
		<form action="teacher_notes_edit_send.php" method="post"  style="background-color: #d1fff3; display: inline-block; padding: 5px;">
		<table style="margin: 0 auto;">
			<?php
				$req_info_edit = $bdd->prepare('SELECT DISTINCT coeff, date FROM notes WHERE nom_interro = :nom_interro AND class_id = :class_id');
				$req_info_edit->execute(array(
				'nom_interro' => $_POST['nom_interro'],
				'class_id' => $_POST['class_id']));
				$infos = $req_info_edit->fetch();
			?>
				<tr><td><em>Nom évaluation : </em></td><td><input type="text" name="new_nom_interro" value="<?php echo $_POST['nom_interro'];?>"></td></tr>
				<tr><td><em>Coefficient : </em></td><td><input type="text" name="coeff" value="<?php echo $infos['coeff'];?>"/></td></tr>
				<tr><td><em>Date :</em></td><td><input type="date" name="date" value="<?php echo $infos['date'];?>"/></td></tr>
				<tr><td colspan="2">                   </td></tr>
			<?php
				$req_edit = $bdd->prepare("SELECT student_id, note FROM notes WHERE nom_interro = :nom_interro AND class_id = :class_id");
				$req_edit->execute(array(
				'nom_interro' => $_POST['nom_interro'],
				'class_id' => $_POST['class_id']));
				
				while($elnote = $req_edit->fetch())
				{
					$req_name = $bdd->prepare("SELECT surname, name FROM eleves WHERE id = :id");
					$req_name->execute(array(
					'id' => $elnote['student_id']));
					$name = $req_name->fetch();
					$_SESSION['eleves'][] = $elnote['student_id'];
			?>
				<tr><td><?php echo $name['surname']." ".$name['name']." : " ;?></td><td><input type="text" class="note_input" name="<?php echo $elnote['student_id'];?>" value="<?php echo $elnote['note']; ?>" onchange='if(this.value > 20 || this.value < 0){this.style.background = "red";}else{this.style.background = "white";}'/></td></tr>
			<?php
				}
			?>
		</table>
			<input type="hidden" name="nom_interro" value="<?php echo $_POST['nom_interro']; ?>" />
			<input type="submit" value="Valider"/>
		</form>
		</div>
	</body>
</html>