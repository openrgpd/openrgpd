<!DOCTYPE html>
<?php
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO;
use DAO\FormulaireCommentaire\FormulaireCommentaireDAO;
use DAO\Catdonneeformulaire\CatdonneeformulaireDAO;
use DAO\Catliceiteformulaire\CatliceiteformulaireDAO;
use DAO\Formulaire\FormulaireDAO;
use metier\formulaire\Formulaire;
use DAO\Droit\DroitDAO;
use DAO\entite\EntiteDAO;
use DAO\pole\PoleDAO;
use DAO\VariableGlobale\VariableGlobaleDAO;
use metier\variableglobale\VariableGlobale;

session_start();
include("connexion/check_connect.php");
include ("connexion/Daos.php")
	
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
<script type="text/javascript">
$(document).ready(){
	$( "#datepicker" ).datepicker({
		altField: "#datepicker",
		closeText: 'Fermer',
		firstDay: 1 ,
		dateFormat: 'yy-mm-dd'
	});
	$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] ); 
};   

function ConfirmDPD() {
	if (confirm("Cliquez sur annuler pour modifier la date de validation du DPD")) {
	} else {
		document.getElementById('datepicker4').focus();
	}
}

function confDPD() {
	alert("Vous n'avez pas modifié la date de validation du traitement ?");
	document.getElementById('datepicker4').focus();
};

</script>

<title>RGPD</title>
</head>
<body>
<div id="container">
	<a href="visu.php" id="header"></a>
</div> <!-- container -->

<?php
	
/*****************************************************************************
PARTIE VALIDATION MODIFS TRAITEMENT  + ENVOI DU MAIL
*****************************************************************************/ 	
if (isset($_POST["valider"])) {
	
	$identifiant=$_SESSION['id_form'];
    if (!empty($_POST['nomLogiciel']) && $_POST['nomLogiciel']!="Ecrire ici ..."){
        $nomLogiciel=htmlspecialchars(($_POST['nomLogiciel']));
    } else {
        $nomLogiciel="";
    }
   
    if (!empty($_POST['origineDonnee']) && $_POST['origineDonnee']!='Ecrire ici ...'){
        $origineDonnee=htmlspecialchars(($_POST['origineDonnee']));
    } else {
        $origineDonnee="";
    }
       
    if (!empty($_POST['validationDPD'])){
        $validationDPD=metier\formulaire\Formulaire::toUs($_POST["validationDPD"]);
    } else {
        $validationDPD="0000-00-00";
    }
        
    if (!empty($_POST['finalite']) && $_POST['finalite']!='Votre commentaire ici...'){
        $finaliteTraitement=htmlspecialchars(($_POST['finalite']));
    } else {
        $finaliteTraitement="";
    }
           
    if (!empty($_POST['sousFinalite']) && $_POST['sousFinalite']!='Votre commentaire ici...'){
        $sousFinalite=htmlspecialchars(($_POST['sousFinalite']));
    } else {
        $sousFinalite="";
    }
    
    if (!empty($_POST['commentaire']) && $_POST['commentaire']!='Votre commentaire ici...'){
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
        $id_gestionnaire=($_POST["service"]);
		$ancienId_gestionnaire=htmlspecialchars(($_SESSION['listGest']));
    } else {
        $id_gestionnaire=htmlspecialchars(($_SESSION['listGest']));
        $ancienId_gestionnaire=htmlspecialchars(($_SESSION['listGest']));
    }
	
	//Catégorie de donnée traitée
	if (isset($_POST['catDonTrait'])) {
		$cac = $_POST['catDonTrait'];
		$catDonneeTraitee="";
		for ($i=0; $i<count($cac); $i++) {
			if ($i ==0){
				$catDonneeTraitee=$cac[$i];			
				$_SESSION['cac']='OK';		
			} else {
				$catDonneeTraitee=$catDonneeTraitee.";".$cac[$i];
				$_SESSION['cac']='KO';	
			}
		}
	} else {
		$_SESSION['cac']='KO';	
	}
    
    if (!empty($_POST['catPersConcernees']) && $_POST['catPersConcernees']!='Votre commentaire ici...'){
        $catPersConcern=htmlspecialchars(($_POST['catPersConcernees']));
    } else {
        $catPersConcern="";
    }
        
    if (!empty($_POST['destiDonnees']) && $_POST['destiDonnees']!='Votre commentaire ici...'){
        $destiDonnees=htmlspecialchars(($_POST['destiDonnees']));
    } else {
        $destiDonnees="";
    }
	
    if (!empty($_POST['dureeUtilit']) && $_POST['dureeUtilit']!='Votre commentaire ici...'){
        $dureeUtiliteAdmi=htmlspecialchars(($_POST['dureeUtilit']));
    } else {
        $dureeUtiliteAdmi="";
    }
	
    if (!empty($_POST['archivage']) && $_POST['archivage']!='Votre commentaire ici...'){
        $archivage=htmlspecialchars(($_POST['archivage']));
    } else {
        $archivage="";
    }
    
    if (isset($_POST['transUE'])){
        if ($_POST["transUE"]=="non"){
            $transfertHorsUE=0;
    	  } else {
            $transfertHorsUE=1;
        }  
    }
	
	//Catégorie de licéité
	if (isset($_POST['catLicTrait'])) {
		$cacL = $_POST['catLicTrait'];
		$catLiceiteTraitee="";
		for ($i=0; $i<count($cacL); $i++) {
			if ($i ==0){
				$catLiceiteTraitee=$cacL[$i];			
				$_SESSION['cacL']='OK';		
			} else {
				$catLiceiteTraitee=$catLiceiteTraitee.";".$cacL[$i];
				$_SESSION['cacL']='KO';	
			}
		}
	} else {
		$_SESSION['cacL']='KO';	
	}
	
    if (!empty($_POST['coRespT']) && $_POST['coRespT']!='Ecrire ici ...'){
        $coRespTraitement=htmlspecialchars(($_POST['coRespT']));
    } else { 
	  $coRespTraitement="";
    }
      
    if (!empty($_POST['RepCoRespT']) && $_POST['RepCoRespT']!='Ecrire ici ...'){
        $representantCoResp=htmlspecialchars(($_POST['RepCoRespT']));
    } else {
        $representantCoResp="";
    }
	
    if (!empty($_POST['sousTrait']) && $_POST['sousTrait']!='Ecrire ici ...'){
        $sousTraitant=htmlspecialchars(($_POST['sousTrait']));
    } else {
        $sousTraitant="";
    }
	
    if (!empty($_POST['delEff']) && $_POST['delEff']!='Ecrire ici ...'){
        $delaiEffacement=htmlspecialchars(($_POST['delEff']));
    } else {
        $delaiEffacement="";
    }
	
    if (!empty($_POST['support']) && $_POST['support']!='Ecrire ici ...'){
        $support=htmlspecialchars(($_POST['support']));
    } else {
        $support="";
    }
	
    if (!empty($_POST['nivIdent']) && $_POST['nivIdent']!='Ecrire ici ...'){
        $nivIdent=htmlspecialchars(($_POST['nivIdent']));
    } else {
        $nivIdent="";
    }

    if (!empty($_POST['comIdent']) && $_POST['comIdent']!='Ecrire ici ...'){
        $comIdent=htmlspecialchars(($_POST['comIdent']));
    } else {
        $comIdent="";
    }
	
    if (!empty($_POST['comSecu']) && $_POST['comSecu']!='Ecrire ici ...'){
        $comSecu=htmlspecialchars(($_POST['comSecu']));
    } else {
        $comSecu="";
    }
	
    if (!empty($_POST['nivSecu']) && $_POST['nivSecu']!='Ecrire ici ...'){
        $nivSecu=htmlspecialchars(($_POST['nivSecu']));
    } else {
        $nivSecu="";
    }
	
	if (isset($_POST['donneePIA'])){
        if ($_POST["donneePIA"]=="non"){
            $donneePIA=0;
	  } else {
            $donneePIA=1;
        }
    }
	
	if (!empty($_POST['PIA']) && $_POST['PIA']!='Ecrire ici ...'){
        $PIA=htmlspecialchars(($_POST['PIA']));
    } else {
        $PIA="";
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
	
	if (!empty($_POST['baseJuridiqueLiceite'])){
		$baseJuridiqueLiceite=htmlspecialchars(($_POST['baseJuridiqueLiceite']));
	} else {
		$baseJuridiqueLiceite="";
	}

      
	$derniereMAJ=date("Y-m-d");
	
	//Ajout du $session de mail pour envoi au DPD
	$sql = "SELECT maildpd FROM entites 
		INNER JOIN servicesmunicipaux on servicesmunicipaux.entite = entites.identifiant
		WHERE servicesmunicipaux.identifiant = ".$id_gestionnaire;
	$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
	$stmt->execute();	
	$row = $stmt->fetch();
	$mail = $row["maildpd"];
	
	$declarant=$_SESSION['identifiant'];
	$formulaire=new Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee, $catPersConcern, 
	$destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement, $support, 
	$nivIdent, $comIdent, $nivSecu, $comSecu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite);
	$formulaire->setIdentifiant($identifiant);
	
	$_SESSION['ancienidgesti']=$ancienId_gestionnaire;
	?>
	<h1 class="text-center">Récapitulatif du traitement saisi :</h1>
	<?php 
 	$rep=\metier\formulaire\Formulaire::tableauComparerForm($formulaire, $id_gestionnaire);
	echo $rep;
	
	/******************************* ENVOI DU MAIL *******************************/
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
		$passage_ligne = "\r\n";
	} else {
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$nom_declarant=$_SESSION['nom'] . " " . $_SESSION['prenom'];
	$rep=\metier\formulaire\Formulaire::tableauComparerForm($formulaire, $id_gestionnaire);
	$message_txt = "Bonjour, nouvelle modification effectuée par ". $nom_declarant ;
	$message_html = "<html><head></head><body><b>Bonjour</b>, nouvelle modification effectuée par ". $nom_declarant ." <br> ".$rep ."</body></html>";
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//=====Définition du sujet.
	$sujet = "Nouvelle modification RGPD";
	//=====Création du header de l'e-mail.
	$header = "From: \"AppliRGPD\"<".$mail.">".$passage_ligne;
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

	$rep = new FormulaireDAO();
	$rep->update($formulaire);
	$id_formulaire = $formulaire->getIdentifiant();

	if ($id_gestionnaire != $_SESSION['ancienidgesti']) {
		$daoGestionDA = new GestionnaireDroitAccesDAO();
		$daoGestionDA->updatePush($id_formulaire, $_SESSION['ancienidgesti'], $id_gestionnaire);
	}

	// Envoi de l'e-mail.
	mail($mail,$sujet,$message,$header);
	echo "<h1>Vos modifications sont validées, un email de notification a été envoyé à votre DPD</h1>";

	echo "<div class='text-center'><a class='btn btn-success btn-lg' href='visu.php' role='button'>Retour à l'accueil</a></div><br>";

/*****************************************************************************
PARTIE FORMULAIRE MODIFS TRAITEMENT 
*****************************************************************************/ 
} else {

	if (!isset($_POST["modifier"])) {
		header('Location: index.php');
		exit();
	} else {
		if (! empty($_POST["modifier"])) {
			$valForm = $_POST['modifier'];
		}
	}
	
	$_SESSION['id_form'] = $valForm;
	$daoFrm = new FormulaireDAO();
	$rep = $daoFrm->read($valForm);
	$daoGesti = new GestionnaireDroitAccesDAO();
	$repGesti = $daoGesti->readIdForm($valForm);
	$nom = $rep->getNomLogiciel();
	$origineDonnee = $rep->getOrigineDonnee();
	$validationDPDUs = $rep->getValidationDPD();
	$validationDPD = metier\formulaire\Formulaire::toFr($validationDPDUs);
	$fin = $rep->getFinaliteTraitement();
	$sousfin = $rep->getSousFinalite();
	$comm = $rep->getCommentaire();
	$dateMiseOeuvreUs = $rep->getDateMiseEnOeuvre();
	$dateMiseOeuvre = metier\formulaire\Formulaire::toFr($dateMiseOeuvreUs);
	$catD = $rep->getCatDonneeTraitee();
	$catP = $rep->getCatPersConcern();
	$destiD = $rep->getDestiDonnees();
	$dureeU = $rep->getDureeUtiliteAdmi();
	$arc = $rep->getArchivage();
	$transfUE = $rep->getTransfertHorsUE();
	$catL = $rep->getCatLiceiteTraitee();
	$coRT = $rep->getCoRespTraitement();
	$repCoR = $rep->getRepresentantCoResp();
	$sousT = $rep->getSousTraitant();
	$delE = $rep->getDelaiEffacement();
	$sup = $rep->getSupport();
	$nivIdent = $rep->getNiveau_identification();
	$comIdent = $rep->getCom_ident();
	$nivSecu = $rep->getNiveau_securite();
	$comSecu = $rep->getCom_secu();
	$dateDerniereMajUs = $rep->getDerniereMAJ();
	$dateDerniereMaj = metier\formulaire\Formulaire::toFr($dateDerniereMajUs);
	$donneePIA = $rep->getDonneePIA();
	$PIA = $rep->getPIA();
	$horsRegistre = $rep->getHorsRegistre();
	$planAction = $rep->getPlanAction();
	$baseJuridique = $rep->getBaseJuridique();
	$baseJuridiqueLiceite = $rep->getBaseJuridiqueLiceite();
	
	$sql = "SELECT entites.responsable FROM entites 
			INNER JOIN servicesmunicipaux on servicesmunicipaux.entite = entites.identifiant
			INNER JOIN gestionnairesdroitacces on gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
			WHERE id_formulaire = ".$valForm.";";
	$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch();
	$responsableactuel=$row[0];

	$frmcom = new FormulaireCommentaireDAO();
	?>
	<br>
	<div class="container">
		<form method="post" class="form-horizontal" action="">

<script type="text/javascript">
function ConfirmDPD() {
	if (confirm("Cliquez sur annuler pour modifier la date de validation par le DPD")) {
	} else {		
		document.getElementById('datepicker4').focus();
		return false
	}
}
</script>

		<div class="row">
			<div class="bs-example">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h1 class="text-center">Modifiez votre déclaration</h1>
					</div>
					<div class="panel-body">	
						<div class="col-lg-6">
							<?php $read = $frmcom->read('nomLogiciel');?>
							<p>* Nom du traitement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea class="form-control" name="nomLogiciel" rows="1" cols="45"><?php echo $nom;?></textarea>	</p>

							<?php $read = $frmcom->read('support');?>
							<p>Support de données / outils :  <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<textarea name="support" class="form-control" rows="1" cols="45"><?php echo $sup; ?></textarea></p>
																				 
							<!-- liste déroulante pour la table servicesmunicipaux.	 -->
							<?php
							$sql = "SELECT servicesmunicipaux.service,entites.entite, entites.identifiant as id_ent, servicesmunicipaux.identifiant as id_serv FROM servicesmunicipaux 
								INNER JOIN entites on servicesmunicipaux.entite = entites.identifiant
								INNER JOIN gestionnairesdroitacces on gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
								WHERE id_formulaire = ".$valForm.";"; 
							$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
							$stmt->bindParam(':id', $id);
							$stmt->execute();
							$rep="";
							while ($row = $stmt->fetch()) {
								$rep= $rep.$row['service']." <i><small>(".$row['entite']."</small></i>) ";
								$repService=$row['id_serv'];
								$repEntite=$row['id_ent'];
							}
							?>
							<?php $read = $frmcom->read('gestionnaire');?>
							<p>* Le gestionnaire des données est : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<?php 
							$list = implode(",", $repGesti);
							$daoGesti = new GestionnaireDroitAccesDAO();
							//$rep3 = $daoGesti->readAll($list);
							$_SESSION['listGest'] = $list;
							echo "<br><b><i>".$rep."</i></b><br>";
							?>

							<div class="panel-primary">	
								<div class="col-lg-12">
									<!-- liste déroulante pour les entités.	 -->
									<select name="updEntite" class="form-control" id="updEntite" onchange="getPoles(this.value);">
										<option value=-1>- - - Choisissez une entité - - -</option>
										<?php
										$pol = new EntiteDAO();
										$readAll = $pol->readAllEntitesByAdmin($_SESSION['identifiant']);
										
										$compt = 1;
										foreach ($readAll as $key => $entites) {
											$rep = $entites->getEntite();
											$rep2=$entites->getIdentifiant();
											/*if ($repEntite == $rep2) {
												$select = " selected=\"selected\"";
											} else {
												$select = "";
											}*/
											
											echo "<option value=$rep2$select> $rep </option>";
											$compt ++;
										} 
									?></select>
									<span id="blocPoles"></span>
									<span id="blocServices"></span><br>
								</div>
							</div>
							<!--A MODIFIER PAR NOUVEAU RESPONSABLE -->
							<?php $read = $frmcom->read('responsable');?>
							<p>* Le responsable du traitement est : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<br>
							<b><i><?php echo $responsableactuel; ?></i></b>
							<span id="blocResp"></span><br> 
							
							<?php $read = $frmcom->read('finaliteTraitement');?>
							<p>* Finalité du traitement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
								<textarea name="finalite" class="form-control" rows="2" cols="45"><?php echo $fin; ?></textarea></p>

							<?php $read = $frmcom->read('sousFinalite');?>
							<p>Sous-finalité du traitement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="sousFinalite" class="form-control" rows="1" cols="45"><?php echo $sousfin; ?></textarea></p>
								
							<?php $read = $frmcom->read('origineDonnee');?>
							<p>Origine des données : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="origineDonnee" class="form-control" rows="1" cols="45"><?php echo $origineDonnee; ?></textarea></p>
							
							<?php $read = $frmcom->read('catPersConcern');?>
							<p>* Catégories des personnes concernées : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="catPersConcernees" class="form-control" rows="2" cols="45"><?php echo $catP; ?></textarea></p>
							
							<?php $read = $frmcom->read('destiDonnee');?>
							<p>* Destinataire des données : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="destiDonnees" class="form-control" rows="1" cols="45"><?php echo $destiD; ?></textarea></p>

							<!--catégorie de données traitées-->
							<?php $read = $frmcom->read('catDonneeTraitee');?>
							<p>* Catégories de données traitées : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<?php
							$cdonnee="";
							foreach (explode(';', $catD) as $cac) {
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
							?>
							<br><b><i><?php echo $cdonnee; ?></i></b><br>
							<?php							
							$cd = new CatdonneeformulaireDAO();
							$readAll = $cd->readAll();

							foreach ($readAll as $key => $e) {
								$libelle = $e->getLibelle();
								$infobulle = $e->getInfobulle();
								$rep = $e->getIdentifiant();
								if ($libelle <> "Données sensibles") { ?>
									<input class="groupcheckbox1" type="checkbox" name="catDonTrait[]" value="<?php echo $rep;?>" required
									<?php
									foreach (explode(';', $catD) as $checked){
										if ($rep == $checked) {
											echo "checked";
										}
									}
									/*
								if (isset($_SESSION['cac']) && ($_SESSION['cac'] != "OK")) {
								echo ' required';
								}*/?>
								>
								<label class="form-check-label-sm" for="catDonTrait"><?php echo $libelle;?></label>
								<img src="bootstrap/images/interro1.png" title="<?php echo $infobulle;?>"/><br>
								<?php
								} else { ?>	
									<input class="groupcheckbox1" type="checkbox" name="catDonTrait[]" value="<?php echo $rep;?>" onclick="montrer_cacher(this,'baseJuridique');" required
									<?php
									foreach (explode(';', $catD) as $checked){
										if ($rep == $checked) {
											echo "checked";
										}
									} 
									?>
									>	
									<label class="form-check-label-sm" for="catDonTrait"><?php echo $libelle;?></label>
									<img src="bootstrap/images/interro1.png" title="<?php echo $infobulle;?>"/><br>
									<textarea name="baseJuridique" id="baseJuridique" class="form-control" 
									<?php
										if ($baseJuridique <> "") {
											echo "style='display:inline'";
										} else {
											echo "style='display:none'";
										}

									?> rows="1" cols="45"><?php echo $baseJuridique;?></textarea>
								<?php
								}
							}
						?>
							</p>
							<!--fin catégories de données -->
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

$(function(){
	var requiredCheckboxes = $('.groupcheckbox1:checkbox[required]');
    requiredCheckboxes.ready(function(){
        if(requiredCheckboxes.is(':checked')) {
            requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
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
    requiredCheckboxes.ready(function(){
        if(requiredCheckboxes.is(':checked')) {
            requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
	requiredCheckboxes.change(function(){
        if(requiredCheckboxes.is(':checked')) {
            requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
});
</script>
							<?php $read = $frmcom->read('dateMEO');?>
							<p>* Date de mise en oeuvre : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<input type="text" id="datepicker2" name="dateMiseEnOeuvre" value=<?php echo $dateMiseOeuvre; ?> >
							<div id="datepicker2"></div></p>
							<script>
								$( "#datepicker2" ).datepicker();
							</script>
						</div>
						<div class="col-lg-6">
							
							<?php $read = $frmcom->read('dureeUtiliteAdmi');?>
							<p>* Durée d'utilité administrative : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<textarea name="dureeUtilit" class="form-control" rows="1" cols="45"><?php echo $dureeU; ?></textarea></p>

							<?php $read = $frmcom->read('delaiEffacement');?>
							<p>Délai d'effacement : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<input class="form-control" type="text" name="delEff" value="<?php echo $delE; ?>" /></p>
							
							<?php $read = $frmcom->read('archivage');?>
							<p>Archivage : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<textarea name="archivage" class="form-control" rows="1" cols="45"><?php echo $arc; ?></textarea></p>
							
							<!--catégorie de licéités traitées-->
							<?php $read = $frmcom->read('catLiceiteTraitee');?>
							<p>* Catégories de licéités : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<?php
							$cliceite="";
							foreach (explode(';', $catL) as $cacL) {
								$cl = new CatliceiteformulaireDAO();
								$readAll = $cl->readAll();
								foreach ($readAll as $key => $e) {
									$rep = $e->getIdentifiant();
									if ($rep==$cacL) {
										$libelle = $e->getLibelle();
										$cliceite = $cliceite.$libelle."; ";
									}
								}
							}
							?>
							<br><b><i><?php echo $cliceite; ?></i></b><br>
							<?php							
							$cl = new CatliceiteformulaireDAO();
							$readAll = $cl->readAll();

							foreach ($readAll as $key => $e) {
								$libelle = $e->getLibelle();
								$infobulle = $e->getInfobulle();
								$rep = $e->getIdentifiant();?> 
								<input class="groupcheckbox2" type="checkbox" name="catLicTrait[]" value="<?php echo $rep;?>" required
								<?php
								foreach (explode(';', $catL) as $checked){
									if ($rep == $checked) {
									echo "checked";
									}
								}/*
								if (isset($_SESSION['cacL']) && ($_SESSION['cacL'] != "OK")) {
								echo ' required';
								}*/
								?>
								>
								<label class="form-check-label-sm" for="catLicTrait"><?php echo $libelle;?></label>
								<img src="bootstrap/images/interro1.png" title="<?php echo $infobulle;?>"/><br><?php
							}
						?>
							</p>
							<!--fin catégories de licéités -->
							
							<?php $read = $frmcom->read('baseJuridiqueLiceite');?>
							<p>Base juridique de la licéité :  <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<textarea name="baseJuridiqueLiceite" class="form-control" rows="1" cols="45"><?php echo $baseJuridiqueLiceite; ?></textarea></p>
							
							<?php $read = $frmcom->read('transfertHorsUE');?>
							<p>* Est-ce que les données seront transférées hors de l'UE?  <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<?php
							if ($transfUE > 0) {
								echo "<input type=\"radio\" name=\"transUE\" value=\"oui\" id=\"oui\" checked=\"checked\"/> <label for=\"oui\">Oui</label>
										 <input type=\"radio\" name=\"transUE\" value=\"non\" id=\"non\" /> <label for=\"non\">Non</label></p>";
							} else {
								echo "<input type=\"radio\" name=\"transUE\" value=\"oui\" id=\"oui\" /> <label for=\"oui\">Oui</label>
										<input type=\"radio\" name=\"transUE\" value=\"non\" id=\"non\" checked=\"checked\"/> <label for=\"non\">Non</label></p>";
							}
							?>	
							
							<?php $read = $frmcom->read('coRespTraitement');?>
							<p>Co-Responsable de traitement :  <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<input type="text" class="form-control" name="coRespT" value="<?php echo $coRT; ?>" /></p>

							<?php $read = $frmcom->read('representantCoResp');?>
							<p>Représentant co-Responsable de traitement :  <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<input type="text" class="form-control" name="RepCoRespT" value="<?php echo $repCoR; ?>" /></p>

							<?php $read = $frmcom->read('sousTraitant');?>
							<p>Sous-Traitant :  <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<input type="text" class="form-control" name="sousTrait" value="<?php echo $sousT; ?>" /></p>

							<?php $read = $frmcom->read('commentaire');?>
							<p>Commentaire :  <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<textarea name="commentaire" class="form-control" rows="2" cols="45"><?php echo $comm; ?></textarea></p>

							<!--<?php $read = $frmcom->read('validationDPD');?>
							<p>Date de déclaration :  <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<input type="text" id="datepicker" name="validationDPD" value="<?php echo $validationDPD; ?>" >
							<div id="datepicker"></div></p>-->
							<script>
								$( "#datepicker" ).datepicker();
							</script>	
							<p>
							<label FOR="datepicker3">Date de dernière mise à jour : </label> 
							<input type="text" id="datepicker3" name="dateMAJ" value=<?php echo $dateDerniereMaj; ?> disabled>
							</p>
							<div id="datepicker3"></div>
							<script>
								$( "#datepicker3" ).datepicker();
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

						<?php 
						if ((($_SESSION['admin']) == "admin") || (($_SESSION['admin']) == "super admin")){ 
							$grise = "";
							$grise2 = " required";
						} else {
							$grise = " disabled";
							$grise2 = "";
						}
							$read = $frmcom->read('donneePIA');?>
							<p>Fait-il l'objet d'un PIA :<?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>					
							<?php
							if ($donneePIA > 0) {
								echo "<input type=\"radio\" name=\"donneePIA\" value=\"oui\" id=\"oui\" checked=\"checked\" ".$grise2." /> <label for=\"oui\">Oui</label>
								<input type=\"radio\" name=\"donneePIA\" value=\"non\" id=\"non\" ".$grise."/> <label for=\"non\">Non</label></p>";
							} else {
								echo "<input type=\"radio\" name=\"donneePIA\" value=\"oui\" id=\"oui\" ".$grise2."/> <label for=\"oui\">Oui</label>
								<input type=\"radio\" name=\"donneePIA\" value=\"non\" id=\"non\" checked=\"checked\" ".$grise."/> <label for=\"non\">Non</label></p>";
							}
							?>
							
							<?php $read = $frmcom->read('PIA');?>
							<p>Commentaire PIA : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>	
							<textarea name="PIA" class="form-control" rows="1" cols="45" <?php echo $grise; ?>><?php echo "$PIA" ?></textarea></p>							

							<?php $read = $frmcom->read('niveau_identification');?>
							<p>Niveau d'identification : <?php echo $nivIdent; ?></p>
							<p> Modifiez le niveau pour : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<select name="nivIdent" <?php echo $grise; ?>>
						<?php
							for( $i= 0 ; $i <= 3 ; $i++ ){
								if ($i == $nivIdent){
									echo "<option value=".$i." selected='selected'>".$i."</option>";
								} else {
									echo "<option value=".$i.">".$i."</option>";
								}
							}
						?>							
							</select></p>

							<?php $read = $frmcom->read('com_ident');?>
							<p> Commentaire identification : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="comIdent" class="form-control" rows="1" cols="45" <?php echo $grise; ?>/> <?php echo $comIdent; ?> </textarea></p>

							<?php $read = $frmcom->read('niveau_securite');?>
							<p>Niveau de sécurité : <?php echo $nivSecu; ?></p>
							<p> Modifiez le niveau pour : <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<select name="nivSecu" <?php echo $grise; ?>>
						<?php
							for( $i= 0 ; $i <= 3 ; $i++ ){
								if ($i == $nivSecu){
									echo "<option value=".$i." selected='selected'>".$i."</option>";
								} else {
									echo "<option value=".$i.">".$i."</option>";
								}
							}
						?>							
							</select></p>
							<?php $read = $frmcom->read('com_secu'); ?>
							<p> Commentaire Sécurité :  <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<textarea name="comSecu" class="form-control" rows="1" cols="45" <?php echo $grise; ?> /><?php echo $comSecu; ?></textarea></p>	
							
							<?php $read = $frmcom->read('ValidationDPD');?>
							<p>* Date de validation par le DPD :  <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?> 
							<input type="text" id="datepicker4" name="validationDPD" <?php echo $grise; ?> value=<?php echo $validationDPD; ?> required>
							<div id="datepicker4"></div></p>
							<script>
								$( "#datepicker4" ).datepicker();
							</script>
							
							<?php $read = $frmcom->read('planAction');?>
							<p>Plan d'action: <?php if ($read->getFormcom_commentaire() <> "") { ?> <img src="bootstrap/images/interro1.png" title="<?php echo $read->getFormcom_commentaire(); ?>"/> <?php } ?>
							<textarea name="planAction" class="form-control" rows="1" cols="45" <?php echo $grise; ?>/><?php echo $planAction; ?></textarea></p>
							
							<?php
							if ($horsRegistre == "Oui") {
								echo '<input type="checkbox" name="horsRegistre" value="Oui" checked=\"checked\" '.$grise.'/> <label for=\"oui\"></label>';
							} else {
								echo '<input type="checkbox" name="horsRegistre" value="Oui" '.$grise.'/> <label for=\"oui\"></label>';
							}
							?>
							<label class="form-check-label-sm" for="horsRegistre">Ne pas inclure dans le registre des traitements</label>		
						</div>
					</div> 
				</div>
			</div>
		</div>
		<div class="col-lg-12"><br>
			<div class="text-center">
				<p><a href="visu.php"><input type="button" class="btn btn-primary btn-lg" value="Retour"></a>
<?php 		if (($_SESSION['admin']) <> "contributeur") { ?>
				<input type="submit" class="btn btn-success btn-lg" value="Valider" name="valider"/>
				<a href="suppr_frm.php?idform=<?php echo $valForm; ?>"><input type="button" name="validerSupp" class="btn btn-danger btn-lg" value="Supprimer" onclick="return confirm('Effectuer la suppression ?');;"></a>

				<!--<a href="charger_modele.php?idform=<?php echo $valForm; ?>"><input type="button" name="validerModele" class="btn btn-warning btn-lg" value="Enregistrer comme modèle" onclick='return confirmationModele();'></a>-->
<?php 		} else { ?>
				<input type="submit" class="btn btn-success btn-lg" value="Valider" name="valider" />
<?php 		}
		}	?>
				</p>
			</div>
		</div>
		</form>
	</div>
</body>
</html>
<?php
include("footer.php");
?>

