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
				<h3><a href="teacher_absences.php">Appel</a></h3>
				
				<h3><a href="teacher_ressources.php">Ressources</a></h3>
				<h3><a href="deco.php">Déconnexion</a></h3>
			</div>
		</div>
	</nav>
	
	<body>
		<div class="page">
		<form action="teacher_upload.php" method="post" enctype="multipart/form-data" style="background-color: rgba(255,255,255,0.85); border-radius: 5px; display: inline-block;">
			<table style="margin: 0 auto;">
				<tr>
				<td>Classe : 
				<select name="class">
					<?php
					foreach($_SESSION['classes'] as $class_id){
						$req_classes = $bdd->prepare('SELECT class_name FROM classes WHERE id = :id');
						$req_classes->execute(array(
						'id' => $class_id));
						$class_name = $req_classes->fetch();
					?>
						<option value="<?php echo $class_id;?>"><?php echo $class_name['class_name'];?></option>
					<?php
					}
					?>
					</select></td>
				</tr>
				<tr style="display: block;"><td><textarea name="message" style="width:470px;height:150px;" placeholder="Votre message"></textarea></td></tr>
				<tr style="display: block;"><td>Fichier joint (< 10 Mo) : <input type="file" name="fichier" /></td></tr>
			</table>
			<input type="submit" value="Envoyer ->"/>
		</form>
		</div>
	</body>
</html>