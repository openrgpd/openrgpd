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
use DAO\appliDroitAcces\AppliDroitAccesDAO;
use metier\applidroitacces\Applidroitacces;
use DAO\Entitepole\EntitepoleDAO;

session_start();
include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/
//partie creation/modification des accès utilisateurs
if (isset($_POST["validerAcces"])) { 
    if (isset($_POST['utilisateurSelect']) && $_POST["utilisateurSelect"]!=-1 && isset($_POST['listbox3']) && $_POST["listbox3"]!=0){	
	    $utilisateur=($_POST["utilisateurSelect"]);
		//partie anciennes entités
		$daoent= new AppliDroitAccesDAO();
		$readIdEnt= $daoent->readIdEnt($utilisateur);
		$ancienEnt = implode(",", $readIdEnt);
		//partie nouvelles entités
		$nouveauEnt=htmlspecialchars($_POST["listbox3"]);
		$daoent->updatePush($utilisateur, $ancienEnt, $nouveauEnt);
		
		$daoAfterUpdate= new DroitDAO();
		$daoAfterUpdate->deleteDroitUtilAfterUpdate($utilisateur);
        $message="Accès modifiés";
        //echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
		//echo '<script type="text/javascript">window.location="admin_droits.php</script>';
		//Exit();
    } else {
        $message="Aucun utilisateur sélectionné";
        echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
		//Exit();
    } 
}

//partie creation/modification des droits utilisateurs
if (isset($_POST["validerDroits"])) { 
    if (isset($_POST['utilisateurSelect']) && $_POST["utilisateurSelect"]!=-1 && isset($_POST['listbox']) && $_POST["listbox"]!=0){
        $utilisateur=($_POST["utilisateurSelect"]);
        $daodroits= new DroitDAO();
        $readIdutil= $daodroits->readIdUtil($utilisateur);
        $ancienDroits = implode(",", $readIdutil);
        $nouveauxDroits=htmlspecialchars(($_POST["listbox"]));
        $daodroits->updatePush($utilisateur, $ancienDroits, $nouveauxDroits);
        $message="Droits service enregistrés";
        echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
    } else {
        $message="Aucun utilisateur sélectionné";
        echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
    }      
}

//pour sélection par entité
if (isset($_POST["validerDroits1"])) { 
	if (isset($_POST['utilisateurSelect']) && $_POST["utilisateurSelect"]!=-1 && isset($_POST['listbox1']) && $_POST["listbox1"]!=0){
		$utilisateur=($_POST["utilisateurSelect"]);
		$daodroits= new DroitDAO();
		$readIdutil= $daodroits->readIdUtil($utilisateur);
		$ancienDroits = implode(",", $readIdutil);
		//on récupère les entités! sélection des services dans la fonction
		$nouveauxDroits=htmlspecialchars(($_POST["listbox1"]));
		$daodroits->updatePushEntite($utilisateur, $ancienDroits, $nouveauxDroits);
		$message="Droits enregistrés";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
    } else {
		$message="Aucun utilisateur sélectionné";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
	}      
}

//pour sélection par pole
if (isset($_POST["validerDroits2"])) { 
	if (isset($_POST['utilisateurSelect']) && $_POST["utilisateurSelect"]!=-1 && isset($_POST['listbox2']) && $_POST["listbox2"]!=0){
		$utilisateur=($_POST["utilisateurSelect"]);
		$daodroits= new DroitDAO();
		$readIdutil= $daodroits->readIdUtil($utilisateur);
		$ancienDroits = implode(",", $readIdutil);
		$nouveauxDroits=htmlspecialchars(($_POST["listbox2"]));
		//on récupère les entités! sélection des poles dans la fonction
		$daodroits->updatePushPole($utilisateur, $ancienDroits, $nouveauxDroits);
		$message="Droits enregistrés";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
	} else {
		$message="Aucun utilisateur sélectionné";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
	}      
}

if (isset($_POST["supprDroits"])) {
    if (isset($_POST['utilisateurSelect']) && $_POST["utilisateurSelect"]){
        $utilisateur=($_POST["utilisateurSelect"]);
        $daodroits= new DroitDAO();
        $SupIdutil= $daodroits->deleteDroitUtil($utilisateur);
        $message="Droits supprimés";
        echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
    } else {
		$message="Aucun utilisateur sélectionné";
		echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
    }      
}

?>
<div class="container">
<a href="admin_all.php">Menu général</a> / Attribution des droits
</div>

<div class="centrer">
<h1 class="centrer">Administration des utilisateurs</h1></div>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h2>Modifier les droits/accès utilisateurs :</h2>
			<form method="post"  id="form_util" action="">
			<!-- 		 liste déroulante pour les utilisateurs.	 -->
				<p class="important">* Choisissez un utilisateur :</p>
				<p><select name="utilisateur" id="multi-select" onchange="document.forms['form_util'].submit();">
				<!--<p><select name="utilisateur" id="multi-select" onchange="document.forms['form_util'].submit();getGestionnaire(this.value);">-->
				
					<option value=-1>- - - Choisissez un utilisateur- - -</option>
					<?php  	
						$_SESSION['userSession'] = $_POST['utilisateur']; 
						$util = new UtilisateurDAO();					
						if ($_SESSION['admin'] == "super admin"){
							$readAll = $util->readAllByAdmin($_SESSION['identifiant']);
						} else if ($_SESSION['admin'] == "admin EPCI"){
							$readAll = $util->readAllByAdminExcept($_SESSION['identifiant']);
						} else {
							$readAll = $util->readAllByAdminExceptAdmin($_SESSION['identifiant']);
						}
						foreach ($readAll as $key => $sm) {
							$rep = $sm->getNom() . " " . $sm->getPrenom();
							$rep2 = $sm->getIdentifiant();
							if (isset($_SESSION['userSession']) && $_SESSION['userSession'] == $rep2) {
								$select = " selected=\"selected\"";
							} else {
								$select = "";
							}							
							echo "<option value=$rep2$select> $rep </option>";
						}
					?>
				</select></p>
				<span id="blocGest"></span>
				
				<!-- fin liste déroulante pour les utilisateurs. -->
				<?php 
				if (isset($_POST['utilisateur']) && $_POST["utilisateur"]!=-1){
					// Accès aux entités
					echo'<div class="row"><div class="col-lg-12">';
					echo '<p>Cet utilisateur à accès en visualisation à :</p>';
					$daoent = new AppliDroitAccesDAO();
					$readAllent = $daoent->readAllEntiteByUtil($_POST["utilisateur"]);
					if (!empty($readAllent)){
						$list = implode(",", $readAllent);
						$var=$daoent->readAll($list);
						echo $var;
					} else {
						echo "aucun";
					}
					echo'</div>';

					//gestion de services
					echo'<div class="row"><div class="col-lg-12">';
					echo '<p>Cet utilisateur est gestionnaire des services suivants :</p>';
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
					echo'</div></div>';							
				} 
				?>			
				<!--Pour donner des droits de visualisation sur une entité-->
				<div class="well">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-md-5 mb-5">
								<p class="important">A accès à :</p>
								<p><select multiple="multiple" placeholder="choisissez une/des entité(s)" class="SlectBox" name="listbox3" id="multi-select">
								<?php
								$ent = new EntiteDAO();
								$readAll = $ent->readAllEntitesByAdmin($_SESSION['identifiant']);

								foreach ($readAll as $key => $e) {
									$rep = $e->getEntite();
									$rep2 = $e->getIdentifiant();
									
									$daoent = new AppliDroitAccesDAO();
									$readAllent = $daoent->readAllEntiteByUtil($_POST['utilisateur']);
									$select="";
									foreach ($readAllent as $d){
										if ($d == $rep2) {
											$select = " selected=\"selected\"";
										}
									}											
									echo "<option value='".$rep2."'".$select.">".$rep."</option>";
								}
								?>	
								</select></p>
							</div>
							<div class="col-md-2 mb-2">
								<input name="utilisateurSelect" type="hidden" value=<?php if (!empty($_POST["utilisateur"])){ echo ($_POST["utilisateur"]); } else { echo "";};?>>
								<br><input type="submit" class="btn btn-success btn-lg" value="Valider" name="validerAcces"/>
							</div>
							<div class="col-md-5 mb-5">
								<p>Permet à l'utilisateur de visualiser les traitements de(s) l'entité(s) sélectionnée(s)</p>
							</div>
						</div>
					</div>
				</div>				
<!--Pour donner des droits sur la gestion d'un service-->
				<div class="well">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-md-5 mb-5">
								<p class="important">Est gestionnaire sur le/les service(s) suivant(s) :</p>
								<p><select multiple="multiple" placeholder="choisissez un/des service(s)" class="SlectBox" name="listbox" id="multi-select">
								<?php
								$serv = new ServiceMunicipalDAO();
								$readAll = $serv->readAllServMByAdmin($_POST['utilisateur']);
								$compt = 1;
								foreach ($readAll as $key => $sm) {
									$rep = $sm->getService();
									$rep2 = $sm->getIdentifiant();

									$daoserv = new DroitDAO();
									$readAllserv = $daoserv->readAllServMByUtil($_POST['utilisateur']);
									$select="";
									foreach ($readAllserv as $d){
										if ($d == $rep2) {
											$select = " selected=\"selected\"";
										}
									}						
									//selection des entités de l'utilisateur
									$sql="SELECT entites.entite FROM entites
										inner join servicesmunicipaux on servicesmunicipaux.entite = entites.identifiant
										WHERE servicesmunicipaux.identifiant = ".$rep2." ";
									$stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
									$stmt->execute();
									$row = $stmt->fetch();
									$entite=$row["entite"];
									
									echo "<option value=".$rep2."".$select.">".$rep." <i>(".$entite.")</i> </option>";
									$compt ++;
								}
								?>
								</select></p>
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
								<!-- fin multiselect gestionnaire -->
							</div>
							<div class="col-md-2 mb-2">
								<br><input type="submit" class="btn btn-success btn-lg" value="Valider" name="validerDroits"/>
								<input type="submit" class="btn btn-danger btn-lg" value="Aucun droit" name="supprDroits"/>
							</div>
							<div class="col-md-5 mb-5">
								<p>Permet à l'utilisateur de créer/modifier des traitements pour le(s) service(s) sélectionné(s)</p>
							</div>
						</div>
					</div>
				</div>
<!--Pour donner des droits sur la gestion d'un pôle-->
				<div class="well">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-md-5 mb-5">
								<p class="important">Est gestionnaire sur le/les service(s) des pôles suivants</p>
								<p><select multiple="multiple" placeholder="choisissez un/des pôle(s)" class="SlectBox" name="listbox2" id="multi-select">
								<?php
								$pol = new PoleDAO();
								$readAll = $pol->readAllPolesByAdmin($_POST['utilisateur']);
								foreach ($readAll as $key => $p) {
									$rep = $p->getPole();
									$rep2 = $p->getIdentifiant();
									
									$daopol = new DroitDAO();
									$readAllpol = $daopol->readAllServMPoleByUtil($_POST['utilisateur']);
									$select="";
									foreach ($readAllpol as $d){
										if ($d == $rep2) {
											$select = " selected=\"selected\"";
										}
									}	
									//selection des entités de l'utilisateur
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
								?></select></p>
							</div>
							<div class="col-md-2 mb-2">
								<br><input type="submit" class="btn btn-success btn-lg" value="Valider" name="validerDroits2"/>
							</div>
							<div class="col-md-5 mb-5">
								<p>Permet à l'utilisateur de créer/modifier des traitements pour tous les services du(des) pôle(s) sélectionné(s)</p>
							</div>
						</div>
					</div>
				</div>
<!--Pour donner des droits sur la gestion d'une entité-->
				<div class="well">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-md-5 mb-5">
								<p class="important">Est gestionnaire sur le/les service(s) des entités suivantes</p>
								<p><select multiple="multiple" placeholder="choisissez une/des entité(s)" class="SlectBox" name="listbox1" id="multi-select">
								<?php
								$ent = new EntiteDAO();
								$readAll = $ent->readAllEntitesByAdmin($_POST['utilisateur']);
								foreach ($readAll as $key => $entites) {
									$rep = $entites->getEntite();
									$rep2 = $entites->getIdentifiant();
									
									$daoent = new DroitDAO();
									$readAllent = $daoent->readAllServMEntiteByUtil($_POST['utilisateur']);
									$select="";
									foreach ($readAllent as $d){
										if ($d == $rep2) {
											$select = " selected=\"selected\"";
										}
									}		
									echo "<option value=$rep2$select> $rep </option>";
								}
								?>
								</select></p>
							</div>
							<div class="col-md-2 mb-2">
								<br><input type="submit" class="btn btn-success btn-lg" value="Valider" name="validerDroits1"/>
							</div>
							<div class="col-md-5 mb-5">
								<p>Permet à l'utilisateur de créer/modifier des traitements pour tous les services de(des) l'entité(s) sélectionnée(s)</p>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
include ("footer.php");
?>
