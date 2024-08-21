<?php
namespace metier\formulaire
{
    use DAO\VariableGlobale\VariableGlobaleDAO;
    use DAO\GestionnaireDroitAcces\GestionnaireDroitAccesDAO;
    use DAO\ServiceMunicipal\ServiceMunicipalDAO;
    use DAO\Droit\DroitDAO;
	use DAO\Utilisateur\UtilisateurDAO;
	use DAO\Catdonneeformulaire\CatdonneeformulaireDAO;
	use DAO\Catliceiteformulaire\CatliceiteformulaireDAO;
    use metier;

use metier\droit\Droit;

    class Formulaire
    {
        private $identifiant = "-1";
        private $nomLogiciel = "";
        private $origineDonnee = "";
        private $validationDPD = "";
        private $finaliteTraitement = "";
        private $sousFinalite = "";
        private $commentaire = "";
        private $dateMiseEnOeuvre = "";
        private $catDonneeTraitee = "";
        private $catPersConcern = "";
        private $destiDonnees = "";
        private $dureeUtiliteAdmi = "";
        private $archivage = "";
        private $transfertHorsUE = FALSE;
        private $catLiceiteTraitee = "";
		private $support="";
        private $coRespTraitement = "";
        private $representantCoResp = "";
        private $sousTraitant = "";
        private $delaiEffacement = "";
        private $niveau_identification="";
        private $com_ident="";
        private $niveau_securite="";
        private $com_secu="";
        private $donneePIA="";
        private $PIA="";
        private $horsRegistre="";
        private $derniereMAJ = "";
        private $declarant = -1;
		private $planAction = "";
        private $baseJuridique= -1;
		private $baseJuridiqueLiceite="";

		function __construct($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee, $catPersConcern, $destiDonnees,
			$dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement, $support, $niveau_identification,
			$com_ident, $niveau_securite, $com_secu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite)
        {
            $this->nomLogiciel = $nomLogiciel;
            $this->origineDonnee = $origineDonnee;
            $this->validationDPD = $validationDPD;
            $this->finaliteTraitement = $finaliteTraitement;
            $this->sousFinalite = $sousFinalite;
            $this->commentaire = $commentaire;
            $this->dateMiseEnOeuvre = $dateMiseEnOeuvre;
            $this->catDonneeTraitee = $catDonneeTraitee;
            $this->catPersConcern = $catPersConcern;
            $this->destiDonnees = $destiDonnees;
            $this->dureeUtiliteAdmi = $dureeUtiliteAdmi;
            $this->archivage = $archivage;
            $this->transfertHorsUE = $transfertHorsUE;
            $this->catLiceiteTraitee = $catLiceiteTraitee;
            $this->coRespTraitement = $coRespTraitement;
            $this->representantCoResp = $representantCoResp;
            $this->sousTraitant = $sousTraitant;
            $this->delaiEffacement = $delaiEffacement;
            $this->support = $support;
            $this->niveau_identification = $niveau_identification;
		    $this->com_ident = $com_ident;
            $this->niveau_securite = $niveau_securite;
            $this->com_secu = $com_secu;
			$this->donneePIA = $donneePIA;
            $this->PIA = $PIA;
			$this->horsRegistre = $horsRegistre;
            $this->derniereMAJ = $derniereMAJ;
            $this->declarant = $declarant;
			$this->planAction = $planAction;
            $this->baseJuridique = $baseJuridique;
			$this->baseJuridiqueLiceite = $baseJuridiqueLiceite;
        }

        public function getDeclarant()
        {
            return $this->declarant;
        }

        public function setDeclarant($declarant)
        {
            $this->declarant = $declarant;
            return $this;
        }

        public function getIdentifiant()
        {
            return $this->identifiant;
        }

        public function getNomLogiciel()
        {
            return $this->nomLogiciel;
        }

        public function getOrigineDonnee()
        {
            return $this->origineDonnee;
        }

        public function getvalidationDPD()
        {
            return $this->validationDPD;
        }

        public function getFinaliteTraitement()
        {
            return $this->finaliteTraitement;
        }

        public function getSousFinalite()
        {
            return $this->sousFinalite;
        }

        public function getCommentaire()
        {
            return $this->commentaire;
        }

        public function getDateMiseEnOeuvre()
        {
            return $this->dateMiseEnOeuvre;
        }

        public function getCatDonneeTraitee()
        {
            return $this->catDonneeTraitee;
        }

        public function getCatPersConcern()
        {
            return $this->catPersConcern;
        }

        public function getDestiDonnees()
        {
            return $this->destiDonnees;
        }

        public function getDureeUtiliteAdmi()
        {
            return $this->dureeUtiliteAdmi;
        }

        public function getArchivage()
        {
            return $this->archivage;
        }

        public function getTransfertHorsUE()
        {
            return $this->transfertHorsUE;
        }

        public function getcatLiceiteTraitee()
        {
            return $this->catLiceiteTraitee;
        }

        public function getCoRespTraitement()
        {
            return $this->coRespTraitement;
        }

        public function getRepresentantCoResp()
        {
            return $this->representantCoResp;
        }

        public function getSousTraitant()
        {
            return $this->sousTraitant;
        }

        public function getDelaiEffacement()
        {
            return $this->delaiEffacement;
        }

        public function getDerniereMAJ()
        {
            return $this->derniereMAJ;
        }

        public function getSupport()
        {
            return $this->support;
        }

        public function getNiveau_identification()
        {
            return $this->niveau_identification;
        }

        public function getCom_ident()
        {
            return $this->com_ident;
        }

        public function getCom_secu()
        {
            return $this->com_secu;
        }

        public function getNiveau_securite()
        {
            return $this->niveau_securite;
        }

		public function getDonneePIA()
        {
            return $this->donneePIA;
        }

        public function getPIA()
        {
            return $this->PIA;
        }

		public function getHorsRegistre()
        {
            return $this->horsRegistre;

        }

		public function getPlanAction()
        {
            return $this->planAction;

        }

		public function getBaseJuridique()
        {
            return $this->baseJuridique;

        }

		public function getBaseJuridiqueLiceite()
        {
            return $this->baseJuridiqueLiceite;

        }

		public function setDonneePIA($donneePIA)
        {
            $this->donneePIA = $donneePIA;
            return $this;
        }

		public function setPIA($PIA)
        {
            $this->PIA = $PIA;
            return $this;
        }

		public function setHorsRegistre($horsRegistre)
        {
            $this->horsRegistre = $horsRegistre;
            return $this;
        }

        public function setIdentifiant($identifiant)
        {
            $this->identifiant = $identifiant;
            return $this;
        }

        public function setNomLogiciel($nomLogiciel)
        {
            $this->nomLogiciel = $nomLogiciel;
            return $this;
        }

        public function setOrigineDonnee($origineDonnee)
        {
            $this->origineDonnee = $origineDonnee;
            return $this;
        }

        public function setvalidationDPD($validationDPD)
        {
            $this->validationDPD = $validationDPD;
            return $this;
        }

        public function setFinaliteTraitement($finaliteTraitement)
        {
            $this->finaliteTraitement = $finaliteTraitement;
            return $this;
        }

        public function setSousFinalite($sousFinalite)
        {
            $this->sousFinalite = $sousFinalite;
            return $this;
        }

        public function setCommentaire($commentaire)
        {
            $this->commentaire = $commentaire;
            return $this;
        }

        public function setDateMiseEnOeuvre($dateMiseEnOeuvre)
        {
            $this->dateMiseEnOeuvre = $dateMiseEnOeuvre;
            return $this;
        }

        public function setCatDonneeTraitee($catDonneeTraitee)
        {
            $this->catDonneeTraitee = $catDonneeTraitee;
            return $this;
        }

        public function setCatPersConcern($catPersConcern)
        {
            $this->catPersConcern = $catPersConcern;
            return $this;
        }

        public function setDestiDonnees($destiDonnees)
        {
            $this->destiDonnees = $destiDonnees;
            return $this;
        }

        public function setDureeUtiliteAdmi($dureeUtiliteAdmi)
        {
            $this->dureeUtiliteAdmi = $dureeUtiliteAdmi;
            return $this;
        }

        public function setArchivage($archivage)
        {
            $this->archivage = $archivage;
            return $this;
        }

        public function setTransfertHorsUE($transfertHorsUE)
        {
            $this->transfertHorsUE = $transfertHorsUE;
            return $this;
        }

        public function setcatLiceiteTraitee($catLiceiteTraitee)
        {
            $this->catLiceiteTraitee = $catLiceiteTraitee;
            return $this;
        }

        public function setCoRespTraitement($coRespTraitement)
        {
            $this->coRespTraitement = $coRespTraitement;
            return $this;
        }

        public function setRepresentantCoResp($representantCoResp)
        {
            $this->representantCoResp = $representantCoResp;
            return $this;
        }

        public function setSousTraitant($sousTraitant)
        {
            $this->sousTraitant = $sousTraitant;
            return $this;
        }

        public function setDelaiEffacement($delaiEffacement)
        {
            $this->delaiEffacement = $delaiEffacement;
            return $this;
        }

        public function setSupport($support)
        {
            $this->support = $support;
            return $this;
        }

        public function setNiveau_identification($niveau_identification)
        {
            $this->niveau_identification = $niveau_identification;
            return $this;
        }

        public function setCom_ident($com_ident)
        {
            $this->com_ident = $com_ident;
            return $this;
        }

        public function setNiveau_securite($niveau_securite)
        {
            $this->niveau_securite = $niveau_securite;
            return $this;
        }

        public function setCom_secu($com_secu)
        {
            $this->com_secu = $com_secu;
            return $this;
        }

        public function setDerniereMAJ($derniereMAJ)
        {
            $this->derniereMAJ = $derniereMAJ;
            return $this;
        }

		public function setPlanAction($planAction)
        {
            $this->planAction = $planAction;
            return $this;
        }

        public function setBaseJuridique($baseJuridique)
        {
            $this->baseJuridique = $baseJuridique;
            return $this;
        }

		public function setBaseJuridiqueLiceite($baseJuridiqueLiceite)
        {
            $this->baseJuridiqueLiceite = $baseJuridiqueLiceite;
            return $this;
        }

        static function toUs($date_fr)
        {
            // transformation de la variable date au bon format
            $date = explode('/', $date_fr);
            $date_us = "$date[2]-$date[1]-$date[0]";
            return $date_us;
        }

        static function toFr($date_Us)
        {
		// transformation de la variable date au bon format
            $date = explode('-', $date_Us);
            $date_Fr = "$date[2]/$date[1]/$date[0]";
            return $date_Fr;
        }

        public static function tableauFormulaire($listeService)
        {
$rep = "<form action=\"modif_frm.php\" method=\"post\" id=\"modifier\"><table>";

/*ajout tri !! 22-10-2018*/
            $rep .= "<tr class='something'><th class='col-md-1'>" . "Sélection" . "</th><th class='col-md-2'>" . "Gestionnaire(s) du droit d'accès

			<!--<img src='bootstrap/images/fleche-bas.png' width='8%' id='imgTri1' title='asc' onclick='triChangeAsc();'>-->

	";
?>
<script>
function triChangeAsc() {
	if (document.getElementById('imgTri1').title= 'asc') {
		document.getElementById('imgTri1').src='bootstrap/images/fleche-haut.png';
		document.getElementById('imgTri1').title='desc';
		document.getElementById('imgTri1').onclick=function()
   {
       triChangeDesc();
   };
	}
}
function triChangeDesc() {
	if (document.getElementById('imgTri1').title= 'desc') {
		document.getElementById('imgTri1').src='bootstrap/images/fleche-bas.png';
		document.getElementById('imgTri1').title='asc';
		document.getElementById('imgTri1').onclick=function()
   {
       triChangeAsc();
   };
	}
}

</script>
<?php
            $rep .= "</th><th class='col-md-2'>" . "index et Nom du Traitement" . "</th><th class='col-md-4'>" . "Finalité du traitement" . "</th><th class='col-md-1'>" . "Date de dernière mise à jour"."</th></tr>";
			$test=1;
            $daoDroit= new DroitDAO();
            if (isset($_SESSION['identifiant']) && isset($_SESSION['identifiant'])) {
                $identifiant=$_SESSION['identifiant'];
                $droitgest=$daoDroit->readIdUtil(($_SESSION['identifiant']));
            } else {
                $droitgest=array();
            }

			$_SESSION['nbtrait'] = 0;
            foreach ($listeService as $unService) {
				$_SESSION['nbtrait']++;
                $val = $unService->getIdentifiant();
				//gestionnaire d'accès
                $daoTest= new GestionnaireDroitAccesDAO();
                $repGesti=$daoTest->readIdForm($val);
                $rep7="";
                $popgesti=implode(',', $repGesti);

                foreach ($repGesti as $gest){
					$sql = "SELECT servicesmunicipaux.identifiant, service, entites.entite FROM servicesmunicipaux
						INNER JOIN entites on servicesmunicipaux.entite = entites.identifiant
						WHERE servicesmunicipaux.identifiant = ".$gest."
						ORDER BY service asc;";

					$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
					$stmt->bindParam(':id', $id);
					$stmt->execute();
					while ($row = $stmt->fetch()) {
						$rep7= $rep7.$row['service']." <i><small>(".$row['entite']."</small></i>), ";
					}
				}

				//responsable traitement A AJOUTER
				$rep8="";
				$sql = "SELECT entites.responsable FROM entites
				INNER JOIN servicesmunicipaux on servicesmunicipaux.entite = entites.identifiant
				INNER JOIN gestionnairesdroitacces on gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
				WHERE id_formulaire = ".$val.";";
				$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
				$stmt->execute();
				$row = $stmt->fetch();
				$rep8=$row[0];

                $derniereMaj=$unService->getDerniereMAJ();
                $newDerniereMaj=metier\formulaire\Formulaire::toFr($derniereMaj);
                if ($newDerniereMaj=="00/00/0000"){
                    $newDerniereMaj="/";
                }
                $tabpop=\metier\formulaire\Formulaire::tableauMailForm($unService, $popgesti);

                if(Droit::comparerArray($droitgest, $repGesti)){
                        $disable="";
                } else {
                    $disable=" disabled";
                }

                $rep .= "<tr>";
                $rep .= "<td>" . "<button name=\"modifier\" type=\"submit\" class=\"btn btn-info2 btn-sm\" value=$val$disable>Modifier</button>" . " <button type=\"button\" class=\"btn btn-info btn-sm\" data-toggle=\"modal\" data-target=\"#myModal$test\"> Détails </button></td>";
				$rep .= "<td>" . $rep7 . "</td>";
                $rep .= "<td>" . $unService->getIdentifiant()." - ".$unService->getNomLogiciel() . "</td>";
                $rep .= "<td>" . $unService->getFinaliteTraitement() . "</td>";
                $rep .= "<td>" . $newDerniereMaj . "</td>";
                $rep .= "</tr>";

                //<!-- Modal -->
                echo "<div class=\"modal fade\" id=\"myModal$test\" role=\"dialog\">";
                echo "<div class=\"modal-dialog\">";
                //<!-- Modal content-->
                echo "<div class=\"modal-content\">";
                echo "<div class=\"modal-header\">";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>";
                echo "<h4 class=\"modal-title\">Détails de la déclaration</h4></div>";
                echo "<div class=\"modal-body\">";

                echo $tabpop;
                echo "</div></div></div></div>";
        		$test+=1;
            }
            return $rep . "</tr></table></form><p class='text-center'>".$_SESSION['nbtrait']." traitement(s) visible(s)</p>";
        }

        public static function tableauMailForm($formulaire, $id_gestionnaire)
        {
			$val = $formulaire->getIdentifiant();

			// pour les gestionnaires et responsables
			$rep7="";
			$rep8="";
			foreach (explode(',', $id_gestionnaire) as $gest){
				/*$daoG=new ServiceMunicipalDAO();
				$rep7.=$daoG->readService($gest) . ", ";*/

				$sql = "SELECT servicesmunicipaux.identifiant, service, entites.entite, entites.responsable FROM servicesmunicipaux
					INNER JOIN entites on servicesmunicipaux.entite = entites.identifiant
					WHERE servicesmunicipaux.identifiant = ".$gest."
					ORDER BY service asc;";
				$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
				$stmt->bindParam(':id', $id);
				$stmt->execute();
				while ($row = $stmt->fetch()) {
					$rep7= $rep7.$row['service']." <i><small>(".$row['entite']."</small></i>), ";
					$rep8= $rep8.$row['responsable']." <i><small>(".$row['entite']."</small></i>), ";
				}
			}

			$dateValidationDPD=$formulaire->getvalidationDPD();
			$newdateValidationDPD=metier\formulaire\Formulaire::toFr($dateValidationDPD);
			$dateMiseOeuvre=$formulaire->getDateMiseEnOeuvre();
			$newDateMiseoeuvre=metier\formulaire\Formulaire::toFr($dateMiseOeuvre);
			$derniereMaj=$formulaire->getDerniereMAJ();
			$newDerniereMaj=metier\formulaire\Formulaire::toFr($derniereMaj);
			$nomL=$formulaire->getNomLogiciel();
			$numD=$formulaire->getorigineDonnee();
			$fin=$formulaire->getFinaliteTraitement();
			$sf=$formulaire->getSousFinalite();
			$com=$formulaire->getCommentaire();
			$cat=$formulaire->getCatDonneeTraitee();
			$cdonnee="";
			foreach (explode(';', $cat) as $cac) {
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
			$catLic=$formulaire->getCatLiceiteTraitee();
			$cliceite="";
			foreach (explode(';', $catLic) as $cac) {
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
			$support=$formulaire->getSupport();
			$catP=$formulaire->getCatPersConcern();
			$dD=$formulaire->getDestiDonnees();
			$dUA=$formulaire->getDureeUtiliteAdmi();
			$arch=$formulaire->getArchivage();
			if ($formulaire->getTransfertHorsUE()==1){
				$transUE="OUI";
			} else {
				$transUE="NON";
			}
			if ($formulaire->getcatLiceiteTraitee()==1){
				$donneeC="OUI";
			} else {
				$donneeC="NON";
			}
			$coRT=$formulaire->getCoRespTraitement();
			$repCR=$formulaire->getRepresentantCoResp();
			$sT=$formulaire->getSousTraitant();
			$nivIdent=$formulaire->getNiveau_identification();
			$comIdent=$formulaire->getCom_ident();
			$donneePIA=$formulaire->getdonneePIA();
			$PIA=$formulaire->getPIA();
			$horsRegistre=$formulaire->getHorsRegistre();
			$planAction=$formulaire->getPlanAction();
			$baseJuridique=$formulaire->getBaseJuridique();
			$baseJuridiqueLiceite=$formulaire->getBaseJuridiqueLiceite();
			$nivSecu=$formulaire->getNiveau_securite();
			$comSecu=$formulaire->getCom_secu();
			$dE=$formulaire->getDelaiEffacement();
			/*AJOUT declarant 26/04/2019*/
			$idDeclarant=$formulaire->getDeclarant();
			$daodeclarant=new UtilisateurDAO();
            $declarant=$daodeclarant->readDeclarant($idDeclarant);
			/**/
			$rep = "<table>
						<tr>
						<td></td>
						<th class='col-md-9'>Déclaration</th>
						</tr><tr>
							<th>Gestionnaire(s) du droit d'accès</th><td>" . $rep7 . "</td>
						</tr><tr>
							<th>Nom du traitement</th><td>" . $nomL . "</td>
						</tr><tr>
							<th>Support de données / outils" ."</th><td>" . $support . "</td>
						</tr><tr>
							<th>Déclarant</th><td>" . $declarant. "</td>
						</tr><tr>
							<th>Validation par le DPD</th><td>" . $newdateValidationDPD . "</td>
						</tr><tr>
							<th>Finalité du traitement</th><td>" . $fin . "</td>
						</tr><tr>
							<th>Sous-finalité</th><td>" . $sf . "</td>
						</tr><tr>
							<th>Origine des données</th><td>" . $numD . "</td>
						</tr><tr>
							<th>Nom du responsable du traitement</th><td>" . $rep8 . "</td>
						</tr><tr>
							<th>Commentaire</th><td>" . $com . "</td>
						</tr><tr>
							<th>Date de mise en oeuvre</th><td>" . $newDateMiseoeuvre . "</td>
						</tr><tr>
							<th>Catégorie de données traitées</th><td>" . $cdonnee. "</td>
						</tr><tr>
							<th>Base juridique du traitement</th><td>" . $baseJuridique . "</td>
						</tr><tr>
							<th>Catégorie de personnes concernées</th><td>" . $catP . "</td>
						</tr><tr>
							<th>Destinataires des données</th><td>" . $dD . "</td>
						</tr><tr>
							<th>Durée d'utilité administrative</th><td>" . $dUA . "</td>
						</tr><tr>
							<th>Archivage</th><td>" . $arch . "</td>
						</tr><tr>
							<th>Transfert hors UE</th><td>" . $transUE . "</td>
						</tr><tr>
							<th>Licéité du traitement</th><td>" . $cliceite . "</td>
						</tr><tr>
							<th>Base juridique de la licéité du traitement" ."</th><td>" . $baseJuridiqueLiceite . "</td>
						</tr><tr>
							<th>Co-responsable du traitement" ."</th><td>" . $coRT . "</td>
						</tr><tr>
							<th>Représentant du Co-responsable du traitement" ."</th><td>" . $repCR . "</td>
						</tr><tr>
							<th>Sous-traitant</th><td>" . $sT . "</td>
						</tr><tr>
							<th>Délai d'effacement</th><td>" . $dE . "</td>
						</tr><tr>
							<th>Niveau d'identification</th><td>" . $nivIdent . "</td>
						</tr><tr>
							<th>Commentaire identification</th><td>" . $comIdent . "</td>
						</tr><tr>
							<th>PIA O/N</th><td>" . $donneePIA . "</td>
						</tr><tr>
							<th>Commentaire PIA</th><td>" . $PIA . "</td>
						</tr><tr>
							<th>Plan d'action</th><td>" . $planAction . "</td>
						</tr><tr>
							<th>Hors Registre</th><td>" . $horsRegistre . "</td>
						</tr><tr>
							<th>Niveau de sécurité</th><td>" . $nivSecu . "</td>
						</tr><tr>
							<th>Commentaire sécurité</th><td>" . $comSecu . "</td>
						</tr><tr>
							<th>Date de dernière mise à jour</th><td>" . $newDerniereMaj . "</td>
						</tr></table>";
			return $rep;
		}

		static function comparer($val1, $val2)
		{
			if ($val1!=$val2){
				$rep="<strong>".$val2."</strong>";
			} else {
				$rep=$val2;
			}
			return $rep;
		}

		public static function tableauComparerForm($objetFormModif, $id_gestionnaireModif)
		{
			$daoForm = new \DAO\Formulaire\FormulaireDAO();
			$valM = $objetFormModif->getIdentifiant();
			$objetFormAncien=$daoForm->read($valM);
			$val= $objetFormAncien->getIdentifiant();

			//pour les gestionnaires des droits d'accès
			$daoTest= new GestionnaireDroitAccesDAO();
			$repGesti=$daoTest->readIdForm($val);
			$repGestiM=$id_gestionnaireModif;
			$rep7="";
			foreach ($repGesti as $gest){
				$daoG=new ServiceMunicipalDAO();
				$rep7.=$daoG->readService($gest) . "<br/> ";
			}
			$rep7M="";
			foreach (explode(",", $repGestiM) as $gestM){
				$daoGM=new ServiceMunicipalDAO();
				$rep7M.=$daoGM->readService($gestM) . "<br/> ";
			}

			//pour les responsables A AJOUTER
			$rep8="";
			$sql = "SELECT entites.responsable FROM entites
			INNER JOIN servicesmunicipaux on servicesmunicipaux.entite = entites.identifiant
			INNER JOIN gestionnairesdroitacces on gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
			WHERE id_formulaire = ".$val.";";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->execute();
			$row = $stmt->fetch();
			$rep8=$row[0];

			$rep8M="";
			$sql = "SELECT entites.responsable FROM entites
			INNER JOIN servicesmunicipaux on servicesmunicipaux.entite = entites.identifiant
			INNER JOIN gestionnairesdroitacces on gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
			WHERE id_formulaire = ".$valM.";";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->execute();
			$row = $stmt->fetch();
			$rep8M=$row[0];

			$dateValidationDPD=$objetFormAncien->getvalidationDPD();
			$dateValidationDPDM=$objetFormModif->getvalidationDPD();
			$newdateValidationDPD=\metier\formulaire\Formulaire::toFr($dateValidationDPD);
			if ($newdateValidationDPD=="00/00/0000"){
				$newdateValidationDPD="/";
			}
			$newdateValidationDPDM=\metier\formulaire\Formulaire::toFr($dateValidationDPDM);
			if ($newdateValidationDPDM=="00/00/0000"){
				$newdateValidationDPDM="/";
			}
			$dateMiseOeuvre=$objetFormAncien->getDateMiseEnOeuvre();
			$dateMiseOeuvreM=$objetFormModif->getDateMiseEnOeuvre();
			$newDateMiseoeuvre=\metier\formulaire\Formulaire::toFr($dateMiseOeuvre);
			if ($newDateMiseoeuvre=="00/00/0000"){
				$newDateMiseoeuvre="/";
			}
			$newDateMiseoeuvreM=\metier\formulaire\Formulaire::toFr($dateMiseOeuvreM);
			if ($newDateMiseoeuvreM=="00/00/0000"){
				$newDateMiseoeuvreM="/";
			}
			$derniereMaj=$objetFormAncien->getDerniereMAJ();
			$derniereMajM=$objetFormModif->getDerniereMAJ();
			$newDerniereMaj=\metier\formulaire\Formulaire::toFr($derniereMaj);
			if ($newDerniereMaj=="00/00/0000"){
				$newDerniereMaj="/";
			}
			$newDerniereMajM=\metier\formulaire\Formulaire::toFr($derniereMajM);
			if ($newDerniereMajM=="00/00/0000"){
				$newDerniereMajM="/";
			}
			$nomL=$objetFormAncien->getNomLogiciel();
			$nomLM=$objetFormModif->getNomLogiciel();
			$numD=$objetFormAncien->getorigineDonnee();
			$numDM=$objetFormModif->getorigineDonnee();
			$fin=$objetFormAncien->getFinaliteTraitement();
			$finM=$objetFormModif->getFinaliteTraitement();
			$sf=$objetFormAncien->getSousFinalite();
			$sfM=$objetFormModif->getSousFinalite();
			$com=$objetFormAncien->getCommentaire();
			$comM=$objetFormModif->getCommentaire();

			$cat=$objetFormAncien->getCatDonneeTraitee();
			$catdonnee="";
			foreach (explode(';', $cat) as $cac) {
				$cd = new CatdonneeformulaireDAO();
				$readAll = $cd->readAll();
				foreach ($readAll as $key => $e) {
					$rep = $e->getIdentifiant();
					if ($rep==$cac) {
						$libelle = $e->getLibelle();
						$catdonnee = $catdonnee.$libelle."; ";
					}
				}
			}
			$catM=$objetFormModif->getCatDonneeTraitee();
			$catdonneeM="";
			foreach (explode(';', $catM) as $cac) {
				$cd = new CatdonneeformulaireDAO();
				$readAll = $cd->readAll();
				foreach ($readAll as $key => $e) {
					$rep = $e->getIdentifiant();
					if ($rep==$cac) {
						$libelleM = $e->getLibelle();
						$catdonneeM = $catdonneeM.$libelleM."; ";
					}
				}
			}

			$catP=$objetFormAncien->getCatPersConcern();
			$catPM=$objetFormModif->getCatPersConcern();
			$dD=$objetFormAncien->getDestiDonnees();
			$dDM=$objetFormModif->getDestiDonnees();
			$dUA=$objetFormAncien->getDureeUtiliteAdmi();
			$dUAM=$objetFormModif->getDureeUtiliteAdmi();
			$arch=$objetFormAncien->getArchivage();
			$archM=$objetFormModif->getArchivage();
			if ($objetFormAncien->getTransfertHorsUE()==1){
				$transUE="OUI";
			} else {
				$transUE="NON";
			}
			if ($objetFormModif->getTransfertHorsUE()==1){
				$transUEM="OUI";
			} else {
				$transUEM="NON";
			}
			if ($objetFormAncien->getcatLiceiteTraitee()==1){
				$donneeC="OUI";
			} else {
				$donneeC="NON";
			}
			if ($objetFormModif->getcatLiceiteTraitee()==1){
				$donneeCM="OUI";
			} else {
				$donneeCM="NON";
			}
			$coRT=$objetFormAncien->getCoRespTraitement();
			$coRTM=$objetFormModif->getCoRespTraitement();
			$repCR=$objetFormAncien->getRepresentantCoResp();
			$repCRM=$objetFormModif->getRepresentantCoResp();
			$sT=$objetFormAncien->getSousTraitant();
			$sTM=$objetFormModif->getSousTraitant();
			$dE=$objetFormAncien->getDelaiEffacement();
			$dEM=$objetFormModif->getDelaiEffacement();

			$catL=$objetFormAncien->getCatLiceiteTraitee();
			$catliceite="";
			foreach (explode(';', $catL) as $cac) {
				$cd = new CatliceiteformulaireDAO();
				$readAll = $cd->readAll();
				foreach ($readAll as $key => $e) {
					$rep = $e->getIdentifiant();
					if ($rep==$cac) {
						$libelle = $e->getLibelle();
						$catliceite = $catliceite.$libelle."; ";
					}
				}
			}
			$catLM=$objetFormModif->getCatLiceiteTraitee();
			$catliceiteM="";
			foreach (explode(';', $catLM) as $cac) {
				$cd = new CatliceiteformulaireDAO();
				$readAll = $cd->readAll();
				foreach ($readAll as $key => $e) {
					$rep = $e->getIdentifiant();
					if ($rep==$cac) {
						$libelleM = $e->getLibelle();
						$catliceiteM = $catliceiteM.$libelleM."; ";
					}
				}
			}
			$support=$objetFormAncien->getSupport();
			$supportM=$objetFormModif->getSupport();
			$nivIdent=$objetFormAncien->getNiveau_identification();
			$nivIdentM=$objetFormModif->getNiveau_identification();
			$comIdent=$objetFormAncien->getCom_ident();
			$comIdentM=$objetFormModif->getCom_ident();
			$donneePIA=$objetFormAncien->getDonneePIA();
			$donneePIAM=$objetFormModif->getDonneePIA();
			$PIA=$objetFormAncien->getPIA();
			$PIAM=$objetFormModif->getPIA();
			$horsRegistre=$objetFormAncien->getHorsRegistre();
			$horsRegistreM=$objetFormModif->getHorsRegistre();
			$planAction=$objetFormAncien->getPlanAction();
			$planActionM=$objetFormModif->getPlanAction();
			$baseJuridique=$objetFormAncien->getBaseJuridique();
			$baseJuridiqueM=$objetFormModif->getBaseJuridique();
			$baseJuridiqueLiceite=$objetFormAncien->getBaseJuridiqueLiceite();
			$baseJuridiqueLiceiteM=$objetFormModif->getBaseJuridiqueLiceite();
			$nivSecu=$objetFormAncien->getNiveau_securite();
			$nivSecuM=$objetFormModif->getNiveau_securite();
			$comSecu=$objetFormAncien->getCom_secu();
			$comSecuM=$objetFormModif->getCom_secu();
			$rep = "<form action=\"comparer.php\" method=\"post\" id=\"comparer\">
						<table>
							<tr>
								<td></td><th>Ancienne déclaration</th><th>Nouvelle déclaration</th>
							</tr><tr>
								<th>Gestionnaire(s) des données</th><td>" . $rep7 . "</td><td>" . metier\formulaire\Formulaire::comparer($rep7, $rep7M) . "</td>
							</tr><tr>
								<th>Nom du traitement</th><td>" . $nomL . "</td><td>" . metier\formulaire\Formulaire::comparer($nomL, $nomLM) . "</td>
							</tr><tr>
								<th>Support de données / outils" ."</th><td>" . $support . "</td><td>" . metier\formulaire\Formulaire::comparer($support, $supportM) . "</td>
							</tr><tr>
								<th>Validation par le DPD</th><td>" . $newdateValidationDPD . "</td><td>" . metier\formulaire\Formulaire::comparer($newdateValidationDPD, $newdateValidationDPDM) . "</td>
							</tr><tr>
								<th>Finalité du traitement</th><td>" . $fin . "</td><td>" . metier\formulaire\Formulaire::comparer($fin, $finM) . "</td>
							</tr><tr>
								<th>Sous-finalité</th><td>" . $sf . "</td><td>" . metier\formulaire\Formulaire::comparer($sf, $sfM) . "</td>
							</tr><tr>
								<th>Nom du responsable du traitement</th><td>" . $rep8 . "</td><td>" . metier\formulaire\Formulaire::comparer($rep8, $rep8M) . "</td>
							</tr><tr>
								<th>Origine des données</th><td>" . $numD . "</td><td>" . metier\formulaire\Formulaire::comparer($numD, $numDM) . "</td>
							</tr><tr>
								<th>Commentaire</th><td>" . $com . "</td><td>" . metier\formulaire\Formulaire::comparer($com, $comM) . "</td>
							</tr><tr>
								<th>Date de mise en oeuvre</th><td>" . $newDateMiseoeuvre . "</td><td>" . metier\formulaire\Formulaire::comparer($newDateMiseoeuvre, $newDateMiseoeuvreM). "</td>
							</tr><tr>
								<th>Catégorie de données traitées</th><td>" . $catdonnee . "</td><td>" . metier\formulaire\Formulaire::comparer($catdonnee, $catdonneeM) . "</td>
							</tr><tr>
								<th>Base juridique du traitement</th><td>" . $baseJuridique . "</td><td>" . metier\formulaire\Formulaire::comparer($baseJuridique, $baseJuridiqueM) . "</td>
							</tr><tr>
								<th>Catégorie de personnes concernées</th><td>" . $catP . "</td><td>" . metier\formulaire\Formulaire::comparer($catP, $catPM) . "</td>
							</tr><tr>
								<th>Destinataires des données</th><td>" . $dD . "</td><td>" . metier\formulaire\Formulaire::comparer($dD, $dDM) . "</td>
							</tr><tr>
								<th>Durée d'utilité administrative</th><td>" . $dUA . "</td><td>" . metier\formulaire\Formulaire::comparer($dUA, $dUAM) . "</td>
							</tr><tr>
								<th>Archivage</th><td>" . $arch . "</td><td>" . metier\formulaire\Formulaire::comparer($arch, $archM) . "</td>
							</tr><tr>
								<th>Transfert hors UE</th><td>" . $transUE . "</td><td>" . metier\formulaire\Formulaire::comparer($transUE, $transUEM) . "</td>
							</tr><tr>
								<th>Licéité du traitement" ."</th><td>" . $catliceite . "</td><td>" . metier\formulaire\Formulaire::comparer($catliceite, $catliceiteM) . "</td>
							</tr><tr>
								<th>Base juridique de la licéité</th><td>" . $baseJuridiqueLiceite . "</td><td>" . metier\formulaire\Formulaire::comparer($baseJuridiqueLiceite, $baseJuridiqueLiceiteM) . "</td>
							</tr><tr>
								<th>Co-responsable du traitement" ."</th><td>" . $coRT . "</td><td>" . metier\formulaire\Formulaire::comparer($coRT, $coRTM) . "</td>
							</tr><tr>
								<th>Représentant du Co-responsable du traitement" ."</th><td>" . $repCR . "</td><td>" . metier\formulaire\Formulaire::comparer($repCR, $repCRM) . "</td>
							</tr><tr>
								<th>Sous-traitant" ."</th><td>" . $sT . "</td><td>" . metier\formulaire\Formulaire::comparer($sT, $sTM) . "</td>
							</tr><tr>
								<th>Délai d'effacement" ."</th><td>" . $dE . "</td><td>" . metier\formulaire\Formulaire::comparer($dE, $dEM) . "</td>
							</tr><tr>
								<th>Niveau d'identification" ."</th><td>" . $nivIdent . "</td><td>" . metier\formulaire\Formulaire::comparer($nivIdent, $nivIdentM) . "</td>
							</tr><tr>
								<th>commentaire identification" ."</th><td>" . $comIdent . "</td><td>" . metier\formulaire\Formulaire::comparer($comIdent, $comIdentM) . "</td>
							</tr><tr>
								<th>PIA O/N" ."</th><td>" . $donneePIA . "</td><td>" . metier\formulaire\Formulaire::comparer($donneePIA, $donneePIAM) . "</td>
							</tr><tr>
								<th>commentaire PIA" ."</th><td>" . $PIA . "</td><td>" . metier\formulaire\Formulaire::comparer($PIA, $PIAM) . "</td>
							</tr><tr>
								<th>Plan d'action" ."</th><td>" . $planAction . "</td><td>" . metier\formulaire\Formulaire::comparer($planAction, $planActionM) . "</td>
							</tr><tr>
								<th>Hors registre des traitements" ."</th><td>" . $horsRegistre . "</td><td>" . metier\formulaire\Formulaire::comparer($horsRegistre, $horsRegistreM) . "</td>
							</tr><tr>
								<th>Niveau de sécurité" ."</th><td>" . $nivSecu . "</td><td>" . metier\formulaire\Formulaire::comparer($nivSecu, $nivSecuM) . "</td>
							</tr><tr>
								<th>commentaire sécurité" ."</th><td>" . $comSecu . "</td><td>" . metier\formulaire\Formulaire::comparer($comSecu, $comSecuM) . "</td>
							</tr><tr>
								<th>Date de dernière mise à jour</th><td>" . $newDerniereMaj . "</td><td>" . metier\formulaire\Formulaire::comparer($newDerniereMaj, $newDerniereMajM) . "</td>
							</tr> </table></form>";
			return $rep;
		}

        public function __toString()
        {
            $rep = "<div class=\"Formulaire\">$this->identifiant $this->nomLogiciel  $this->origineDonnee $this->validationDPD $this->finaliteTraitement $this->nomRespTraitement $this->sousFinalite
					$this->commentaire $this->dateMiseEnOeuvre $this->catDonneeTraitee $this->catPersConcern $this->destiDonnees $this->dureeUtiliteAdmi $this->archivage
					$this->transfertHorsUE $this->catLiceiteTraitee $this->coRespTraitement $this->representantCoResp $this->sousTraitant $this->delaiEffacement $this->support $this->niveau_identification
					$this->com_ident $this->niveau_securite $this->com_secu $this->derniereMAJ $this->donneePIA $this->PIA $this->horsRegistre $this->planAction $this->baseJuridique $this->baseJuridiqueLiceite</div>";
            return $rep;
        }
    }
}

namespace metier\serviceMunicipal
{
    class ServiceMunicipal
    {
        private $identifiant = - 1;
        private $service = "";
        private $pole = "";
        private $entite = "";

        public function __construct($service, $pole, $entite)
        {
            $this->service = $service;
            $this->pole = $pole;
			$this->entite = $entite;
        }

        public function getIdentifiant()
        {
            return $this->identifiant;
        }

        public function getService()
        {
            return $this->service;
        }

        public function getPole()
        {
            return $this->pole;
        }

 	  public function getEntite()
        {
            return $this->entite;
        }

        public function setEntite($entite)
        {
            $this->entite = $entite;
            return $this;
        }

        public function setIdentifiant($identifiant)
        {
            $this->identifiant = $identifiant;
            return $this;
        }

        public function setService($service)
        {
            $this->service = $service;
            return $this;
        }

        public function setPole($pole)
        {
            $this->pole = $pole;
            return $this;
        }

        public function __toString()
        {
            $rep = "<div class=\"ServiceMunicipal\">$this->identifiant $this->service $this->pole $this->entite</div>";
            return $rep;
        }
    }
}

namespace metier\pole
{
    class Pole
    {
        private $identifiant = - 1;
        private $pole = "";

        public function __construct($pole)
        {
            $this->pole = $pole;
        }

        public function getIdentifiant()
        {
            return $this->identifiant;
        }

        public function getPole()
        {
            return $this->pole;
        }

        public function setIdentifiant($identifiant)
        {
            $this->identifiant = $identifiant;
            return $this;
        }

        public function setPole($pole)
        {
            $this->pole = $pole;
            return $this;
        }

        public function __toString()
        {
            $rep = "<div class=\"Pole\">$this->identifiant $this->pole </div>";
            return $rep;
        }
    }
}

namespace metier\entite
{
    class Entite
    {
        private $identifiant = - 1;
        private $entite = "";
		private $siret = "";
		private $maildpd = "";
		private $responsable = "";

        public function __construct($entite,$maildpd,$responsable,$siret)
        {
        $this->entite = $entite;
		$this->maildpd = $maildpd;
		$this->responsable = $responsable;
		$this->siret = $siret;
        }

        public function getIdentifiant()
        {
            return $this->identifiant;
        }

        public function getEntite()
        {
            return $this->entite;
        }

		public function getSiret()
        {
            return $this->siret;
        }

        public function getMaildpd()
        {
            return $this->maildpd;
        }

		public function getResponsable()
        {
            return $this->responsable;
        }

        public function setIdentifiant($identifiant)
        {
            $this->identifiant = $identifiant;
            return $this;
        }

        public function setEntite($entite)
        {
            $this->entite = $entite;
            return $this;
        }

		public function setSiret($siret)
        {
            $this->siret = $siret;
            return $this;
        }

        public function setMaildpd($maildpd)
        {
            $this->maildpd = $maildpd;
            return $this;
        }

		public function setResponsable($responsable)
        {
            $this->responsable = $responsable;
            return $this;
        }

        public function __toString()
        {
            $rep = "<div class=\"Entite\">$this->identifiant $this->entite $this->maildpd $this->responsable $this->siret</div>";
            return $rep;
        }
    }
}

namespace metier\gestionnairedroitacces
{
    class Gestionnairedroitacces
    {
        private $identifiant = "-1";
        private $id_formulaire = "";
        private $id_gestionnaire = "";

        public function __construct($id_formulaire, $id_gestionnaire)
        {
            $this->id_formulaire = $id_formulaire;
            $this->id_gestionnaire = $id_gestionnaire;
        }

        public function getIdentifiant()
        {
            return $this->identifiant;
        }

        public function getId_formulaire()
        {
            return $this->id_formulaire;
        }

        public function getId_gestionnaire()
        {
            return $this->id_gestionnaire;
        }

        public function setIdentifiant($identifiant)
        {
            $this->identifiant = $identifiant;
            return $this;
        }

        public function setId_formulaire($id_formulaire)
        {
            $this->id_formulaire = $id_formulaire;
            return $this;
        }

        public function setId_gestionnaire($id_gestionnaire)
        {
            $this->id_gestionnaire = $id_gestionnaire;
            return $this;
        }

        public function __toString()
        {
            $rep = "<div class=\"GestionnaireDroitAcces\">$this->identifiant $this->id_formulaire $this->id_gestionnaire </div>";
            return $rep;
        }
    }
}

namespace metier\applidroitacces
{
    class Applidroitacces
    {
        private $identifiant = "-1";
        private $id_entite = "";
        private $id_utilisateur = "";

        public function __construct($id_entite, $id_utilisateur)
        {
            $this->id_entite = $id_entite;
            $this->id_utilisateur = $id_utilisateur;
        }

        public function getIdentifiant()
        {
            return $this->identifiant;
        }

        public function getId_entite()
        {
            return $this->id_entite;
        }

        public function getId_utilisateur()
        {
            return $this->id_utilisateur;
        }

        public function setIdentifiant($identifiant)
        {
            $this->identifiant = $identifiant;
            return $this;
        }

        public function setId_entite($id_entite)
        {
            $this->id_entite = $id_entite;
            return $this;
        }

        public function setId_utilisateur($id_utilisateur)
        {
            $this->id_utilisateur = $id_utilisateur;
            return $this;
        }

        public function __toString()
        {
            $rep = "<div class=\"AppliDroitAcces\">$this->identifiant $this->id_entite $this->id_utilisateur </div>";
            return $rep;
        }
    }
}

namespace metier\utilisateur
{
   use DAO\Utilisateur\UtilisateurDAO;

   class Utilisateur
   {
		private $identifiant="-1";
		private $nom="";
		private $prenom="";
		private $login="";
		private $mdphache="";
		private $admin="";
		private $nbessai="";
		private $mail="";


       function __construct($nom, $prenom, $login, $mdphache, $admin, $nbessai, $mail)
       {
			$this->nom=$nom;
			$this->prenom=$prenom;
			$this->login=$login;
			$this->mdphache=$mdphache;
			$this->admin=$admin;
			$this->nbessai=$nbessai;
			$this->mail=$mail;
       }

		public function getNom()
		{
			return $this->nom;
		}

		public function getPrenom()
		{
			return $this->prenom;
		}

		public function getIdentifiant()
		{
			return $this->identifiant;
		}

		public function getLogin()
		{
			return $this->login;
		}

		public function getMdphache()
		{
			return $this->mdphache;
		}

		public function getAdmin()
		{
			return $this->admin;
		}

		public function getNbessai()
		{
			return $this->nbessai;
		}

		public function getMail()
		{
			return $this->mail;
		}

		public function setIdentifiant($identifiant)
		{
			$this->identifiant = $identifiant;
			return $this;
		}

		public function setNom($nom)
		{
			$this->nom = $nom;
			return $this;
		}

		public function setPrenom($prenom)
		{
			$this->prenom = $prenom;
			return $this;
		}

		public function setLogin($login)
		{
			$this->login = $login;
			return $this;
		}

		public function setMdphache($mdphache)
		{
			$this->mdphache = $mdphache;
			return $this;
		}

		public function setAdmin($admin)
		{
			$this->admin = $admin;
			return $this;
		}

		public function setNbessai($nbessai)
		{
			$this->nbessai = $nbessai;
			return $this;
		}

		public function setMail($mail)
		{
			$this->mail = $mail;
			return $this;
		}

		function controleChampsVide($recupMdpC){
			return (!empty($this->nom) && !empty($this->prenom) && !empty($this->login) && !empty($this->mdphache)&& !empty($this->admin) && !empty($this->mdpC));
		}

		function controleChampsVideConnexion($recupMdp){
			return (!empty($this->login) && !empty($recupMdp));
		}

		function controlePassPolicy($mdp){
			return (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-99])(?=.*\W)#', $mdp));
		}

		function controlePass($recupMdpC){
			return password_verify($recupMdpC, $this->mdphache);
		}

		function controlPassConnexion($mdpConnexion){
			$daoUtilisateur=new UtilisateurDAO();
			$test=$daoUtilisateur->readPasswordDb($this->login);
			return password_verify($mdpConnexion, $test);
		}

		/*function controlPassConnexionAdmin($mdpConnexion){
			$daoUtilisateur=new UtilisateurDAO();
			$test=$daoUtilisateur->readPasswordDbAdmin($this->login);
			return password_verify($mdpConnexion, $test);
		}	*/

		function controlNbessai($mdpConnexion){
			$daoUtilisateur=new UtilisateurDAO();
			$test=$daoUtilisateur->readPasswordDb($this->login);
			return password_verify($mdpConnexion, $test);
		}

		function valideUtilisateurInscription($recupMdpC)
		{
			$daoUtilisateur=new UtilisateurDAO();

			if (!isset($login)){
				if ($this->controleChampsVide($recupMdpC)){
					$message="Vous n'avez pas rempli le champ mot de passe obligatoire, le formulaire va être réinitialisé";
				/*} elseif ($daoUtilisateur->existNomPrenom($this->nom, $this->prenom)){
					$message="Cet utilisateur existe déjà, le formulaire va être réinitialisé";*/
				} elseif ($daoUtilisateur->existMail($this->mail)){
					$message="Ce mail est déjà utilisé, le formulaire va être réinitialisé";
				} elseif ($daoUtilisateur->existLogin($this->login)){
					$message="Ce login est déjà utilisé, le formulaire va être réinitialisé";
				} elseif (!$this->controlePassPolicy($this->mdphache)){
					$message="Votre mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et six caractères, le formulaire va être réinitialisé";
				} elseif (!$this->controlePass($recupMdpC)){
					$message="Votre mot de passe de contrôle n'est pas identique, le formulaire va être réinitialisé";
				} else {
					$daoUtilisateur->create($this);
					$message="Inscription effectuée";
				}
				echo '<script type="text/javascript">window.alert("' . $message .'");</script>';
			}
		}

    	function valideConnexion($mdp)
		{
			$daoUtilisateur=new UtilisateurDAO();
			if (!$daoUtilisateur->existLogin($this->login)){
				$message="Identifiant ou mot de passe incorrect";
				echo '<script type="text/javascript">window.alert("' . $message .'");</script>';
			} elseif (!$daoUtilisateur->existNomPrenomNbessai($this->login)){
				$message="Votre compte est bloqué suite à 5 tentatives erronnées, veuillez réinitialiser le mot de passe.";
				echo '<script type="text/javascript">window.alert("' . $message .'");</script>';
			} else {
					$test=$this->login;
					$objet=$daoUtilisateur->read($test);
					$testid=$objet->getIdentifiant();
					$testessai=$objet->getNbessai();

				 /*if (!Utilisateur::controlPassConnexionAdmin($mdp)){
					$message="Identifiant ou mot de passe incorrect pour admin";
					echo '<script type="text/javascript">window.alert("' . $message.'");</script>';
				} else*/
				if (!Utilisateur::controlPassConnexion($mdp)){
					$message="Identifiant ou mot de passe incorrect";
					echo '<script type="text/javascript">window.alert("' . $message .'");</script>';
					$testessai = $testessai + 1;
				} else {
					$_SESSION['identifiant'] =$objet->getIdentifiant();
					$_SESSION['nom'] =$objet->getNom();
					$_SESSION['prenom'] = $objet->getPrenom();
					$_SESSION['admin'] = $objet->getAdmin();
					$_SESSION['login'] = $this->login;
					$testessai = 0;
				}

				$daoupdate= new UtilisateurDAO();
				$update= $daoupdate->updateEssai($testid,$testessai);

				echo "<script type='text/javascript'>document.location.replace('visu.php');</script>";
			}
		}

		function utilisateur_est_connecte()
		{
			return !empty($_SESSION['identifiant']);
		}

		public function __toString()
		{
			$rep = "<div class=\"Utilisateur\">$this->identifiant $this->nom $this->prenom $this->login $this->mdphache $this->admin $this->nbessai $this->mail</div>";
			return $rep;
		}
    }
}

namespace metier\droit
{
    class Droit
    {
        private $identifiant = "-1";
        private $id_utilisateur = "";
        private $id_gestionnaire = "";

        public function __construct($id_utilisateur, $id_gestionnaire)
        {
            $this->id_utilisateur = $id_utilisateur;
            $this->id_gestionnaire = $id_gestionnaire;
        }

        public function getIdentifiant()
        {
            return $this->identifiant;
        }

        public function getId_utilisateur()
        {
            return $this->id_utilisateur;
        }

        public function getId_gestionnaire()
        {
            return $this->id_gestionnaire;
        }

        public function setIdentifiant($identifiant)
        {
            $this->identifiant = $identifiant;
            return $this;
        }

        public function setId_utilisateur($id_utilisateur)
        {
            $this->id_utilisateur = $id_utilisateur;
            return $this;
        }

        public function setId_gestionnaire($id_gestionnaire)
        {
            $this->id_gestionnaire = $id_gestionnaire;
            return $this;
        }
        static function comparerArray($droitutil, $gestiForm){
            return array_intersect($droitutil, $gestiForm);
        }

        public function __toString()
        {
            $rep = "<div class=\"Droit\">$this->identifiant $this->id_utilisateur $this->id_gestionnaire</div>";
            return $rep;
        }
    }
}

/*AJOUT 24/05/2018 sur modèle utilisateur */
namespace metier\variableglobale
{
   use DAO\VariableGlobale\VariableGlobaleDAO;

   class VariableGlobale
   {
       private $identifiant="-1";
       private $varnom="";
       private $varvaleur="";

       function __construct($varnom, $varvaleur)
       {
           $this->varnom=$varnom;
           $this->varvaleur=$varvaleur;
       }

		public function getVarnom()
		{
			return $this->varnom;
		}

		public function getVarvaleur()
		{
			return $this->varvaleur;
		}

		public function getIdentifiant()
		{
			return $this->identifiant;
		}

		public function setIdentifiant($identifiant)
		{
			$this->identifiant = $identifiant;
			return $this;
		}

		public function setVarnom($varnom)
		{
			$this->varnom = $varnom;
			return $this;
		}

		public function setVarvaleur($varvaleur)
		{
			$this->varvaleur = $varvaleur;
			return $this;
		}

		public function __toString()
		{
			 $rep = "<div class=\"VariableGlobale\">$this->identifiant $this->varnom $this->varvaleur</div>";
			 return $rep;
		}
	}
}

namespace metier\formulairecommentaire
{
   use DAO\FormulaireCommentaire\FormulaireCommentaireDAO;

   class FormulaireCommentaire
   {
       private $identifiant="-1";
       private $formcom_champconcerne="";
       private $formcom_commentaire="";
       private $formcom_libelle="";

		function __construct($formcom_champconcerne, $formcom_commentaire, $formcom_libelle)
		{
			$this->formcom_champconcerne=$formcom_champconcerne;
			$this->formcom_commentaire=$formcom_commentaire;
			$this->formcom_libelle=$formcom_libelle;
		}

		public function getFormcom_champconcerne()
		{
			return $this->formcom_champconcerne;
		}

		public function getFormcom_commentaire()
		{
			return $this->formcom_commentaire;
		}

		public function getFormcom_libelle()
		{
			return $this->formcom_libelle;
		}


		public function getIdentifiant()
		{
			return $this->identifiant;
		}

		public function setIdentifiant($identifiant)
		{
			$this->identifiant = $identifiant;
			return $this;
		}

		public function setFormcom_champconcerne($formcom_champconcerne)
		{
			$this->formcom_champconcerne = $formcom_champconcerne;
			return $this;
		}

		public function setFormcom_commentaire($formcom_commentaire)
		{
			$this->formcom_commentaire = $formcom_commentaire;
			return $this;
		}

		public function setFormcom_libelle($formcom_libelle)
		{
			$this->formcom_libelle = $formcom_libelle;
			return $this;
		}


		public function __toString()
		{
			$rep = "<div class=\"VariableGlobale\">$this->identifiant $this->formcom_champconcerne $this->formcom_commentaire $this->formcom_libelle</div>";
			return $rep;
		}
	}
}

namespace metier\catdonneeformulaire
{
   use DAO\Catdonneeformulaire\CatdonneeformulaireDAO;

   class Catdonneeformulaire
   {
       private $identifiant="-1";
       private $libelle="";
	 private $infobulle="";

		function __construct($libelle,$infobulle)
		{
			$this->libelle=$libelle;
			$this->infobulle=$infobulle;
		}

		public function getLibelle()
		{
			return $this->libelle;
		}

		public function getInfobulle()
		{
			return $this->infobulle;
		}

		public function getIdentifiant()
		{
			return $this->identifiant;
		}

		public function setIdentifiant($identifiant)
		{
			$this->identifiant = $identifiant;
			return $this;
		}

		public function setLibelle($libelle)
		{
			$this->libelle = $libelle;
			return $this;
		}

		public function setInfobulle($infobulle)
		{
			$this->infobulle = $infobulle;
			return $this;
		}

		public function __toString()
		{
			$rep = "<div class=\"VariableGlobale\">$this->identifiant $this->libelle $this->infobulle</div>";
			return $rep;
		}
	}
}

namespace metier\catliceiteformulaire
{
   use DAO\Catliceiteformulaire\CatliceiteformulaireDAO;

   class Catliceiteformulaire
   {
       private $identifiant="-1";
       private $libelle="";
	 private $infobulle="";

		function __construct($libelle,$infobulle)
		{
			$this->libelle=$libelle;
			$this->infobulle=$infobulle;
		}

		public function getLibelle()
		{
			return $this->libelle;
		}

		public function getInfobulle()
		{
			return $this->infobulle;
		}

		public function getIdentifiant()
		{
			return $this->identifiant;
		}

		public function setIdentifiant($identifiant)
		{
			$this->identifiant = $identifiant;
			return $this;
		}

		public function setLibelle($libelle)
		{
			$this->libelle = $libelle;
			return $this;
		}

		public function setInfobulle($infobulle)
		{
			$this->infobulle = $infobulle;
			return $this;
		}

		public function __toString()
		{
			$rep = "<div class=\"VariableGlobale\">$this->identifiant $this->libelle $this->infobulle</div>";
			return $rep;
		}
	}
}

namespace metier\entitepole
{
   use DAO\Entitepole\EntitepoleDAO;

   class entitepole
   {
       private $identifiant="-1";
       private $id_pole="";
	 private $id_entite="";

		function __construct($id_pole, $id_entite)
		{
			$this->id_pole=$id_pole;
			$this->id_entite=$id_entite;
		}

		public function getId_pole()
		{
			return $this->id_pole;
		}

		public function getId_entite()
		{
			return $this->id_entite;
		}

		public function getIdentifiant()
		{
			return $this->identifiant;
		}

		public function setIdentifiant($identifiant)
		{
			$this->identifiant = $identifiant;
			return $this;
		}

		public function setId_pole($id_pole)
		{
			$this->id_pole = $id_pole;
			return $this;
		}

		public function setId_entite($id_entite)
		{
			$this->id_entite = $id_entite;
			return $this;
		}

		public function __toString()
		{
			$rep = "<div class=\"VariableGlobale\">$this->identifiant $this->id_pole $this->id_entite</div>";
			return $rep;
		}
	}
}

?>