<?php
	session_start(); 
	if(!isset($_SESSION['idp']))
	{
		header('Location: check.php');
	}
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');

	if( strpos($_GET['note'], ',') !== false)
    {
		$_GET['note'] = str_replace(',','.',$_GET['note']);
    }

	$req_mod = $bdd->prepare('UPDATE notes SET note = :note WHERE student_id = :student_id AND nom_interro = :nom_interro');
	$req_mod->execute(array(
	'student_id' => $_GET['student_id'],
	'nom_interro' => $_GET['nom_interro'],
	'note' => $_GET['note']));
	$req_moyenne = $bdd->prepare('SELECT note FROM notes WHERE nom_interro = :nom_interro AND class_id = :class_id');
	$req_moyenne->execute(array(
	'nom_interro' => $_GET['nom_interro'],
	'class_id' => $_GET['class_id']));
	
	$smoyenne = 0;
	$nbel = 0;
	while($note = $req_moyenne->fetch()){
		if($note['note'] == "" || $note['note'] == NULL){
		
		}else{
			$smoyenne += $note['note'];
			$nbel += 1;
		}
	}
	$moyenne = $smoyenne / $nbel;
	$req_send_moy = $bdd->prepare('UPDATE notes SET moyenne = :moyenne WHERE nom_interro = :nom_interro AND class_id= :class_id');
	$req_send_moy->execute(array(
	'moyenne' => round($moyenne,2),
	'nom_interro' => $_GET['nom_interro'],
	'class_id' => $_GET['class_id']));
?>