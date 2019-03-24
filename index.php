<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Goupil-jcvd Notes</title>
		<link rel="icon" href=""/>
		<link rel="stylesheet" href="index.css"/>
	</head>
	
	<nav>
		<div id="nav">
			<button id="navhover"><h1>Janson de Sailly<h1></button>
		</div>
	</nav>
	
	<body>
		<div class="page">
			<h2 style="color: white;">Se connecter :</h2>
			<form action="check.php" method="post" id="connect" style="display: inline-block;">
				<input type="text" name="id" placeholder="Identifiant"/>
				<input type="password" name="mdp" placeholder="Mot de passe"/>
				<input type="submit" value="Connexion"/>
			</form>	
			<br/>
			<?php
				if($_GET['deco'] == 1){
			?>
					<h4 style="border-radius: 25px;background: rgba(255,0,0,0.65);padding: 10px;width:250px; margin: auto;">Vous avez bien été déconnecté</h4>
			<?php
				}
			?>
		</div>
	</body>
</html>