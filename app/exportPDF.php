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
use metier\formulaire\Formulaire;
use DAO\Catliceiteformulaire\CatliceiteformulaireDAO;

session_start();
include("connexion/check_connect.php");
include ("connexion/Daos.php");

// header ("Refresh: 1;URL=admin_all.php");
// header('Content-type: text/html; charset=utf-8');

// partie qui gère les exports des tables.  

if (isset($_POST['validerPDF'])){
	$jour=date('d-m-Y');

/*****************/
require('./fpdf/tableau.php');
//require('./fpdf/bookmark.php');
/*****************/

$pdf = new PDF();
$titre = "Registre des traitements RGPD du ".$jour;  
$pdf->SetTitle($titre);

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);

//reprise de l'export CSV : requête sql
	$sql = "SELECT formulaire.identifiant, formulaire.nomLogiciel, formulaire.origineDonnee, DATE_FORMAT(formulaire.validationDPD, '%d-%m-%Y') , formulaire.finaliteTraitement, formulaire.sousFinalite, 
		formulaire.commentaire, DATE_FORMAT(formulaire.dateMiseEnOeuvre, '%d-%m-%Y'), servicesmunicipaux.service, formulaire.catDonneeTraitee, formulaire.catPersConcern, formulaire.destiDonnees, 
      	formulaire.dureeUtiliteAdmi, formulaire.archivage, formulaire.transfertHorsUE, formulaire.catLiceiteTraitee, formulaire.coRespTraitement, formulaire.representantCoResp, formulaire.sousTraitant, 
		formulaire.delaiEffacement, formulaire.support, formulaire.niveau_identification, formulaire.com_ident, formulaire.niveau_securite, formulaire.com_secu, DATE_FORMAT(formulaire.derniereMAJ, '%d-%m-%Y'), 
		formulaire.declarant, poles.pole, entites.entite, entites.responsable, nom_gestda.Gestionnairesdudroitdacces, formulaire.donneePIA, formulaire.PIA, formulaire.planAction, formulaire.baseJuridique, 
		formulaire.baseJuridiqueLiceite		
 		FROM formulaire 
		LEFT JOIN nom_gestda ON nom_gestda.id_formulaire=formulaire.identifiant 
		LEFT JOIN gestionnairesdroitacces ON formulaire.identifiant = gestionnairesdroitacces.id_formulaire
		LEFT JOIN servicesmunicipaux ON gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
		LEFT JOIN poles ON poles.identifiant = servicesmunicipaux.pole
		LEFT JOIN entites ON entites.identifiant = servicesmunicipaux.entite  
		WHERE";

	/*condition si entite sélectionnée*/
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
	/* pour hors registre */
	$sql = $sql." AND (formulaire.horsRegistre is null OR formulaire.horsRegistre ='')";
	$sql = $sql." GROUP BY formulaire.identifiant ORDER BY servicesmunicipaux.entite, servicesmunicipaux.pole, formulaire.identifiant ";
	$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
	$stmt->execute();

/*A titre indicatif : emplacement des champs

formulaire.identifiant= $row[0];
formulaire.nomLogiciel= $row[1];  //Nom du logiciel
formulaire.origineDonnee= $row[2]; 
formulaire.validationDPD= $row[3]; 
formulaire.finaliteTraitement= $row[4]; 
formulaire.sousFinalite= $row[5]; 
formulaire.commentaire= $row[6]; 
formulaire.dateMiseEnOeuvre= $row[7]; 
servicesmunicipaux.service= $row[8];
formulaire.catDonneeTraitee= $row[9]; 
formulaire.catPersConcern= $row[10]; 
formulaire.destiDonnees= $row[11]; 
formulaire.dureeUtiliteAdmi= $row[12]; 
formulaire.archivage= $row[13]; 
formulaire.transfertHorsUE= $row[14]; 
formulaire.donneeSensible= $row[15]; 
formulaire.coRespTraitement= $row[16]; 
formulaire.representantCoResp= $row[17]; 
formulaire.sousTraitant= $row[18]; 
formulaire.delaiEffacement= $row[19]; 
formulaire.support= $row[20]; 
formulaire.niveau_identification= $row[21]; 
formulaire.com_ident= $row[22]; 
formulaire.niveau_securite= $row[23]; 
formulaire.com_secu= $row[24]; 
formulaire.derniereMAJ= $row[25]; 
formulaire.declarant= $row[26]; 
poles.pole= $row[27]; 
entites.entite= $row[28]; 
nom_RT.responsable= $row[29]; 
nom_gestda.Gestionnairesdudroitdacces= $row[30];
formulaire.donneePIA= $row[31]; 
formulaire.PIA= $row[32];
formulaire.planAction= $row[33]; 
formulaire.baseJuridique= $row[34];
formulaire.baseJuridiqueLiceite= $row[35];
*/
	//compteur de traitement
	$cpt=1;
	$sommaire = array();
	$pagePrec ='';
 	while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {

		/*partie pour le sommaire*/
		$page = $pdf->PageNo();
		$sommaire[$cpt]=array($cpt,iconv('UTF-8', 'windows-1252', html_entity_decode($row[1])),$page);
		
		//$pdf = new PDF_Bookmark();
		if ($page <> $pagePrec) {
			$pdf->Bookmark('Page '.$page, false); 
		} 
		$pagePrec = $page;
		$pdf->Bookmark(htmlspecialchars_decode(utf8_decode($row[1])), false, 1, -1);
		
		/*partie qui gère la mise en page PDF*/
		$fonce=array(253,180,21);
		$clair=array(255,230,185);

		$pdf->SetFont('Arial','B',10);
		$pdf->Image('./bootstrap/images/bandeau.png',5,5,-600);
		$pdf->Cell(0,5,$cpt." - ".htmlspecialchars_decode(utf8_decode($row[1]))." (".utf8_decode($row[28]).")",0,1); 
		$pdf->SetFont('Arial','I',8); 
		
		if ($row[25] <> "00-00-0000") {
			$pdf->Cell(0,5,"Validation par le DPD : ".$row[3]. " (dernière MAJ le ".$row[25].")",0,1); 
		} else {
			$pdf->Cell(0,5,"Validation par le DPD : ".$row[3],0,1); 
		}
		$pdf->Cell(0,5,"Index du traitement : ".htmlspecialchars_decode(utf8_decode($row[0])),0,1); 
		$pdf->SetFont('Arial','',8); 

		$pdf->SetFillColor($clair[0],$clair[1],$clair[2]);
		
		if ($row[20] <> "") {
			$pdf->Cell(50,5,'Support de données / outils',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(utf8_decode($row[20])),1,1);
		}
		
		if ($row[2] <> "") {
			$pdf->Cell(50,5,'Origine des données',1,0,false,true);
			$pdf->multiCell(140,5,utf8_decode($row[2]),1,1);
		}
		if ($row[7] <> "") {
			$pdf->Cell(50,5,'Date de mise en oeuvre',1,0,false,true);
			if ($row[7] <> "00-00-0000") {
				$pdf->MultiCell(140,5,utf8_decode($row[7]),1,1);
			} else {
				$pdf->MultiCell(140,5,'',1,1);
			}
		}
		if ($row[4] <> "") {
			$pdf->Cell(50,5,'Finalité',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(iconv('utf8', 'cp1252', $row[4])),1,1);
		}
		if ($row[5] <> "") {
			$pdf->Cell(50,5,'Sous-finalité',1,0,false,true);
			$pdf->MultiCell(140,5,iconv('utf8', 'cp1252', $row[5]),1,1);
		}
		if ($row[8] <> "") {
			$pdf->Cell(50,5,'Service concerné',1,0,false,true);
			$pdf->MultiCell(140,5,utf8_decode($row[8])." (pôle ".utf8_decode($row[27]).")",1,1);
		}
		if ($row[30] <> "") {
			$pdf->Cell(50,5,'Gestionnaire(s) des données',1,0,false,true);
			$pdf->MultiCell(140,5,utf8_decode($row[30]),1,1);
		}
		if ($row[29] <> "") {
			$pdf->Cell(50,5,'Responsable(s)',1,0,false,true);
			$pdf->MultiCell(140,5,utf8_decode($row[29]),1,1);
		}
		if ($row[16] <> "") {
			$pdf->Cell(50,5,'Co-responsable(s)',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(utf8_decode($row[16])),1,1);
		}
		if ($row[17] <> "") {
			$pdf->Cell(50,5,'Représentant(s) du co-responsable',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(utf8_decode($row[17])),1,1);
		}
		if ($row[18] <> "") {
			$pdf->Cell(50,5,'Sous-traitant',1,0,false,true);
			$pdf->MultiCell(140,5,iconv('utf8', 'cp1252', $row[18]),1,1);
		}
		if ($row[6] <> "") {
			$pdf->Cell(50,5,'Commentaire',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(iconv('utf8', 'cp1252', $row[6])),1,1);
		}
		if ($row[9] <> "") {
			$cdonnee="";
			foreach (explode(';', $row[9]) as $cac) {
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
			$pdf->Cell(50,5,'Catégorie de données traitée',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(iconv('utf8', 'cp1252', $cdonnee)),1,1);
		}
		if ($row[34] <> "") {
			$pdf->Cell(50,5,'Base juridique du traitement',1,0,false,true);
			$pdf->MultiCell(140,5,iconv('utf8', 'cp1252', $row[34]),1,1);
		}
		if ($row[10] <> "") {
			$pdf->Cell(50,5,'Catégorie de personnes concernée',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(iconv('utf8', 'cp1252', $row[10])),1,1);
		}
		if ($row[11] <> "") {
			$pdf->Cell(50,5,'Destinataire(s) des données',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(iconv('utf8', 'cp1252', $row[11])),1,1);
		}
		if ($row[12] <> "") {
			$pdf->Cell(50,5,'Durée d\'utilité administrative',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(iconv('utf8', 'cp1252', $row[12])),1,1);
		}
		if ($row[19] <> "") {
			$pdf->Cell(50,5,'Délais d\'effacement',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(utf8_decode($row[19])),1,1);
		}
		if ($row[13] <> "") {
			$pdf->Cell(50,5,'Archivage',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(utf8_decode($row[13])),1,1);
		}
		if ($row[14] <> "") {
			$pdf->Cell(50,5,'Transfert Hors UE',1,0,false,true);
			if ($row[14] <> "0") {
				$pdf->Cell(45,5,"Oui",1,1);
			} else {
				$pdf->Cell(45,5,"Non",1,1);
			}
		} 
		
		if ($row[15] <> "") {
			$cliceite="";
			foreach (explode(';', $row[15]) as $cac) {
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
			$pdf->Cell(50,5,'Catégories de licéités',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(iconv('utf8', 'cp1252', $cliceite)),1,1);
		}
		if ($row[35] <> "") {
			$pdf->Cell(50,5,'Base Juridique de la licéité',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(utf8_decode($row[35])),1,1);
		}
		if ($row[31] <> "") {
			$pdf->Cell(50,5,'Fait l\'objet d\'un PIA',1,0,false,true);
			if ($row[31] <> "0") {
				$pdf->Cell(45,5,"Oui",1,1);
			} else {
				$pdf->Cell(45,5,"Non",1,1);
			}
		}
		if ($row[32] <> "") {
			$pdf->Cell(50,5,'Commentaire PIA',1,0,false,true);
			$pdf->MultiCell(140,5,htmlspecialchars_decode(utf8_decode($row[20])),1,1);
		}
		if ($row[21] <> "") {
			$pdf->Cell(50,5,'Niveau d\'identification',1,0,false,true);
			$pdf->Cell(45,5,utf8_decode($row[21]),1,0);
		}
		if ($row[23] <> "") {
			$pdf->Cell(50,5,'Niveau de sécurité',1,0,false,true);
			$pdf->Cell(45,5,utf8_decode($row[23]),1,1);
		}
		if ($row[22] <> "") {
			$pdf->Cell(50,5,'Commentaire d\'identification',1,0,false,true);
			$pdf->MultiCell(140,5,iconv('utf8', 'cp1252', $row[22]),1,1);
		}
		if ($row[24] <> "") {
			$pdf->Cell(50,5,'Commentaire de sécurité',1,0,false,true);
			$pdf->MultiCell(140,5,iconv('utf8', 'cp1252', $row[24]),1,1);
		}
		if ($row[33] <> "") {
			$pdf->Cell(50,5,'Plan d\'action du DPD',1,0,false,true);
			$pdf->MultiCell(140,5,iconv('utf8', 'cp1252', $row[33]),1,1);
		}
		$pdf->ln();
					
		$cpt = $cpt+1;
	}	
	
/****** POUR LE SOMMAIRE *******/	
	// Calcul de la taille du tableau
	$tailleSommaire = sizeof($sommaire);
	// Parcours du tableau
	$pdf->ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,"Table des matières",0,1); 
	
	for($i=1; $i<$tailleSommaire+1; $i++) {
		$pdf->SetFont('Arial','I',8); 
		if (($sommaire[$i][2]) <> $pagePrec) {
			$pdf->Cell(20,5,"Page ".$sommaire[$i][2],1,0,false,true);
		} else {
			$pdf->Cell(20,5,"",1,0,false,true);
		}
		$pdf->SetFont('Arial','',8); 
		$pdf->Multicell(170,5,"Traitement n°".$sommaire[$i][0]." / ".$sommaire[$i][1],1,1,false,true);
		$pagePrec = $sommaire[$i][2];
	}
/*
	$jour=date('Y-m-d h:m:s');
	$nomdoc = "Export-".$_SESSION['identifiant'];
	$nomdoc = strtr($nomdoc, 'ÁÀÂÄÃÅÇÉÈÊËÍÏÎÌÑÓÒÔÖÕÚÙÛÜÝ', 'AAAAAACEEEEEIIIINOOOOOUUUUY');
	$nomdoc = strtr($nomdoc, 'áàâäãåçéèêëíìîïñóòôöõúùûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
	$nomFichier=$jour."-".$nomdoc.".pdf";
	$cheminFichier="generationPDF/".$nomFichier;
	$pdf->Output('F',$cheminFichier);
*/
	$nomdoc="Export RGPD-".$jour;
	$pdf->Output();

}

