<!DOCTYPE html>
<?php
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use DAO\FormulaireCommentaire\FormulaireCommentaireDAO;
use DAO\Catdonneeformulaire\CatdonneeformulaireDAO;
use DAO\Catliceiteformulaire\CatliceiteformulaireDAO;
use DAO\Droit\DroitDAO;
use DAO\entite\EntiteDAO;
use DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO;
use DAO\Formulaire\FormulaireDAO;
use metier\formulaire\Formulaire;
use DAO\Entitepole\EntitepoleDAO;
use DAO\VariableGlobale\VariableGlobaleDAO;
use metier\variableglobale\VariableGlobale;

session_start();
include("connexion/check_connect.php");
include ("connexion/Daos.php");
?>

<html lang="fr">
<head>
	<meta content="text/html" charset="utf8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/jquery-ui.css">
	<script src="bootstrap/js/jquery-1.12.4.js"></script>
	<script src="bootstrap/js/jquery-ui.js"></script>
	<script src="bootstrap/js/datepicker-fr.js"></script>
	<!-- multiselect  -->
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<script src="bootstrap/js/bootstrap.min.js"></script>	
	<!-- <script src="bootstrap/js/jquery.js"></script> entre en conflit avec datepicker  -->
	<script src="bootstrap/js/jquery.sumoselect.min.js"></script>
	<link href="bootstrap/css/sumoselect.css" rel="stylesheet">
	<link href="bootstrap/css/screen.css" rel="stylesheet">
	<script type="text/javascript" src="LD/ld_xhr.js"></script>
	
	<title>RGPD Formulaire</title>
</head>
<body>

<div id="container">
	<a href="visu.php" id="header"></a>
</div> <!-- container -->
<br>

<?php
/*****************************************************************************
PARTIE VALIDATION TRAITEMENT  + ENVOI DU MAIL
*****************************************************************************/ 
if (isset($_POST["valider"])) {
	
	/* les champs obligatoires */
	$nomLogiciel=htmlspecialchars(($_POST['nomLogiciel']));
	$origineDonnee=htmlspecialchars(($_POST['origineDonnee']));
	
	if (!empty($_POST['validationDPD'])){ 
		$validationDPD=metier\formulaire\Formulaire::tous($_POST["validationDPD"]);
	} else {
		$validationDPD="0000-00-00";
	}

	$finaliteTraitement=htmlspecialchars(($_POST['finalite']));
	$catPersConcern=htmlspecialchars(($_POST['catPersConcernees']));
	$destiDonnees=htmlspecialchars(($_POST['destiDonnees']));
	$dureeUtiliteAdmi=htmlspecialchars(($_POST['dureeUtilit']));
	$delaiEffacement=htmlspecialchars(($_POST['delEff']));
	$support=htmlspecialchars(($_POST['support']));
	$baseJuridiqueLiceite=htmlspecialchars(($_POST['baseJuridiqueLiceite']));
	if (isset($_POST['donneePIA'])){
		if ($_POST["donneePIA"]=="non"){
			$donneePIA=0;
		} else {
			$donneePIA=1;
		}   
	} else {
		$donneePIA='';
	}
	
	if (!empty($_POST['PIA'])){
		$PIA=htmlspecialchars(($_POST['PIA']));
	} else {
		$PIA="";
	}

	if (!empty($_POST['numActivite'])){
		$num_Activite=htmlspecialchars(($_POST['numActivite']));
	} else {
		$num_Activite="";
	}

	//Catégorie de donnée traitée
	$catDonneeTraitee="";
	$cac = $_POST['catDonTrait'];
	for ($i=0; $i<count($cac); $i++) {
		if ($i ==0){
			$catDonneeTraitee=$cac[$i];
		} else {
			$catDonneeTraitee=$catDonneeTraitee.";".$cac[$i];		
		}
	}
	//$catDonneeTraitee=htmlspecialchars(($_POST['catDonTrait']));  
	
	//Catégorie de licéité 
	$catLiceiteTraitee="";
	$cac = $_POST['catLicTrait'];
	for ($i=0; $i<count($cac); $i++) {
		if ($i ==0){
			$catLiceiteTraitee=$cac[$i];
		} else {
			$catLiceiteTraitee=$catLiceiteTraitee.";".$cac[$i];		
		}
	}
	//$catDonneeTraitee=htmlspecialchars(($_POST['catLicTrait']));  
	
    /* les autres */
	if (!empty($_POST['sousFinalite'])){
		$sousFinalite=htmlspecialchars(($_POST['sousFinalite']));
	} else {
		$sousFinalite="";
	}
	
	if (!empty($_POST['commentaire'])){
		$commentaire=htmlspecialchars(($_POST['commentaire']));
	} else {
		$commentaire="";
	}
		
	if (!empty($_POST['dateMiseEnOeuvre'])){
		$dateMiseEnOeuvre=metier\formulaire\Formulaire::toUs($_POST["dateMiseEnOeuvre"]);
	} else {
		$dateMiseEnOeuvre="0000-00-00";
	}
	
	//gestionnaire
	if (isset($_POST['service']) && $_POST["service"]!=-1 && $_POST["service"]!=""){
		$id_gestionnaire=htmlspecialchars($_POST["service"]);
    } else {
        $message="Aucun utilisateur sélectionné";
    } 
	
	if (!empty($_POST['archivage'])){
		$archivage=htmlspecialchars(($_POST['archivage']));
	} else {
		$archivage="";
	}
	
	if (isset($_POST['transUE'])){
		if ($_POST["transUE"]=="non"){
			$transfertHorsUE=0;}
		else {
			$transfertHorsUE=1;
		}   
	}
	
	if (!empty($_POST['coRespT'])){
		$coRespTraitement=htmlspecialchars(($_POST['coRespT']));
	} else {
		$coRespTraitement="";
	}
		
	if (!empty($_POST['RepCoRespT'])){
		$representantCoResp=htmlspecialchars(($_POST['RepCoRespT']));
	} else {
		$representantCoResp="";
	}
	
	if (!empty($_POST['sousTrait'])){
		$sousTraitant=htmlspecialchars(($_POST['sousTrait']));
	} else {
		$sousTraitant="";
	}
		
	if (!empty($_POST['nivIdent'])){
		$nivIdent=htmlspecialchars(($_POST['nivIdent']));
	} else {
		$nivIdent="";
	}
	
	if (!empty($_POST['comident'])){
		$comIdent=htmlspecialchars(($_POST['comident']));
	} else {
		$comIdent="";
	}
	
	if (!empty($_POST['nivSecu'])){
		$nivSecu=htmlspecialchars(($_POST['nivSecu']));
	} else {
		$nivSecu="";
	}

	if (!empty($_POST['mesSecu'])){
		$mesSecu=htmlspecialchars(($_POST['mesSecu']));
	} else {
		$mesSecu="";
	}
	
	if (!empty($_POST['comsecu'])){
		$comSecu=htmlspecialchars(($_POST['comsecu']));
	} else {
		$comSecu="";
	}
	
	if (!empty($_POST['dateMAJ'])){
		$derniereMAJ=$_POST["dateMAJ"];
		//$derniereMAJ=metier\formulaire\Formulaire::toUs($_POST["dateMAJ"]);
	} else {
		$derniereMAJ=date("Y-m-d");
	}
	
	if (!empty($_POST['horsRegistre'])){
		$horsRegistre=htmlspecialchars(($_POST['horsRegistre']));
	} else {
		$horsRegistre="";
	}
	
	if (!empty($_POST['planAction'])){
		$planAction=htmlspecialchars(($_POST['planAction']));
	} else {
		$planAction="";
	}
	
	if (!empty($_POST['baseJuridique'])){
		$baseJuridique=htmlspecialchars(($_POST['baseJuridique']));
	} else {
		$baseJuridique="";
	}

	
	$declarant=$_SESSION['identifiant'];
	$formulaire=new Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee, $catPersConcern, 
					$destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement, $support, 
					$nivIdent, $comIdent, $nivSecu, $comSecu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite, $num_Activite, 
					$mesSecu);
	/****************************PARTIE ENVOI DU MAIL************************************/
	//Sélection du mail de l'entité
	$sql = "SELECT maildpd, responsable, entites.entite FROM entites 
		INNER JOIN servicesmunicipaux on servicesmunicipaux.entite = entites.identifiant
		WHERE servicesmunicipaux.identifiant = ".$id_gestionnaire;
	$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
	$stmt->execute();	
	$row = $stmt->fetch();
	$mail = $row["maildpd"];
	$resp = $row["responsable"];	
	$ent = $row["entite"];
	
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
		$passage_ligne = "\r\n";
	} else {
		$passage_ligne = "\n";
	}

	//=====Déclaration des messages au format texte et au format HTML.
	$nom_declarant=$_SESSION['nom'] . " " . $_SESSION['prenom'];
	$rep=\metier\formulaire\Formulaire::tableauMailForm($formulaire, $id_gestionnaire);
	$message_txt = "Bonjour, nouvelle entrée effectuée par ".$nom_declarant." dans la base de donnée RGPD";
	$message_html = "<html><head></head><body><b>Bonjour</b>, nouvelle entrée effectuée par ".$nom_declarant." dans la base de donnée RGPD <br> ".$rep."</body></html>";
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//=====Définition du sujet.
	$sujet = "Nouveau traitement RGPD";
	//=====Création du header de l'e-mail.
	$header = "From: \"OpenRGPD\"<".$mail.">".$passage_ligne;
	$header.= "Reply-to: \"DPD\"<".$mail.">".$passage_ligne;//MODIFIER PAR $mail
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//=====Création du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format texte.
	$message.= "Content-Type: text/plain; charset=\"utf8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$message.= "Content-Type: text/html; charset=\"utf8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	
	$rep = new DAO\Formulaire\FormulaireDAO();
	$rep->create($formulaire);
	
	//gestionnaire
	DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO::createPush($id_gestionnaire);
	
	//=====Envoi de l'e-mail.
	mail($mail,$sujet,$message,$header);

	?>
	<h1 class="text-center">Votre traitement est validé, un email de notification a été envoyé à votre DPD</h1>
	<h1 class="text-center">Récapitulatif du traitement saisi :</h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<p><b>Nom du traitement : </b>
				<?php echo $nomLogiciel;?></p>
				<p><b>Numéro d'activité du traitement : </b>
				<?php echo $num_Activite;?></p>
				<p><b>Support de données / outils :</b>
				<?php echo $_POST["support"];?></p>
				<p><b>Date de validation par le DPD : </b>
				<?php echo $validationDPD;?></p>
				<p><b>Service gestionnaire des données : </b>
				<?php 
				$daoGesti=new GestionnaireDroitAccesDAO();
				$rep=$daoGesti->readAll($id_gestionnaire);
				echo $rep ; ?></p>
				<p><b>Responsable de traitement : </b>
				<?php echo $resp." (".$ent.")";?></p>
				<p><b>Origine des données : </b>
				<?php echo $origineDonnee;?></p>
				<p><b>Finalité de traitement : </b>
				<?php echo $finaliteTraitement;?></p>
				<p><b>Sous-finalité du traitement : </b>
				<?php echo $sousFinalite;?></p>			
				<p><b>Commentaire :</b>
				<?php echo $commentaire;?></p>		
				<p><b>Date de mise en oeuvre : </b>
				<?php echo ($_POST['dateMiseEnOeuvre']);?></p>
				<p><b>Catégories de données traitées :</b>
				<?php 
				$cdonnee="";
				foreach (explode(';', $catDonneeTraitee) as $cac) {
					$cd = new CatdonneeformulaireDAO();
					$readAll = $cd->readAll();
					foreach ($readAll as $key => $e) {
						$rep = $e->getIdentifiant();
						if ($rep==$cac) {
							$libelle = $e->getLibelle();
							$cdonnee = $cdonnee.$libelle."; ";
						}
					}
				}			
				echo $cdonnee;?></p>
				<p><b>base juridique du traitement (si données sensibles) : </b>
				<?php echo ($_POST['baseJuridique']);?></p>
			</div>		
			<div class="col-lg-6">
				<p><b>Catégories des personnes concernées :</b>
				<?php echo $catPersConcern;?></p>
				<p><b>Destinataire des données :</b>
				<?php echo $destiDonnees;?></p>
				<p><b>Durée d'utilité des données :</b>
				<?php echo $dureeUtiliteAdmi;?> </p>
				<p><b>Archivage :</b>
				<?php echo $archivage;?></p>
				<p><b>Est-ce que les données seront transférées hors de l'UE ?</b>
				<?php echo $_POST["transUE"];?></p>
				<p><b>Catégories de licéités :</b>
				<?php 
				$cliceite="";
				foreach (explode(';', $catLiceiteTraitee) as $cac) {
					$cl = new CatliceiteformulaireDAO();
					$readAll = $cl->readAll();
					foreach ($readAll as $key => $e) {
						$rep = $e->getIdentifiant();
						if ($rep==$cac) {
							$libelle = $e->getLibelle();
							$cliceite = $cliceite.$libelle."; ";
						}
					}
				}			
				echo $cliceite;?></p>
				<p><b>Base juridique de la licéité :</b>
				<?php echo $_POST["baseJuridiqueLiceite"];?></p>
				<p><b>Co-Responsable de traitement :</b>
				<?php echo $coRespTraitement;?> </p>
				<p><b>Représentant co-Responsable de traitement :</b>
				<?php echo $representantCoResp;?> </p>
				<p><b>Sous-Traitant :</b>
				<?php echo $sousTraitant;?> </p>
				<p><b>Délai d'effacement :</b>
				<?php echo $delaiEffacement;?></p>
			</div>
		</div>
		<div class="panel">
		  <div class="panel-body">
				<div class="row">
				<h2>Renseignements DPD</h2>
					<div class="col-lg-6">
						<p><b>Fait-il l'objet d'un PIA ?</b>
						<?php echo $donneePIA;?></p>
						<p><b>Commentaire PIA :</b>
						<?php echo $PIA;?></p>
						<p><b>Niveau d'identification :</b>
						<?php echo $nivIdent;?></p>
						<p><b>Commentaire identification :</b>
						<?php echo $comIdent;?></p>
						<p><b>Niveau de sécurité :</b>
						<?php echo $nivSecu;?></p>
						<p><b>Mesures de sécurité :</b>
						<?php echo $mesSecu;?></p>
						<p><b>Commentaire sécurité :</b>
						<?php echo $comSecu;?></p>
						<p><b>Date de dernière mise à jour :</b>
						<?php echo ($_POST['dateMAJ']);?> </p>
						<p><b>Plan d'action :</b>
						<?php echo $planAction;?></p>
						<p><b>Hors registre des traitements :</b>
						<?php echo $horsRegistre;?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center">
			<a class='btn btn-success btn-lg' href='visu.php' role='button'>Retour à l'accueil</a>
		</div><br>
	<?php

/*****************************************************************************
PARTIE FORMULAIRE INITIAL
*****************************************************************************/ 
} else {
	$frmcom = new FormulaireCommentaireDAO();
?>
	<div class="container">
		<form name="frm" method="post" class="form-horizontal" action="">
		
<script type="text/javascript">

</script>
		<div class="row">
			<div class="bs-example">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h1 class="text-center">Formulaire de déclaration</h1>
						<h6 class="text-center">(*) champs obligatoire</h6>
					</div>
					<div class="panel-body">	
						<div class="col-lg-6">
							<?php $read = $frmcom->read('nomLogiciel');?>
							<p>* Nom du traitement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> <?php } ?>									
							<input type="text" class="form-control" name="nomLogiciel" required/></p>

							<?php $read = $frmcom->read('numActivite');?> <!-- rendre optionnel pour ?-->
							<p>Numéro d'activité du traitement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> <?php } ?>									
							<input type="text" class="form-control" name="numActivite"/></p>
							
							<?php $read = $frmcom->read('support');?>
							<p>Support de données / outils : <?php if ($read->getFormcom_commentaire() <> "") { ?> <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> <?php } ?>									
							<textarea name="support" class="form-control" rows="1" cols="45"></textarea></p>

							<div class="panel panel-default">
							  <div class="panel-body">
								<!-- début multiselect gestionnaire -->
								<?php $read = $frmcom->read('gestionnaire');?>
								<p>* Choisissez le service gestionnaire des données : <?php if ($read->getFormcom_commentaire() <> "") { ?> <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> <?php } ?>
								<!-- Select Multiple -->
								<!-- name="listbox" id="multi-select" required>-->
								<div class="panel-primary">	
									<div class="col-lg-12">
										<!-- liste déroulante pour les entités.	 -->
										<select name="updEntite" class="form-control" id="updEntite" onchange="getPoles(this.value);" required>
											<option value=>- - - Choisissez une entité - - -</option>
											<?php
											$pol = new EntiteDAO();
											$readAll = $pol->readAllEntitesByAdmin($_SESSION['identifiant']);
											
											$compt = 1;
											foreach ($readAll as $key => $entites) {
												if (isset($_POST["updEntite"]) && $_POST["updEntite"] == $compt) {
													$select = " selected=\"selected\"";
												} else {
													$select = "";
												}
												$rep = $entites->getEntite();
												$rep2=$entites->getIdentifiant();
												
												echo "<option value=$rep2$select> $rep </option>";
												$compt ++;
											} 
										?></select>
										<span id="blocPoles"></span>
										<span id="blocServices"></span><br>
									</div>
								</div>
								<!-- fin multiselect gestionnaire -->									
								<?php $read = $frmcom->read('responsable');?>
								<p>* Le Responsable du traitement est : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
								<span id="blocResp"></span><br> 	
								</div>
							</div>					
							
							<?php $read = $frmcom->read('finaliteTraitement');?>
							<p>* Finalité du traitement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="finalite" class="form-control" rows="2" cols="45" required></textarea></p>

							<?php $read = $frmcom->read('sousFinalite');?>
							<p>Sous-finalité du traitement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="sousFinalite" class="form-control" rows="1" cols="45" ></textarea></p>
							
							<?php $read = $frmcom->read('origineDonnee');?>
							<p>Origine des données : <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>	" />
							<textarea name="origineDonnee" class="form-control" rows="1" cols="45"></textarea></p>

							<?php $read = $frmcom->read('catPersConcern');?>
							<p>* Catégories des personnes concernées : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="catPersConcernees" class="form-control" rows="1" cols="45" required></textarea></p>
							
							<?php $read = $frmcom->read('destiDonnee');?>
							<p>* Destinataire des données : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="destiDonnees" class="form-control" rows="1" cols="45" required></textarea></p>

						<!--catégorie de données traitées-->
						<?php $read = $frmcom->read('catDonneeTraitee');?>
							<p>* Catégories de données traitées : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<br>
							<?php
							$cd = new CatdonneeformulaireDAO();
							$readAll = $cd->readAll();
							foreach ($readAll as $key => $e) {
								$libelle = $e->getLibelle();
								$infobulle = $e->getInfobulle();
								$rep = $e->getIdentifiant();
								if ($libelle <> "Données sensibles") { ?>
									<input class="groupcheckbox1" type="checkbox" name="catDonTrait[]" value="<?php echo $rep;?>" required>
									<label class="form-check-label-sm" for="catDonTrait"><?php echo $libelle;?></label>
									<img src="bootstrap/images/interro1.png" title="<?php echo $infobulle;?>"/><br>
								<?php } else { ?>	
										<input class="groupcheckbox1" type="checkbox" name="catDonTrait[]" value="<?php echo $rep;?>" onclick="montrer_cacher(this,'baseJuridique');" required>	
										<label class="form-check-label-sm" for="catDonTrait"><?php echo $libelle;?></label>
										<img src="bootstrap/images/interro1.png" title="<?php echo $infobulle;?>"/><br>
										<textarea name="baseJuridique" id="baseJuridique" class="form-control" style="display:none" rows="1" cols="45" placeholder="Base juridique du traitement" ></textarea>
	
<script language="JavaScript">
function montrer_cacher(laCase,champ1,champ2)
{
    if (laCase.checked) 
    {
		document.getElementById(champ1).style.display="inline";
        document.getElementById(champ2).style.display="inline";
    }
    else 
    {
		document.getElementById(champ1).style.display="none";
        document.getElementById(champ2).style.display="none";
    }
} 
</script>
<?php
								}
							}
						?>
										
<script type="text/javascript">
$(function(){
	var requiredCheckboxes = $('.groupcheckbox1:checkbox[required]');
    requiredCheckboxes.change(function(){
        if(requiredCheckboxes.is(':checked')) {
            requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
});

$(function(){
	var requiredCheckboxes = $('.groupcheckbox2:checkbox[required]');
    requiredCheckboxes.change(function(){
        if(requiredCheckboxes.is(':checked')) {
            requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
});
</script>
							</p>
						<!--fin catégories de données -->		
						
						</div>
						<div class="col-lg-6">	
							
							<?php $read = $frmcom->read('dureeUtiliteAdmi');?>
							<p>* Durée d'utilité administrative : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="dureeUtilit" class="form-control" rows="1" cols="45" required></textarea></p>

							<?php $read = $frmcom->read('delaiEffacement');?>
							<p>* Délai d'effacement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<input type="text" class="form-control" name="delEff" required/></p>
							
							<?php $read = $frmcom->read('archivage');?>
							<p>Archivage : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="archivage" class="form-control" rows="1" cols="45"></textarea></p>
							
							<!--catégorie de licéités-->
							<?php $read = $frmcom->read('catLiceiteTraitee');?>
							<p>* Catégories de licéités : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<br><?php
							$cd = new CatliceiteformulaireDAO();
							$readAll = $cd->readAll();
							foreach ($readAll as $key => $e) {
								$libelle = $e->getLibelle();
								$infobulle = $e->getInfobulle();
								$rep = $e->getIdentifiant();?>
								<input class="groupcheckbox2" type="checkbox" name="catLicTrait[]" value="<?php echo $rep;?>" required>
								<label class="form-check-label-sm" for="catLicTrait"><?php echo $libelle;?></label>
								<img src="bootstrap/images/interro1.png" title="<?php echo $infobulle;?>"/><br><?php
							}
							?>
							
							<?php $read = $frmcom->read('baseJuridiqueLiceite');?>
							<p>Base juridique de la licéité : <?php if ($read->getFormcom_commentaire() <> "") { ?> <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> <?php } ?>									
							<textarea name="baseJuridiqueLiceite" class="form-control" rows="1" cols="45"></textarea></p>

							<?php $read = $frmcom->read('transfertHorsUE');?>
							<p>* Est-ce que les données seront transférées hors de l'UE ? <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<input type="radio" name="transUE" value="oui" id="oui" required/> <label for="oui">Oui</label> 
							<input type="radio" name="transUE" value="non" id="non" /> <label for="non">Non</label></p>

							<?php $read = $frmcom->read('coRespTraitement');?>
							<p>Co-Responsable de traitement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<input type="text" class="form-control" name="coRespT"/></p>

							<?php $read = $frmcom->read('representantCoResp');?>
							<p>Représentant co-Responsable de traitement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<input type="text" class="form-control" name="RepCoRespT"/></p>

							<?php $read = $frmcom->read('sousTraitant');?>
							<p>Sous-Traitant : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<input type="text" class="form-control" name="sousTrait"/></p>

							<?php $read = $frmcom->read('commentaire');?>
							<p>Commentaire : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="commentaire" class="form-control" rows="2" cols="45" /></textarea></p>		
							<!-- fonction date du jour -->	

							<?php $read = $frmcom->read('dateMiseEnOeuvre');?>
							<p>Date de mise en oeuvre : <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>	" />
							<input type="text" id="datepicker2" name="dateMiseEnOeuvre" />
							<div id="datepicker2"></div></p>
							<script>
								$( "#datepicker2" ).datepicker();
							</script>							
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="bs-example">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<h1 class="panel-title">Cadre réservé au DPD</h1>
						</div>
						<div class="panel-body">
							<!--Réservé au DPD -->	
							<?php 
							if ((($_SESSION['admin']) == "admin") || (($_SESSION['admin']) == "super admin")){ 
								$grise = "";
								$grise2 = " required";
							} else {
								$grise = " disabled";
								$grise2 = "";
							}
							$read = $frmcom->read('donneePIA');?>
							<p>Fait-il l'objet d'un PIA : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<input type="radio" name="donneePIA" value="oui" id="oui" <?php echo $grise.$grise2; ?>/> <label for="oui">Oui</label>
							<input type="radio" name="donneePIA" value="non" id="non" <?php echo $grise; ?>/> <label for="non">Non</label></p>
							
							<?php $read = $frmcom->read('PIA');?>
							<p>Commentaire PIA : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="PIA" class="form-control" rows="1" cols="45" <?php echo $grise; ?>></textarea></p>
							
							<?php $read = $frmcom->read('niveau_identification');?>
							<p>Niveau d'identification : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<select name="nivIdent" <?php echo $grise; ?>>
								<option value="0" selected="selected">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select></p>

							<?php $read = $frmcom->read('com_ident');?>
							<p>Commentaire Identification : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="comident" class="form-control" rows="1" cols="45" <?php echo $grise; ?>/></textarea></p>

							<?php $read = $frmcom->read('niveau_securite');?>
							<p>Niveau de sécurité : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<select name="nivSecu" <?php echo $grise; ?>>
								<option value="0" selected="selected">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select></p>

							<?php $read = $frmcom->read('mesure_securite');?>
							<p>Mesures de sécurité : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<select name="mesSecu" class="form-control" <?php echo $grise; ?>>
								<option value="" selected="selected">---</option>
								<option>Uniquement pour les agents Etat : Les mesures de sécurité sont mises en œuvre conformément à la politique de sécurité des systèmes d’information du MIOM</option>
							</select></p>

							<?php $read = $frmcom->read('com_secu');?>
							<p>Commentaire Sécurité : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="comsecu" class="form-control" rows="1" cols="45" <?php echo $grise; ?>/></textarea></p>
							
							<?php $read = $frmcom->read('validationDPD');?>
							<p>Date de validation par le DPD: <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>" />
							<input type="text" id="datepicker4" name="validationDPD" <?php echo $grise; ?>/>
							<div id="datepicker4"></div></p>
							<script>
								$( "#datepicker4" ).datepicker();
							</script>
							<!-- date de déclaration -->
							<!--<input type="hidden" name="validationDPD" id="dateDuJour"/>-->
							<!-- date de MAJ de la déclaration -->
							<input type="hidden" name="dateMAJ" id="dateDuJour2"/>
							<script type="text/javascript">
								function getDate() {
									var today = new Date();
									var dd = today.getDate();
									var mm = today.getMonth()+1;
									var yyyy = today.getFullYear();
									if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm}
									today = yyyy+"-"+mm+"-"+dd;

									document.getElementById("dateDuJour").value = today;
									document.getElementById("dateDuJour2").value = today;
								}
								getDate();
							</script>	
							
							<?php $read = $frmcom->read('planAction');?>
							<p>Plan d'action: <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="planAction" class="form-control" rows="1" cols="45" <?php echo $grise; ?>/></textarea></p>
							
							<input type="checkbox" name="horsRegistre" value="Oui" <?php echo $grise; ?>>
							<label class="form-check-label-sm" for="horsRegistre">Ne pas inclure dans le registre des traitements</label>							
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12"><br>
				<fieldset>
					<div class="text-center">
						<a href="visu.php"><input type="button" class="btn btn-primary btn-lg" value="Retour" ></a>
						<input type="submit" class="btn btn-success btn-lg" value="Valider" name="valider" /><br><br>
					</div>
				</fieldset>
			</div>
		</div>
		</form>
<?php } ?>
	</div>
</body>
</html>
