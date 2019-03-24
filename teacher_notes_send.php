<?php 
	session_start(); 
	if(!isset($_SESSION['idp']))
	{
		header('Location: check.php');
	}
	print_r($_SESSION['eleves']);
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
	$array_moyenne = array_diff($_POST, array("nom_interro" => $_POST['nom_interro'], "storage" => $_POST['storage'], "coeff" => $_POST['coeff'], "Valider" => $_POST['Valider'], "date" => $_POST['date']));
	$insert_note = $bdd->prepare("INSERT INTO `notes` (
					`id` ,
					`student_id` ,
					`class_id` ,
					`nom_interro` ,
					`teacher_id` ,
					`note`,
					`coeff`,
					`moyenne`,
					`date`
					)
					VALUES (
					NULL ,  :student_id, :class_id, :nom_interro,  :teacher_id,  :note, :coeff, :moyenne, :date
					);");
	if($_POST['coeff'] == ""){
		$_POST['coeff'] = 1;
	}
	$notes = 0;
	$nb_eleves = 0;
	foreach($_SESSION['eleves'] as $el_id)
	{
		if($_POST[$el_id] == "Abs" || $_POST[$el_id] == '' || $_POST[$el_id] == NULL){
			
		}else{
			if( strpos($_POST[$el_id], ',') !== false)
			{
				$_POST[$el_id] = str_replace(',','.',$_POST[$el_id]);
			}
			$notes += $_POST[$el_id];
			$nb_eleves += 1; 
		}	
	}
	echo $notes;
	echo $nb_eleves;
	$moyenne = $notes / $nb_eleves;
	foreach($_SESSION['eleves'] as $eleve_id){
			$insert_note->execute(array(
			'student_id' => $eleve_id,
			'class_id' => $_POST['storage'],
			'teacher_id' => $_SESSION['idp'],
			'nom_interro' => $_POST['nom_interro'],
			'note' => $_POST[$eleve_id],
			'coeff' => $_POST['coeff'],
			'moyenne' => round($moyenne, 2),
			'date' => $_POST['date']));
	}

	header('Location: teacher_notes.php?input=1'); 
?>
