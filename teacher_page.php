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
		<script>
			function display_class(){
				<?php
					$req_classlist = $bdd->prepare('SELECT surname,name FROM eleves WHERE class_id = :id');
					//$req_classlist->execute((array(
					//'id' => ));
				?>
			}
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
                     <div style="background-color: white; display: inline-block;">
			<div style="display: block;"><h1 style="color: black; display: inline;">Bienvenue </h1><h1 style="color: #55bbbb; display: inline;"><?php echo $_SESSION['surname']. " " .$_SESSION['name'] ?></h1></div>
			
			
			<div style="display: inline-block;">
			<?php
				$_SESSION['classes'] = array();
				$_SESSION['classes_names'] = array();
				$req_cl = $bdd->prepare('SELECT id,class_name FROM classes WHERE id IN(SELECT class_id FROM teachersclasses WHERE teacher_id = :teacher_id)');
				$req_cl->execute(array(
				'teacher_id' => $_SESSION['idp']));
							
				while($resultats = $req_cl->fetch())
				{
					$_SESSION['classes'][]= $resultats['id'];	
					$_SESSION['classes_names'][]= $resultats['class_name'];
			?>
					<h2 id="<?php echo $resultats['class_id'];?>" onclick="display_class()" style="color: #338888; border: 4px solid #227777; display: inline-block; margin: 10px; padding: 3px;"><?php echo $resultats['class_name']; ?></h2><br/>
			<?php	
				}
				$_SESSION['classes'] = array_unique($_SESSION['classes']);
				$_SESSION['classes_names'] = array_unique($_SESSION['classes_names']);
			?>
                        </div>
			</div>
		</div>
	</body>
</html>	