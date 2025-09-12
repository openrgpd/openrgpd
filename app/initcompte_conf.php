<?php 
// Utilisation et démarrage des sessions
include_once("../config.php");
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
<title>RGPD initialisation du compte</title>

</head>
<body>

<?php

use DAO\VariableGlobale\VariableGlobaleDAO;
use metier\variableglobale\VariableGlobale;
use DAO\Utilisateur\UtilisateurDAO;
use metier\utilisateur\Utilisateur;

$mailFrom = Application::MAIL;

if (isset($_GET['mail'])) {
	/**/
	$lien_decrypt=decrypt(md5($mail));
	/* */
	//verif que le login existe
	$daoUtilisateur=new UtilisateurDAO();

	if (!$daoUtilisateur->existMail($_GET['mail'])){
		$message="Cette adresse mail n'existe pas dans l'application.";
		echo '<script type="text/javascript">window.alert("' . $message .'");</script>';
	} else {
		$lien=$_GET['lien'];

if (isset($_POST['validerMdp'])) {
	if (($_POST['mdp']) == ($_POST['mdpC'])) {
		// Mdp hash
		$secure_mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
		$sql = "UPDATE utilisateurs SET mdphache = '$secure_mdp' WHERE mail='$lien_decrypt';";
		$result = mysqli_query($saintave, $sql);
		echo "<script>alert('Le mot de passe est modifié');</script>";
		header("Location: https://rgpd.megalis.bretagne.bzh/");
	} else {
		echo "<script>alert('Les mots de passe ne sont pas identiques');</script>";
		header("Refresh:0");
	}
}
?>
<div class="container">
	<form method="post" class="form-horizontal" name="connexion" action="">
		<div class="row">
			<div class="bs-example">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="text-center">Modification du mot de passe</h2>
					</div>
					<div class="panel-body">	
						<div class="col-lg-6">
							<fieldset>	
							<label>Nouveau Mot de passe :</label> 
							<input type="password" class="form-control" name="mdp" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$" 
							alt="Le mot de passe doit contenir de 8 à 15 caractères, au moins une lettre minuscule/un chiffre/un de ces caractères spéciaux: $ @ % * + - _ !"
							title="Le mot de passe doit contenir de 8 à 15 caractères, au moins une lettre minuscule/un chiffre/un de ces caractères spéciaux: $ @ % * + - _ !" required><br>
							<label>Confirmation du Mot de passe :</label> 
							<input type="password" class="form-control" name="mdpC" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$" 
							alt="Le mot de passe doit contenir de 8 à 15 caractères, au moins une lettre minuscule/un chiffre/un de ces caractères spéciaux: $ @ % * + - _ !"
							title="Le mot de passe doit contenir de 8 à 15 caractères, au moins une lettre minuscule/un chiffre/un de ces caractères spéciaux: $ @ % * + - _ !" required><br>
							<button type="submit" class="btn btn-danger btn-lg" name="validerMdp" >Valider la modification</button>
							<a href="index.php"><input type="button" class="btn btn-danger btn-lg" value="Retour"></a>
							</fieldset>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>                  
<?php
include("footer.php");
?>           

</body>

</html>
 