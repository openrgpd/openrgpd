<?php

include ("connexion/Daos.php");

use DAO\Formulaire\FormulaireDAO;
use DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO;
use metier\formulaire\Formulaire;

session_start();
include("connexion/check_connect.php");
?>

<html>
<head>
<title>Fin</title>
<meta content="text/html" charset="utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="bootstrap/css/screen.css" rel="stylesheet">
<script src="bootstrap/js/bootstrap.min.js"></script> 

<?php
header ("Refresh: 2;URL=index.php");
?>

</head>
<body>
	<div id="container">
		<div id="header"></div><br>
	</div>
	<div class="container">
        <div class="row">
			<div class="col-lg-12">

			<h2>Traitement supprimé, vous allez être redirigé automatiquement</h2>

			<?php 
				 //partie suppression d'un traitement  
					if (isset($_GET['idform'])) {
					/*Supprimer dans table gestionnairedroitacces id_formulaire + id_gestionnaire*/
					$daosupgest=new GestionnaireDroitAccesDAO(); 
						$daosupgest->deleteByFrm(($_GET['idform']));

					/*Supprimer le formulaire  avec id_formulaire*/
						$daosupfrm=new FormulaireDAO(); 
						$daosupfrm->deleteByIdFrm(($_GET['idform']));
					}
			?>  
			</div>
		</div>
	</div>
<?php
include("footer.php");
?>