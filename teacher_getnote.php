<?php
	session_start(); 
	if(!isset($_SESSION['idp']))
	{
		header('Location: check.php');
	}
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
	
	$req_info_edit = $bdd->prepare('SELECT DISTINCT coeff, date FROM notes WHERE nom_interro = :nom_interro AND class_id = :class_id');
	$req_info_edit->execute(array(
	'nom_interro' => $_GET['nom_interro'],
	'class_id' => $_GET['class_id']));
	$infos = $req_info_edit->fetch();
	
	$req_edit = $bdd->prepare("SELECT student_id, note FROM notes WHERE nom_interro = :nom_interro AND class_id = :class_id");
	$req_edit->execute(array(
	'nom_interro' => $_GET['nom_interro'],
	'class_id' => $_GET['class_id']));

	
				
?>
<table style="margin: 0 auto;">
				<tr><td><em>Nom évaluation : </em></td><td><input type="text" name="nom_interro" value="<?php echo $_GET['nom_interro'];?>" id="nom_interro" onchange="editInfo(<?php echo $_GET['nom_interro'];?>,this.value, 1);"/></td></tr>
				<tr><td><em>Coefficient : </em></td><td><input type="text" name="coeff" value="<?php echo $infos['coeff'];?>" onchange="editInfo(<?php echo $infos['coeff'];?>,this.value, 2);"/></td></tr>
				<tr><td><em>Date :</em></td><td><input type="date" name="date" value="<?php echo $infos['date'];?>" onchange="editInfo(<?php echo $infos['date'];?>,this.value, 3);"/></td></tr>
				<tr><td colspan="2">                   </td></tr>
				<?php
				while($elnote = $req_edit->fetch())
				{
					$req_name = $bdd->prepare("SELECT surname, name FROM eleves WHERE id = :id");
					$req_name->execute(array(
					'id' => $elnote['student_id']));
					$name = $req_name->fetch();
				?>
				<tr><td><?php echo $name['surname']." ".$name['name']." : " ;?></td><td><input type="text" name="<?php echo $elnote['student_id'];?>" value="<?php echo $elnote['note']; ?>" id="<?php echo $_GET['class_id']; ?>" onchange="editNote(document.getElementById('nom_interro').value, this.name, this.value, this.id);"/></td></tr>
				<?php
					}
				?>
</table>