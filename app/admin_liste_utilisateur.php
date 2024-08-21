<?php
/*A AJOUTER EN DEBUT DES PAGES*/
include("admin_header.php");
include ("connexion/Daos.php");

use DAO\Droit\DroitDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use DAO\Utilisateur\UtilisateurDAO;
use DAO\pole\PoleDAO;
use DAO\entite\EntiteDAO;
use metier\utilisateur\Utilisateur;

session_start();
include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/
?>
 
<div class="container">
<a href="admin_all.php">Menu général</a> / Liste des droits
</div>

<div class="centrer">
	<h1 class="centrer">Accès par utilisateurs/services</h1>
</div>
<div class="container">

<form class="col-md-4" method="POST" action="" id="formEntite">
	<fieldset>
		<!-- liste déroulante pour les Entités	-->
		<p class="text-center">Filtrer par entité :
		<select name="listeEntite" id="listeEntite" onchange="document.forms['formEntite'].submit();">
			<option value=-1>- - - Toutes les entités - - -</option>
			<?php
			$ent = new EntiteDAO();
			$readAll = $ent->readAllEntitesByAdmin($_SESSION['identifiant']);
			foreach ($readAll as $key => $entites) {
				$rep = $entites->getEntite();
				$rep2 = $entites->getIdentifiant();
				if (isset($_POST["listeEntite"]) && $_POST["listeEntite"] == $rep2) {
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
		<!-- liste déroulante pour les Pôles -->
			<p class="text-center">Filtrer par pôle :
			<select name="listePole" id="listePole" onchange="document.forms['formEntite'].submit();">
				<option value=-1>- - - Tous les pôles - - -</option>
			<?php
			$recupEntite = $_POST["listeEntite"];
			$pol = new PoleDAO();
			$readAll = $pol->readAllPolesByEntite($recupEntite);
			foreach ($readAll as $key => $p) {
				$rep3 = $p->getPole();
				$rep4=$p->getIdentifiant();
				if (isset($_POST["listePole"]) && $_POST["listePole"] == $rep4) {
					$select = " selected=\"selected\"";
				} else {
					$select = "";
				}
				echo "<option value=$rep4$select> $rep3 </option>";
			}
		}
		?>
		</select></p>
		<!-- fin liste déroulante pour les pôles -->
		<?php 
		if (isset($_POST["listePole"]) && $_POST["listePole"] !=-1) {
		?>
			<p class="text-center">Filtrer par gestionnaire des données :
			<select name="listeService" id="listeService" onchange="document.forms['formEntite'].submit();">
				<option value=-1>- - - Tous les services- - -</option>
			<?php
			$recupPole = $_POST["listePole"];
			$serv = new ServiceMunicipalDAO();
			$readAll = $serv->readAllServMPole($recupPole);
			foreach ($readAll as $key => $sm) {
				$rep5 = $sm->getService();
				$rep6=$sm->getIdentifiant();
				if (isset($_POST["listeService"]) && $_POST["listeService"] == $rep6) {
					$select = " selected=\"selected\"";
				} else {
					$select = "";
				} 
				echo "<option value=$rep6$select> $rep5 </option>";
			}
		}
		?>
		</select></p>
	</fieldset>
</form>
</div>

<div class="container">
	<div class="row">
      	<div class="col-lg-12">
			<h2>Vue par utilisateurs :</h2>	
<?php
/*******************************************/
	echo "<table>
		<tr><th class='col-md-4'>Nom, Prénom</th><th class='col-md-8'>Accès au(x) service(s)</th>";

	if ($_SESSION['admin'] == "super admin") {
		$util = new UtilisateurDAO();
		$readAll = $util->readAllByAdmin($_SESSION['identifiant']);
	} else {
		$util = new UtilisateurDAO();
		$readAll = $util->readAllByAdminExcept($_SESSION['identifiant']);
	}
	foreach ($readAll as $key => $sm) {
		$utilisateur = $sm->getNom() . " " . $sm->getPrenom();
		$id_utilisateur = $sm->getIdentifiant();
		echo "<tr><td>" . $utilisateur . "</td><td>";
		$serv = new ServiceMunicipalDAO();
		
		if (!isset($_POST['listeEntite']) || $_POST['listeEntite'] ==-1) {
			$readAllServ = $serv->readServDroitUtil($id_utilisateur);
		} else if (isset($_POST['listeService']) && $_POST['listeService'] !=-1) {
			$readAllServ = $serv->readServDroitUtilByServ($id_utilisateur,$_POST['listeService']);
		} else if (isset($_POST['listePole']) && $_POST['listePole'] !=-1) {
			$readAllServ = $serv->readServDroitUtilByPol($id_utilisateur,$_POST['listePole']);
		} else if (isset($_POST['listeEntite']) && $_POST['listeEntite'] !=-1) {
			$readAllServ = $serv->readServDroitUtilByEnt($id_utilisateur,$_POST['listeEntite']);
		}
		echo $readAllServ;
		echo "</td></tr>";
/*
		$daodroits= new DroitDAO();
		$readAllDroits= $daodroits->readIdUtil($_POST["utilisateur"]);
		if (!empty($readAllDroits)){
			$list = implode(",", $readAllDroits);
			if (($_SESSION['admin'] == "super admin")||($_SESSION['admin'] == "admin EPCI")){
				$var=$daodroits->readAllSPE($list);
			} else {
				$var=$daodroits->readAll($list);
			}
			echo $var;
		} else {
			echo "aucun";
		}
		echo'</div></div>';		*/					
	}
	echo "</table>";
/**************************************/
?>	
		</div>

	</div>
</div>
<?php
include("footer.php");
?>