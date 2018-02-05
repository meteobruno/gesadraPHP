<?php
include_once('./parametres.php');
try
{
    $bdd = new PDO( DB_PDO_DSN, DB_USERNAME, DB_PASSWORD);
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
require 'envois.php';

  $couleur_date_heure = "white";
  $placeholder_date_heure = "Date et Heure";

if (isset($_POST['valider'])) {
	
  if (!empty($_POST['date_heure'])) {
    # code...
  
	$date_heure = ($_POST['date_heure']);
	$degre_urgence = ($_POST['degre_urgence']);
	$mode_trans = ($_POST['mode_trans']);

	if (!empty($_POST['nv_indicatif_recu_de'])) {
		$recu_de = ($_POST['nv_indicatif_recu_de']);
	}else{
		$recu_de = ($_POST['recu_de']);
	}

	if (!empty($_POST['nv_indicatif_emis_vers'])) {
		$emis_vers = ($_POST['nv_indicatif_emis_vers']);
	}else{
		$emis_vers = ($_POST['emis_vers']);
	}
	
	if(isset($_POST['message'])){
		$message = ($_POST['message']);
	}


	nouvelleMainCourante($bdd, $date_heure, $recu_de, $emis_vers, $degre_urgence, $mode_trans, $message);}
  else{
    $couleur_date_heure = "bisque";
    $placeholder_date_heure = "Merci de remplir ce champ";
}
}


 ?>

<html>
<head>
		<title>Ajouter une main courante</title>
		<meta charset="UTF-8">

		<script type="text/javascript">
function TD(n){

return n.toString().replace(/^(\d)$/,'0$1')
}
function DateLocale(d){
var tabJours={'fr':['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi','Dimanche']
}
var tabMois={'fr':['01', '02', '03', '04', '05', '06','07','08','09','10','11','12']
}

var SysLang=(navigator.userLanguage)?navigator.userLanguage:navigator.language;

switch (SysLang){
case ('fr'): DateLang='fr'
break;
default: DateLang='fr';
}

var Mois=tabMois[DateLang][d.getMonth()]
return d.getDate()+"/"+ Mois +"/"+d.getFullYear()+" "+TD(d.getHours())+":"+TD(d.getMinutes())
}




</script>
<style type="text/css">
.table1
{
    border-collapse: collapse;
}
.td1, .th1
{
    border: 1px solid black;
}
</style>
<script type="text/javascript">
function edition()
    {
    options = "Width=700,Height=700" ;
    window.open( "impression_main_courante.php", "impression_main_courante", options ) ;
    }
</script>
	</head>
<body>
	<form method="POST">
		<table width="100%">
			<tr width="100%"><td colspan="2" style="background-color: orange; color: blue;">
<div align="center"><span style="background: orange; font-size : 18px; color: blue;"><b>Ajouter une main courante</b></span></br></div>
		</td></tr>
		<form method="POST">
			<tr width="100%"><td width="30%">
				Reçu de :</td><td width="70%">
      	<select name="recu_de">
		<?php $sql = "SELECT id, indicatif_membre FROM membres";
if ($res = $bdd->query($sql)) {

   /* Récupère le nombre de lignes qui correspond à la requête SELECT */
   if ($res->fetchColumn() > 0) {

      /* Effectue la vraie requête SELECT et travaille sur le résultat */
      $sql = "SELECT id, indicatif_membre FROM membres";
      foreach ($bdd->query($sql) as $row) {

      echo '
      	<option value="'.$row['indicatif_membre'].'">'.strtoupper($row['indicatif_membre']).'</option>
            ';
      }
   }} ?>
   </select> <b>OU</b> <input type="text" name="nv_indicatif_recu_de" id="nv_indicatif_recu_de" placeholder="Nouvel indicatif">
      	</td></tr>

		<tr width="100%"><td width="30%">
			<tr width="100%"><td width="30%">
				Emis vers :</td><td width="70%">
      	<select name="emis_vers">
		<?php $sql = "SELECT id, indicatif_membre FROM membres";
if ($res = $bdd->query($sql)) {

   /* Récupère le nombre de lignes qui correspond à la requête SELECT */
   if ($res->fetchColumn() > 0) {

      /* Effectue la vraie requête SELECT et travaille sur le résultat */
      $sql = "SELECT id, indicatif_membre FROM membres";
      foreach ($bdd->query($sql) as $row) {

      echo '
      	<option value="'.$row['indicatif_membre'].'">'.strtoupper($row['indicatif_membre']).'</option>
            ';
      }
   }} ?>
   </select> <b>OU</b> <input type="text" name="nv_indicatif_emis_vers" id="nv_indicatif_emis_vers" placeholder="Nouvel indicatif">
      	</td></tr>

		<tr width="100%"><td width="30%">
		Date/Heure :</td><td width="70%">
		<?php echo '<input type="text" style="width : 200px; background-color:'.$couleur_date_heure.';" name="date_heure" id="date_heure" placeholder ="'.$placeholder_date_heure.'">';?> <input id="button" type="button" value="Date et Heure actuelle" onclick="document.getElementById('date_heure').value = (DateLocale(new Date()))" /></td></tr>

		<tr width="100%"><td width="30%">
		Degré d'urgence :</td><td width="70%">
		<select name="degre_urgence">
      	<option value="Routine">Routine</option>
      	<option value="Urgent">Urgent</option>
      	<option value="Immediat">Immediat</option>
      	<option value="Flash">Flash</option>
      	<option value="Sauvetage Vie Humaine">Sauvetage Vie Humaine</option>
      	<option value="Priorité Absolue">Priorité Absolue</option>
      	</select></td></tr>

		<tr width="100%"><td width="30%">
		Mode de transmission :</td><td width="70%">
		<select name="mode_trans">
      	<option value="Radio - Phonie">Radio - Phonie</option>
      	<option value="Radio - APRS">Radio - APRS</option>
      	<option value="Radio - Image">Radio - Image</option>
      	<option value="Radio - Mode numérique">Radio - Mode numérique</option>
      	<option value="Téléphone - Filaire">Téléphone - Filaire</option>
      	<option value="Téléphone - Mobile">Téléphone - Mobile</option>
      	<option value="Mail">Mail</option>
      	<option value="Autre">Autre</option>
      	</select></td></tr>

      	<tr width="100%"><td width="30%">
      		Message :
      	</td><td width="70%">
      	<input type="text" id="message" name="message" placeholder="Message" style="width: 90%">
      </td>
      	</tr>

      	<tr width="100%"><td width="30%">
      		<b>OU</b> Message prédéfini :
      	</td><td width="70%">
      	<input type="radio" name="message_pred" value="se_signale" id="se_signale" onclick="document.getElementById('message').value = 'Se signale sur le réseau'"><label for="se_signale">Se signale</label>

                    <input type="radio" name="message_pred" value="qrt" id="qrt" onclick="document.getElementById('message').value = 'Quitte le réseau'"><label for="qrt">QRT</label>

                    <input type="radio" name="message_pred" value="attente" id="attente" onclick="document.getElementById('message').value = 'Attente'"><label for="attente">Attente</label>

                    <input type="radio" name="message_pred" value="en_route" id="en_route" onclick="document.getElementById('message').value = 'En route vers'"><label for="en_route" >En route...</label>

                    <input type="radio" name="message_pred" value="arrive" id="arrive" onclick="document.getElementById('message').value = 'Arrivé sur les lieux'"><label for="arrive">Arrivé</label>

                    <input type="radio" name="message_pred" value="essai_radio" id="essai_radio" onclick="document.getElementById('message').value = 'Appel pour contrôle de la liaison radio'"><label for="essai_radio">Essai radio</label>

                    <input type="radio" name="message_pred" value="disponbile" id="disponible" onclick="document.getElementById('message').value = 'De nouveau disponible'"><label for="disponible">Disponible</label>

                    <input type="radio" name="message_pred" value="indisponible" id="indisponible" onclick="document.getElementById('message').value = 'Momentanement indisponible'"><label for="indisponible">Indisponible</label>

                    <input type="radio" name="message_pred" value="qsp" id="qsp" onclick="document.getElementById('message').value = 'Demande autorisation pour appeler directement'" onclick="document.getElementById('message').value = 'En route vers'"><label for="qsp">QSP...</label>

                    <input type="radio" name="message_pred" value="aucun_choix" id="aucun_choix"><label for="aucun_choix">Aucun choix</label>
      </td>
      	</tr>

		<tr width="100%"><td colspan="2">
			<div align="center"> <input type="submit" style="margin-top : 10px;" id="valider" name="valider" value="Valider"></br></br></td></div></tr>


	<tr width="100%"><td colspan="2" style="background-color: orange; color: blue;">
<div align="center"><span style="background: orange; font-size : 18px; color: blue;"><b>Dernières transmissions enregistrées</b></span></br></div>
		</td></tr>
		<td colspan="2">
			<div align="center">
			<table class="table1" width="100%">
        <a href="impression_main_courante.php" onclick="edition();return false;">Imprimer la liste</a>
        <thead>
          <tr>
            <th class="th1">Date/Heure</th>
            <th class="th1">De...</th>
            <th class="th1">À...</th>
            <th class="th1">Degré d'urgence</th>
            <th class="th1">Mode de trans.</th>
            <th class="th1">Message</th>
          </tr>
        </thead>
		<?php
		 $sql = "SELECT date_heure, recu_de, emis_vers, degre_urgence, mode_transmission, message FROM main_courante ORDER BY `date_heure` DESC";
if ($res = $bdd->query($sql)) {

   /* Récupère le nombre de lignes qui correspond à la requête SELECT */
   if ($res->fetchColumn() > 0) {

      /* Effectue la vraie requête SELECT et travaille sur le résultat */
      $sql = "SELECT date_heure, recu_de, emis_vers, degre_urgence, mode_transmission, message FROM main_courante ORDER BY `date_heure` DESC";
      foreach ($bdd->query($sql) as $row) {

      		if ($row['degre_urgence'] == "Routine") {
      			$text_color = "black";
      			$bg_color = "white";
      		}
      		elseif ($row['degre_urgence'] == "Urgent") {
      			$text_color = "blue";
      			$bg_color = "white";
      		}
      		elseif ($row['degre_urgence'] == "Immediat") {
      			$text_color = "tomato";
      			$bg_color = "white";
      		}
      		elseif ($row['degre_urgence'] == "Flash") {
      			$text_color = "red";
      			$bg_color = "white";
      		}
      		elseif ($row['degre_urgence'] == "Sauvetage Vie Humaine") {
      			$text_color = "black";
      			$bg_color = "darksalmon";
      		}
      		elseif ($row['degre_urgence'] == "Priorité Absolue") {
      			$text_color = "black";
      			$bg_color = "orangered";
      		}

      print '
      	<tr width="100%" style ="color: '.$text_color.'; background-color: '.$bg_color.';">
      	<td width="16%" class="td1">'.$row['date_heure'].'</td><td width="8%" class="td1">'.strtoupper($row['recu_de']).'</td><td width="8%" class="td1">'.strtoupper($row['emis_vers']).'</td><td width ="15%" class="td1">'.$row['degre_urgence'].'</td><td width="20%" class="td1">'.$row['mode_transmission'].'</td><td width = "33%" class="td1">'.$row['message'].'</td>
            

            </tr>';
      }
   }} ?>
</table></td></table>
		</div>
	</table>
	</form>
</body>
</html>