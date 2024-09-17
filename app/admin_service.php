<?php
/*A AJOUTER EN DEBUT DES PAGES*/
include("admin_header.php");
include ("connexion/Daos.php");

use DAO\Droit\DroitDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use metier\serviceMunicipal\ServiceMunicipal;
use DAO\pole\PoleDAO;
use metier\pole\Pole;
use DAO\entite\EntiteDAO;
use metier\entite\Entite;
use DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO;
use DAO\Formulaire\FormulaireDAO;
use DAO\Utilisateur\UtilisateurDAO;

session_start();
include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/
?>
<div class="container">
	<a href="admin_all.php">Menu général</a> / Modifier un service
</div>

<div class="centrer">
	<h1 class="centrer">Administration des services</h1>
</div>
<div class="container">

<?php 
// modifications des services
if (isset($_POST["btnmodif"])) {
   	if (!empty($_POST["serv"])) {
		// si vide msg !
		// Update des valeurs entités et poles de la ligne
        	$objet = new ServiceMunicipal($_POST["serv"], $_POST["servP"], $_POST["servE"]);
        	$objet->setIdentifiant($_POST["btnmodif"]);
        	$daoTest= new ServiceMunicipalDAO();
        	$rep1=$daoTest->update($objet);
        	$message='Service modifié avec succès';
	  	echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
   	} else {
		$message='Le champ est vide';
	  	echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
	}	
}

 //suppression d'un service
if (isset($_POST["validerSupp"])){   
	$daogest=new GestionnaireDroitAccesDAO();
	$countGest=$daogest->readCountGesti(($_POST['validerSupp']));
	$daoform=new FormulaireDAO();
	$countAct=$daoform->readCountActeur(($_POST['validerSupp']));
	if ($countGest>0){
		$message="Ce service apparaît encore comme gestionnaire du droit d'accès d'une déclaration.";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
	} elseif ($countAct>0){
		$message="Ce service apparaît encore comme acteur de mise en oeuvre dans une déclaration.";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
	} else {
		$daodroits=new DroitDAO();
		$daodroits->deleteDroitServ(($_POST['validerSupp']));
		$daoService=new ServiceMunicipalDAO();
		$daoService->delete(($_POST['validerSupp']));
		$message="Service supprimé";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
	}
}

// AJOUT service
if (isset($_POST["valider"])) {
	if (!empty($_POST['ajoutServMun']) && $_POST['ajoutServMun']!="Ecrire ici ..."){
		$nomServMun=htmlspecialchars(($_POST['ajoutServMun']));
		if ((!empty($_POST['pole']) && $_POST['pole']!=-1) && (!empty($_POST['entite']) && $_POST['entite']!=-1)) {
			$nomServMunPole=htmlspecialchars(($_POST['pole']));
			$nomServMunEntite=htmlspecialchars(($_POST['entite']));
			$serviceMunicipaux= new ServiceMunicipal($nomServMun, $nomServMunPole, $nomServMunEntite);
			$rep= new ServiceMunicipalDAO();
			$rep->create($serviceMunicipaux);
			unset($serviceMunicipaux);
			//sélection dernier service
			$service = new ServiceMunicipalDAO();
			$rep = $service -> readLastServ();
			$serv = $rep;
			//Partie droits pour super admin et admin local
			$util = new UtilisateurDAO();
			$readAllAdmin = $util->readIdUtilAdmin($_SESSION['identifiant']);
			foreach ($readAllAdmin as $key => $ud) {
				$idutil = $ud->getIdentifiant();
				$sql = "INSERT INTO droits (id_utilisateur, id_gestionnaire) values (".$idutil.", ".$serv.")";
				$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
				$stmt->execute();
			}
	
			$message='Service correctement ajouté';
			echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
	
		} else {
			$message='Vous n\'avez pas choisi de pôle ou  d\'entité';
			echo '<script type="text/javascript">window.alert("' . $message . '");</script>';
		}
	} else {
		$message='Vous n\'avez pas rempli le champ service';
		echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
	}
	
}

/**************************************************AJOUT***********************************************************/
?>
<div class="well">
<div class="row">
<div class="col-lg-12">

	<form method="POST" action="" id="fEntite">
	    <h3>Ajouter un service :</h3>
		<div class="form-row">
			<div class="col-md-6 mb-3">
				<!-- 		 liste déroulante pour les Entités.	 -->
				<p class="important">Choisissez l'entité dont dépend le service : </p>
				<p><select name="entite" id="entite" onchange="document.forms['fEntite'].submit();">
					<option value=-1>- - - Toutes les entités - - -</option>
			<?php
			$ent = new EntiteDAO();
			$readAll = $ent->readAllEntitesByAdmin($_SESSION['identifiant']);

			foreach ($readAll as $key => $entites) {
				$rep = $entites->getEntite();
				$rep2 = $entites->getIdentifiant();

				if (isset($_POST["entite"]) && $_POST["entite"] == $rep2) {
					$select = " selected=\"selected\"";
				} else {
					$select = "";
				}
				echo "<option value=$rep2$select> $rep </option>";
			}
			?>
				</select></p>
				<!-- fin liste déroulante pour les entités -->
			
			<?php 
			if (isset($_POST["entite"]) && $_POST["entite"] !=-1) {
			?>
				<p class="important">Choisissez le pôle dont dépend le service : </p>
				<p><select name="pole" id="pole" onchange="document.forms['fEntite'].submit();">
					<option value=-1>- - - Tous les pôles - - -</option>
				<?php
				$rEntite = $_POST["entite"];
				$pol = new PoleDAO();
				$readAll = $pol->readAllPolesByEntite($rEntite);

				foreach ($readAll as $key => $sm) {
					$rep3 = $sm->getPole();
					$rep4=$sm->getIdentifiant();
					if (isset($_POST["pole"]) && $_POST["pole"] == $rep4) {
						$select = " selected=\"selected\"";
					} else {
						$select = "";
					}
					echo "<option value=$rep4$select> $rep3 </option>";
				} ?>
				</select></p>
			<?php }
			?>
			</div>
			<div class="col-md-3 mb-3">
				<p class="important">Nom du service :</p>
				<p><input type="text" name="ajoutServMun"
					value='' 
					onfocus="if(this.value=='Ecrire ici ...'){this.value=''};"
					onblur="if(this.value==''){this.value='Ecrire ici ...'};"/>
				</p>
				<!-- fin liste déroulante pour les pôles. -->
			</div>
			<div class="col-md-2 mb-3">
				<p><input type="submit" class="btn btn-success btn-lg" value="Valider" name="valider"/></p>
			</div>		
		</div>
	</form>
</div>
</div>
</div>
</div>
<?php
/**************************************************FILTRE***********************************************************/
?>
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
		<!-- fin liste déroulante pour les entités -->
		<?php 
		if (isset($_POST["listeEntite"]) && $_POST["listeEntite"] !=-1) {
		?>
		<!-- liste déroulante pour les Pôles. -->
			<p class="text-center">Choisissez un pôle :
			<select name="listePole" id="listePole" onchange="document.forms['formEntite'].submit();">
				<option value=-1>- - - Tous les pôles - - -</option>
		<?php
			$_SESSION['poleSession'] = $_POST['listePole']; 
			$pol = new PoleDAO();
			$readAll = $pol->readAllPolesByEntite($_SESSION['entiteSession']);

			foreach ($readAll as $key => $sm) {
				$rep3 = $sm->getPole();
				$rep4=$sm->getIdentifiant();
				if (isset($_SESSION['poleSession']) && $_SESSION['poleSession'] == $rep4) {
					$select = " selected=\"selected\"";
				} else {
					$select = "";
				}	
				echo "<option value=$rep4$select> $rep3 </option>";
			}
			echo "</select></p>";
		}
		?>
		<!-- fin liste déroulante pour les Pôles -->
	</fieldset>
</form>
<?php
/**************************************************MODIFICATION***********************************************************/
?>
<fieldset>
<h3>Modifier un service :</h3>

<?php
echo "<table>
	<tr><th class='col-md-4'>Service</th><th class='col-md-4'>Pôle</th><th class='col-md-4'>Entité</th></t>";

/*filtre*/
if (isset($_POST["listeEntite"]) && $_POST["listeEntite"] !=-1) {
	if (isset($_POST["listePole"]) && $_POST["listePole"] !=-1) {
      	$serv = new ServiceMunicipalDAO();
		$readAll = $serv->readAllServMEntitePole($_POST["listeEntite"], $_POST["listePole"]);
	} else {
      	$serv = new ServiceMunicipalDAO();
		$readAll = $serv->readAllServMEntite($_POST["listeEntite"]);
	}
} else {
	$serv = new ServiceMunicipalDAO();
	$readAll = $serv->readAllServMByAdmin($_SESSION['identifiant']);
}

foreach ($readAll as $key => $sm) {
	$lireService = $sm->getService();
	$lireIdService=$sm->getIdentifiant();
	$lireIdPole=$sm->getPole();
	$lireIdEntite=$sm->getEntite();
	
	echo "<tr><form method='POST' action=''>";
	?>
	<td><input type='text' class='form-control' name='serv' value = "<?php echo $lireService; ?>" ></td>
	<?php
	echo "<td><select name='servP' id='servP' class='form-control'>";
	$pol = new PoleDAO();
	$readAllP = $pol->readAllPolesByAdmin($_SESSION['identifiant']);
	foreach ($readAllP as $keyP => $poles) {
		if ($lireIdPole == $poles->getIdentifiant()) {
				$select = " selected=\"selected\"";
		} else {
				$select = "";
		}
		
		$rep = $poles->getPole();
		$rep2= $poles->getIdentifiant();

		$sql="SELECT entites.entite FROM entites
			inner join entitepole on entitepole.id_entite = entites.identifiant
			inner join poles on entitepole.id_pole = poles.identifiant
			WHERE poles.identifiant = ".$rep2." ";
	
		$stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
		$stmt->execute();									
		
		$parenthese = "";
		$cpt=0;
		while ($row = $stmt->fetch()) {
			if ($cpt==0) {
				$parenthese = $row["entite"];
			} else {
				$parenthese = $parenthese.",".$row["entite"];
			}
			$cpt++;
		}
		echo "<option value=".$rep2."".$select.">".$rep." <i>(".$parenthese.")</i> </option>";
	}
	echo "</select></td>";
	echo "<td><select name='servE' id='servE' class='form-control'>";
	$ent = new EntiteDAO();
	$readAllE = $ent->readAllEntitesByAdmin($_SESSION['identifiant']);
	foreach ($readAllE as $keyE => $entites) {
		if ($lireIdEntite == $entites->getIdentifiant()) {
				$selectE = " selected=\"selected\"";
		} else {
				$selectE = "";
		}
		$rep3 = $entites->getEntite();
		$rep4=$entites->getIdentifiant();
		echo "<option value=$rep4$selectE> $rep3 </option>";
	}
	echo "</select></td>";
	if (isset($_POST["listeEntite"]) && $_POST["listeEntite"] !=-1) {
		echo "<input type='hidden' name='listeEntite' value='".$_POST["listeEntite"]."'>";
	}
	if (isset($_POST["listePole"]) && $_POST["listePole"] !=-1) {
		echo "<input type='hidden' name='listePole' value='".$_POST["listePole"]."'>";
	}
	echo "<td><button name='btnmodif' type='submit' class='btn btn-info2 btn-sm' value='$lireIdService'>Modifier</button></td>";
	echo "<td><button name='validerSupp' type='submit' class='btn btn-danger btn-sm' value='$lireIdService' onclick='return confirmation();'>Supprimer</button></td>
		</form></tr>";
}

?>
</table></fieldset></div></div>
<?php
include("footer.php");
?>