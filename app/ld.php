<?php
include ("connexion/Daos.php");

use DAO\pole\PoleDAO;
use DAO\FormulaireCommentaire\FormulaireCommentaireDAO;
use DAO\Catdonneeformulaire\CatdonneeformulaireDAO;
use DAO\entite\EntiteDAO;
use DAO\Entitepole\EntitepoleDAO;
use DAO\Formulaire\FormulaireDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use metier\utilisateur\Utilisateur;
use DAO\Utilisateur\UtilisateurDAO;
use DAO\Droit\DroitDAO;
use DAO\appliDroitAcces\AppliDroitAccesDAO;
use metier\applidroitacces\Applidroitacces;

session_start();

/**
 * Code qui sera appelé par un objet XHR et qui
 * retournera la liste déroulante  */

/* On récupère l'identifiant de l'entité choisie. */
$idr = isset($_GET['idr']) ? $_GET['idr'] : false;
/* Si on a une entité, on procède à la requête */
if(false !== $idr) { 
/*rqt responsable de l'entité*/
	$sql="SELECT entites.responsable 
		FROM entites
		WHERE entites.identifiant =".$idr;
    $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
    $stmt->execute();
            
    $row = $stmt->fetch();
	$responsableLibelle=$row[0];
?>
	<div id="listeResp">
		<?php echo "$responsableLibelle"; ?>
	</div>
<?php
} 

/* On récupère l'identifiant de l'entité choisie. */
$ide = isset($_GET['ide']) ? $_GET['ide'] : false;
/* Si on a une entité, on procède à la requête */
if(false !== $ide) { 
?>
	<select class = "form-control" name="listePole" id="listePole" onchange="getServices(this.value);" required>
		<option selected value=>- - - Tous les pôles - - -</option>
		<?php
		$pol = new PoleDAO();
		$readAll = $pol->readAllPolesByEntiteUser($ide,($_SESSION['identifiant']));
		foreach ($readAll as $key => $p) {
			$rep3 = $p->getPole();
			$rep4=$p->getIdentifiant();
			echo "<option value=$rep4> $rep3 </option>";
		}
		?>
	</select>
<?php
} 

/* On récupère l'identifiant du pôle choisi. */
$idp = isset($_GET['idp']) ? $_GET['idp'] : false;
/* Si on a une entité, on procède à la requête */
if(false !== $idp) { 
?>
	<select class = "form-control" name="service" id="service" required>
		<option value=>- - - Tous les services - - -</option>
		<?php
		$serv = new ServiceMunicipalDAO();
		$readAll = $serv->readAllServMPoleByUser($idp,($_SESSION['identifiant']));
		foreach ($readAll as $key => $s) {
			$rep5 = $s->getService();
			$rep6=$s->getIdentifiant();
			echo "<option value=$rep6> $rep5 </option>";
		}
?>
	</select>
<?php
} 

/* Pour la liste des droits d'accès */
$idl = isset($_GET['idl']) ? $_GET['idl'] : false;
if(false !== $idl) { 
	echo '<p>Cet utilisateur à accès en visualisation à :</p>';
	$daoent = new AppliDroitAccesDAO();
	$readAllent = $daoent->readAllEntiteByUtil($idl);
	if (!empty($readAllent)){
		$list = implode(",", $readAllent);
		$var=$daoent->readAll($list);
		echo $var;
	} else {
		echo "aucun";
	}

	echo '<p>Cet utilisateur est gestionnaire des services suivants :</p>';
	$daodroits= new DroitDAO();
	$readAllDroits= $daodroits->readIdUtil($idl);
	if (!empty($readAllDroits)){
		$list = implode(",", $readAllDroits);
		$var=$daodroits->readAll($list);
		echo $var;
	} else {
		echo "aucun";
	}	
} 


