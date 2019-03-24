<?php
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
	$id = htmlspecialchars($_POST['id']);
	$mdp = htmlspecialchars($_POST['mdp']);
	
	$req = $bdd->prepare('SELECT id,name,surname,class_id FROM eleves WHERE c_id = :id AND c_mdp = :mdp');
	$req->execute(array(
		'id' => $id,
		'mdp' => $mdp));
	$resultat = $req->fetch();
	
	$req2 = $bdd->prepare('SELECT id,name FROM teachers WHERE c_id = :id AND c_mdp = :mdp');
	$req2->execute(array(
		'id' => $id,
		'mdp' => $mdp));
	$resultat2 = $req2->fetch();
	
	if ($resultat)
	{
		//echo 'Vous êtes co élève';
		session_start();
		$_SESSION['ide'] = $resultat['id'];
		$_SESSION['name'] = $resultat['name'];
		$_SESSION['surname'] = $resultat['surname'];
		$_SESSION['class_id'] = $resultat['class_id'];
		header('Location: student_page.php');
		
	}elseif ($resultat2){
		//echo 'Vous êtes co prof';
		session_start();
		$_SESSION['idp'] = $resultat2['id'];
		$_SESSION['name'] = $resultat2['name'];
		header('Location: teacher_page.php');
	}else{
		echo 'Mauvais identifiant ou mot de passe !';
	}
	

?>