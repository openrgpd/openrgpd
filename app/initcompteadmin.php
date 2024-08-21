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

if (isset($_POST['logindmd'])) {

	//verif que le login existe 
	$daoUtilisateur=new UtilisateurDAO();
	if (!$daoUtilisateur->existLogin($_POST['logindmd'])){
		$message="Ce login n'existe pas.";
		echo '<script type="text/javascript">window.alert("' . $message .'");</script>';
	} else {
		//génération aléatoire du mdp et envoi par mail

		/*function mdp_aleatoire($nb_car, $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789') {
    			$nb_lettres = strlen($chaine) - 1;
    			$generation = '';
    			for($i=0; $i < $nb_car; $i++) {
       			$pos = mt_rand(0, $nb_lettres);
        			$car = $chaine[$pos];
        			$generation .= $car;
    			}
    			return $generation;
		}
		$mdp = mdp_aleatoire(8);*/

function uniqidReal($lenght = 13) {
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}

	$mdp = uniqidReal();
	$mdphache= password_hash($mdp, PASSWORD_DEFAULT);	

		//sélection de l'identifiant du login + Update du mdp DPD dans la table
		$daoUtilisateur->updateMDP($_POST['logindmd'], $mdphache);


		//Envoi du mail
		$mailDPO= new VariableGlobaleDAO();
		$readmaildpo= $mailDPO->read("dpdmail");
		$mailbis=$readmaildpo->getVarvaleur();

		$mail=$readmaildpo->getVarvaleur();
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
    			$passage_ligne = "\r\n";
		} else {
   			$passage_ligne = "\n";
		}

		$message_txt = "Demande de nouveau mot de passe pour le DPD";
		$message_html = "<html><head></head><body>Nouveau mot de passe pour le compte ". $_POST['logindmd'] ." : ". $mdp ." .</body></html>";
		//=====Création de la boundary
		$boundary = "-----=".md5(rand());
		//=====Définition du sujet.
		$sujet = "Demande de nouveau mot de passe";
		//=====Création du header de l'e-mail.
		$header = "From: \"AppliRGPD\"<".$mail.">".$passage_ligne;
		$header.= "Reply-to: \"DPD\"<".$mail.">".$passage_ligne;
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

		$message="Demande envoyée au DPD.";
		echo '<script type="text/javascript">window.alert("' . $message .'");window.location="index.php"</script>';
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
					<h1 class="text-center">Demande de nouveau mot de passe pour le DPD</h1>
					<h6 class="text-center">Déclaration des traitements RGPD</h6>
				</div>
				<div class="panel-body">	
					<div class="col-lg-6">
						<fieldset>	
       					<label> Votre login :</label>
       					<input type="text" class="form-control" name="logindmd"><br>
       					<button type="submit" class="btn btn-success btn-lg" name="validerConnexion" >Envoyer un nouveau mdp par mail</button>
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