<?php
/*A AJOUTER EN DEBUT DES PAGES*/
include("admin_header.php");
include ("connexion/Daos.php");

use DAO\Droit\DroitDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use DAO\Utilisateur\UtilisateurDAO;
use DAO\pole\PoleDAO;
use metier\utilisateur\Utilisateur;
use metier\serviceMunicipal\ServiceMunicipal;
use DAO\entite\EntiteDAO;
use DAO\Entitepole\EntitepoleDAO;
use metier\entite\Entite;
use DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO;
use DAO\Formulaire\FormulaireDAO;
use DAO\appliDroitAcces\AppliDroitAccesDAO;
use metier\applidroitacces\Applidroitacces;

session_start();

include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/
?>

<div class="container">
<a href="admin_all.php">Menu général</a> / Imprimer le registre des traitements
</div>

<div class="container">
	<div class="row">
	    <div class="col-lg-12">
			<div class="centrer">
				<h1 class="centrer">Imprimer le registre des traitements</h1>
			</div>
			<div class="col-lg-6">
				<div class="well">
				<form method='POST' action='exportPDF.php'>
					<label for="listbox">Choisissez l'entité : 
						<p><select name="entite" id="entite" >
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
					<h4> Imprimer le registre des traitements:</h4>
					<p><input type="submit" class="btn btn-success btn-lg btn-block" value="Générer le fichier PDF" name="validerPDF"/></p>
				</form>
				</div>
			</div>		
		</div>	
	</div>
</br>
</div>


</body>
</html>
