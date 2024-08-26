<?php
/*A AJOUTER EN DEBUT DES PAGES*/
include("admin_header.php");
include ("connexion/Daos.php");

use DAO\Droit\DroitDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use DAO\Utilisateur\UtilisateurDAO;
use DAO\pole\PoleDAO;
use DAO\entite\EntiteDAO;
use DAO\appliDroitAcces\AppliDroitAccesDAO;
use metier\applidroitacces\Applidroitacces;
use metier\droit\Droit;
use metier\utilisateur\Utilisateur;

session_start();
include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/
?>

<div class="container">
<a href="admin_all.php">Menu général</a> / Ajouter un utilisateur
</div>

<div class="centrer">
<h1 class="centrer">Administration des utilisateurs</h1></div>

<div class="container">

      <div class="row">
      <div class="col-lg-6">
<h2>Ajouter un utilisateur :</h2>

<form method="post" class="form-horizontal"action="">
	<fieldset>
		<p class="important">* Nom :
			<input type="text" class="form-control" name="nom" required/>
		</p>
		<p class="important">* Prénom :
			<input type="text" class="form-control" name="prenom" required/>
		</p>
		<p class="important">* Adresse mail :
			<input type="email" class="form-control" name="mail" required/>
		</p>
		<p class="important">* Login :
			<input type="text" class="form-control" name="login" required/>
		</p>
		<p class="important">* Mot de passe :
			<input type="password" class="form-control" name="mdp" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$" 
			alt="Le mot de passe doit contenir de 8 à 15 caractères, au moins une lettre minuscule/un chiffre/un de ces caractères spéciaux: $ @ % * + - _ !"
			title="Le mot de passe doit contenir de 8 à 15 caractères, au moins une lettre minuscule/un chiffre/un de ces caractères spéciaux: $ @ % * + - _ !" required/>
		</p>
		<p class="important">* Confirmation du mot de passe :
			<input type="password" class="form-control" name="mdpC" required/> 
		</p>	
		
		<p class="important">* Niveau d'accès :</p>
		<SELECT class=form-control name="niveau" required>
			<OPTION value="contributeur">Contributeur</OPTION>
			<OPTION value="admin">Administrateur</OPTION>
			<OPTION value="admin">Admin EPCI</OPTION>
		</SELECT>	

		<p class="important">* Lier aux entités :</p>
		<!-- Select Multiple -->
		<select multiple="multiple" placeholder="choisissez une/des entité(s)" class="SlectBox" name="listbox" id="multi-select" required>
<?php
		$ent = new EntiteDAO();
		$readAll = $ent->readAllEntitesByAdmin($_SESSION['identifiant']);		
		$compt = 1;
		foreach ($readAll as $key => $e) {
			$rep = $e->getEntite();
			$rep2 = $e->getIdentifiant();
			echo "<option value=$rep2> $rep</option>";
			$compt ++;
		}
?>
		</select>
			</p>
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
		<!-- fin multiselect -->

<br><p><input type="submit" class="btn btn-success btn-lg" value="Valider" name="validerUtil"/></p>
</fieldset></form></div></div></div>

<?php
//partie validation d'un nouvel utilisateur
if (isset($_POST["validerUtil"]) && ((isset($_POST['listbox']) && $_POST["listbox"]!=0)))
{
    	if (!empty($_POST["nom"])){
        	$recupNom=$_POST["nom"];
    	} else {
        	$recupNom="";
    	}
    	if (!empty($_POST["prenom"])){
        	$recupPrenom=$_POST["prenom"];
    	} else {
        	$recupPrenom="";
    	}
    	if (!empty($_POST["login"])){
        	$recupLogin=$_POST["login"];
   	} else{
        	$recupLogin="";
    	}
	if (!empty($_POST["mail"])){
		$recupMail=$_POST["mail"];
	} else {
		$recupMail="";
	}
    	if (!empty($_POST["mdp"])){
        	$recupMdphache= password_hash($_POST["mdp"], PASSWORD_DEFAULT);
    	} else {
        	$recupMdphache="";
    	}
    	if (!empty($_POST["mdpC"])){
       	 $recupMdpC=$_POST["mdpC"];
    	} else {
        	$recupMdpC="";
    	}
    	if (!empty($_POST["niveau"])){
        	$recupNiveau=$_POST["niveau"];
    	} else {
        	$recupNiveau="contributeur";
    	}

    	$utilisateur= new Utilisateur($recupNom, $recupPrenom, $recupLogin, $recupMdphache,$recupNiveau,0,$recupMail);

		$utilisateur->valideUtilisateurInscription($recupMdpC);
	//recup dernier enregistrement utilisateur
	$idutil = new UtilisateurDao();
 	$rep = $idutil -> readUtilisateur($recupMail);
	$id = $rep->getIdentifiant();
	//partie accès entité
      $nvacces=htmlspecialchars($_POST["listbox"]);
	foreach (explode(',', $nvacces) as $ent){
      	$id_entite=$ent;
            $entite= new AppliDroitAcces($id_entite, $id);
            $rep= new AppliDroitAccesDAO();
            $rep->create($entite);
      }
	//partie accès admin
	if ($recupNiveau = "admin") {
		$sql = "SELECT distinct servicesmunicipaux.identifiant FROM servicesmunicipaux 
			INNER JOIN entitepole ON entitepole.id_entite = servicesmunicipaux.entite
			INNER JOIN applidroitacces ON applidroitacces.id_entite = entitepole.id_entite
			WHERE applidroitacces.id_utilisateur = ".$id ;
		$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
		$stmt->execute();

		while ($row = $stmt->fetch()) {
                	$id_service = $row[0];
            	$droit= new Droit($id, $id_service);
            	$rep= new DroitDAO();
            	$rep->create($droit);
            }
	}	
}
 	
?>
<?php
include("footer.php");
?>