<?php
// EDIT INFOS INTERRO
	session_start(); 
	if(!isset($_SESSION['idp']))
	{
		header('Location: check.php');
	}
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
	
	if($_GET['info_type'] == 1)
	{
		$info_req = $bdd->prepare('UPDATE notes SET nom_interro = :new_nom_interro WHERE nom_interro = :nom_interro');
		$info_req->execute(array(
		'nom_interro' => $_GET['old_info'],
		'new_nom_interro' => $_GET['new_info']));
	}
	if($_GET['info_type'] == 2)
	{
		$info_req = $bdd->prepare('UPDATE notes SET coeff = :new_nom_interro WHERE coeff = :nom_interro');
		$info_req->execute(array(
		'nom_interro' => $_GET['old_info'],
		'new_nom_interro' => $_GET['new_info']));
	}
	if($_GET['info_type'] == 3)
	{
		$info_req = $bdd->prepare('UPDATE notes SET date = :new_nom_interro WHERE date = :nom_interro');
		$info_req->execute(array(
		'nom_interro' => $_GET['old_info'],
		'new_nom_interro' => $_GET['new_info']));
	}
?>