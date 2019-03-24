<?php $bdd = new PDO('mysql:host=localhost;dbname=main;charset=utf8', 'root', 'root'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>admin</title>
		<link rel="stylesheet" href="index.css"/>
	</head>
	
	<nav>
		<div id="nav">
			<button id="navhover"><h1>La gestion des notes<h1></button>
		</div>
	</nav>
	
	<body>
		<div class="page">
			<h2>Admin</h2>
			<div id="tables">
					<table>
						<tr><th>Classes</th></tr>
						<?php
							$req_classes=$bdd->query('SELECT class_name FROM classes ORDER BY id');
							while($donnees_classes = $req_classes->fetch()){
						?>
						<tr><td><?php echo $donnees_classes['class_name'] ?></td></tr>
						<?php
							}
						?>
						<tr><td><form action="admin_addclass.php"><input type="submit" value="Ajouter +"/></form></td></tr>
					</table>
					
					<table>
						<tr><th>Professeurs</th></tr>
						<?php
							$req_teachers=$bdd->query('SELECT surname, name FROM teachers ORDER BY id');
							while($donnees_teachers = $req_teachers->fetch()){
						?>
						<tr><td><?php echo $donnees_teachers['surname']." ".$donnees_teachers['name'] ?></td></tr>
						<?php
							}
						?>
						<tr><td><form action="admin_addteacher.php"><input type="submit" value="Ajouter +"/></form></td></tr>
					</table>
					
					<table>
						<tr><th>Elèves</th></tr>
						<tr><td>1</td></tr>
						<tr><td>2</td></tr>
						<tr><td>3</td></tr>
						<tr><td>4</td></tr>
						<tr><td>5</td></tr>
						<tr><td>6</td></tr>
						<tr><td><form action="admin_addstudent.php"><input type="submit" value="Ajouter +"/></form></td></tr>
					</table>
			</div>
		</div>
	</body>
</html>