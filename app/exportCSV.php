<?php
use DAO\Droit\DroitDAO;
use DAO\ServiceMunicipal\ServiceMunicipalDAO;
use metier\serviceMunicipal\ServiceMunicipal;
use DAO\pole\PoleDAO;
use metier\pole\Pole;
use DAO\entite\EntiteDAO;
use metier\entite\Entite;
use DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO;
use DAO\Formulaire\FormulaireDAO;
use DAO\Catdonneeformulaire\CatdonneeformulaireDAO;
use DAO\Catliceiteformulaire\CatliceiteformulaireDAO;
use DAO\Utilisateur\UtilisateurDAO;
use metier\formulaire\Formulaire;

session_start();
include("connexion/check_connect.php");
include ("connexion/Daos.php");

// partie qui gère les exports des tables.
// partie listbox
if (isset($_POST['validerCSV'])){
	$output = fopen("importexport/exportformulaire.csv", "w");
	fputcsv($output, array("ID", 
				"Traitement", 
				"Origine des données", 
				"Validation du DPD", 
				"Finalité du traitement", 
				"Sous-finalité", 
				"Commentaire", 
				"Date de mise en oeuvre", 
				"Catégorie de données traitées", 
				"Catégorie de personnes concernées", 
				"Destinataires des données", 
				"Durée d'utilité administrative", 
				"Archivage", 
				"Transfert hors UE", 
				"Licéité du traitement", 
				"Support de données / outils", 
				"Co-responsable du traitement", 
				"Représentant du Co-responsable du traitement", 
				"Sous-traitant", 
				"Délai d'effacement", 
				"Niveau d'identification", 
				"Commentaire d'identification", 
				"Niveau de sécurité", 
				"Commentaire de sécurité", 
				"Date de dernière mise à jour",
				"Déclarant",
				"Gestionnaire(s) des données",
				"Pôle",
				"Entité", 
				"Nom du responsable du traitement",
				"PIA ",
				"Commentaire PIA",
				"Plan d'action du DPD", 
				"base Juridique du traitement",
				"base Juridique de la licéité"));
				
	$sql = "SELECT formulaire.identifiant, formulaire.nomLogiciel, formulaire.origineDonnee, formulaire.validationDPD, formulaire.finaliteTraitement, formulaire.sousFinalite, 
			formulaire.commentaire, formulaire.dateMiseEnOeuvre, replace(formulaire.catDonneeTraitee,';','/'), formulaire.catPersConcern, formulaire.destiDonnees, 
        	formulaire.dureeUtiliteAdmi, formulaire.archivage, formulaire.transfertHorsUE, replace(formulaire.catLiceiteTraitee,';','/'), formulaire.support, formulaire.coRespTraitement, 
			formulaire.representantCoResp, formulaire.sousTraitant, formulaire.delaiEffacement, formulaire.niveau_identification, formulaire.com_ident, formulaire.niveau_securite, 
        	formulaire.com_secu, formulaire.derniereMAJ, formulaire.declarant, poles.pole, entites.entite, entites.responsable, nom_gestda.Gestionnairesdudroitdacces, 
			formulaire.donneePIA, formulaire.PIA, formulaire.planAction, formulaire.baseJuridique, formulaire.baseJuridiqueLiceite 
 		FROM formulaire 
		LEFT JOIN nom_gestda ON nom_gestda.id_formulaire=formulaire.identifiant 
		LEFT JOIN gestionnairesdroitacces ON formulaire.identifiant = gestionnairesdroitacces.id_formulaire
		LEFT JOIN servicesmunicipaux ON gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
		LEFT JOIN poles ON poles.identifiant = servicesmunicipaux.pole
		LEFT JOIN entites ON entites.identifiant = servicesmunicipaux.entite 
		WHERE";

	/*condition si entite*/
	if (($_POST['entite'])<>"-1") {
      	$sql = $sql." servicesmunicipaux.entite = ".$_POST['entite'];
	} else {
		//dans liste de l'administrateur
		$ent = new EntiteDAO();
		$readAll = $ent->readAllEntitesByAdmin($_SESSION['identifiant']);
		$req = "";
		foreach ($readAll as $key => $entites) {
			$rep = $entites->getEntite();
			$rep2 = $entites->getIdentifiant();
			$req = $req.",".$rep2;
		}

		//supprimer 1ère virgule
		$req = substr($req,1);
		$sql = $sql." servicesmunicipaux.entite IN (".$req.") ";
	}
	$sql = $sql." AND (formulaire.horsRegistre is null OR formulaire.horsRegistre ='')";
	$sql = $sql." GROUP BY formulaire.identifiant ORDER BY servicesmunicipaux.entite, formulaire.identifiant ";
	
	$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
		
		$identifiant= htmlspecialchars($row[0]);
		$nomLogiciel= htmlspecialchars($row[1]); 
		$origineDonnee= htmlspecialchars($row[2]); 
		$validationDPD= htmlspecialchars($row[3]); 
		$finaliteTraitement= htmlspecialchars($row[4]); 
		$sousFinalite= htmlspecialchars($row[5]); 
		$commentaire= htmlspecialchars($row[6]); 
		$dateMiseEnOeuvre= htmlspecialchars($row[7]); 
		//donnee traitées
		$catDonneeTraitee= htmlspecialchars($row[8]); 
		$cdonnee="";
		foreach (explode('/', $row[8]) as $cac) {
			$cd = new CatdonneeformulaireDAO();
			$readAll = $cd->readAll();
			foreach ($readAll as $key => $e) {
				$rep = $e->getIdentifiant();
				if ($rep==$cac) {
					$libelle = $e->getLibelle();
					$cdonnee = $cdonnee.$libelle."/ ";
				}
			}
		}  	
		$catPersConcern= htmlspecialchars($row[9]); 
		$destiDonnees= htmlspecialchars($row[10]); 
		$dureeUtiliteAdmi= htmlspecialchars($row[11]); 
		$archivage= htmlspecialchars($row[12]); 
		$transfertHorsUE= htmlspecialchars($row[13]); 
		
		//liceite traitées
		$catLiceiteTraitee= htmlspecialchars($row[14]); 
		$cliceite="";
		foreach (explode('/', $row[14]) as $cacL) {
			$cl = new CatliceiteformulaireDAO();
			$readAll = $cl->readAll();
			foreach ($readAll as $key => $e) {
				$rep = $e->getIdentifiant();
				if ($rep==$cacL) {
					$libelle = $e->getLibelle();
					$cliceite = $cliceite.$libelle."/ ";
				}
			}
		}  	
		$support= htmlspecialchars($row[15]);
		$coRespTraitement= htmlspecialchars($row[16]); 
		$representantCoResp= htmlspecialchars($row[17]); 
		$sousTraitant= htmlspecialchars($row[18]); 
		$delaiEffacement= htmlspecialchars($row[19]); 
		$niveau_identification= htmlspecialchars($row[20]); 
		$com_ident= htmlspecialchars($row[21]); 
		$niveau_securite= htmlspecialchars($row[22]); 
		$com_secu= htmlspecialchars($row[23]); 
		$derniereMAJ= htmlspecialchars($row[24]);	
		$declarant= htmlspecialchars($row[25]);
		$daodeclarant=new UtilisateurDAO();		
        $declarantTXT=$daodeclarant->readDeclarant($declarant);		
		$pole= htmlspecialchars($row[26]); 
		$entite= htmlspecialchars($row[27]); 
		$nomresp= htmlspecialchars($row[28]); 
		$gest= htmlspecialchars($row[29]); 
		$donneePIA= htmlspecialchars($row[30]); 
		$PIA= htmlspecialchars($row[31]);
		$planAction= htmlspecialchars($row[32]); 
		$baseJuridique= htmlspecialchars($row[33]);
		$baseJuridiqueLiceite= htmlspecialchars($row[34]);
 			
		fputcsv($output, array($identifiant,$nomLogiciel,$origineDonnee,$validationDPD,$finaliteTraitement,$sousFinalite,$commentaire,$dateMiseEnOeuvre,$cdonnee,$catPersConcern,
		$destiDonnees,$dureeUtiliteAdmi,$archivage,$transfertHorsUE,$cliceite,$support,$coRespTraitement,$representantCoResp,$sousTraitant,$delaiEffacement,
		$niveau_identification,$com_ident,$niveau_securite,$com_secu,$derniereMAJ,$declarantTXT,$gest,$pole,$entite,$nomresp,$donneePIA,$PIA,$planAction,$baseJuridique,$baseJuridiqueLiceite));
	}
	fclose($output);
	$fname = 'importexport/exportformulaire.csv';
	header('Content-type: application/text');
	header("Content-Disposition: inline; filename=".$fname);
	readfile($fname);	
}