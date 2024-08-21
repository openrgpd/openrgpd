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
<a href="admin_all.php">Menu général</a> / Export des traitements
</div>

<div class="container">
	<div class="row">
	    <div class="col-lg-12">
			<div class="centrer">
				<h1 class="centrer">Exporter au format .csv</h1>
			</div>
			<div class="col-lg-6">
				<div class="well">
				<form method='POST' action='exportCSV.php'>
					<label for="listbox">Choisissez l'entité pour l'export : 
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
					<h4> Exporter un tableau csv:</h4>
					<!--<a href="manuels/....pdf">Lire la note sur l'export</a> <br/>-->
					<p><input type="submit" class="btn btn-success btn-lg btn-block" value="Export au format CSV" name="validerCSV"/></p>
					<h4>Ouvrir le fichier avec LibreOffice Calc (encodage UTF-8)</h4>

				</form>
				</div>
			</div>		
		</div>	
	</div>
</br>
</div>


</body>
</html>
