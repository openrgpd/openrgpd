<!DOCTYPE html>
<?php
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use DAO\FormulaireCommentaire\FormulaireCommentaireDAO;
use DAO\Catdonneeformulaire\CatdonneeformulaireDAO;
use DAO\Droit\DroitDAO;
use DAO\entite\EntiteDAO;
use DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO;
use DAO\Formulaire\FormulaireDAO;
use metier\formulaire\Formulaire;
use DAO\Entitepole\EntitepoleDAO;
use DAO\VariableGlobale\VariableGlobaleDAO;
use metier\variableglobale\VariableGlobale;

session_start();
include("connexion/check_connect.php");
include ("connexion/Daos.php");
?>

<html lang="fr">
<head>
	<meta content="text/html" charset="utf8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/jquery-ui.css">
	<script src="bootstrap/js/jquery-1.12.4.js"></script>
	<script src="bootstrap/js/jquery-ui.js"></script>
	<script src="bootstrap/js/datepicker-fr.js"></script>
	<!-- multiselect  -->
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<!-- <script src="bootstrap/js/jquery.js"></script> entre en conflit avec datepicker  -->
	<script src="bootstrap/js/jquery.sumoselect.min.js"></script>
	<link href="bootstrap/css/sumoselect.css" rel="stylesheet">
	<link href="bootstrap/css/screen.css" rel="stylesheet">
	<script type="text/javascript" src="LD/ld_xhr.js"></script>

	<!-- datapicker -->
	<script type="text/javascript"> 
		$(document).ready(){
			$( "#datepicker" ).datepicker({
				altField: "#datepicker",
				closeText: 'Fermer',
				firstDay: 1 ,
				dateFormat: 'yy-mm-dd'
			});
			$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] ); 
		});   
	</script>
	<!-- Multiselect -->
	<script type="text/javascript">
		$(document).ready(function () {
			$('.SlectBox').SumoSelect({
				placeholder: 'This is a placeholder',
				csvDispCount: 3 ,
				outputAsCSV: true ,
				csvSepChar : ','
			});
			var MySelect;
			MySelect = $('.SlectBox').SumoSelect();  
		});
	</script>
	
	<title>RGPD Formulaire</title>
</head>
<body>

<div id="container">
	<a href="visu.php" id="header"></a>
</div> <!-- container -->
<br>

<?php
//selection des modeles disponibles
		$sql="SELECT nomlogiciel, finaliteTraitement, sousFinalite, commentaire, catDonneeTraitee, catPersConcern, destiDonnees, dureeUtiliteAdmi, archivage, 
			transfertHorsUE, donneeSensible, delaiEffacement, consentement FROM formulaire";
		$stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
		$stmt->execute();
		$cptEnt = 0;
		$chaine = "";
        while ($row = $stmt->fetch()) {
			$entite=$row["entite"];
			if ($cptEnt == 0) {
				$chaine = $entite;
			} else {
				$chaine = $chaine." / ".$entite;
			}
			$cptEnt++;
		}
		
?>

<h1>Bientôt disponible </h1>
<?php
include("footer.php");
?>