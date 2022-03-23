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

//Nouveau Mdp
if (isset($_POST["validerMdp"])) { 
	if ((!empty($_POST["newMdp"])) && (!empty($_POST["newMdpC"]))) {
		if (($_POST["newMdp"]) == ($_POST["newMdpC"])) {
			$id_utilisateur=($_POST["validerMdp"]);
			$daoUtil = new UtilisateurDAO();
			$rep=$daoUtil->readId($id_utilisateur);
			$nom=$rep->getNom();
			$prenom=$rep->getPrenom();
			$login=$rep->getLogin();
			$niveauAdmin= $rep->getAdmin();
			$mdphache= password_hash($_POST["newMdp"], PASSWORD_DEFAULT);	
			$nbessai= $rep->getNbessai();
			$mail= $rep->getMail();
	
			$objet= new Utilisateur($nom,$prenom,$login,$mdphache,$niveauAdmin,$nbessai,$mail);
			$objet->setIdentifiant($id_utilisateur);
			$daoupdate= new UtilisateurDAO();
			$update= $daoupdate->update($objet);			
			$message="Mot de passe correctement modifié";
			echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
			echo '<script type="text/javascript">window.location="admin_utilisateur_modif_supr.php"</script>';
			Exit();

		} else {
			$message="Le Mot de passe ne correspond pas";
			echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
			Exit();
		}  
	} else {
		$message="Un des champs de Mdp est vide";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
		Exit();
	}
}

if (isset($_POST["btnmodif"])) { 
	$id_utilisateur=$_POST["btnmodif"];
	$message="Aucune modification prise en compte"; 

	//rappel des valeurs de l'utilisateur
	$daoUtil = new UtilisateurDAO();
	$rep=$daoUtil->readId($id_utilisateur);
	$nom=$rep->getNom();
	$prenom=$rep->getPrenom();
	$login=$rep->getLogin();
	$mdphache=$rep->getMdphache();
	$nbessai= $rep->getNbessai();
	$niveauAdmin= $rep->getAdmin();
	$mail= $rep->getMail();

	//Droits Admin/contributeur
	if ($niveauAdmin <> 'super admin') {
		if (!empty($_POST["niveau"])) {
			$niveauAdmin= ($_POST["niveau"]);
		}
	}	
		
	//nouveau nom
	if (!empty($_POST["nom"])) {
		$nom= ($_POST["nom"]);
		$message="Modifications enregistrées";
	}	
	
	//nouveau prénom
	if (!empty($_POST["prenom"])) {
		$prenom= ($_POST["prenom"]);
		$message="Modifications enregistrées";
	}		
	
	//nouveau mail
	if (!empty($_POST["mail"])) {
		$mail= ($_POST["mail"]);
		$message="Modifications enregistrées";
	}	
	
	//nouveau nbessai
	if (!empty($_POST["nbessai"])) {
		$nbessai= ($_POST["nbessai"]);
		$message="Modifications enregistrées";
	}	

	//nouveau login
	if (!empty($_POST["login"])) {
		if ($login == $_POST["login"]){
			$login = ($_POST["login"]);
		} else {
			$daoUtilisateur=new UtilisateurDAO();
			if (!$daoUtilisateur->existLogin($_POST["login"])){
				$login= ($_POST["login"]);
				$message="Modifications enregistrées";
			} else {
				$message="Ce login existe déjà, les autres modifications sont bien prises en compte";
			}
		
		}
	}
	
	//update final de l'utilisateur
	$objet= new Utilisateur($nom,$prenom,$login,$mdphache,$niveauAdmin,$nbessai,$mail);
	$objet->setIdentifiant($id_utilisateur);
	$daoupdate= new UtilisateurDAO();
	$update= $daoupdate->update($objet);	
	echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
}
//partie suppression d'un utilisateur
if (isset($_POST["validerSupp"])) {
	$id_utilisateur=$_POST["validerSupp"];
	$daodroits=new DroitDAO();
	$daodroits->deleteDroitUtil($id_utilisateur);
	$daoacces=new AppliDroitAccesDAO();
	$daoacces->deleteByUtil($id_utilisateur);
	$daoutil=new UtilisateurDAO();
	$daoutil->delete($id_utilisateur);
	echo '<script type="text/javascript">window.alert("Suppression effectuée");</script>';
}

?>
<div class="container">
	<a href="admin_all.php">Menu général</a> / modifier un utilisateur
</div>
<div class="centrer">
	<h1 class="centrer">Administration des utilisateurs</h1>
</div>
<div style="margin: 3em">
	<div class="row">
		<div class="col-lg-12">

<!--ajout 13/12/2018-->

<form method="POST" action="" id="formEntite">
	<fieldset>
		<!-- 		 liste déroulante pour les Entités.	 -->
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
	</fieldset>
</form>

<!-- Modification -->

			<h2>modifier un utilisateur :</h2>	
			<table>
			<tr><th class='col-md-1'>Nom</th><th class='col-md-1'>Prénom</th><th class='col-md-1'>Login</th><th class='col-md-2'>Adresse mail</th>
				<th class='col-md-1'>Type</th><th class='col-md-2'>Accès</th><th class='col-md-1'>nb essai</th><th class='col-md-1'>Mdp</th><th class='col-md-1'>Modification</th><th class='col-md-1'>Suppression</th></tr>
<!-- 		 liste déroulante pour les utilisateurs.	 -->
	<?php
		/*filtre*/
		if (isset($_POST["listeEntite"]) && $_POST["listeEntite"] !=-1) {
			if ($_SESSION['admin'] == "super admin") {
				$util = new UtilisateurDAO();
				$readAll = $util->readAllByAdminFiltre($_SESSION['identifiant'],$_POST["listeEntite"]);
			} else {
				$util = new UtilisateurDAO();
				$readAll = $util->readAllByAdminExceptFiltre($_SESSION['identifiant'],$_POST["listeEntite"]);
			}
		} else {
			if ($_SESSION['admin'] == "super admin") {
				$util = new UtilisateurDAO();
				$readAll = $util->readAllByAdmin($_SESSION['identifiant']);
			} else {
				$util = new UtilisateurDAO();
				$readAll = $util->readAllByAdminExcept($_SESSION['identifiant']);
			}
		}

		$cpt=1;
		foreach ($readAll as $key => $sm) {
			$nom = $sm->getNom();
			$prenom = $sm->getPrenom();
			$login = $sm->getLogin();
			$mail = $sm->getMail();
			$acces = $sm->getAdmin();
			$essai = $sm->getNbessai();
			$id_utilisateur = $sm->getIdentifiant();
			echo "<tr><form method='POST' action=''>";
			?>
			<td><input type='text' class='form-control' name='nom' value = "<?php echo $nom; ?>" required></td>
			<?php
			echo "<td><input type='text' class='form-control' name='prenom' value = '".$prenom."'required></td>
			<td><input type='text' class='form-control' name='login' value = '".$login."'required></td>
			<td><input type='text' class='form-control' name='mail' value = '".$mail."'required></td>
			<td><SELECT class=form-control name='niveau' required>";
			if ($acces == 'contributeur') { 
				echo '<OPTION value="contributeur" selected>Contributeur</OPTION>';
				echo '<OPTION value="admin" >Administrateur</OPTION>';
				echo '<OPTION value="admin EPCI" >Admin EPCI</OPTION>';
		 	} else if ($acces == 'admin'){
				echo '<OPTION value="contributeur" >Contributeur</OPTION>';
				echo '<OPTION value="admin" selected>Administrateur</OPTION>';
				echo '<OPTION value="admin EPCI" >Admin EPCI</OPTION>';
		 	} else if ($acces == 'admin EPCI'){
				echo '<OPTION value="contributeur" >Contributeur</OPTION>';
				echo '<OPTION value="admin" >Administrateur</OPTION>';
				echo '<OPTION value="admin EPCI" selected>Admin EPCI</OPTION>';
		 	} else {
				echo '<OPTION value="super admin" >Super Admin</OPTION>';
			}
			echo '</SELECT></td>';

			echo '<td>';
			// droits d'accès actuel
			$daoent = new AppliDroitAccesDAO();
			$readAllent = $daoent->readAllEntiteByUtil($id_utilisateur);
			if (!empty($readAllent)){
				$list = implode(",", $readAllent);
				$var=$daoent->readAll($list);
				echo $var;
			} else {
				echo "aucun";
			}
			echo '</td>';
			// nombre d'essais
			echo "<td><input type='text' class='form-control' name='nbessai' value = '".$essai."'></td>";

			//<!-- Modal pour nouveau Mdp-->	
			echo "<td><button type=\"button\" class=\"btn btn-info btn-lg\" data-toggle=\"modal\" data-target=\"#myModal$cpt\"> Nv Mdp </button></td>";	
			echo "<div class=\"modal fade\" id=\"myModal$cpt\" role=\"dialog\">";
			echo "<div class=\"modal-dialog\">";
			//<!-- Modal content-->
			echo "<div class=\"modal-content\">";
			echo "<div class=\"modal-header\">";
			echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>";
			echo "<h4 class=\"modal-title\">Générer un nouveau mot de passe</h4></div>";  
			echo "<div class=\"modal-body\">";
?>  
			<form method="post"  id="form_mdp" action="">
				<h2>Regénérer le mot de passe de l'utilisateur:</h2>
				<p class="important">* Nouveau Mdp :</p>
					<input type="password" class="form-control" name="newMdp" value='' 
						pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$" 
						alt="Le mot de passe doit contenir de 8 à 15 caractères, au moins une lettre minuscule/un chiffre/un de ces caractères spéciaux: $ @ % * + - _ !"
						title="Le mot de passe doit contenir de 8 à 15 caractères, au moins une lettre minuscule/un chiffre/un de ces caractères spéciaux: $ @ % * + - _ !"
						onfocus="if(this.value=='Ecrire ici ...'){this.value=''};"
						onblur="if(this.value==''){this.value='Ecrire ici ...'};" />
				<p class="important">* Confirmation Mdp :</p>
					<input type="password" class="form-control" name="newMdpC" value=''
						onfocus="if(this.value=='Ecrire ici ...'){this.value=''};"
						onblur="if(this.value==''){this.value='Ecrire ici ...'};" />
			<p><button name='validerMdp' type='submit' class='btn btn-success btn-lg' value='<?php echo $id_utilisateur; ?>'>Valider</button></p>
			
<?php
			$cpt++; 
			echo "</div></div></div></div></div>";
			echo "<td><button name='btnmodif' type='submit' class='btn btn-info2 btn-lg' value='$id_utilisateur'>Modification</button></td>";
			echo "<td><button name='validerSupp' type='submit' class='btn btn-danger btn-lg' value='$id_utilisateur' onclick='return confirmation();'>Suppression</button></td>
			</form></tr>";
		}
		echo "</table>";
		?>
	</div>
</div>
<?php
include("footer.php");
?>