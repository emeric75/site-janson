<?php 
	session_start(); 
	if(!isset($_SESSION['idp']))
	{
		header('Location: check.php');
	}
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
	
	echo $_POST['class'];
	echo $_POST['message'];
	
	if($_FILES['fichier']['size'] == 0)
	{
		$req_res = $bdd->prepare('INSERT INTO ressources (class_id, teacher_id, message) VALUES (:class_id, :teacher_id, :message)');
		$req_res->execute(array(
		'class_id' => $_POST['class'],
		'teacher_id' => $_SESSION['idp'],
		'message' => $_POST['message']));
	}else
	{
		if($_FILES['fichier']['size'] < 10485760)
		{
			$extension_upload = strtolower(  substr(  strrchr($_FILES['fichier']['name'], '.')  ,1)  );
			$f_id = md5(uniqid(rand(), true));
			$bdd_file_id = $f_id . "." . $extension_upload;
			$path = "ressources/" . $_FILES['fichier']['name'];
			$upload = move_uploaded_file($_FILES['fichier']['tmp_name'], $path);
			$req_res = $bdd->prepare('INSERT INTO ressources (class_id, teacher_id, message, file_id) VALUES (:class_id, :teacher_id, :message, :file_id)');
			$req_res->execute(array(
			'class_id' => $_POST['class'],
			'teacher_id' => $_SESSION['idp'],
			'message' => $_POST['message'],
			'file_id' => $_FILES['fichier']['name']));
			header('Location: teacher_ressources.php?envoye=1');
		}
		else
		{
			header('Location: teacher_ressources.php?too_big=1');
		}
	}
?>