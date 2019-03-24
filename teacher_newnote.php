<?php 
	session_start(); 
	if(!isset($_SESSION['idp']))
	{
		header('Location: check.php');
	}
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
	
	$req_eleves = $bdd->prepare('SELECT name,surname,id FROM eleves WHERE class_id = :class_id ORDER BY name');
	$req_eleves->execute(array(
	'class_id' => $_GET['class_id']));
			
?>

			<table style="margin: 0 auto;">
				<tr><td><em>Nom évaluation : </em></td><td><input type="text" name="nom_interro"></td></tr>
				<tr><td><em>Coefficient : </em></td><td><input type="text" name="coeff" placeholder="1 par défaut"/></td></tr>
				<tr><td><em>Date :</em></td><td><input type="date" name="date"/></td></tr>
			</table>
			<h3><strong>Notes :</strong></h3>
			<table style="margin: 0 auto;">
<?php
	while($eleve = $req_eleves->fetch())
	{
	$_SESSION['eleves'][]=$eleve['id'];
?>
			<tr><td><?php echo $eleve['surname'] . " " . $eleve['name'] . " : ";?></td><td><input type="text" onchange='if(this.value > 20 || this.value < 0){this.style.background = "red";}else{this.style.background = "white";}' name="<?php echo $eleve['id'];?>"></input></td></tr>
<?php
	}
?>
	<input type="hidden" name="storage" value="<?php echo $_GET['class_id'] ?>">
	<input type="submit" name="Valider"></input>