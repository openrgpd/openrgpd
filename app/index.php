<?php 
// Utilisation et démarrage des sessions
session_start();
include ("connexion/Daos.php");
?>
<html lang="fr">
<head>
<meta content="text/html" charset="utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="bootstrap/css/bootstrap.css" rel="stylesheet"> 
<!--source pour le modal https://www.w3schools.com/bootstrap/bootstrap_modal.asp et https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_modal&stacked=h-->
<script src="bootstrap/js/jquery.js"></script>
<script src="bootstrap/js//bootstrap.min.js"></script>
<link href="bootstrap/css/screen.css" rel="stylesheet">
<title>RGPD connexion</title>

</head>
<body>

<?php

use DAO\Formulaire\FormulaireDAO;
use metier\utilisateur\Utilisateur;
use DAO\Utilisateur\UtilisateurDAO;
use DAO\Droit\DroitDAO;

if (!empty($_SESSION['identifiant'])) {
	//header('Location: visu.php');
	echo "<script type='text/javascript'>document.location.replace('visu.php');</script>";

	} else {
	if (isset($_POST["validerConnexion"])){
		if (!empty($_POST["loginConnexion"])){
			$recupLogin=$_POST["loginConnexion"];
			$_SESSION["loginConnexion"]=$recupLogin;
		} else {
		$recupLogin="";
		}
		if (!empty($_POST["mdpConnexion"])){
			$recupMdp=$_POST["mdpConnexion"];
			$_SESSION["mdpConnexion"]=$recupMdp;
		} else {
			$recupMdp="";
		}
		$util= new Utilisateur("", "", $recupLogin, $recupMdp,"","","");
		
		if (!$util->utilisateur_est_connecte()){
			$util->valideConnexion($recupMdp);
		} else {
			$util->valideConnexion($recupMdp);
		}
	}
}
?>

<div id="container">
	<div id="header">
	</div> <!-- Header -->   
</div> <!-- container -->
<br>
<div class="container">
	<form method="post" class="form-horizontal" name="connexion" action="">
	<div class="row">
		<div class="bs-example">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h1 class="text-center">Connexion</h1>
					<h6 class="text-center">Déclaration des traitements RGPD</h6>
				</div>
				<div class="panel-body">	
					<div class="col-lg-6">
						<fieldset>	
       					<label> Votre login :</label>
       					<input type="text" class="form-control" name="loginConnexion"><br>
       					<label>Votre mot de passe :</label> 
       					<input type="password" class="form-control" name="mdpConnexion"><br>
       		 
       					<button type="submit" class="btn btn-success btn-lg" name="validerConnexion" >Valider</button>

 						<h4><a href="initcompte.php">Demander à réinitialiser le mot de passe</a></h4>
						</fieldset>	
					</div>
				</div>
			</div>
		</div>
	</div>
      </form>
</div>  

<?php 
include ("footer.php");
?>                 