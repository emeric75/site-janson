<?php 
	session_start(); 
	if(!isset($_SESSION['idp']))
	{
		header('Location: check.php');
	}
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
	print_r($_POST);
	foreach(array_unique($_SESSION['eleve']) as $eleve)
	{
		
		echo $eleve." ".$_POST['absent'.$eleve];
		echo $eleve." ".$_POST['retard'.$eleve];
		if($_POST['absent'.$eleve] == '1')
		{
			$req_abs = $bdd->prepare('INSERT INTO absences (student_id, is_retard, date) VALUES (:student_id, 0, NOW())');
			$req_abs->execute(array(
			'student_id' => $eleve));
		}
		if($_POST['retard'.$eleve] == '1')
		{
			$req_abs = $bdd->prepare('INSERT INTO absences (student_id, is_retard, date, retard_time) VALUES (:student_id, 1, NOW(), :retard_time)');
			$req_abs->execute(array(
			'student_id' => $eleve,
			'retard_time' => $_POST['retard_time'.$eleve]));
		}
	}
	header("Location: teacher_absences.php");
?>