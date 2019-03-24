<?php
	session_start(); 
	if(!isset($_SESSION['idp']))
	{
		header('Location: check.php');
	}
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
	
	foreach(array_unique($_SESSION['eleves']) as $mod)
	{
		if($_POST[$mod] == "Abs" || $_POST[$mod] == '' || $_POST[$mod] == NULL){
			
		}else{
			$notes += $_POST[$mod];
			$nb_eleves += 1;
		}
	}
	$moyenne = $notes / $nb_eleves;
	echo $moyenne;
	foreach(array_unique($_SESSION['eleves']) as $mod)
	{
		$req_mod = $bdd->prepare('UPDATE notes SET nom_interro = :new_nom_interro, date = :date, note = :note, coeff =:coeff, moyenne = :moyenne WHERE student_id= :student_id AND nom_interro = :nom_interro');
		$req_mod->execute(array(
		'student_id' => $mod,
		'nom_interro' => $_POST['nom_interro'],
		'date' => $_POST['date'],
		'note' => $_POST[$mod],
		'coeff' => $_POST['coeff'],
		'moyenne' => round($moyenne, 2),
		'new_nom_interro' => $_POST['new_nom_interro']));
	}
	
	header('Location: teacher_notes.php?edit=1');
?>