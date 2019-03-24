<?php 
	session_start(); 
	if(!isset($_SESSION['idp']))
	{
		header('Location: check.php');
	}
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Goupil-jcvd Notes</title>
		<link rel="icon" href=""/>
		<link rel="stylesheet" href="index.css"/>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script>
				var i;
				function getNotes(str,class_id) {
					document.getElementById("req_ok").innerHTML = "";
					i = 0;
					if (str == "") {
						return;
					} else { 
						if (window.XMLHttpRequest) {
							// code for IE7+, Firefox, Chrome, Opera, Safari
							xmlhttp = new XMLHttpRequest();
						} else {
							// code for IE6, IE5
							xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange = function() {
							if (this.readyState == 4 && this.status == 200) {
								document.getElementById("noteedit").innerHTML = this.responseText;
								
							}
						};
						xmlhttp.open("GET","teacher_getnote.php?nom_interro="+str+"&class_id="+class_id,true);
						xmlhttp.send();
					}
				}
				
				function editNote(nom_interro,student_id,note,class_id){
					if (window.XMLHttpRequest) {
							// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
							// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							i = i+1;
							document.getElementById("req_ok").innerHTML = i + " note(s) éditées " + this.responseText;
							
						}
					};
					xmlhttp.open("GET","teacher_editnote.php?nom_interro="+nom_interro+"&student_id="+student_id+"&note="+note+"&class_id="+class_id,true);
					xmlhttp.send();
				}
				
				function editInfo(old_info,new_info,info_type){
					if (window.XMLHttpRequest) {
							// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
							// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("req_ok").innerHTML = i + " note(s) éditées " + this.responseText;
							
						}
					};
					xmlhttp.open("GET","teacher_editinfo.php?old_info="+old_info+"&new_info="+new_info+"&info_type="+info_type,true);
					xmlhttp.send();
				}
				
				function newNote(class_id){
					if (window.XMLHttpRequest) {
							// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
							// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("newnote").innerHTML = this.responseText;
							
						}
					};
					xmlhttp.open("GET","teacher_newnote.php?class_id="+class_id,true);
					xmlhttp.send();
				}
	</script>
	</head>
	
	<nav>
		<div id="nav">
						<button id="navhover"><a href="teacher_page.php" class="accueil_link"><h1 style="color: #339999;"><?php echo $_SESSION['surname']. " " .$_SESSION['name'] ?></h1><h1>Janson de Sailly</h1></a></button>
			<div id="navlink">
				<h3><a href="teacher_notes.php">Notes</a></h3>
				<h3><a href="teacher_absences.php">Appel</a></h3>
				
				<h3><a href="teacher_ressources.php">Ressources</a></h3>
				<h3><a href="deco.php">Déconnexion</a></h3>
			</div>
		</div>
	</nav>
	<body>
		<div class="page">
            <div style="background-color: white; display: inline-block;">
			<div style="display: block;"><h1 style="color: #339999; display: inline;">Mes classes :</h1></div>
			<?php
				if($_GET['input'] == 1)
				{
			?>
					<h4 style="border-radius: 2px;background: rgba(0,255,0,0.65);padding: 5px;width:155px; margin: auto;">Notes enregistrées !</h4><br/>
			<?php
				}
				if($_GET['edit'] == 1)
				{
			?>
					<h4 style="border-radius: 2px;background: rgba(0,255,0,0.65);padding: 5px;width:155px; margin: auto;">Notes éditées !</h4><br/>
			<?php
				}
			?>
				<form action="teacher_notes_input.php" method="post">
				<select name="class" id="class_select">
							<option value="selection">--Choisissez la classe--</option>
					<?php
					foreach($_SESSION['classes'] as $class_id)
					{
						
						$req_classes = $bdd->prepare('SELECT class_name FROM classes WHERE id = :id');
						$req_classes->execute(array(
						'id' => $class_id));
						$class_name = $req_classes->fetch();
					//	foreach($_SESSION['classes_names'] as $class_name){
					?>
							<option value="<?php echo $class_id;?>"><?php echo $class_name['class_name'];?></option>
					<?php
					}
					?>
					
					
				</select>
				<input type="submit" value = "Ajouter une note ->"/>
				<!--<input type="submit" value="Classe ->" onclick="newNote($('#class_select').val());"></input>-->
			</form>
			
			<table style="margin: 0 auto; background-color:white;">
			<?php
				$req_tests=$bdd->prepare('SELECT DISTINCT nom_interro FROM notes WHERE teacher_id = :teacher_id AND class_id = :class_id ORDER BY date');
				foreach($_SESSION['classes'] as $class_id)
				{
					$req_classes->execute(array(
					'id' => $class_id));
					$class_name = $req_classes->fetch();
					echo '<tr><td style="border-radius: 15px; background: rgba(0,0,255,0.70); padding: 10px; margin:auto; color: white;"><strong>' . $class_name['class_name'] . '</strong></td>';
					$req_tests->execute(array(
					'teacher_id' => $_SESSION['idp'],
					'class_id' => $class_id));
					echo "<td><ul>";
					while($interro = $req_tests->fetch())
					{
			?>
						<li>
							<!--<form action='teacher_notes_edit.php' method='post'>-->
								<input type='hidden' name='nom_interro' value="<?php echo $interro['nom_interro'];?>"/>
								<input type='hidden' name='class_id' value="<?php echo $class_id;?>" id="ci"/>
								<input type='hidden' name='class_name' value="<?php echo $class_name['class_name'];?>"/>
								<input type='submit' value="<?php echo $interro['nom_interro'];?>" id="<?php echo $class_id;?>" onclick="getNotes(this.value, this.id)"/>
							<!--</form>-->
						</li>	
			<?php	
					}
					echo "</ul></td></tr>";
				}
				$_SESSION['eleves'] = array();
			?>
			</table>
			
            </div>
			<div id="newnote" style="background-color: white; display: none;">
				<strong><h1 style="color: white;">Saisie des notes</h1></strong>
				<form action="teacher_notes_send.php" method="post" style="background-color: #d1fff3; display: inline-block; padding: 5px;">
				<table style="margin: 0 auto;">
					<tr><td><em>Nom évaluation : </em></td><td><input type="text" name="nom_interro"></td></tr>
					<tr><td><em>Coefficient : </em></td><td><input type="text" name="coeff" placeholder="1 par défaut"/></td></tr>
					<tr><td><em>Date :</em></td><td><input type="date" name="date"/></td></tr>
				</table>
				<h3><strong>Notes :</strong></h3>
				<table style="margin: 0 auto;">
				<?php
			
					$req_eleves = $bdd->prepare('SELECT name,surname,id FROM eleves WHERE class_id = :class_id ORDER BY name');
					$req_eleves->execute(array(
					'class_id' => $_POST['class']));
					while($eleve = $req_eleves->fetch())
					{
						$_SESSION['eleves'][]=$eleve['id'];
						?>
					<tr><td><?php echo $eleve['surname'] . " " . $eleve['name'] . " : ";?></td><td><input type="text" onchange='if(this.value > 20 || this.value < 0){this.style.background = "red";}else{this.style.background = "white";}' name="<?php echo $eleve['id'];?>"></input></td></tr>
						<?php
					}
				?>
				</table>
				<input type="hidden" name="storage" value="<?php echo $_POST['class'] ?>">
				<input type="submit" name="Valider"></input>
				</form>
			</div>
			<div id="newnote" style="background-color: white;"></div>
			<div id="noteedit" style="background-color: white;"></div>
			<div id="req_ok" style="background-color: white;"></div>
		</div>
	</body>
</html>