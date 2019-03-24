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
			<div style="margin: 0 auto; background-color: rgba(238,232,170,0.70); width: 55%;">
			<?php
				$req_res = $bdd->prepare('SELECT teacher_id, message, file_id FROM ressources WHERE class_id = :class_id ORDER BY dt DESC');
				$req_res->execute(array(
				'class_id' => $_SESSION['class_id']));
				while($res = $req_res->fetch())
				{
					$req_teacher = $bdd->prepare('SELECT name, subject FROM teachers WHERE id = :id');
					$req_teacher->execute(array(
					'id' => $res['teacher_id']));
					$teacher = $req_teacher->fetch();
			?>
					
					<div class="ressource" style="margin: 0 auto; background-color: rgba(238,232,170,1); border-radius: 5px; display: block; width: 95%;">
						<p style="text-align: left; font-size: 17px;">De : <?php echo $teacher['name'] . " (". $teacher['subject']. ")";?></p>
						<?php echo $res['message']; ?></br>
						<?php 
						if ($res['file_id'] != "")
						{ ?>
						<img src="joint.png"  height="20" width="20"/> : <a href="ressources/<?php echo $res['file_id']; ?>" target="_blank"><?php echo $res['file_id']; ?></a> 
						<?php 
						} ?>
					</div>
		  <?php } ?>
		  </div>
		</div>
	</body>
</html>