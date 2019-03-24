<?php
	$bdd = new PDO('mysql:host=localhost;dbname=main;charset=utf8', 'root', 'root');
	$class_name = $_POST['name'];

		$req = $bdd->prepare('INSERT INTO classes (class_name) VALUES (:class_name)');
		$req->execute(array(
		'class_name' => $class_name));
		header("Location: admin.php");
	
?>