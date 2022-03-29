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

if (isset($_GET['mail'])) {
	//verif que le login existe
	$daoUtilisateur=new UtilisateurDAO();

	if (!$daoUtilisateur->existMail($_GET['mail'])){
		$message="Cette adresse mail n'existe pas dans l'application.";
		echo '<script type="text/javascript">window.alert("' . $message .'");</script>';
	} else {
		$mail=$_GET['mail'];
		$mdp = chaine_aleatoire();
		$mdphache= password_hash($mdp, PASSWORD_DEFAULT);
		$sql = "UPDATE utilisateurs SET mdphache= '".$mdphache."' , nbessai = '0' WHERE mail = '".$mail."';";
		$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
		$stmt->execute();

		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
    			$passage_ligne = "\r\n";
		} else {
   			$passage_ligne = "\n";
		}

		$message_txt = "Demande de nouveau mot de passe";
		$message_html = "<html><head></head><body>Demande de nouveau mot de passe pour le compte ". $mail .".</br>mot de passe: ".$mdp."</br></body></html>";
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

		//echo '<script type="text/javascript">window.alert("Vous recevrez un mail sous peu avec votre nouveau mot de passe");</script>';
		//echo '<script type="text/javascript">window.location="index.php"</script>';
	}
}

/*
function chaine_aleatoire() {
	$chaine = 'azertyuiopqsdfghjklmwxcvbn123456789';
    	$nb_lettres = strlen($chaine) - 1;
    	$generation = '';
    	for($i=0; $i < 8; $i++) {
		$pos = mt_rand(0, $nb_lettres);
        	$car = $chaine[$pos];
        	$generation .= $car;
    	}
    	return $generation;
}*/


function chaine_aleatoire() {
	$chaine = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN123456789@&#-$¤£*%!/';
	$nb_lettres = strlen($chaine) - 1;
	$generation = '';
	for($i=0; $i < 20; $i++) {
		$pos = mt_rand(0, $nb_lettres);
		$car = $chaine[$pos];
		$generation .= $car;
	}
    return $generation;
}

?>       
<?php
include("footer.php");
?>           

</body>

</html>
 