<?php 
// Utilisation et démarrage des sessions
session_start();
include("connexion/check_connect.php");
include("connexion/Daos.php");

?>
<html lang="fr">
<head>
<meta content="text/html" charset="utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="bootstrap/css/bootstrap.css" rel="stylesheet"> 
<script src="bootstrap/js/jquery.js"></script>
<script src="bootstrap/js//bootstrap.min.js"></script>
<link href="bootstrap/css/screen.css" rel="stylesheet">

<title>RGPD Tableau</title>
</head>
<body>

<?php
use DAO\pole\PoleDAO;
use DAO\entite\EntiteDAO; 
use DAO\Entitepole\EntitepoleDAO;
use DAO\Formulaire\FormulaireDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use metier\utilisateur\Utilisateur;
use DAO\Utilisateur\UtilisateurDAO;
use DAO\Droit\DroitDAO;
?>

<div id="container">
	<a href="visu.php" id="header"></a>
</div> 
   
<nav class="navbar navbar-default">
	<div class="container-fluid">
<?php 
	if (!isset($_SESSION['identifiant'])) { 
?>
		<ul class="nav navbar-nav navbar-right">
			<li><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">connexion</button></li> 
		</ul>
<?php 
	} else { 
		//selection des entités de l'utilisateur
		$sql="SELECT entite FROM entites
			inner join applidroitacces on applidroitacces.id_entite = entites.identifiant
			inner join utilisateurs on applidroitacces.id_utilisateur = utilisateurs.identifiant
			WHERE utilisateurs.identifiant = ".$_SESSION['identifiant']." LIMIT 5";
		$stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
		$stmt->execute();
		$cptEnt = 0;
		$chaine = "";
        while ($row = $stmt->fetch()) {
			$entite=$row["entite"];
			if ($cptEnt == 0) {
				$chaine = $entite;
			} else {
				$chaine = $chaine." / ".$entite;
			}
			$cptEnt++;
		}
?>     
		<div>
		<b>Bienvenue, <?php echo htmlspecialchars($_SESSION['nom'])." ".htmlspecialchars($_SESSION['prenom'])."</b><i> (".$chaine.")</i>"; ?>
		<ul class="nav navbar-nav navbar-right" style="vertical-align: center;">
<?php 
		if (!isset($_SESSION['identifiant'])){
			echo"<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Nouvelle déclaration\" onclick=\"window.location.href='index.php'\" disabled>";
		} else {
			echo"<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Nouvelle déclaration\" onclick=\"window.location.href='formulaire.php'\">";
			//echo"<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Consulter un modèle\" onclick=\"window.location.href='charger_modele.php'\">";                   
		}
?>

<?php 
			$daodroitutilisateur=new UtilisateurDAO();
			$utilisateuradmin=$daodroitutilisateur->readDroitAdmin($_SESSION['identifiant']);
			$array = (array) $utilisateuradmin;
			if (in_array("admin", $array) || in_array("super admin", $array) || in_array("admin EPCI", $array)){
				echo "<a href=\"admin_all.php\"><button type=\"button\" class=\"btn btn-info btn-lg\" >Administration</button></a>";
			}
?>
			<a href="connexion/deconnexion.php"><button type="button" class="btn btn-info btn-lg" >Déconnexion</button></a>
		</ul>
		</div>
<?php 
	} 
?>
    </div>
</nav>
 
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">		
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">connexion</h4></div>
							
			<div class="modal-body">
			   <div class="row">
				   <form class="col-md-6" name="connexion" method="post" action="">
						<label> Votre login :</label>
						<input type="text" name="loginConnexion">
						<label> Votre mot de passe :</label> 
						<input type="password" name="mdpConnexion"> 
						<button type="submit" class="btn btn-success btn-lg" name="validerConnexion" >Valider</button>
				   </form>   
			   </div>				   
			</div>
		</div>
	</div>
</div>     	  

<h1 class="text-center">Liste des traitements recensés</h1>

<!-- Pour filtrer par utilisateur -->
<div class="row" style="border-top:1px solid #cecece;" align=center>
	<!-- Pour rechercher par Pole et Service -->
	
	<div class="col-md-12">
			<form class="col-md-2" method="POST" action="" id="formUtilisateur">
<?php 
if (!isset($_POST["visuGest"]) || ($_POST["visuGest"] == 0)) {
?> 		
		<input type="hidden" name="visuGest" value="<?php echo $_SESSION['identifiant']; ?>"/>
<?php 
} else { 
?>
		<input type="hidden" name="visuGest" value="0"/>
<?php 
} 
?>
		<input type="submit" class="btn btn-danger right" value="Afficher tous les traitements" name="btnVisuGest" onclick="Change_valeur()"/></p>
	</form>
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
		<!-- Pour rechercher par mots clés  -->
		<form class="col-md-4" method="POST" action="" id="formMotCle">
			<p class="text-center">Recherche par mot-clé :
				<input type="text" name="recherche" />
				<input type="submit" class="btn btn-success right" value="Rechercher" name="btnrecherche"/>
			</p>
		</form>
	</div>
	<div class="col-md-12" style="border-top:1px solid #cecece;">
		<!-- Pour rechercher par mots clés -->
		<form method="POST" action="" id="formFiltre">
			<!--<input type="button" class="boutonSpoiler" value="Afficher/Masquer les filtres" onclick="ouvrirFermerSpoiler(this);" />-->
			<input type="button" class="btn btn-warning right" value="Afficher/Masquer les filtres" onclick="ouvrirFermerSpoiler(this);" />
			<div class="contenuSpoiler" style='display:none'><br>
				<div class="form-row">
					<div class="form-group col-md-2">Validé par le DPD : 
						<input type="radio" name="validationdpdON" id="validationdpdON1" value=1> Oui
						<input type="radio" name="validationdpdON" id="validationdpdON2" value=0> Non
					</div>
					<div class="form-group col-md-2">Transfert hors UE : 
						<input type="radio" name="transfertHUEON" id="transfertHUE1" value=1> Oui
						<input type="radio" name="transfertHUEON" id="transfertHUE2" value=0> Non
					</div>
					<div class="form-group col-md-2">Niveau d'identification : 
						<select name="nividentON" id="nividentON">
							<option value=-1>- liste -</option>
							<option value= 0> 0 </option>
							<option value= 1> 1 </option>
							<option value= 2> 2 </option>
							<option value= 3> 3 </option>
						</select>
					</div>
					<div class="form-group col-md-2">Niveau de securité : 
						<select name="securiteON" id="securiteON">
							<option value=-1>- liste -</option>
							<option value= 0> 0 </option>
							<option value= 1> 1 </option>
							<option value= 2> 2 </option>
							<option value= 3> 3 </option>
						</select>
					</div>
					<div class="form-group col-md-2">PIA : 
						<input type="radio" name="piaON" id="piaON1" value=1> Oui
						<input type="radio" name="piaON" id="piaON2" value=0> Non
					</div>
					<div class="form-group col-md-2">Hors registre des traitements
						<input type="checkbox" name="horsRegistre" value="Oui">
					</div>
					<div class="form-group col-md-6">Catégorie de données traitées : 
						<input type="checkbox" name="catdtcbox[]" value=1> <i>Etat-civil, identité, données d'identification</i>
						<input type="checkbox" name="catdtcbox[]" value=2> <i>Vie personnelle</i>
						<input type="checkbox" name="catdtcbox[]" value=3> <i>Vie professionnelle</i>
						<input type="checkbox" name="catdtcbox[]" value=4> <i>Information d'ordre économique et financier</i>
						<input type="checkbox" name="catdtcbox[]" value=5> <i>Données de connexion</i>
						<input type="checkbox" name="catdtcbox[]" value=6> <i>Données sensibles</i>
					</div>
					<div class="form-group col-md-6">Catégorie de licéités : 
						<input type="checkbox" name="catlcbox[]" value=1> <i>Consentement</i>
						<input type="checkbox" name="catlcbox[]" value=2> <i>Contrat </i>
						<input type="checkbox" name="catlcbox[]" value=3> <i>Obligation légale</i>
						<input type="checkbox" name="catlcbox[]" value=4> <i>Intérêts vitaux</i>
						<input type="checkbox" name="catlcbox[]" value=5> <i>Mission d'intérêt public</i>
						<input type="checkbox" name="catlcbox[]" value=6> <i>Fins légitime du RT</i>
					</div>
				</div>
				<!--<div class="form-row">
					<div class="form-group col-md-12">Tri par :
						<select name="listeTri" id="listeTri">
							<option value=-1>- Tri possible -</option>
							<option value="1" > 1 </option>
							<option value="2" > 2 </option>
							<option value="3" > 3 </option>
							<option value="4" > 4 </option>
						</select>
						<input type="radio" name="tri" id="asc" value="Asc"> Asc
						<input type="radio" name="tri" id="desc" value="Desc"> Desc
					</div>
				</div>-->
				<div class="form-row">
					<div class="form-group col-md-12">
						<input type="reset" class="btn btn-secondary" value="Reset"/>
						<input type="submit" class="btn btn-success" value="Rechercher" name="btnfiltre"/>
					</div>
				</div>
			</div>
		</form>
	</div>
		
<script>
function ouvrirFermerSpoiler(bouton) {
    var divContenu = bouton.nextSibling;
    if(divContenu.nodeType == 3) divContenu = divContenu.nextSibling;
    if(divContenu.style.display == 'block') {
        divContenu.style.display = 'none';
    } else {
        divContenu.style.display = 'block';
    }
}
</script>

	</div>
</div>

<?php
// Partie liste des pôles et services
if (isset($_POST["visuGest"]) && ($_POST["visuGest"] <> "0")){
	$daoForm= new FormulaireDAO();
	$readAllForm = $daoForm->readAllFormByUser($_POST["visuGest"]);
	$rep=\metier\formulaire\Formulaire::tableauFormulaire($readAllForm);
	echo $rep;
} elseif (isset($_POST["btnfiltre"])) {
	//Catégorie de donnée traitée
	$catdtcbox="";
	if (!isset($_POST["catdtcbox"])) {
		$cac = "";
	} else {
		$cac = $_POST['catdtcbox'];
		for ($i=0; $i<count($cac); $i++) {
			if ($i ==0){
				$catdtcbox=$cac[$i];
			} else {
				$catdtcbox=$catdtcbox.";".$cac[$i];		
			}
		}
	}
	//Catégorie de licéité traitée
	$catlcbox="";
	if (!isset($_POST["catlcbox"])) {
		$cac = "";
	} else {
		$cac = $_POST['catlcbox'];
		for ($i=0; $i<count($cac); $i++) {
			if ($i ==0){
				$catlcbox=$cac[$i];
			} else {
				$catlcbox=$catlcbox.";".$cac[$i];		
			}
		}
	}
	if (!isset($_POST["validationdpdON"])) {
		$validationdpdON="";
	} else {
		$validationdpdON=$_POST["validationdpdON"];
	}
	if (!isset($_POST["transfertHUEON"])) {
		$transfertHUEON="";
	} else {
		$transfertHUEON=$_POST["transfertHUEON"];
	}
	if (!isset($_POST["nividentON"])) {
		$nividentON="";
	} else {
		$nividentON=$_POST["nividentON"];
	}
	if (!isset($_POST["securiteON"])) {
		$securiteON="";
	} else {
		$securiteON=$_POST["securiteON"];
	}
	if (!isset($_POST["piaON"])) {
		$piaON="";
	} else {
		$piaON=$_POST["piaON"];
	}
	if (!isset($_POST["listeTri"])) {
		$listeTri="";
	} else {
		$listeTri=$_POST["listeTri"];
	}
	if (!isset($_POST["tri"])) {
		$tri="";
	} else {
		$tri=$_POST["tri"];
	}
	if (!isset($_POST["horsRegistre"])) {
		$horsRegistre="";
	} else {
		$horsRegistre=$_POST["horsRegistre"];
	}
	
	$daoForm= new FormulaireDAO();
	$readAllForm = $daoForm->readAllFormByFiltre($_SESSION['identifiant'],$validationdpdON,$transfertHUEON,$nividentON,$securiteON,$piaON,$horsRegistre,$catdtcbox,$catlcbox,$listeTri,$tri);
	$rep=\metier\formulaire\Formulaire::tableauFormulaire($readAllForm);
	echo $rep; 
} elseif (!isset($_POST["recherche"]) || $_POST["recherche"] =="") {
	$daoForm= new FormulaireDAO();
	if (!isset($_POST["listeEntite"]) || $_POST["listeEntite"] ==-1){
		$readAllForm = $daoForm->readAllFormByGest($_SESSION['identifiant']);
	} elseif (isset($_POST["listeService"]) && $_POST["listeService"]!=-1) {
		$readAllForm = $daoForm->readAllFormByServGest($_POST["listeService"]);
	} elseif (isset($_POST["listePole"]) && $_POST["listePole"] !=-1) {
		$readAllForm = $daoForm->readAllFormByPoleGest($_POST["listePole"]);
	} elseif (isset($_POST["listeEntite"]) && $_POST["listeEntite"] !=-1) {
		$readAllForm = $daoForm->readAllFormByEntite($_POST["listeEntite"]);
	}
	$rep=\metier\formulaire\Formulaire::tableauFormulaire($readAllForm);
	echo $rep; 
} elseif (isset($_POST["recherche"])){
	$daoForm= new FormulaireDAO();
	$readAllForm = $daoForm->readAllFormPartout($_POST["recherche"]);
	$rep=\metier\formulaire\Formulaire::tableauFormulaire($readAllForm);
	echo $rep;
}

// Partie validation de la connexion
if (isset($_POST["validerConnexion"])){
	if (!empty($_POST["loginConnexion"])){
		$recupLogin=$_POST["loginConnexion"];
		$_SESSION["loginConnexion"]=$recupLogin;
	} else {
		$recupLogin="";
	}
	if (!empty($_POST["mdpConnexion"])){
		$recupMdp=$_POST["mdpConnexion"];
		$_SESSION["mdpConnexion"]=$recupMdp;
	} else {
		$recupMdp="";
	}
	$util= new Utilisateur("", "", $recupLogin, $recupMdp,"");
	
	if (!$util->utilisateur_est_connecte()){
		$util->valideConnexion($recupMdp);
		echo '<script type="text/javascript">
			 parent.window.location.reload();
			 </script> ';
	} else {
		$util->valideConnexion($recupMdp);
	}
}
?>
</body>
<?php
include("footer.php");
?>
</html>