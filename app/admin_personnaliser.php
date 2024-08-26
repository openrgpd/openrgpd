<?php
/*A AJOUTER EN DEBUT DES PAGES*/
include("admin_header.php");
include ("connexion/Daos.php");

use DAO\Droit\DroitDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use metier\serviceMunicipal\ServiceMunicipal;
use DAO\pole\PoleDAO;
use metier\pole\Pole;
use DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO;
use DAO\Formulaire\FormulaireDAO;
use DAO\VariableGlobale\VariableGlobaleDAO;
use metier\variableglobale\VariableGlobale;

session_start();
include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/

/*Pour personnalisation, on recherche la variable varnom = faire une fonction*/
$VariableVarNom="";

/*sélection adresse mail du DPD*/
$mailtest="dpdmail";
$mailDPO= new VariableGlobaleDAO();
$readmaildpo= $mailDPO->read($mailtest);
$mailactuel=$readmaildpo->getVarvaleur();
$mailactuelID=$readmaildpo->getIdentifiant();

?>

<div class="container">
<a href="admin_all.php">Menu général</a> / Personnaliser l'application
</div>

<div class="centrer">
<h1 class="centrer">Personnaliser l'application</h1></div>
<div class="container">
<div class="row">
<div class="col-lg-6">

<!-- Partie BANDEAU APPLICATION -->
<h4>Modifier le bandeau du site : </h4>
<form method="POST" action="" enctype="multipart/form-data">
     <!-- On limite le fichier à 500Ko -->
     <input type="hidden" name="MAX_FILE_SIZE" value="500000">
     Fichier à envoyer (2000/300px, au format png, max 500ko): <input type="file" name="bandeau"><br>
     <input type="submit" class="btn btn-success btn-lg" value="Valider" name="valider2"/>
</form></div></div>

<?php
if (isset($_POST["valider2"])) {
	$dossier = 'bootstrap/images/';
	$fichier = basename($_FILES['bandeau']['name']);
	$taille_maxi = 100000;
	$taille = filesize($_FILES['bandeau']['tmp_name']);
	$extensions = array('.png', '.gif', '.jpg', '.jpeg');
	$extension = strrchr($_FILES['bandeau']['name'], '.'); 

	//Si l'extension n'est pas dans le tableau
	if(!in_array($extension, $extensions)) {
		 $erreur = 'Vous devez uploader un fichier de type png...';
	}
	if($taille>$taille_maxi) {
		 $erreur = 'Le fichier est trop gros...';
	}
	//S'il n'y a pas d'erreur, on upload
	if(!isset($erreur)) {
		 /*$fichier = strtr($fichier, 
			  'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
			  'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
		 $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);*/
		 $fichier="bandeau.png";

		 if(move_uploaded_file($_FILES['bandeau']['tmp_name'], $dossier . $fichier)) {
			echo 'Upload effectué avec succès !';
		 	Header('Location: '.$_SERVER['PHP_SELF']);
			Exit();	
		 } else {
			  echo 'Echec de l\'upload !';
		 }
	} else {
		 echo $erreur;
	}
}
?>
<?php
include("footer.php");
?>

