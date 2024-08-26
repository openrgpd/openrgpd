<?php
/*A AJOUTER EN DEBUT DES PAGES*/
include("admin_header.php");
include ("connexion/Daos.php");

use DAO\Droit\DroitDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use DAO\Utilisateur\UtilisateurDAO;
use DAO\pole\PoleDAO;
use metier\utilisateur\Utilisateur;

session_start();

include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/
?>
 
<div class="centrer">
	<h1 class="centrer">Menu général</h1>
</div>
<br>
<div class="container">
	<div class="row">

<?php if ($_SESSION['admin'] == "super admin") { ?>
		<div class="col-lg-4">
<?php } else { ?>	
		<div class="col-lg-6">
<?php } ?>	
			<div class="well">
				<h3>Gestion des Utilisateurs</h3>
				<a class="btn btn-primary btn-lg btn-block" href="admin_utilisateur_ajout.php" role="button">Ajouter un utilisateur</a>
				<a class="btn btn-primary btn-lg btn-block" href="admin_utilisateur_modif_supr.php" role="button">Gestion des utilisateurs</a>
				<a class="btn btn-primary btn-lg btn-block" href="admin_droits.php" role="button">Droits d'accès</a>
				<a class="btn btn-primary btn-lg btn-block" href="admin_liste_utilisateur.php" role="button">Tableau droits</a>
			</div>
		</div>
<?php if ($_SESSION['admin'] == "super admin") { ?>
		<div class="col-lg-4">
<?php } else { ?>	
		<div class="col-lg-6">
<?php } ?>	
			<div class="well">
				<h3>Gestion des Entités/Pôles/Services</h3>
				<a class="btn btn-primary btn-lg btn-block" href="admin_entite.php" role="button">Les Entités</a>
				<a class="btn btn-primary btn-lg btn-block" href="admin_pole.php" role="button">Les Pôles</a>
				<a class="btn btn-primary btn-lg btn-block" href="admin_service.php" role="button">Les Services</a>
			</div>
		</div>
<?php if ($_SESSION['admin'] == "super admin") { ?>
		<div class="col-lg-4">
			<div class="well">
				<h3>Divers</h3>
				<a class="btn btn-primary btn-lg btn-block" href="admin_personnaliser.php" role="button">Personnaliser l'application</a>
				<a class="btn btn-primary btn-lg btn-block" href="admin_categorie_donnee.php" role="button">Catégories de données</a>
				<a class="btn btn-primary btn-lg btn-block" href="admin_categorie_liceite.php" role="button">Catégories de licéités</a>
				<a class="btn btn-primary btn-lg btn-block" href="admin_tableau.php" role="button">Infobulles formulaire</a>
			</div>
		</div>
<?php } ?>
	</div>

	<div class="row">

<?php if ($_SESSION['admin'] == "super admin") { ?>
		<div class="col-lg-4">
<?php } else { ?>	
		<div class="col-lg-6">
<?php } ?>	
			<div class="well">
				<h3>Editer votre registre des traitements</h3>
				<a class="btn btn-primary btn-lg btn-block" href="admin_expPDF.php" role="button">Imprimer un PDF</a>
				<a class="btn btn-primary btn-lg btn-block" href="admin_expCSV.php" role="button">Exporter les traitements</a>				
			</div>
		</div>
	</div>

</div>

<?php
include("footer.php");
?>

