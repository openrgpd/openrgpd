<?php
/*A AJOUTER EN DEBUT DES PAGES*/
include("admin_header.php");
include ("connexion/Daos.php");

use DAO\Droit\DroitDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use metier\serviceMunicipal\ServiceMunicipal;
use DAO\entite\EntiteDAO;
use DAO\Entitepole\EntitepoleDAO;
use metier\entite\Entite;
use DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO;
use DAO\Formulaire\FormulaireDAO;
use DAO\appliDroitAcces\AppliDroitAccesDAO;
use metier\applidroitacces\Applidroitacces;
use DAO\Utilisateur\UtilisateurDAO;

session_start();
include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/
?>

<div class="container">
<a href="admin_all.php">Menu général</a> / Modifier une entité
</div>

<div class="centrer">
<h1 class="centrer">Administration des Entités</h1></div>
<div class="container">
<div class="row">
<div class="col-lg-12">

<?php
/***************************Ajout d'une entité****************************/
?>
<div class="container">
	<div class="well">
		<div class="row">
			<div class="col-lg-12">
				<form method="POST" action="">
					<fieldset>		
						<h3>Ajouter une entité : </h3>
						<div class="form-row">
							<div class="col-md-4 mb-3">
							<label for="ajoutEntite">Nom de l'entité :</label>
							<input type="text" class="form-control" name="ajoutEntite" required>
							</div>
							<div class="col-md-3 mb-3">
								<label for="ajoutmaildpd">Adresse mail du DPD de l'entité :</label>
								<input type="text" class="form-control" name="ajoutmaildpd" required>
							</div>
							<div class="col-md-3 mb-3">
								<label for="ajoutresponsable">Responsable des traitements:</label>
								<input type="text" class="form-control" name="ajoutresponsable" required>
							</div>
							<div class="col-md-1 mb-3">
									<p><input type="submit" class="btn btn-success btn-lg" value="Valider" name="valider4"/></p>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
<?php
// partie validation ajout à la table entités
if (isset($_POST["valider4"])) {
	if ((!empty($_POST['ajoutEntite'])) && (!empty($_POST['ajoutmaildpd']) && $_POST['ajoutmaildpd']!="Ecrire ici ...") && 
	(!empty($_POST['ajoutresponsable']) && $_POST['ajoutresponsable']!="-1")){
	//partie création entité
		$nomEntite=htmlspecialchars(($_POST['ajoutEntite']));
		$nomEntites= new \metier\entite\Entite($nomEntite, $_POST['ajoutmaildpd'],$_POST['ajoutresponsable']);
		$rep1= new EntiteDAO();
		$rep1->create($nomEntites);
		//sélection dernière entité
		$identite = new entiteDao();
		$rep = $identite -> readLastEnt();
		$ident = $rep;
		//Partie droits pour super admin et admin local
		$util = new UtilisateurDAO();
		$readAllAdmin = $util->readIdUtilAdmin($_SESSION['identifiant']);
		foreach ($readAllAdmin as $key => $ud) {
			$idutil = $ud->getIdentifiant();
			$droitacces= new AppliDroitAcces($ident, $idutil);
			$rep= new AppliDroitAccesDAO();
			$rep->create($droitacces);	
		}
		$message='Entité correctement ajoutée';
		echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
		echo '<script type="text/javascript">window.location="admin_entite.php"</script>';
		Exit();
	} else {  
		$message='Vous n\'avez pas rempli un des champs';
		echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
		Exit();
	} 
}
?>
</div>
</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<h3>Modifier une entité :</h3>

<?php
/***************************Modification de l'entité****************************/
?>
		<form method='POST' action=''><table>
			<tr><th class='col-md-4'>entité</th><th class='col-md-3'>Mail du DPD</th><th class='col-md-3'>Responsable</th><th class='col-md-1'>Modification</th><th class='col-md-1'>Suppression</th></tr>

<?php
$ent = new EntiteDAO();
$readAll = $ent->readAllEntitesByAdmin($_SESSION['identifiant']);

foreach ($readAll as $key => $entites) {
	$lireEntite=$entites->getEntite();
	$lireIdEntite=$entites->getIdentifiant();
	$lireMailEntite=$entites->getMaildpd();
	$lireRespEntite=$entites->getResponsable();

	echo "<td><input type='text' class='form-control' name='entite".$lireIdEntite."' value = '".$lireEntite."' ></td>";
	echo "<td><input type='text' class='form-control' name='maildpd".$lireIdEntite."' value = '".$lireMailEntite."'></td>";
	echo "<td><input type='text' class='form-control' name='responsable".$lireIdEntite."' value = '".$lireRespEntite."'></td>";
	echo "<td><button name='btnmodif' type='submit' class='btn btn-info2 btn-sm' value='$lireIdEntite'>Modifier</button></td>";
	echo "<td><button name='validerSupp' type='submit' class='btn btn-danger btn-sm' value='$lireIdEntite' onclick='return confirmation();'>Supprimer</button></td></tr>";
}
echo "</table></form>";

// partie modification de la table entites
if (isset($_POST["btnmodif"])) {
	$id= $_POST["btnmodif"]; 
	if ((!empty($_POST['entite'.$id])) && (!empty($_POST['maildpd'.$id])) && (!empty($_POST['responsable'.$id]))) {
		//partie libellé et mail de l'entité
		$nomEnt=htmlspecialchars($_POST['entite'.$id]);
		$maildpd=htmlspecialchars($_POST['maildpd'.$id]);
		$responsable=htmlspecialchars($_POST['responsable'.$id]);
		$idEnt=htmlspecialchars($id);
		$objet= new Entite($nomEnt,$maildpd,$responsable);
		$objet->setIdentifiant($idEnt);
		$daoEnt= new EntiteDAO();
		$rep=$daoEnt->update($objet);

      	$message="Modifications effectuées";
      	echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
		echo '<script type="text/javascript">window.location="admin_entite.php"</script>';
		Exit();
	} else {
		$message="Un des champs est vide";
      	echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
		echo '<script type="text/javascript">window.location="admin_entite.php"</script>';
		Exit();
	}
}

//partie suppression d'un champ de la table entites
if (isset($_POST["validerSupp"])){   
	$id= $_POST["validerSupp"];
	//vérifier si un service est attaché
      $daoentiteserv=new ServiceMunicipalDAO();
      $countServ=$daoentiteserv->readCountServEntite($id);
      if ($countServ>0){
		$message="Cette entité est encore reliée à un service.";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
		Exit();
	//vérifier si un pole est attaché
	} else {
		$daoentitepol=new EntitepoleDAO();
      	$countPol=$daoentitepol->readCountPoleEntite($id);
		if ($countPol>0){	
			$message="Cette entité est encore reliée à un pôle.";
			echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
			Exit();
		//vérifier si un responsable est attaché
		} else {
			//supprimer applidroitacces
			$daoAcces= new ApplidroitaccesDAO();
			$daoAcces->deleteByEnt($id);
			//supprimer l'entité
			$daoEntite= new EntiteDAO();
			$daoEntite->deleteByEnt($id);
			$message="entité supprimé";
			echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
			echo '<script type="text/javascript">window.location="admin_entite.php"</script>';
			Exit();
		}
	}
}
?>
</div>
</div>
</div>
<?php
include("footer.php");
?>
 
