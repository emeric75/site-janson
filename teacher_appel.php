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
		  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script>   
		$(function() {
$( "#datepicker" ).datepicker({
altField: "#datepicker",
closeText: 'Fermer',
prevText: 'Précédent',
nextText: 'Suivant',
currentText: 'Aujourd\'hui',
monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
weekHeader: 'Sem.',
dateFormat: 'yy-mm-dd',
firstDay: '1'
});
});
		</script>
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
			<form action="teacher_appel_send.php" method="post" style="background-color: rgba(255,255,255,0.85); border-radius: 5px; display: inline-block;">
			<h1>Appel :</h1>
			<em>Date : </em><input type="text" id="datepicker"></input>
			<em>Cours : </em>
			<select name="cours">
				<?php
					$req_periodes = $bdd->query('SELECT id,TIME_FORMAT(debut, "%H:%i") as debut, TIME_FORMAT(fin, "%H:%i") as fin FROM heures_cours');
					while($periode = $req_periodes->fetch())
					{
				?>
						<option value="<?php echo $periode['id'];?>"><?php echo $periode['debut']. "-" . $periode['fin']; ?></option>
				<?php
					}
				?>
			</select>
			<table style="margin: 0 auto;">
			<tr><th>Nom</th><th>Absent</th><th>Retard</th></tr>
		<?php
			$req_eleves = $bdd->prepare('SELECT name,surname,id FROM eleves WHERE class_id = :id ORDER BY name');
			$req_eleves->execute(array(
			'id' => $_POST['class']));
			while($eleve = $req_eleves->fetch())
			{
			$_SESSION['eleve'][] = $eleve['id'];
		?>
			<tr><td><?php echo $eleve['surname'] . " " . $eleve['name'] . " : ";?></td>
			<td><input type="button" class="absent" id="absent<?php echo $eleve['id']; ?>" value="✘" onclick="if(this.value == '✘'){this.value = '✔'; document.getElementById('retard'+<?php echo $eleve['id']; ?>).value = '✘'; document.getElementById('retard_display'+<?php echo $eleve['id']; ?>).style.display = 'none'; document.getElementById('absent_send'+<?php echo $eleve['id']; ?>).value='1';document.getElementById('retard_send'+<?php echo $eleve['id']; ?>).value='0';}else{this.value = '✘'; document.getElementById('absent_send'+<?php echo $eleve['id']; ?>).value='0';}"/><input type="hidden" name="absent<?php echo $eleve['id']; ?>" id="absent_send<?php echo $eleve['id']; ?>" value='0'></td>
			<td><input type="button" class="retard" id="retard<?php echo $eleve['id']; ?>"  value="✘" onclick="if(this.value == '✘'){this.value = '✔'; document.getElementById('retard_display'+<?php echo $eleve['id']; ?>).style.display = 'inline'; document.getElementById('absent'+<?php echo $eleve['id']; ?>).value = '✘'; document.getElementById('retard_send'+<?php echo $eleve['id']; ?>).value='1'; document.getElementById('absent_send'+<?php echo $eleve['id']; ?>).value='0';}else{this.value = '✘'; document.getElementById('retard_display'+<?php echo $eleve['id']; ?>).style.display = 'none'; document.getElementById('retard_time' + <?php echo $eleve['id']; ?>).value = ''; document.getElementById('retard_send'+<?php echo $eleve['id']; ?>).value='0';}"/><input type="hidden" name="retard<?php echo $eleve['id']; ?>" id="retard_send<?php echo $eleve['id']; ?>" value='0'><div id="retard_display<?php echo $eleve['id'];?>" style="display: none;"><input type="number" id="retard_time<?php echo $eleve['id']; ?>" name="retard_time<?php echo $eleve['id']; ?>" min="1" max="60" placeholder="Durée">'</div></td>
			<td><input type="text" name="motif<?php echo $eleve['id']; ?>" placeholder="Motif"/></td></tr>
		<?php
			}
		?>	
			
			</table>
			<input type="submit" name="Appel terminé"></input>
			</form>
			
		</div>
	</body>
</html>