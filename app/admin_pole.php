<?php
/*A AJOUTER EN DEBUT DES PAGES*/
include("admin_header.php");
include ("connexion/Daos.php");

use DAO\Droit\DroitDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use metier\serviceMunicipal\ServiceMunicipal;
use DAO\pole\PoleDAO;
use DAO\entite\EntiteDAO;
use metier\pole\Pole;
use DAO\Entitepole\EntitepoleDAO;
use DAO\Formulaire\FormulaireDAO;

session_start();
include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/
?>

<div class="container">
	<a href="admin_all.php">Menu général</a> / Modifier un pôle
</div>
<div class="centrer">
	<h1 class="centrer">Administration des Pôles</h1>
</div>
<div class="container">

<?php
/*************************** partie modification de la table poles *******************************/

if (isset($_POST["btnmodif"])) { 
	$id= $_POST["btnmodif"];
	$message="Aucune modification enregistrée";
	if (isset($_POST['listbox'.$id]) && $_POST["listbox".$id]!=0){
	//partie entité
		$daoentites= new EntitepoleDAO();
		$readIdEnt= $daoentites->readIdentitebypole($id);
		$ancienEnt = implode(",", $readIdEnt);
		$nouveauEnt=htmlspecialchars($_POST["listbox".$id]);
		$daoentites->updatePush($_POST["btnmodif"], $ancienEnt, $nouveauEnt);
		$message="Modifications effectuées";
	}
	if (!empty($_POST['pole'.$id])){
		//partie libellé du pôle
		$nomPole=htmlspecialchars($_POST['pole'.$id]);
		$idPole=htmlspecialchars($id);
		$objet= new Pole($nomPole);
		$objet->setIdentifiant($idPole);
		$daoPole= new PoleDAO();
		$rep3=$daoPole->update($objet);
		$message="Modifications effectuées";
	}  
    echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
}

if (isset($_POST["validerSupp"])){   
	//vérifier si un service est rattaché
	$id= $_POST["validerSupp"];
	$daopoleserv=new ServiceMunicipalDAO();
	$countServ=$daopoleserv->readCountServPole($id);
	if ($countServ>0){
		$message="Ce pôle apparaît encore comme gestionnaire du droit d'accès d'une déclaration.";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
	} else {
		$daoPole= new PoleDAO();
		$daoPole->delete($_POST["validerSupp"]);
		$daopolent= new EntitepoleDAO();
		$daopolent->deleteBypol($_POST["validerSupp"]);
		$message="pôle supprimé";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
	}
}

// partie validation ajout d'un pôle
if (isset($_POST["valider4"])) {
	if (isset($_POST['listbox']) && $_POST["listbox"]!=0){
		if (!empty($_POST['ajoutPole'])){
			$nomPole=htmlspecialchars(($_POST['ajoutPole']));
			$nomPoles= new \metier\pole\Pole($nomPole);
			$rep1= new PoleDAO();
			$rep1->create($nomPoles);
			//recup dernier enregistrement
			$idpole = new PoleDao();
			$rep = $idpole -> readMaxPole();
			$id = $rep->getIdentifiant();
			//partie entité
			$daoentites= new EntitepoleDAO();
			$readIdEnt= $daoentites->readIdentitebypole($id);
			$ancienEnt = implode(",", $readIdEnt);
			$nouveauEnt=htmlspecialchars($_POST["listbox"]);
			$daoentites->updatePush($id, $ancienEnt, $nouveauEnt);

			$message='Pôle correctement ajouté';
			echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
			echo '<script type="text/javascript">window.location="admin_pole.php"</script>';
			Exit();
		} else {  
			$message='Vous n\'avez pas rempli le champ pôle';
			echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
			Exit();
		} 
	} else {  
		$message='Vous n\'avez pas sélectionné d\'entité';
		echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
		Exit();
	} 
}

/****************************************************************************************************/
/********************************** AJOUT d'un Pole *************************************************/
?>
<div class="well">
<div class="row">
<div class="col-lg-12">
 
    <form method="POST" action="">
		<fieldset>	
		<h3>Ajouter un pôle :</h3>		
		<div class="form-row">
			<div class="col-md-4 mb-3">
				<label for="ajoutPole">Nom du pôle :</label>
				<input type="text" class="form-control" name="ajoutPole" required>
			</div>
		</div>
<!-- 		 liste déroulante pour les Entités.	 -->
		<div class="col-md-6 mb-6">
			<label for="listbox">Choisissez l'entité dont dépend le pôle : 
			<select multiple="multiple" placeholder="choisissez une/des entité(s)" class="SlectBox" name="listbox" id="multi-select" required>
<?php		
			$ent = new EntiteDAO();
			$readAll = $ent->readAllEntitesByAdmin($_SESSION['identifiant']);

			foreach ($readAll as $key => $e) {
				$rep = $e->getEntite();
				$rep2 = $e->getIdentifiant();
				echo "<option value=$rep2> $rep</option>";
			}
			echo "</select>";
?>		
		</div>
		<div class="col-md-2 mb-2">
			<p><input type="submit" class="btn btn-success btn-lg" value="Valider" name="valider4"/></p>
			</fieldset>
		</div>
	</form>

</div>
</div>
</div>

<div class="container">
<div class="row">
<div class="col-lg-12">

<form method="POST" action="" id="formEntite">
	<fieldset>
		<!-- 		 liste déroulante pour les Entités.	 -->
		<p class="text-center">Filtrer par entité :
		<select name="listeEntite" id="listeEntite" onchange="document.forms['formEntite'].submit();">
		<option value=-1>- - - Toutes les entités - - -</option>
		<?php
		$_SESSION['entiteSession'] = $_POST['listeEntite']; 
		$ent = new EntiteDAO();
		$readAll = $ent->readAllEntitesByAdmin($_SESSION['identifiant']);

		foreach ($readAll as $key => $entites) {
			$rep = $entites->getEntite();
			$rep2 = $entites->getIdentifiant();

			if (isset($_SESSION['entiteSession']) && $_SESSION['entiteSession'] == $rep2) {
				$select = " selected=\"selected\"";
			} else {
				$select = "";
			}	
			echo "<option value=$rep2$select> $rep </option>";
		}
		?>
		</select></p>
	</fieldset>
</form>
		<!-- fin liste déroulante pour les entités -->
<?php
/***************************************** Modification *****************************************************/
?>
<h3>Modifier un pôle :</h3>
<!-- 		 liste déroulante pour les Pôles.	 -->
<?php
	echo "<form method='POST' action=''><table
		<tr><th class='col-md-4'>Pôles</th><th class='col-md-3'>Entité(s) actuelle(s)</th><th class='col-md-4'>Nouvelle(s) entité(s)</th><th class='col-md-1'>Modification</th><th class='col-md-1'>Suppression</th></tr>";
	$cpt=0;
	echo "<tr>";
	$pol = new PoleDAO();

	/*filtre*/
	if (isset($_POST["listeEntite"]) && $_POST["listeEntite"] !=-1) {
		$readAll = $pol->readAllPolesByEntite($_POST["listeEntite"]);
	} else {
		$readAll = $pol->readAllPolesByAdmin($_SESSION['identifiant']);
	}
	foreach ($readAll as $key => $poles) {
		$lirePole=$poles->getPole();
		$lireIdPole=$poles->getIdentifiant();
		?>
		<td><input type='text' class='form-control' name='<?php echo "pole".$lireIdPole; ?>' value = "<?php echo $lirePole;?>" ></td><td>
		<?php
		$daoentites= new EntitepoleDAO();
		$readAllentites= $daoentites->readIdentitebypole($lireIdPole);
		if (!empty($readAllentites)){
			$list = implode(",", $readAllentites);
			$var=$daoentites->readAll($list);
			echo $var;
		} else {
			echo "aucun";
		}
		echo "</td>";
		if (isset($_POST["listeEntite"]) && $_POST["listeEntite"] !=-1) {
			echo "<input type='hidden' name='listeEntite' value='".$_POST["listeEntite"]."'>";
		}
		?>
		<td>
		<select multiple="multiple" placeholder="choisissez une/des entité(s)" class="SlectBox" name="listbox<?php echo $lireIdPole;?>" id="multi-select">
		<?php		
		$ent = new EntiteDAO();
		$readAll = $ent->readAllEntitesByAdmin($_SESSION['identifiant']);
		foreach ($readAll as $key => $e) {
			$rep = $e->getEntite();
			$rep2 = $e->getIdentifiant();
			echo "<option value=$rep2> $rep</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "<td><button name='btnmodif' type='submit' class='btn btn-info2 btn-sm' value='$lireIdPole'>Modifier</button></td>";
		echo "<td><button name='validerSupp' type='submit' class='btn btn-danger btn-sm' value='$lireIdPole' onclick='return confirmation();'>Supprimer</button></td></tr>"; 
	}
	echo "</table></form></div></div></div>";
	$cpt++;
?>
</div>
</div>

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
<?php
include("footer.php");
?>