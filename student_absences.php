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
					$req_absences = $bdd->prepare("SELECT date_format(date, '%d/%m/%Y %H:%i') as date, motif, excused, is_retard, retard_time FROM absences WHERE student_id = :student_id ORDER BY date");
					$req_absences->execute(array(
					'student_id' => $_SESSION['ide']));
					$i = 0;
					$j = 0;
					$k = 0;
					while($absence = $req_absences->fetch())
					{
						if($absence['is_retard'] == 0){
							$array_absence[$j]['date'] = $absence['date'];
							$array_absence[$j]['motif'] = $absence['motif'];
							$array_absence[$j]['excused'] = $absence['excused'];
							$j = $j + 1;
						}else
						{
							$array_retard[$k]['date'] = $absence['date'];
							$array_retard[$k]['motif'] = $absence['motif'];
							$array_retard[$k]['excused'] = $absence['excused'];
							$array_retard[$k]['retard_time'] = $absence['retard_time'];
							$k = $k + 1;
						}
					}
					if($array_absence == array()){
						echo "<h2 style='background-color: rgba(255,255,255,0.65); border-radius: 5px; display: inline-block;'>Aucune absence</h2>";
					}else{
						echo "<table style='margin: 0 auto; background-color: rgba(255,255,255,0.65); border-radius: 5px;'>
				<tr><th>Date</th><th>Motif</th><th>Excusé ?</th></tr>";
						foreach($array_absence as $abs){
				?>
					<tr><td><?php echo $abs['date'];?></td><td><?php echo $abs['motif'];?></td><td><?php if($abs['excused'] == 1){echo "Oui";}else{echo "Non";}?></td></tr>
				<?php
					echo "</table>";
					}}
					if($array_retard == array())
					{
						echo "<h2 style='background-color: rgba(255,255,255,0.65); border-radius: 5px; display: inline-block;'>Aucun retard</h2>";
					}else
					{
						echo "<table style='margin: 0 auto; background-color: rgba(255,255,255,0.65); border-radius: 5px;'>
				<tr><th>Date</th><th>Motif</th><th>Durée</th><th>Excusé ?</th></tr>";
						foreach($array_retard as $ret){
				?>
					<tr><td><?php echo $ret['date'];?></td><td><?php echo $ret['motif'];?></td><td><?php echo $ret['retard_time'].'\'';?></td><td><?php if($ret['excused'] == 1){echo "Oui";}else{echo "Non";}?></td></tr>
				<?php
					}
					}
				?>
			</table>
		</div>
	</body>
</html>