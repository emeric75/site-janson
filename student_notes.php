<?php 
	session_start(); 
	error_reporting(0);
	if(!isset($_SESSION['ide']))
	{
		header('Location: check.php');
	}
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u930540763_main;charset=utf8', 'u930540763_goupl', 'goupilcoins');
	include("fsphp/php-wrapper/fusioncharts.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Goupil-jcvd Notes</title>
		<link rel="icon" href=""/>
		<link rel="stylesheet" href="index.css"/>
		<script type="text/javascript" src="fusioncharts/js/fusioncharts.js"></script>
	</head>
	
	<nav>
		<div id="nav">
			<button id="navhover"><a href="student_page.php" class="accueil_link"><h1 style="color: #339999;"><?php echo $_SESSION['surname']. " " .$_SESSION['name'] ?></h1><h1>Janson de Sailly</h1></a></button>
			<div id="navlink">
				<h3><a href="student_notes.php">Notes</a></h3>
				<h3><a href="student_absences.php">Vie scolaire</a></h3>
				<h3><a href="student_ressources.php">Ressources</a></h3>
				<h3><a href="deco.php">Déconnexion</a></h3>
			</div>
		</div>
	</nav>
	
	<body>
		<div class="page">
			<div></div>
			<table style="margin: 0 auto; border: 2px solid black;background-color: white;">
				<tr><td colspan="3" style="border-bottom: 2px solid black;"><h1 style="color: black;"><?php echo $_SESSION['surname']. " " . $_SESSION['name']. " (". $_SESSION['class_name'] .")"?></h1></td></tr>
				<tr style="background-color: #66ffcc;"><th style="font-size: 15px; text-align: left;">Discipline</th><th style="font-size: 15px; text-align: left;">Notes</th><th style="font-size: 15px; text-align: left;">Moyenne</th></tr>
				<?php
					$req_profs = $bdd->prepare('SELECT id,name,subject FROM teachers WHERE id IN(SELECT teacher_id from teachersclasses WHERE class_id = :class_id)');
					$req_profs->execute(array(
					'class_id' => $_SESSION['class_id']));
					$i = 0;
					while($discipline = $req_profs->fetch())
					{
						$sigma_note = 0;
						$data = array();
						$req_notes=$bdd->prepare('SELECT id, note, coeff, nom_interro, date, date_format(date, "%d/%m") as date_aff, moyenne FROM notes WHERE teacher_id = :teacher_id AND student_id = :student_id ORDER BY date');
						$req_notes->execute(array(
						'teacher_id' => $discipline['id'],
						'student_id' => $_SESSION['ide']));
				?>
							<tr>
								<td style="text-align: left;"><?php echo $discipline['subject'];?><br/>
								  <div style="font-size: 12px;"><strong><?php echo $discipline['name'];?></strong></div></td>
								<td style="text-align: left;">
								
								<?php 
									while($note = $req_notes->fetch(PDO::FETCH_ASSOC))
									{
										
										$data[] = $note;
										if ($note['coeff'] != 1){
											if($note['note'] < 10)
											{
								?>
												<p class="note"><strong><?php echo $note['note'];?><sub><?php echo $note['coeff']."  ";?></sub></strong></p>
								<?php
											}else
											{
								?>
												<p class="note"><?php echo $note['note'];?><sub><?php echo $note['coeff']. "  ";?></sub></p>
								<?php
											}
										}else
										{
											if($note['note'] < 10)
											{
								?>
												<p class="note"><strong><?php echo $note['note']. "  ";?></strong></p>
								<?php
											}else
											{
								?>
												<p class="note"><?php echo $note['note']. "  "; ?></p>
								<?php
											}
										}
										if($note['note'] == 'Abs')
										{
										
										}else
										{
											$preM += $note['note'] * $note['coeff'];
											$mcount += $note['coeff'];
										}
								?>
										
								<?php
									} 
                                                                        if($data == array()){
                                                                              $moyenne = NULL;
									}else{
                                                                              $moyenne = round($preM / $mcount, 2);
                                                                        }
									
								?>
								</td>
								<td><?php if ($moyenne == NULL || $moyenne == 0){echo "Ø";}else{echo $moyenne;} ?></td>
							</tr>
							
				<?php		
						$preM = 0;
						$mcount= 0;	
						$labels = array();
						$values = array();
						$values[0]['seriesname'] = "Note élève";
						$values[1]['seriesname'] = "Note moyenne classe";
						foreach($data as $row)
						{
							$labels[0]['category'][]['label'] =  $row['nom_interro']."<br/>".$row['date_aff'];
							$values[0]['data'][]['value'] = $row['note'];
							$values[1]['data'][]['value'] = $row['moyenne'];
                                                        
                                                           $sigma_moyenne += $row['moyenne']*$row['coeff'];
							   $sigma_coeff += $row['coeff'];
							   $sigma_note += 1;   
                                                        
						}
						$largeur = 500 + 50*$sigma_note;
						$moyenne_c = round($sigma_moyenne / $sigma_coeff, 2);
						$moyennes_e[$discipline['subject']] = $moyenne;
						$moyennes_c[$discipline['subject']] = $moyenne_c;
						$labels_encoded = json_encode($labels);
						$labels_encoded = '"categories":'. $labels_encoded ;
						$values_encoded = json_encode($values);
						$values_encoded = '"dataset":'.$values_encoded;
						$chart_info = '{"chart": {
							"caption": "'. $discipline['subject'] . " / ". $discipline['surname']." ".$discipline['name']. '",
							"yAxisMaxValue" : "20", 
							"exportEnabled" :"1",
							"theme": "fint"
						},';
						$trend = ',"trendlines": [
									{
										"line": [
											{
												"startvalue": "'.$moyenne.'",
												"valueonright": "1",
												"color": "7ca5c5",
												"displayvalue": "Moyenne élève '.$moyenne.'",
												"showontop": "0",
												"thickness": "2",
											},
									
										 
											{
												"startvalue": "'.$moyenne_c.'",
												"valueonright": "0",
												"color": "b8900a",
												"displayvalue": "'.$moyenne_c.' Moyenne classe",
												"showontop": "0",
												"thickness": "2",
												"dashed": "1",
												"dashGap": "10",
												"dashLen": "10",
											}
										
										
									
									]}]';
						$data_encoded = $chart_info . $labels_encoded . "," . $values_encoded . $trend . "}";
						$columnChart = new FusionCharts('msline', "ex" .$i , $largeur, 400, "chartContainer". $i, "json", $data_encoded);
						$columnCharts[] = $columnChart;
						$i += 1;
					}
				?>
				
			
				
				<?php
					foreach($moyennes_e as $moy)
					{
                                                if($moy == NULL){
                                                }else{
						$sigma_moy += $moy;
						$sigma += 1;
                                                }
					}
					foreach($moyennes_c as $moy_c)
					{
                                                if($moy_c == NULL){
                                                }else{
						$sigma_moy_c += $moy_c;
						$sigma_c += 1;
                                                }
					}
					$moy_g = round($sigma_moy / $sigma,2);
					$moy_g_c = round($sigma_moy_c / $sigma_c,2);
					
					$chart_info_g = '{"chart": {
							"caption": "Moyennes année",
							"yaxismaxvalue" : "20", 
							"exportEnabled" :"1",
							"theme": "fint"
					},';
					
					$data_g = '"data":[{"label" : "Elève", "value": "'.$moy_g.'"},{"label":"Classe", "value":"'.$moy_g_c.'"}]}';
					$gChart = new FusionCharts('column2d', "g" , 500, 400, "chartContainerg", "json", $chart_info_g.$data_g);
					$gChart->render();
				?>
				<tr>
					<td colspan="2"  style="background-color: #FF96FF;"><strong>Moyenne générale</strong></td>
					<td><strong><?php if($moy_g != 0 || $moy_g != NULL){echo round($moy_g,2);}else{echo "Ø";} ?></strong></td>
				</tr>
				</table>
				
				<br/>
				
				<?php
					$i=0;
					foreach($columnCharts as $chart)
					{
				?>
						<div id="<?php echo "chartContainer" . $i;?>"></div>
						<br/>
				<?php
						$i +=1;
						$chart->render();
					}
					$i =0;
				?>
				
				<br/>
				
				<div id="chartContainerg"></div>
		</div>
	</body>
</html>
	