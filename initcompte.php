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
<title>RGPD initialisation du compte</title>

</head>
<body>

<?php

use DAO\VariableGlobale\VariableGlobaleDAO;
use metier\variableglobale\VariableGlobale;
use DAO\Utilisateur\UtilisateurDAO;
use metier\utilisateur\Utilisateur;

$mailFrom = 'no-reply@megalis.bretagne.bzh';

if (isset($_POST['maildmd'])) {
	//verif que le mail existe
	$daoUtilisateur=new UtilisateurDAO();

	if (!$daoUtilisateur->existMail($_POST['maildmd'])){
		$message="Cette adresse mail n'existe pas dans l'application.";
		echo '<script type="text/javascript">window.alert("' . $message .'");</script>';
	} else {
		$mail=$_POST['maildmd'];
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
    			$passage_ligne = "\r\n";
		} else {
   			$passage_ligne = "\n";
		}
		$message_txt = "Demande de nouveau mot de passe";
		$message_html = "<html><head></head><body>
			Souhaitez-vous réellement obtenir un nouveau mot de passe pour accéder à l'application ? <br>
			Si oui, <a href='https://rgpd.megalis.bretagne.bzh/initcompte_conf.php?mail=".$mail."'>cliquez sur ce lien pour recevoir un nouveau mot de passe</a></br></body></html>";
		//=====Création de la boundary
		$boundary = "-----=".md5(rand());
		//=====Définition du sujet.
		$sujet = "Demande de nouveau mot de passe";
		//=====Création du header de l'e-mail.
		$header = "From: \"AppliRGPD\"<".$mailFrom.">".$passage_ligne;
		$header.= "Reply-to: \"DPD\"<".$mailFrom.">".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		//=====Création du message.
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format texte.
		$message.= "Content-Type: text/plain; charset=\"utf8\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_txt.$passage_ligne;
		$message.= $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format HTML
		$message.= "Content-Type: text/html; charset=\"utf8\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_html.$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

		mail($mail,$sujet,$message,$header);

		echo '<script type="text/javascript">window.alert("Vous recevrez sous peu, un mail de confirmation de votre demande");</script>';
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
					<h1 class="text-center">Demande de nouveau mot de passe</h1>
					<h6 class="text-center">Logiciel RGPD</h6>
				</div>
				<div class="panel-body">	
					<div class="col-lg-6">
						<fieldset>	
       					<label> Votre Adresse mail :</label>
       					<input type="text" class="form-control" name="maildmd"><br>
       					<button type="submit" class="btn btn-success btn-lg" name="validerConnexion" >Recevoir un nouveau mot de passe</button>
						<a href="index.php"><input type="button" class="btn btn-warning btn-lg" value="Retour"></a>
						</fieldset>	
					</div>
				</div>
			</div>
		</div>
	</div>
      </form>
</div>                  

</body>

</html>
 <?php
include("footer.php");
?>