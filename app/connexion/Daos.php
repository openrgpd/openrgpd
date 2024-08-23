<?php
namespace DAO
{
    include ("Connexion.php");
    include ("./metier/Metier.php");

    abstract class DAO
    {
        abstract function create($objet);
        abstract function read($key);
        abstract function update($objet);
        abstract function delete($key);
        protected $key;
        protected $table;

        function __construct($key, $table)
        {
            $this->key = $key;
            $this->table = $table;
        }

        function getLastKey()
        {
            $sql = "SELECT MAX($this->key) as max FROM $this->table;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            $num = $row["max"];

            return $num;
        }

        function getLastKey2()
        {
            $sql = "SELECT MAX(identifiant) as max FROM formulaire;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            $num = $row["max"];

            return $num;
        }

        function getLastKey3()
        {
            $sql = "SELECT MAX(identifiant) as max FROM utilisateurs;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            $num = $row["max"];

            return $num;
        }
    }
}

namespace DAO\Formulaire
{
    use metier;

    class FormulaireDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "formulaire");
        }

        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (nomLogiciel, origineDonnee, validationDPD, finaliteTraitement, sousFinalite, commentaire, dateMiseEnOeuvre, catDonneeTraitee, catPersConcern,
					destiDonnees, dureeUtiliteAdmi, archivage, transfertHorsUE, catLiceiteTraitee, coRespTraitement, representantCoResp, sousTraitant, delaiEffacement, support,
					niveau_identification, com_ident, niveau_securite, com_secu, derniereMAJ, declarant, donneePIA, PIA, horsRegistre, planAction, baseJuridique, baseJuridiqueLiceite) values (:nomLogiciel, :origineDonnee, :validationDPD,
					:finaliteTraitement, :sousFinalite, :commentaire, :dateMiseEnOeuvre,:catDonneeTraitee, :catPersConcern, :destiDonnees, :dureeUtiliteAdmi, :archivage, :transfertHorsUE,
					:catLiceiteTraitee, :coRespTraitement, :representantCoResp, :sousTraitant, :delaiEffacement, :support, :niveau_identification, :com_ident,
					:niveau_securite, :com_secu, :derniereMAJ, :declarant, :donneePIA, :PIA, :horsRegistre, :planAction, :baseJuridique, :baseJuridiqueLiceite)";
			//var_dump($sql);
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);

            $nomLogiciel = $objet->getNomLogiciel();
            $origineDonnee = $objet->getorigineDonnee();
            $validationDPD = $objet->getvalidationDPD();
            $finaliteTraitement = $objet->getFinaliteTraitement();
            $sousFinalite = $objet->getSousFinalite();
            $commentaire = $objet->getCommentaire();
            $dateMiseEnOeuvre = $objet->getDateMiseEnOeuvre();
            $catDonneeTraitee = $objet->getCatDonneeTraitee();
            $catPersConcern = $objet->getCatPersConcern();
            $destiDonnees = $objet->getDestiDonnees();
            $dureeUtiliteAdmi = $objet->getDureeUtiliteAdmi();
            $archivage = $objet->getArchivage();
            $transfertHorsUE = $objet->getTransfertHorsUE();
            $catLiceiteTraitee = $objet->getcatLiceiteTraitee();
            $coRespTraitement = $objet->getCoRespTraitement();
            $representantCoResp = $objet->getRepresentantCoResp();
            $sousTraitant = $objet->getSousTraitant();
            $delaiEffacement = $objet->getDelaiEffacement();
            $support = $objet->getSupport();
            $niveau_identification = $objet->getNiveau_identification();
			$com_ident = $objet->getCom_ident();
            $niveau_securite = $objet->getNiveau_securite();
			$com_secu = $objet->getCom_secu();
            $derniereMAJ = $objet->getDerniereMAJ();
			$donneePIA = $objet->getDonneePIA();
			$PIA = $objet->getPIA();
			$horsRegistre = $objet->getHorsRegistre();
            $declarant = $objet->getDeclarant();
			$planAction = $objet->getPlanAction();
            $baseJuridique = $objet->getBaseJuridique();
            $baseJuridiqueLiceite = $objet->getBaseJuridiqueLiceite();

            $stmt->bindParam(':nomLogiciel', $nomLogiciel);
            $stmt->bindParam(':origineDonnee', $origineDonnee);
            $stmt->bindParam(':validationDPD', $validationDPD);
            $stmt->bindParam(':finaliteTraitement', $finaliteTraitement);
            $stmt->bindParam(':sousFinalite', $sousFinalite);
            $stmt->bindParam(':commentaire', $commentaire);
            $stmt->bindParam(':dateMiseEnOeuvre', $dateMiseEnOeuvre);
            $stmt->bindParam(':catDonneeTraitee', $catDonneeTraitee);
            $stmt->bindParam(':catPersConcern', $catPersConcern);
            $stmt->bindParam(':destiDonnees', $destiDonnees);
            $stmt->bindParam(':dureeUtiliteAdmi', $dureeUtiliteAdmi);
            $stmt->bindParam(':archivage', $archivage);
            $stmt->bindParam(':transfertHorsUE', $transfertHorsUE);
            $stmt->bindParam(':catLiceiteTraitee', $catLiceiteTraitee);
            $stmt->bindParam(':coRespTraitement', $coRespTraitement);
            $stmt->bindParam(':representantCoResp', $representantCoResp);
            $stmt->bindParam(':sousTraitant', $sousTraitant);
            $stmt->bindParam(':delaiEffacement', $delaiEffacement);
            $stmt->bindParam(':support', $support);
            $stmt->bindParam(':niveau_identification', $niveau_identification);
			$stmt->bindParam(':com_ident', $com_ident);
            $stmt->bindParam(':niveau_securite', $niveau_securite);
            $stmt->bindParam(':com_secu', $com_secu);
            $stmt->bindParam(':derniereMAJ', $derniereMAJ);
			$stmt->bindParam(':donneePIA', $donneePIA);
            $stmt->bindParam(':PIA', $PIA);
			$stmt->bindParam(':horsRegistre', $horsRegistre);
            $stmt->bindParam(':declarant', $declarant);
			$stmt->bindParam(':planAction', $planAction);
            $stmt->bindParam(':baseJuridique', $baseJuridique);
            $stmt->bindParam(':baseJuridiqueLiceite', $baseJuridiqueLiceite);
            $stmt->execute();

            $id = $this->getLastKey();
            $objet->setIdentifiant($id);
        }

        public function read($id)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant = $row["identifiant"];
            $nomLogiciel = htmlspecialchars($row["nomLogiciel"]);
            $origineDonnee = $row["origineDonnee"];
            $validationDPD = $row["validationDPD"];
            $finaliteTraitement = $row["finaliteTraitement"];
            $sousFinalite = $row["sousFinalite"];
            $commentaire = $row["commentaire"];
            $dateMiseEnOeuvre = $row["dateMiseEnOeuvre"];
            $catDonneeTraitee = $row["catDonneeTraitee"];
            $catPersConcern = $row["catPersConcern"];
            $destiDonnees = $row["destiDonnees"];
            $dureeUtiliteAdmi = $row["dureeUtiliteAdmi"];
            $archivage = $row["archivage"];
            $transfertHorsUE = $row["transfertHorsUE"];
            $catLiceiteTraitee = $row["catLiceiteTraitee"];
            $coRespTraitement = $row["coRespTraitement"];
            $representantCoResp = $row["representantCoResp"];
            $sousTraitant = $row["sousTraitant"];
            $delaiEffacement = $row["delaiEffacement"];
            $support = $row["support"];
            $niveau_identification = $row["niveau_identification"];
			$com_ident = $row["com_ident"];
            $niveau_securite = $row["niveau_securite"];
			$com_secu = $row["com_secu"];
			$donneePIA = $row["donneePIA"];
			$PIA = $row["PIA"];
			$horsRegistre = $row["horsRegistre"];
            $derniereMAJ = $row["derniereMAJ"];
            $declarant = $row["declarant"];
			$planAction = $row["planAction"];
            $baseJuridique = $row["baseJuridique"];
            $baseJuridiqueLiceite = $row["baseJuridiqueLiceite"];
            $rep = new metier\formulaire\Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee,
					$catPersConcern, $destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement,
					$support, $niveau_identification, $com_ident, $niveau_securite, $com_secu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

		public function readAllForm()
        {
            $list = [];
            $sql = "SELECT * FROM $this->table";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $nomLogiciel = $row["nomLogiciel"];
                $origineDonnee = $row["origineDonnee"];
                $validationDPD = $row["validationDPD"];
                $finaliteTraitement = $row["finaliteTraitement"];
                $sousFinalite = $row["sousFinalite"];
                $commentaire = $row["commentaire"];
                $dateMiseEnOeuvre = $row["dateMiseEnOeuvre"];
                $catDonneeTraitee = $row["catDonneeTraitee"];
                $catPersConcern = $row["catPersConcern"];
                $destiDonnees = $row["destiDonnees"];
                $dureeUtiliteAdmi = $row["dureeUtiliteAdmi"];
                $archivage = $row["archivage"];
                $transfertHorsUE = $row["transfertHorsUE"];
                $catLiceiteTraitee = $row["catLiceiteTraitee"];
                $coRespTraitement = $row["coRespTraitement"];
                $representantCoResp = $row["representantCoResp"];
                $sousTraitant = $row["sousTraitant"];
                $delaiEffacement = $row["delaiEffacement"];
                $support = $row["support"];
				$niveau_identification = $row["niveau_identification"];
				$com_ident = $row["com_ident"];
				$niveau_securite = $row["niveau_securite"];
				$com_secu = $row["com_secu"];
				$donneePIA = $row["donneePIA"];
				$PIA = $row["PIA"];
				$horsRegistre = $row["horsRegistre"];
                $derniereMAJ = $row["derniereMAJ"];
                $declarant = $row["declarant"];
				$planAction = $row["planAction"];
				$baseJuridique = $row["baseJuridique"];
				$baseJuridiqueLiceite = $row["baseJuridiqueLiceite"];
                $rep = new metier\formulaire\Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee,
						$catPersConcern, $destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement,
						$support, $niveau_identification, $com_ident, $niveau_securite, $com_secu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite);
                $rep->setIdentifiant($identifiant);

                $list[] = $rep;
            }
            return $list;
        }


        public function readNomColonne()
        {
            $sql = "select COLUMN_name from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='$this->table';";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();
            $list=[];
            while ($row = $stmt->fetch()) {
				$list[]=$row;
			}
			return $list;
        }

		public function readCountActeur($id_gestionnaire)
        {
            $sql = "SELECT COUNT(*) as nbServ FROM $this->table WHERE acteurMiseEnOeuvre= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id_gestionnaire);
            $stmt->execute();
            $row = $stmt->fetch();
            $nbServ=$row["nbServ"];

            return $nbServ;
        }

        public function readAllFormByPoleGest($idPole)
        {
            $list = [];
            $sql = "SELECT * FROM formulaire
					WHERE identifiant IN
						(SELECT id_formulaire
						FROM gestionnairesdroitacces
						WHERE id_gestionnaire IN
							(SELECT identifiant
							FROM servicesmunicipaux
							WHERE pole=:idPole));";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idPole', $idPole);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $nomLogiciel = $row["nomLogiciel"];
                $origineDonnee = $row["origineDonnee"];
                $validationDPD = $row["validationDPD"];
                $finaliteTraitement = $row["finaliteTraitement"];
                $sousFinalite = $row["sousFinalite"];
                $commentaire = $row["commentaire"];
                $dateMiseEnOeuvre = $row["dateMiseEnOeuvre"];
                $catDonneeTraitee = $row["catDonneeTraitee"];
                $catPersConcern = $row["catPersConcern"];
                $destiDonnees = $row["destiDonnees"];
                $dureeUtiliteAdmi = $row["dureeUtiliteAdmi"];
                $archivage = $row["archivage"];
                $transfertHorsUE = $row["transfertHorsUE"];
                $catLiceiteTraitee = $row["catLiceiteTraitee"];
                $coRespTraitement = $row["coRespTraitement"];
                $representantCoResp = $row["representantCoResp"];
                $sousTraitant = $row["sousTraitant"];
                $delaiEffacement = $row["delaiEffacement"];
                $support = $row["support"];
				$niveau_identification = $row["niveau_identification"];
				$com_ident = $row["com_ident"];
				$niveau_securite = $row["niveau_securite"];
				$com_secu = $row["com_secu"];
				$donneePIA = $row["donneePIA"];
				$PIA = $row["PIA"];
				$horsRegistre = $row["horsRegistre"];
                $derniereMAJ = $row["derniereMAJ"];
                $declarant = $row["declarant"];
				$planAction = $row["planAction"];
				$baseJuridique = $row["baseJuridique"];
				$baseJuridique = $row["baseJuridiqueLiceite"];
                $rep = new metier\formulaire\Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee,
						$catPersConcern, $destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement,
						$support, $niveau_identification, $com_ident, $niveau_securite, $com_secu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

        public function readAllFormByEntite($idEntite)
        {
            $list = [];
            $sql = "SELECT *
					FROM formulaire
					WHERE identifiant IN
						(SELECT id_formulaire
						FROM gestionnairesdroitacces
						WHERE id_gestionnaire IN
							(SELECT identifiant
							FROM servicesmunicipaux
							WHERE entite=:idEntite));";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idEntite', $idEntite);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $nomLogiciel = $row["nomLogiciel"];
                $origineDonnee = $row["origineDonnee"];
                $validationDPD = $row["validationDPD"];
                $finaliteTraitement = $row["finaliteTraitement"];
                $sousFinalite = $row["sousFinalite"];
                $commentaire = $row["commentaire"];
                $dateMiseEnOeuvre = $row["dateMiseEnOeuvre"];
                $catDonneeTraitee = $row["catDonneeTraitee"];
                $catPersConcern = $row["catPersConcern"];
                $destiDonnees = $row["destiDonnees"];
                $dureeUtiliteAdmi = $row["dureeUtiliteAdmi"];
                $archivage = $row["archivage"];
                $transfertHorsUE = $row["transfertHorsUE"];
                $catLiceiteTraitee = $row["catLiceiteTraitee"];
                $coRespTraitement = $row["coRespTraitement"];
                $representantCoResp = $row["representantCoResp"];
                $sousTraitant = $row["sousTraitant"];
                $delaiEffacement = $row["delaiEffacement"];
                $support = $row["support"];
				$niveau_identification = $row["niveau_identification"];
				$com_ident = $row["com_ident"];
				$niveau_securite = $row["niveau_securite"];
				$com_secu = $row["com_secu"];
				$donneePIA = $row["donneePIA"];
				$PIA = $row["PIA"];
				$horsRegistre = $row["horsRegistre"];
                $derniereMAJ = $row["derniereMAJ"];
                $declarant = $row["declarant"];
				$planAction = $row["planAction"];
				$baseJuridique = $row["baseJuridique"];
				$baseJuridiqueLiceite = $row["baseJuridiqueLiceite"];
                $rep = new metier\formulaire\Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee,
						$catPersConcern, $destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement,
						$support, $niveau_identification, $com_ident, $niveau_securite, $com_secu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

        public function readAllFormByServGest($idGest)
        {
            $list = [];
            $sql = "SELECT *
					FROM formulaire
					WHERE identifiant IN
						(SELECT id_formulaire
						FROM gestionnairesdroitacces
						WHERE id_gestionnaire = :idGest);";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idGest', $idGest);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $nomLogiciel = $row["nomLogiciel"];
                $origineDonnee = $row["origineDonnee"];
                $validationDPD = $row["validationDPD"];
                $finaliteTraitement = $row["finaliteTraitement"];
                $sousFinalite = $row["sousFinalite"];
                $commentaire = $row["commentaire"];
                $dateMiseEnOeuvre = $row["dateMiseEnOeuvre"];
                $catDonneeTraitee = $row["catDonneeTraitee"];
                $catPersConcern = $row["catPersConcern"];
                $destiDonnees = $row["destiDonnees"];
                $dureeUtiliteAdmi = $row["dureeUtiliteAdmi"];
                $archivage = $row["archivage"];
                $transfertHorsUE = $row["transfertHorsUE"];
                $catLiceiteTraitee = $row["catLiceiteTraitee"];
                $coRespTraitement = $row["coRespTraitement"];
                $representantCoResp = $row["representantCoResp"];
                $sousTraitant = $row["sousTraitant"];
                $delaiEffacement = $row["delaiEffacement"];
                $support = $row["support"];
				$niveau_identification = $row["niveau_identification"];
				$com_ident = $row["com_ident"];
				$niveau_securite = $row["niveau_securite"];
				$com_secu = $row["com_secu"];
				$donneePIA = $row["donneePIA"];
				$PIA = $row["PIA"];
				$horsRegistre = $row["horsRegistre"];
                $derniereMAJ = $row["derniereMAJ"];
                $declarant = $row["declarant"];
				$planAction = $row["planAction"];
				$baseJuridique = $row["baseJuridique"];
				$baseJuridiqueLiceite = $row["baseJuridiqueLiceite"];
                $rep = new metier\formulaire\Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee,
							$catPersConcern, $destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement,
							$support, $niveau_identification, $com_ident, $niveau_securite, $com_secu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridiqueLiceite);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

        public function readAllFormByUser($idUser)
        {
            $list = [];
            $sql = "SELECT distinct formulaire.identifiant, nomLogiciel, origineDonnee, validationDPD, finaliteTraitement, sousFinalite, commentaire, dateMiseEnOeuvre, catDonneeTraitee,
					catPersConcern, destiDonnees, dureeUtiliteAdmi, archivage, transfertHorsUE, catLiceiteTraitee, coRespTraitement, representantCoResp, sousTraitant, delaiEffacement,
					support, niveau_identification, com_ident, niveau_securite, com_secu, derniereMAJ, declarant, donneePIA, PIA, horsRegistre, planAction, baseJuridique , baseJuridiqueLiceite
				FROM formulaire
				INNER JOIN gestionnairesdroitacces ON gestionnairesdroitacces.id_formulaire = formulaire.identifiant
				INNER JOIN servicesmunicipaux ON gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN entites ON servicesmunicipaux.entite = entites.identifiant
				INNER JOIN applidroitacces ON applidroitacces.id_entite = entites.identifiant
				INNER JOIN utilisateurs ON utilisateurs.identifiant = applidroitacces.id_utilisateur
				WHERE utilisateurs.identifiant = :idUser;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $nomLogiciel = $row["nomLogiciel"];
                $origineDonnee = $row["origineDonnee"];
                $validationDPD = $row["validationDPD"];
                $finaliteTraitement = $row["finaliteTraitement"];
                $sousFinalite = $row["sousFinalite"];
                $commentaire = $row["commentaire"];
                $dateMiseEnOeuvre = $row["dateMiseEnOeuvre"];
                $catDonneeTraitee = $row["catDonneeTraitee"];
                $catPersConcern = $row["catPersConcern"];
                $destiDonnees = $row["destiDonnees"];
                $dureeUtiliteAdmi = $row["dureeUtiliteAdmi"];
                $archivage = $row["archivage"];
                $transfertHorsUE = $row["transfertHorsUE"];
                $catLiceiteTraitee = $row["catLiceiteTraitee"];
                $coRespTraitement = $row["coRespTraitement"];
                $representantCoResp = $row["representantCoResp"];
                $sousTraitant = $row["sousTraitant"];
                $delaiEffacement = $row["delaiEffacement"];
                $support = $row["support"];
				$niveau_identification = $row["niveau_identification"];
				$com_ident = $row["com_ident"];
				$niveau_securite = $row["niveau_securite"];
				$com_secu = $row["com_secu"];
				$donneePIA = $row["donneePIA"];
				$PIA = $row["PIA"];
				$horsRegistre = $row["horsRegistre"];
                $derniereMAJ = $row["derniereMAJ"];
                $declarant = $row["declarant"];
				$planAction = $row["planAction"];
				$baseJuridique = $row["baseJuridique"];
				$baseJuridiqueLiceite = $row["baseJuridiqueLiceite"];
                $rep = new metier\formulaire\Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee,
						$catPersConcern, $destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement,
						$support, $niveau_identification, $com_ident, $niveau_securite, $com_secu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

		public function readAllFormByGest($idUser)
        {
            $list = [];
            $sql = "SELECT distinct formulaire.identifiant, nomLogiciel, origineDonnee, validationDPD, finaliteTraitement, sousFinalite, commentaire, dateMiseEnOeuvre, catDonneeTraitee,
					catPersConcern, destiDonnees, dureeUtiliteAdmi, archivage, transfertHorsUE, catLiceiteTraitee, coRespTraitement, representantCoResp, sousTraitant, delaiEffacement,
					support, niveau_identification, com_ident, niveau_securite, com_secu, derniereMAJ, declarant, donneePIA, PIA, horsRegistre, planAction, baseJuridique, baseJuridiqueLiceite
				FROM formulaire
				INNER JOIN gestionnairesdroitacces ON gestionnairesdroitacces.id_formulaire = formulaire.identifiant
				INNER JOIN servicesmunicipaux ON gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN droits ON droits.id_gestionnaire = gestionnairesdroitacces.id_gestionnaire
				INNER JOIN utilisateurs ON utilisateurs.identifiant = droits.id_utilisateur
				WHERE utilisateurs.identifiant = :idUser;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $nomLogiciel = $row["nomLogiciel"];
                $origineDonnee = $row["origineDonnee"];
                $validationDPD = $row["validationDPD"];
                $finaliteTraitement = $row["finaliteTraitement"];
                $sousFinalite = $row["sousFinalite"];
                $commentaire = $row["commentaire"];
                $dateMiseEnOeuvre = $row["dateMiseEnOeuvre"];
                $catDonneeTraitee = $row["catDonneeTraitee"];
                $catPersConcern = $row["catPersConcern"];
                $destiDonnees = $row["destiDonnees"];
                $dureeUtiliteAdmi = $row["dureeUtiliteAdmi"];
                $archivage = $row["archivage"];
                $transfertHorsUE = $row["transfertHorsUE"];
                $catLiceiteTraitee = $row["catLiceiteTraitee"];
                $coRespTraitement = $row["coRespTraitement"];
                $representantCoResp = $row["representantCoResp"];
                $sousTraitant = $row["sousTraitant"];
                $delaiEffacement = $row["delaiEffacement"];
                $support = $row["support"];
				$niveau_identification = $row["niveau_identification"];
				$com_ident = $row["com_ident"];
				$niveau_securite = $row["niveau_securite"];
				$com_secu = $row["com_secu"];
				$donneePIA = $row["donneePIA"];
				$PIA = $row["PIA"];
				$horsRegistre = $row["horsRegistre"];
                $derniereMAJ = $row["derniereMAJ"];
                $declarant = $row["declarant"];
				$planAction = $row["planAction"];
				$baseJuridique = $row["baseJuridique"];
				$baseJuridiqueLiceite = $row["baseJuridiqueLiceite"];
                $rep = new metier\formulaire\Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee,
						$catPersConcern, $destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement,
						$support, $niveau_identification, $com_ident, $niveau_securite, $com_secu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite);
				$rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

		public function readAllFormPartout($recherche)
        {
            $list = [];
			$sql = "SELECT formulaire.identifiant, nomLogiciel, origineDonnee, validationDPD, finaliteTraitement, sousFinalite, commentaire, dateMiseEnOeuvre, catDonneeTraitee,
					catPersConcern, destiDonnees, dureeUtiliteAdmi, archivage, transfertHorsUE, catLiceiteTraitee, coRespTraitement, representantCoResp, sousTraitant, delaiEffacement,
					support, niveau_identification, com_ident, niveau_securite, com_secu, derniereMAJ, declarant, donneePIA, PIA, horsRegistre, planAction, baseJuridique, baseJuridiqueLiceite
				FROM formulaire
				left JOIN gestionnairesdroitacces ON gestionnairesdroitacces.id_formulaire = formulaire.identifiant
				INNER JOIN servicesmunicipaux ON gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN entites ON servicesmunicipaux.entite = entites.identifiant
				INNER JOIN applidroitacces ON applidroitacces.id_entite = entites.identifiant
				INNER JOIN utilisateurs ON utilisateurs.identifiant = applidroitacces.id_utilisateur
				WHERE (UCASE(nomLogiciel) like UCASE('%".$recherche."%') OR UCASE( origineDonnee) like UCASE('%".$recherche."%') OR UCASE(finaliteTraitement) like UCASE('%".$recherche."%')
				OR UCASE(sousFinalite) like UCASE('%".$recherche."%') OR UCASE(commentaire) like UCASE('%".$recherche."%') OR UCASE(com_secu) like UCASE('%".$recherche."%')
				OR UCASE(catDonneeTraitee) like UCASE('%".$recherche."%') OR UCASE(catPersConcern) like UCASE('%".$recherche."%') OR UCASE(DestiDonnees) like UCASE('%".$recherche."%')
				OR UCASE(dureeUtiliteAdmi) like UCASE('%".$recherche."%') OR UCASE(archivage) like UCASE('%".$recherche."%') OR UCASE(coRespTraitement) like UCASE('%".$recherche."%')
				OR UCASE(representantCoResp) like UCASE('%".$recherche."%') OR UCASE(sousTraitant) like UCASE('%".$recherche."%') OR UCASE(delaiEffacement) like UCASE('%".$recherche."%')
				OR UCASE(support) like UCASE('%".$recherche."%') OR UCASE(com_ident) like UCASE('%".$recherche."%') OR UCASE(com_secu) like UCASE('%".$recherche."%')
				OR UCASE(planAction) like UCASE('%".$recherche."%') OR UCASE(baseJuridique) like UCASE('%".$recherche."%') OR UCASE(baseJuridiqueLiceite) like UCASE('%".$recherche."%'))
				AND utilisateurs.identifiant = ".$_SESSION['identifiant']."
				GROUP by formulaire.identifiant;";

			//var_dump($sql);
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $nomLogiciel = $row["nomLogiciel"];
                $origineDonnee = $row["origineDonnee"];
                $validationDPD = $row["validationDPD"];
                $finaliteTraitement = $row["finaliteTraitement"];
                $sousFinalite = $row["sousFinalite"];
                $commentaire = $row["commentaire"];
                $dateMiseEnOeuvre = $row["dateMiseEnOeuvre"];
                $catDonneeTraitee = $row["catDonneeTraitee"];
                $catPersConcern = $row["catPersConcern"];
                $destiDonnees = $row["destiDonnees"];
                $dureeUtiliteAdmi = $row["dureeUtiliteAdmi"];
                $archivage = $row["archivage"];
                $transfertHorsUE = $row["transfertHorsUE"];
                $catLiceiteTraitee = $row["catLiceiteTraitee"];
                $coRespTraitement = $row["coRespTraitement"];
                $representantCoResp = $row["representantCoResp"];
                $sousTraitant = $row["sousTraitant"];
                $delaiEffacement = $row["delaiEffacement"];
                $support = $row["support"];
				$niveau_identification = $row["niveau_identification"];
				$com_ident = $row["com_ident"];
				$niveau_securite = $row["niveau_securite"];
				$com_secu = $row["com_secu"];
				$donneePIA = $row["donneePIA"];
				$PIA = $row["PIA"];
				$horsRegistre = $row["horsRegistre"];
                $derniereMAJ = $row["derniereMAJ"];
                $declarant = $row["declarant"];
				$planAction = $row["planAction"];
				$baseJuridique = $row["baseJuridique"];
				$baseJuridiqueLiceite = $row["baseJuridiqueLiceite"];

                $rep = new metier\formulaire\Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee,
						$catPersConcern, $destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement,
						$support, $niveau_identification, $com_ident, $niveau_securite, $com_secu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite);
				$rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

		public function readAllFormByFiltre($user,$f1,$f2,$f3,$f4,$f5,$f6,$f7,$f8,$f9,$f10)
        {
            $list = [];
			$sql = "SELECT formulaire.identifiant, nomLogiciel, origineDonnee, validationDPD, finaliteTraitement, sousFinalite, commentaire, dateMiseEnOeuvre, catDonneeTraitee,
					catPersConcern, destiDonnees, dureeUtiliteAdmi, archivage, transfertHorsUE, catLiceiteTraitee, coRespTraitement, representantCoResp, sousTraitant, delaiEffacement,
					support, niveau_identification, com_ident, niveau_securite, com_secu, derniereMAJ, declarant, donneePIA, PIA, horsRegistre, planAction, baseJuridique, baseJuridiqueLiceite
				FROM formulaire
				left JOIN gestionnairesdroitacces ON gestionnairesdroitacces.id_formulaire = formulaire.identifiant
				INNER JOIN servicesmunicipaux ON gestionnairesdroitacces.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN entites ON servicesmunicipaux.entite = entites.identifiant
				INNER JOIN applidroitacces ON applidroitacces.id_entite = entites.identifiant
				INNER JOIN utilisateurs ON utilisateurs.identifiant = applidroitacces.id_utilisateur
				WHERE utilisateurs.identifiant = :idUser ";

			if (($f1<>"")||($f2<>"")||($f3<>"")||($f4<>"")||($f5<>"")||($f6<>"")||($f7<>"")||($f8<>"")||($f9<>"")) {
				$sql = $sql."AND (";
				$i=0;
				if ($f1<>"") {
					$sql= $sql."validationDPD > 0000-00-00 ";
					$i=$i+1;
				}
				if ($f2<>"") {
					if ($i <> 0) {
						$sql = $sql."AND ";
					}
					$sql = $sql."UCASE(transfertHorsUE) like UCASE('%".$f2."%') ";
					$i=$i+1;
				}
				if ($f3<>"-1") {
					if ($i <> 0) {
						$sql = $sql."AND ";
					}
					$sql = $sql."UCASE(niveau_identification) like UCASE('%".$f3."%') ";
					$i=$i+1;
				}
				if ($f4<>"-1") {
					if ($i <> 0) {
						$sql = $sql."AND ";
					}
					$sql = $sql."UCASE(niveau_securite) like UCASE('%".$f4."%') ";
					$i=$i+1;
				}
				if ($f5<>"") {
					if ($i <> 0) {
						$sql = $sql."AND ";
					}
					$sql = $sql."UCASE(donneePIA) like UCASE('%".$f5."%') ";
					$i=$i+1;
				}
				if ($f6<>"") {
					if ($i <> 0) {
						$sql = $sql."AND ";
					}
					$sql = $sql."UCASE(horsRegistre) like UCASE('%".$f6."%') ";
					$i=$i+1;
				}
				if ($f7<>"") {
					if ($i <> 0) {
						$sql = $sql."AND ";
					}
					$sql = $sql."UCASE(catDonneeTraitee) like UCASE('%".$f7."%') ";
					$i=$i+1;
				}
				if ($f8<>"") {
					if ($i <> 0) {
						$sql = $sql."AND ";
					}
					$sql= $sql."UCASE(catLiceiteTraitee) like UCASE('%".$f8."%') ";
					$i=$i+1;
				}
				$sql = $sql.") GROUP by formulaire.identifiant ";
				if ($f9<>"-1") {
					$sql= $sql."ORDER BY '%".$f9."%' ".$f10." ";
					$i=$i+1;
				}
			}
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':idUser', $user);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $nomLogiciel = $row["nomLogiciel"];
                $origineDonnee = $row["origineDonnee"];
                $validationDPD = $row["validationDPD"];
                $finaliteTraitement = $row["finaliteTraitement"];
                $sousFinalite = $row["sousFinalite"];
                $commentaire = $row["commentaire"];
                $dateMiseEnOeuvre = $row["dateMiseEnOeuvre"];
                $catDonneeTraitee = $row["catDonneeTraitee"];
                $catPersConcern = $row["catPersConcern"];
                $destiDonnees = $row["destiDonnees"];
                $dureeUtiliteAdmi = $row["dureeUtiliteAdmi"];
                $archivage = $row["archivage"];
                $transfertHorsUE = $row["transfertHorsUE"];
                $catLiceiteTraitee = $row["catLiceiteTraitee"];
                $coRespTraitement = $row["coRespTraitement"];
                $representantCoResp = $row["representantCoResp"];
                $sousTraitant = $row["sousTraitant"];
                $delaiEffacement = $row["delaiEffacement"];
                $support = $row["support"];
				$niveau_identification = $row["niveau_identification"];
				$com_ident = $row["com_ident"];
				$niveau_securite = $row["niveau_securite"];
				$com_secu = $row["com_secu"];
				$donneePIA = $row["donneePIA"];
				$PIA = $row["PIA"];
				$horsRegistre = $row["horsRegistre"];
                $derniereMAJ = $row["derniereMAJ"];
                $declarant = $row["declarant"];
				$planAction = $row["planAction"];
				$baseJuridique = $row["baseJuridique"];
				$baseJuridiqueLiceite = $row["baseJuridiqueLiceite"];
                $rep = new metier\formulaire\Formulaire($nomLogiciel, $origineDonnee, $validationDPD, $finaliteTraitement, $sousFinalite, $commentaire, $dateMiseEnOeuvre, $catDonneeTraitee,
						$catPersConcern, $destiDonnees, $dureeUtiliteAdmi, $archivage, $transfertHorsUE, $catLiceiteTraitee, $coRespTraitement, $representantCoResp, $sousTraitant, $delaiEffacement,
						$support, $niveau_identification, $com_ident, $niveau_securite, $com_secu, $derniereMAJ, $declarant, $donneePIA, $PIA, $horsRegistre, $planAction, $baseJuridique, $baseJuridiqueLiceite);
				$rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

        public function update($objet)
        {
            $sql = "UPDATE $this->table SET nomLogiciel=:nomLogiciel, origineDonnee=:origineDonnee, validationDPD=:validationDPD, finaliteTraitement=:finaliteTraitement, sousFinalite=:sousFinalite,
					commentaire=:commentaire, dateMiseEnOeuvre=:dateMiseEnOeuvre, catDonneeTraitee=:catDonneeTraitee, catPersConcern=:catPersConcern, destiDonnees=:destiDonnees,
					dureeUtiliteAdmi=:dureeUtiliteAdmi, archivage=:archivage, transfertHorsUE=:transfertHorsUE, catLiceiteTraitee=:catLiceiteTraitee, coRespTraitement=:coRespTraitement,
					representantCoResp=:representantCoResp, sousTraitant=:sousTraitant, delaiEffacement=:delaiEffacement, support=:support, niveau_identification=:niveau_identification,
					com_ident=:com_ident, niveau_securite=:niveau_securite, com_secu=:com_secu, derniereMAJ=:derniereMAJ, declarant=:declarant, donneePIA=:donneePIA, PIA=:PIA,
					horsRegistre =:horsRegistre, planAction=:planAction, PIA=:PIA, baseJuridique =:baseJuridique, baseJuridiqueLiceite =:baseJuridiqueLiceite

					WHERE $this->key = :id ;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id = $objet->getIdentifiant();

            $nomLogiciel = $objet->getNomLogiciel();
            $origineDonnee = $objet->getorigineDonnee();
            $validationDPD = $objet->getvalidationDPD();
            $finaliteTraitement = $objet->getFinaliteTraitement();
            $sousFinalite = $objet->getSousFinalite();
            $commentaire = $objet->getCommentaire();
            $dateMiseEnOeuvre = $objet->getDateMiseEnOeuvre();
            $catDonneeTraitee = $objet->getCatDonneeTraitee();
            $catPersConcern = $objet->getCatPersConcern();
            $destiDonnees = $objet->getDestiDonnees();
            $dureeUtiliteAdmi = $objet->getDureeUtiliteAdmi();
            $archivage = $objet->getArchivage();
            $transfertHorsUE = $objet->getTransfertHorsUE();
            $catLiceiteTraitee = $objet->getcatLiceiteTraitee();
            $coRespTraitement = $objet->getCoRespTraitement();
            $representantCoResp = $objet->getRepresentantCoResp();
            $sousTraitant = $objet->getSousTraitant();
            $delaiEffacement = $objet->getDelaiEffacement();
            $support = $objet->getSupport();
            $niveau_identification = $objet->getNiveau_identification();
			$com_ident = $objet->getCom_ident();
            $niveau_securite = $objet->getNiveau_securite();
            $com_secu = $objet->getCom_secu();
			$donneePIA = $objet->getDonneePIA();
			$PIA = $objet->getPIA();
			$horsRegistre = $objet->getHorsRegistre();
            $derniereMAJ = $objet->getDerniereMAJ();
            $declarant = $objet->getDeclarant();
			$planAction = $objet->getPlanAction();
            $baseJuridique = $objet->getBaseJuridique();
            $baseJuridiqueLiceite = $objet->getBaseJuridiqueLiceite();


            $stmt->bindParam(':nomLogiciel', $nomLogiciel);
            $stmt->bindParam(':origineDonnee', $origineDonnee);
            $stmt->bindParam(':validationDPD', $validationDPD);
            $stmt->bindParam(':finaliteTraitement', $finaliteTraitement);
            $stmt->bindParam(':sousFinalite', $sousFinalite);
            $stmt->bindParam(':commentaire', $commentaire);
            $stmt->bindParam(':dateMiseEnOeuvre', $dateMiseEnOeuvre);
            $stmt->bindParam(':catDonneeTraitee', $catDonneeTraitee);
            $stmt->bindParam(':catPersConcern', $catPersConcern);
            $stmt->bindParam(':destiDonnees', $destiDonnees);
            $stmt->bindParam(':dureeUtiliteAdmi', $dureeUtiliteAdmi);
            $stmt->bindParam(':archivage', $archivage);
            $stmt->bindParam(':transfertHorsUE', $transfertHorsUE);
            $stmt->bindParam(':catLiceiteTraitee', $catLiceiteTraitee);
            $stmt->bindParam(':coRespTraitement', $coRespTraitement);
            $stmt->bindParam(':representantCoResp', $representantCoResp);
            $stmt->bindParam(':sousTraitant', $sousTraitant);
            $stmt->bindParam(':delaiEffacement', $delaiEffacement);
            $stmt->bindParam(':support', $support);
            $stmt->bindParam(':niveau_identification', $niveau_identification);
			$stmt->bindParam(':com_ident', $com_ident);
            $stmt->bindParam(':niveau_securite', $niveau_securite);
            $stmt->bindParam(':com_secu', $com_secu);
			$stmt->bindParam(':donneePIA', $donneePIA);
            $stmt->bindParam(':PIA', $PIA);
			$stmt->bindparam(':horsRegistre', $horsRegistre);
            $stmt->bindParam(':derniereMAJ', $derniereMAJ);
            $stmt->bindParam(':declarant', $declarant);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':planAction', $planAction);
            $stmt->bindParam(':baseJuridique', $baseJuridique);
            $stmt->bindParam(':baseJuridiqueLiceite', $baseJuridiqueLiceite);
            $stmt->execute();
        }

        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $del = $objet->getIdentifiant();
            $stmt->bindParam(':id', $del);
            $stmt->execute();
        }

        public function deleteByIdFrm($identifiant)
        {
            $sql = "DELETE FROM $this->table WHERE identifiant=:identifiant;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':identifiant', $identifiant);
            $stmt->execute();
        }

	    public function copyByIdFrm($id)
        {
			$sql = "INSERT INTO modele (nomlogiciel, finaliteTraitement, sousFinalite, commentaire, catDonneeTraitee, catPersConcern, destiDonnees, dureeUtiliteAdmi, archivage, transfertHorsUE,
			catLiceiteTraitee, delaiEffacement, support) SELECT nomlogiciel, finaliteTraitement, sousFinalite, commentaire, catDonneeTraitee, catPersConcern, destiDonnees, dureeUtiliteAdmi, archivage,
			transfertHorsUE, catLiceiteTraitee, delaiEffacement, support FROM formulaire WHERE identifiant=".$id;
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
	}
}

namespace DAO\ServiceMunicipal
{
    class ServiceMunicipalDAO extends \DAO\DAO
    {
		function __construct()
		{
			parent::__construct("identifiant", "servicesmunicipaux");
		}

		public function create($objet)
		{
			$sql = "INSERT INTO $this->table (service, pole, entite) values (:service, :pole, :entite)";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$service = $objet->getService();
			$pole = $objet->getPole();
			$entite = $objet->getEntite();
			$stmt->bindParam(':service', $service);
			$stmt->bindParam(':pole', $pole);
			$stmt->bindParam(':entite', $entite);
			$stmt->execute();

			$id = $this->getLastKey();
			$objet->setIdentifiant($id);
		}

		public function read($id)
		{
			$sql = "SELECT * FROM $this->table WHERE $this->key=:id";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$row = $stmt->fetch();
			$identifiant = $row["identifiant"];
			$service = $row["service"];
			$pole = $row["pole"];
			$entite = $row["entite"];

			$rep = new \metier\serviceMunicipal\ServiceMunicipal($service, $pole, $entite);
			$rep->setIdentifiant($identifiant);

			return $rep;
		}

		public function readService($id)
		{
			$sql = "SELECT service, pole, entite FROM $this->table WHERE $this->key=:id ORDER BY service asc";

			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$row = $stmt->fetch();
			$service = $row["service"];

			$pole = $row["pole"];
			$entite = $row["entite"];

			return $service;
		}

		public function readServicePoleEntite($id)
		{
			$sql = "SELECT service, poles.pole, entites.entite
				FROM servicesmunicipaux
				INNER JOIN poles ON servicesmunicipaux.pole = poles.identifiant
				INNER JOIN entites on servicesmunicipaux.entite = entites.identifiant
				WHERE servicesmunicipaux.identifiant=:id
				ORDER BY service asc";

			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$row = $stmt->fetch();
			$service = $row["service"];
			$pole = $row["pole"];
			$entite = $row["entite"];

			return "<b>".$service."</b><i> (".$pole." / ".$entite.")</i>";
		}

		public function readServiceEntite()
		{
			$list = [];
			$sql = "SELECT servicesmunicipaux.identifiant, service, entites.entite FROM $this->table
				INNER JOIN entites on servicesmunicipaux.entite = entites.identifiant
				WHERE $this->key=:id
				ORDER BY service asc;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			while ($row = $stmt->fetch()) {
				$identifiant = $row["identifiant"];
				$service = $row["service"];
				$entite = $row["entite"];
				$rep = new \metier\serviceMunicipal\ServiceMunicipal($service, $entite);
				$rep->setIdentifiant($identifiant);
				$list[] = $rep;
			}
			return $list;
		}

		public function readDPDmail($id)
		{
			$sql = "SELECT service FROM $this->table WHERE $this->key=:id ORDER BY service asc";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$row = $stmt->fetch();
			$maildpd = $row["maildpd"];

			return $maildpd;
		}

		public function readLastServ()
		{
			$sql = "SELECT max(identifiant) FROM $this->table";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->execute();

			$row = $stmt->fetch();
			$identifiant = $row[0];

			return $identifiant;
		}

		public function readAllServM()
		{
			$list = [];
			$sql = "SELECT * FROM $this->table ORDER BY service asc;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->execute();

			while ($row = $stmt->fetch()) {
				$identifiant = $row["identifiant"];
				$service = $row["service"];
				$pole = $row["pole"];
				$entite = $row["entite"];
				$rep = new \metier\serviceMunicipal\ServiceMunicipal($service, $pole, $entite);
				$rep->setIdentifiant($identifiant);
				$list[] = $rep;
			}
			return $list;
		}

		public function readAllServMByAdmin($admin)
		{
			$list = [];
			$sql = "SELECT distinct servicesmunicipaux.identifiant, servicesmunicipaux.service, servicesmunicipaux.pole, servicesmunicipaux.entite FROM $this->table
				INNER JOIN poles on servicesmunicipaux.pole = poles.identifiant
				INNER JOIN entites on entites.identifiant = servicesmunicipaux.entite
				INNER JOIN applidroitacces on entites.identifiant = applidroitacces.id_entite
				INNER JOIN utilisateurs on utilisateurs.identifiant = id_utilisateur
				WHERE id_utilisateur = ".$admin." ORDER BY entites.entite, poles.pole, service;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->execute();

			while ($row = $stmt->fetch()) {
				$identifiant = $row["identifiant"];
				$service = $row["service"];
				$pole = $row["pole"];
				$entite = $row["entite"];
				$rep = new \metier\serviceMunicipal\ServiceMunicipal($service, $pole, $entite);
				$rep->setIdentifiant($identifiant);
				$list[] = $rep;
			}
			return $list;
		}

		public function readAllServMPole($id)
		{
			$list = [];
			$sql = "SELECT * FROM $this->table WHERE pole = :poles ORDER BY pole, service asc";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':poles', $id);
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				$identifiant = $row["identifiant"];
				$service = $row["service"];
				$pole = $row["pole"];
				$entite = $row["entite"];
				$rep = new \metier\serviceMunicipal\ServiceMunicipal($service, $pole, $entite);
				$rep->setIdentifiant($identifiant);
				$list[] = $rep;
			}
			return $list;
		}

		public function readAllServMPoleByUser($id,$user)
		{
			$list = [];
			$sql = "SELECT distinct servicesmunicipaux.identifiant, servicesmunicipaux.service, servicesmunicipaux.pole, servicesmunicipaux.entite
				FROM servicesmunicipaux
				INNER JOIN poles on poles.identifiant = servicesmunicipaux.pole
				INNER JOIN droits on droits.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN utilisateurs on droits.id_utilisateur = utilisateurs.identifiant
				INNER JOIN entitepole on poles.identifiant = entitepole.id_pole
				WHERE servicesmunicipaux.pole =".$id." AND utilisateurs.identifiant =".$user."
				ORDER BY pole, service asc";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				$identifiant = $row["identifiant"];
				$service = $row["service"];
				$pole = $row["pole"];
				$entite = $row["entite"];
				$rep = new \metier\serviceMunicipal\ServiceMunicipal($service, $pole, $entite);
				$rep->setIdentifiant($identifiant);
				$list[] = $rep;
			}
			return $list;
		}

		public function readAllServMEntiteByUser($id,$user)
		{
			$list = [];
			$sql = "SELECT distinct servicesmunicipaux.identifiant, servicesmunicipaux.service, servicesmunicipaux.pole, servicesmunicipaux.entite
				FROM servicesmunicipaux
				INNER JOIN poles on poles.identifiant = servicesmunicipaux.pole
				INNER JOIN droits on droits.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN utilisateurs on droits.id_utilisateur = utilisateurs.identifiant
				INNER JOIN entitepole on poles.identifiant = entitepole.id_pole
				WHERE servicesmunicipaux.entite =".$id." AND utilisateurs.identifiant =".$user."
				ORDER BY pole, service asc";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				$identifiant = $row["identifiant"];
				$service = $row["service"];
				$pole = $row["pole"];
				$entite = $row["entite"];
				$rep = new \metier\serviceMunicipal\ServiceMunicipal($service, $pole, $entite);
				$rep->setIdentifiant($identifiant);
				$list[] = $rep;
			}
			return $list;
		}

		public function readAllServMEntite($id)
		{
			$list = [];
			$sql = "SELECT * FROM $this->table WHERE entite = :entites ORDER BY entite, service asc";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':entites', $id);
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				$identifiant = $row["identifiant"];
				$service = $row["service"];
				$pole = $row["pole"];
				$entite = $row["entite"];
				$rep = new \metier\serviceMunicipal\ServiceMunicipal($service, $pole, $entite);
				$rep->setIdentifiant($identifiant);
				$list[] = $rep;
			}
			return $list;
		}

		public function readAllServMEntitePole($id, $id2)
		{
			$list = [];
			$sql = "SELECT * FROM $this->table WHERE entite = :entites AND pole = :poles ORDER BY entite, service asc";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':entites', $id);
			$stmt->bindParam(':poles', $id2);
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				$identifiant = $row["identifiant"];
				$service = $row["service"];
				$pole = $row["pole"];
				$entite = $row["entite"];
				$rep = new \metier\serviceMunicipal\ServiceMunicipal($service, $pole, $entite);
				$rep->setIdentifiant($identifiant);
				$list[] = $rep;
			}
			return $list;
		}

        public function readCountServPole($id)
        {
            $sql = "SELECT COUNT(*) as nbServ FROM $this->table WHERE pole= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();
            $nbServ=$row["nbServ"];
            return $nbServ;
        }

	public function readCountServEntite($id)
        {
            $sql = "SELECT COUNT(*) as nbServ FROM $this->table WHERE entite= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();
            $nbServ=$row["nbServ"];
            return $nbServ;
        }

		public function update($objet)
		{
			$sql = "UPDATE $this->table SET service= :service, pole = :pole, entite = :entite WHERE $this->key = :id ;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$id = $objet->getIdentifiant();
			$service = $objet->getService();
			$pole = $objet->getPole();
			$entite = $objet->getEntite();
			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':service', $service);
			$stmt->bindParam(':pole', $pole);
			$stmt->bindParam(':entite', $entite);
			$stmt->execute();
		}

		public function delete($id)
		{
			$sql = "DELETE FROM $this->table WHERE $this->key=:id;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
		}

        public function readServDroitUtil($id_utilisateurs)
		{
            $sql="SELECT DISTINCT servicesmunicipaux.identifiant, servicesmunicipaux.service, poles.pole, entites.entite
				FROM $this->table
				INNER JOIN droits on droits.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN entites on servicesmunicipaux.entite = entites.identifiant
				INNER JOIN poles on servicesmunicipaux.pole = poles.identifiant
				WHERE servicesmunicipaux.identifiant IN
					(SELECT id_gestionnaire
					FROM droits
					WHERE servicesmunicipaux.identifiant=droits.id_gestionnaire AND droits.id_utilisateur=:id_utilisateur)
				ORDER BY service;";
			$stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_utilisateur', $id_utilisateurs);
            $stmt->execute();
            $rep="";
            while ($row = $stmt->fetch()){
				$service=$row["service"];
				$pole=$row["pole"];
				$entite=$row["entite"];
				$rep.="<b>".$service." </b><i>(".$pole." / ".$entite.")</i><br/> ";
			}
            return $rep;
        }

		public function readServDroitUtilByServ($id_utilisateurs, $id_services)
		{
            $sql="SELECT DISTINCT servicesmunicipaux.identifiant, servicesmunicipaux.service, poles.pole, entites.entite
				FROM $this->table
				INNER JOIN droits on droits.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN entites on servicesmunicipaux.entite = entites.identifiant
				INNER JOIN poles on servicesmunicipaux.pole = poles.identifiant
				WHERE droits.id_utilisateur= :id_utilisateur AND servicesmunicipaux.identifiant = :id_service
				ORDER BY service;";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_utilisateur', $id_utilisateurs);
			$stmt->bindParam(':id_service', $id_services);
            $stmt->execute();
            $rep="";
            while ($row = $stmt->fetch()){
				$service=$row["service"];
				$pole=$row["pole"];
				$entite=$row["entite"];
				$rep.="<b>".$service." </b><i>(".$pole." / ".$entite.")</i><br/> ";
			}
            return $rep;
		}

		public function readServDroitUtilByPol($id_utilisateurs, $id_poles)
		{
            $sql="SELECT DISTINCT servicesmunicipaux.identifiant, servicesmunicipaux.service, poles.pole, entites.entite
				FROM $this->table
				INNER JOIN droits on droits.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN entites on servicesmunicipaux.entite = entites.identifiant
				INNER JOIN poles on servicesmunicipaux.pole = poles.identifiant
				WHERE servicesmunicipaux.identifiant IN
					(SELECT droits.id_gestionnaire
					FROM droits
					WHERE droits.id_utilisateur = :id_utilisateur)
				AND servicesmunicipaux.identifiant IN
					(SELECT servicesmunicipaux.identifiant
					FROM servicesmunicipaux
					WHERE servicesmunicipaux.pole = :id_pole)
				ORDER BY service;";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_utilisateur', $id_utilisateurs);
			$stmt->bindParam(':id_pole', $id_poles);
            $stmt->execute();
            $rep="";
            while ($row = $stmt->fetch()){
				$service=$row["service"];
				$pole=$row["pole"];
				$entite=$row["entite"];
				$rep.="<b>".$service." </b><i>(".$pole." / ".$entite.")</i><br/> ";
			}
            return $rep;
		}

		public function readServDroitUtilByEnt($id_utilisateurs, $id_entites)
		{
            $sql="SELECT DISTINCT servicesmunicipaux.identifiant, servicesmunicipaux.service, poles.pole, entites.entite
				FROM $this->table
				INNER JOIN droits on droits.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN entites on servicesmunicipaux.entite = entites.identifiant
				INNER JOIN poles on servicesmunicipaux.pole = poles.identifiant
				WHERE servicesmunicipaux.identifiant IN
					(SELECT droits.id_gestionnaire
					FROM droits
					WHERE droits.id_utilisateur = :id_utilisateur)
				AND servicesmunicipaux.identifiant IN
					(SELECT servicesmunicipaux.identifiant
					FROM servicesmunicipaux
					WHERE servicesmunicipaux.entite = :id_entite)
				ORDER BY service;";
			$stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_utilisateur', $id_utilisateurs);
			$stmt->bindParam(':id_entite', $id_entites);
            $stmt->execute();
            $rep="";
            while ($row = $stmt->fetch()){
				$service=$row["service"];
				$pole=$row["pole"];
				$entite=$row["entite"];
				$rep.="<b>".$service." </b><i>(".$pole." / ".$entite.")</i><br/> ";
			}
            return $rep;
        }
	}
}

namespace DAO\pole
{
    class PoleDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "poles");
        }
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (pole) values (:pole)";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $pole = $objet->getPole();
            $stmt->bindParam(':pole', $pole);
            $stmt->execute();

            $id = $this->getLastKey();
            $objet->setIdentifiant($id);
        }

        public function read($id)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id ORDER BY pole";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant = $row["identifiant"];
            $pole = $row["pole"];

            $rep = new \metier\pole\Pole($pole);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function readAllPoles()
        {
            $list = [];
            $sql = "SELECT * FROM $this->table ORDER BY pole;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $pole = $row["pole"];
                $rep = new \metier\pole\Pole($pole);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

        public function readAllPolesByAdmin($admin)
        {
            $list = [];
            $sql = "SELECT distinct poles.identifiant, pole FROM poles
				INNER JOIN entitepole on entitepole.id_pole = poles.identifiant
				INNER JOIN entites on entites.identifiant = entitepole.id_entite
				INNER JOIN applidroitacces on entites.identifiant = applidroitacces.id_entite
				INNER JOIN utilisateurs on utilisateurs.identifiant = id_utilisateur
				WHERE id_utilisateur = ".$admin." ORDER BY entites.entite, pole;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $pole = $row["pole"];
                $rep = new \metier\pole\Pole($pole);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

        public function readAllPolesByEntite($entite)
        {
            $list = [];
            $sql = "SELECT distinct poles.identifiant, pole
					FROM poles
					INNER JOIN entitepole on poles.identifiant = entitepole.id_pole
					WHERE id_entite =".$entite."
					ORDER BY pole";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $pole = $row["pole"];
                $rep = new \metier\pole\Pole($pole);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

       public function readAllPolesByEntiteUser($entite,$user)
        {
            $list = [];
            $sql = "SELECT distinct poles.identifiant, poles.pole
				FROM poles
				INNER JOIN entitepole on poles.identifiant = entitepole.id_pole
				INNER JOIN servicesmunicipaux on servicesmunicipaux.pole = entitepole.id_pole
				INNER JOIN droits on droits.id_gestionnaire = servicesmunicipaux.identifiant
				INNER JOIN utilisateurs on droits.id_utilisateur = utilisateurs.identifiant
				WHERE id_entite =".$entite." and utilisateurs.identifiant =".$user."
				ORDER BY pole";

            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $pole = $row["pole"];
                $rep = new \metier\pole\Pole($pole);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

        public function readPole($pol)
        {
            $sql="SELECT * FROM $this->table WHERE pole=:pol";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':pol', $pol);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant=$row["identifiant"];
            $pole=$row["pole"];

            $rep= new \metier\pole\Pole($pole);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

		public function readMaxPole()
        {
            $sql="SELECT max(identifiant) as identifiant, pole FROM $this->table";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant=$row["identifiant"];
            $pole=$row["pole"];

            $rep= new \metier\pole\Pole($pole);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function update($objet)
        {
            $sql = "UPDATE $this->table SET pole= :pole WHERE $this->key = :id ;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id = $objet->getIdentifiant();

            $pole = $objet->getPole();
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':pole', $pole);
            $stmt->execute();
        }

		public function delete($id)
		{
			$sql = "DELETE FROM $this->table WHERE $this->key=:id;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
		}
    }
}

namespace DAO\entite
{
    class EntiteDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "entites");
        }
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (entite, maildpd, responsable, siret) values (:entite, :maildpd, :responsable, :siret)";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $entite = $objet->getEntite();
			$maildpd = $objet->getMaildpd();
			$responsable = $objet->getResponsable();
            $siret = $objet->getSiret();
            $stmt->bindParam(':entite', $entite);
            $stmt->bindParam(':maildpd', $maildpd);
			$stmt->bindParam(':responsable', $responsable);
            $stmt->bindParam(':siret', $siret);
            $stmt->execute();

            $id = $this->getLastKey();
            $objet->setIdentifiant($id);
        }

        public function read($id)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant = $row["identifiant"];
            $entite = $row["entite"];
            $maildpd = $row["maildpd"];
			$responsable = $row["responsable"];
            $siret = $row["siret"];

            $rep = new \metier\entite\Entite($entite);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function readAllEntites()
        {
            $list = [];
            $sql = "SELECT * FROM $this->table ORDER BY entite;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $entite = $row["entite"];
                $maildpd = $row["maildpd"];
				$responsable = $row["responsable"];
                $siret = $row["siret"];
                $rep = new \metier\entite\Entite($entite);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

        public function readAllEntitesByAdmin($admin)
        {
            $list = [];
            $sql = "SELECT distinct entites.identifiant, entite, maildpd, responsable, siret FROM $this->table
				INNER JOIN applidroitacces on id_entite = entites.identifiant
				INNER JOIN utilisateurs on utilisateurs.identifiant = id_utilisateur
				WHERE id_utilisateur = ".$admin." ORDER BY entite;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $entite = $row["entite"];
				$maildpd = $row["maildpd"];
				$responsable = $row["responsable"];
                $siret = $row["siret"];
                $rep = new \metier\entite\Entite($entite, $maildpd, $responsable, $siret);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

        public function readAllEntitesByUser($user)
        {
            $list = [];
            $sql = "SELECT distinct entites.identifiant, entite, maildpd, responsable, siret FROM $this->table
				INNER JOIN applidroitacces on id_entite = entites.identifiant
				INNER JOIN utilisateurs on utilisateurs.identifiant = id_utilisateur
				WHERE id_utilisateur = ".$user." AND ORDER BY entite;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant = $row["identifiant"];
                $entite = $row["entite"];
				$maildpd = $row["maildpd"];
				$responsable = $row["responsable"];
                $siret = $row["siret"];
                $rep = new \metier\entite\Entite($entite, $maildpd, $responsable, $siret);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
            }
            return $list;
        }

		public function readEntite($id)
		{
			$sql = "SELECT entite FROM $this->table WHERE $this->key=:id ORDER BY entite asc";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$row = $stmt->fetch();
			$entite = $row["entite"];

			return $entite;
		}

		public function readLastEnt()
		{
			$sql = "SELECT max(identifiant) FROM $this->table";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->execute();

			$row = $stmt->fetch();
			$identifiant = $row[0];

			return $identifiant;
		}

        public function update($objet)
        {
            $sql = "UPDATE $this->table SET entite= :entite, maildpd= :maildpd, responsable= :responsable, siret= :siret WHERE $this->key = :id ;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id = $objet->getIdentifiant();
            $maildpd = $objet->getMaildpd();
            $entite = $objet->getEntite();
			$responsable = $objet->getResponsable();
            $siret = $objet->getSiret();
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':entite', $entite);
            $stmt->bindParam(':maildpd', $maildpd);
			$stmt->bindParam(':responsable', $responsable);
            $stmt->bindParam(':siret', $siret);
            $stmt->execute();
        }

        public function deleteByEnt($id_entite)
        {
            $sql = "DELETE FROM $this->table WHERE identifiant= :id_entite;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_entite', $id_entite);
            $stmt->execute();
        }

		public function delete($id)
		{
			$sql = "DELETE FROM $this->table WHERE $this->key=:id;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
		}
    }
}

namespace DAO\GestionnaireDroitAcces
{
	use metier\gestionnairedroitacces\Gestionnairedroitacces;
	use DAO\Formulaire\FormulaireDAO;
	use DAO\ServiceMunicipal\ServiceMunicipalDAO;

    class GestionnaireDroitAccesDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "gestionnairesdroitacces");
        }
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (id_formulaire, id_gestionnaire) values (:id_formulaire, :id_gestionnaire)";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id_formulaire = $objet->getId_formulaire();
            $id_gestionnaire = $objet->getId_gestionnaire();
            $stmt->bindParam(':id_formulaire', $id_formulaire);
            $stmt->bindParam(':id_gestionnaire', $id_gestionnaire);
            $stmt->execute();

            $id = $this->getLastKey();
            $objet->setIdentifiant($id);
        }

	  //Ancienne version avec plusieurs Gestionnaires du droit d'accès
        public function createPushMulti($gestionnaireDroitAcces)
        {
            foreach (explode(',', $gestionnaireDroitAcces) as $gest){
                $form=new FormulaireDAO();
                $id_formulaire = $form->getLastKey2();
                $id_gestionnaire=$gest;
                $gestionnaire= new Gestionnairedroitacces($id_formulaire, $id_gestionnaire);
                $rep= new GestionnaireDroitAccesDAO();
                $rep->create($gestionnaire);
            }
        }

        static function createPush($gestionnaireDroitAcces) {
        	$form=new FormulaireDAO();
            $id_formulaire = $form->getLastKey2();
            $id_gestionnaire=$gestionnaireDroitAcces;
            $gestionnaire= new Gestionnairedroitacces($id_formulaire, $id_gestionnaire);
            $rep= new GestionnaireDroitAccesDAO();
            $rep->create($gestionnaire);
        }

        public function read($id)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant = $row["identifiant"];
            $id_formulaire = $row["id_formulaire"];
            $id_gestionnaire = $row["id_gestionnaire"];

            $rep = new \metier\gestionnairedroitacces\Gestionnairedroitacces($id_formulaire, $id_gestionnaire);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function readIdForm($id)
        {
            $list = [];
            $sql = "SELECT id_gestionnaire FROM $this->table WHERE id_formulaire= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $id_gestionnaire = $row["id_gestionnaire"];
                $list[].=$id_gestionnaire;
            }
            return $list;
        }

        public function readCountGesti($id_gestionnaire)
        {
            $sql = "SELECT COUNT(*) as nbGest FROM $this->table WHERE id_gestionnaire= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id_gestionnaire);
            $stmt->execute();
            $row = $stmt->fetch();
            $nbGest=$row["nbGest"];
            return $nbGest;
        }

        public function readAll($objet)
        {
            foreach (explode(',', $objet) as $gest){
                $daoG=new ServiceMunicipalDAO();
                $rep=$daoG->readService($gest);
                echo $rep ."<br/>";
            }
        }

        public function update($objet)
        {
            $sql = "UPDATE $this->table SET id_formulaire= :id_formulaire, id_gestionnaire = :id_gestionnaire WHERE $this->key = :id ;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id = $objet->getIdentifiant();
            $id_formulaire = $objet->getId_formulaire();
            $id_gestionnaire = $objet->getId_gestionnaire();
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_formulaire', $id_formulaire);
            $stmt->bindParam(':id_gestionnaire', $id_gestionnaire);
            $stmt->execute();
        }

        public function updatePush($id_formulaire, $ancienGestionnaireDroitAcces, $nouveauxGestionnaireDroitAcces)
        {
            foreach (explode(',', $ancienGestionnaireDroitAcces) as $id_gestionnaire){
                $sql= "DELETE FROM $this->table WHERE id_formulaire= :idform AND id_gestionnaire= :idgesti";
                $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
                $stmt->bindParam(":idform", $id_formulaire);
                $stmt->bindParam(":idgesti", $id_gestionnaire);
                $stmt->execute();

            }
           foreach (explode(',', $nouveauxGestionnaireDroitAcces) as $gest){
                $id_gestionnaire=$gest;
                $gestionnaire= new Gestionnairedroitacces($id_formulaire, $id_gestionnaire);
                $rep= new GestionnaireDroitAccesDAO();
                $rep->create($gestionnaire);

            }
        }

        public function deleteByServ($id_gestionnaire)
        {
            $sql = "DELETE FROM $this->table WHERE id_gestionnaire= :id_gestionnaire;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_gestionnaire', $id_gestionnaire);
            $stmt->execute();
        }

        public function deleteByFrm($id_formulaire)
        {
            $sql = "DELETE FROM $this->table WHERE id_formulaire= :id_formulaire;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_formulaire', $id_formulaire);
            $stmt->execute();
        }

        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $del = $objet->getIdentifiant();
            $stmt->bindParam(':id', $del);
            $stmt->execute();
        }
    }
}

namespace DAO\AppliDroitAcces
{
	use metier\applidroitacces\Applidroitacces;
	use DAO\Utilisateur\UtilisateurDAO;
	use DAO\entite\EntiteDAO;

    class AppliDroitAccesDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "applidroitacces");
        }
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (id_entite, id_utilisateur) values (:id_entite, :id_utilisateur)";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id_entite = $objet->getId_entite();
            $id_utilisateur = $objet->getId_utilisateur();
            $stmt->bindParam(':id_entite', $id_entite);
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->execute();

            $id = $this->getLastKey();
            $objet->setIdentifiant($id);
        }

        public function createPush($appliDroitAcces)
        {
            foreach (explode(',', $appliDroitAcces) as $ent){
                $util=new UtilisateurDAO();
                $id_utilisateur = $util->getLastKey2();
                $id_entite=$ent;
                $entite= new Applidroitacces($id_entite, $id_utilisateur);
                $rep= new AppliDroitAccesDAO();
                $rep->create($entite);
            }
        }

        public function read($id)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant = $row["identifiant"];
            $id_entite = $row["id_entite"];
            $id_utilisateur = $row["id_utilisateur"];

            $rep = new \metier\applidroitacces\Applidroitacces($id_entite, $id_utilisateur);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function readIdUtil($id)
        {
            $list = [];
            $sql = "SELECT id_utilisateur FROM $this->table WHERE id_entite= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $id_utilisateur = $row["id_utilisateur"];
                $list[].=$id_utilisateur;
            }
            return $list;
        }

        public function readIdEnt($id)
        {
            $list = [];
            $sql = "SELECT id_entite FROM $this->table WHERE id_utilisateur= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $id_entite = $row["id_entite"];
                $list[].=$id_entite;
            }
            return $list;
        }


        public function readCountUtil($id_utilisateur)
        {
            $sql = "SELECT COUNT(*) as nbUtil FROM $this->table WHERE id_utilisateur= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id_utilisateur);
            $stmt->execute();
            $row = $stmt->fetch();
            $nbUtil=$row["nbUtil"];
            return $nbUtil;
        }

        public function readAll($objet)
        {
            foreach (explode(',', $objet) as $util){
                $daoU=new EntiteDAO();
                $rep=$daoU->readEntite($util);
                echo $rep ."<br/>";
            }
        }

        public function update($objet)
        {
            $sql = "UPDATE $this->table SET id_entite= :id_entite, id_utilisateur = :id_utilisateur WHERE $this->key = :id ;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id = $objet->getIdentifiant();
            $id_entite = $objet->getId_entite();
            $id_utilisateur = $objet->getId_utilisateur();
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_entite', $id_entite);
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->execute();
        }

        public function updatePush($id_utilisateur, $ancienDroitAcces, $nouveauxDroitAcces)
        {
            foreach (explode(',', $ancienDroitAcces) as $id_entite){
                $sql= "DELETE FROM $this->table WHERE id_utilisateur= :idutil AND id_entite= :ident";
                $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
                $stmt->bindParam(":idutil", $id_utilisateur);
                $stmt->bindParam(":ident", $id_entite);
                $stmt->execute();
            }
           foreach (explode(',', $nouveauxDroitAcces) as $ent){
                $id_entite=$ent;
                $entite= new Applidroitacces($id_entite, $id_utilisateur);
                $rep= new AppliDroitAccesDAO();
                $rep->create($entite);
            }
        }

        public function readAllEntiteByUtil($id)
        {
            $list = [];
            $sql = "SELECT distinct id_entite FROM $this->table WHERE id_utilisateur=".$id;
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $id_entite = $row["id_entite"];
                $list[].=$id_entite;
            }
            return $list;
        }

        public function deleteByUtil($id_utilisateur)
        {
            $sql = "DELETE FROM $this->table WHERE id_utilisateur= :id_utilisateur;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->execute();
        }

        public function deleteByEnt($id_entite)
        {
            $sql = "DELETE FROM $this->table WHERE id_entite= :id_entite;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_entite', $id_entite);
            $stmt->execute();
        }

        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $del = $objet->getIdentifiant();
            $stmt->bindParam(':id', $del);
            $stmt->execute();
        }
    }
}


namespace DAO\Utilisateur
{
	use metier\utilisateur\Utilisateur;

    class UtilisateurDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "utilisateurs");
        }

        public function create($objet)
        {
            $sql= "INSERT INTO $this->table (nom, prenom, login, mdphache, admin, nbessai, mail) values(:nom, :prenom, :login, :mdphache, :admin, :nbessai, :mail)";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $nom=$objet->getNom();
            $prenom=$objet->getPrenom();
            $login=$objet->getLogin();
            $mdphache=$objet->getMdphache();
            $admin=$objet->getAdmin();
            $nbessai=$objet->getNbessai();
			$mail=$objet->getMail();

            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':mdphache', $mdphache);
			$stmt->bindParam(':admin', $admin);
            $stmt->bindParam(':nbessai', $nbessai);
			$stmt->bindParam(':mail', $mail);
            $stmt->execute();
            $identifiant=$this->getLastKey();
            $objet->setIdentifiant($identifiant);
        }

        public function read($login)
        {
            $sql="SELECT * FROM $this->table WHERE login=:login";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':login', $login);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant=$row["identifiant"];
            $nom=$row["nom"];
            $prenom=$row["prenom"];
            $login=$row["login"];
            $mdphache=$row["mdphache"];
			$admin=$row["admin"];
			$nbessai=$row["nbessai"];
			$mail=$row["mail"];

            $rep= new Utilisateur($nom, $prenom, $login, $mdphache, $admin, $nbessai, $mail);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function readId($identifiant)
        {
            $sql="SELECT * FROM $this->table WHERE identifiant=:identifiant";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':identifiant', $identifiant);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant=$row["identifiant"];
            $nom=$row["nom"];
            $prenom=$row["prenom"];
            $login=$row["login"];
            $mdphache=$row["mdphache"];
			$admin=$row["admin"];
			$nbessai=$row["nbessai"];
			$mail=$row["mail"];

            $rep= new Utilisateur($nom, $prenom, $login, $mdphache, $admin, $nbessai, $mail);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

	  public function readDroitAdmin($id)
        {
            $list = [];
            $sql = "SELECT admin FROM $this->table WHERE identifiant= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $admin = $row["admin"];
                $list[].=$admin;
            }
            return $list;
        }

        public function readUtilisateur($util)
        {
            $sql="SELECT * FROM $this->table WHERE mail=:util";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':util', $util);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant= $row["identifiant"];
            $nom=$row["nom"];
            $prenom=$row["prenom"];
            $login=$row["login"];
            $mdphache=$row["mdphache"];
			$admin=$row["admin"];
			$nbessai=$row["nbessai"];
			$mail=$row["mail"];

            $rep= new \metier\utilisateur\Utilisateur($nom, $prenom, $login, $mdphache,$admin,$nbessai, $mail);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function readUtilDroitServ($id_service)
		{
            $sql="SELECT DISTINCT nom, prenom
				FROM $this->table, droits
				WHERE utilisateurs.identifiant IN
					(SELECT id_utilisateur
					FROM droits
					WHERE utilisateurs.identifiant=droits.id_utilisateur AND droits.id_gestionnaire=:id_service)
				ORDER BY nom, prenom;";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_service', $id_service);
            $stmt->execute();
            $rep="";
            while ($row = $stmt->fetch()){
			$nom=$row["nom"];
			$prenom=$row["prenom"];
			$rep.=$nom ." ".$prenom . "<br/> ";
		}
            return $rep;
        }

        public function readUtilDroitServExcept($id_services)
		{
            $sql="SELECT DISTINCT nom, prenom
				FROM $this->table, droits
				WHERE utilisateurs.identifiant IN
					(SELECT id_utilisateur
					FROM droits
					WHERE utilisateurs.identifiant=droits.id_utilisateur AND droits.id_gestionnaire=:id_service AND admin <> 'super admin')
				ORDER BY nom, prenom;";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_service', $id_services);
            $stmt->execute();
            $rep="";
            while ($row = $stmt->fetch()){
			$nom=$row["nom"];
			$prenom=$row["prenom"];
			$rep.=$nom ." ".$prenom . "<br/> ";
		}
            return $rep;
        }

        public function readAll()
        {
            $list = [];
            $sql="SELECT * FROM $this->table ORDER BY nom, prenom";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["identifiant"];
                $nom=$row["nom"];
                $prenom=$row["prenom"];
                $login=$row["login"];
                $mdphache=$row["mdphache"];
				$admin=$row["admin"];
				$nbessai=$row["nbessai"];
				$mail=$row["mail"];

                $rep= new Utilisateur($nom, $prenom, $login, $mdphache,$admin,$nbessai, $mail);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
		}
            return $list;
        }

		public function readIdUtilAdmin($id)
        {
            $list = [];
            $sql="SELECT * FROM $this->table WHERE identifiant= :id OR admin = 'super admin'";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["identifiant"];
                $nom=$row["nom"];
                $prenom=$row["prenom"];
                $login=$row["login"];
                $mdphache=$row["mdphache"];
				$admin=$row["admin"];
				$nbessai=$row["nbessai"];
				$mail=$row["mail"];

                $rep= new Utilisateur($nom, $prenom, $login, $mdphache,$admin,$nbessai, $mail);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
		}
            return $list;
        }

        public function readAllByAdmin($adm)
        {
            $list = [];
            $sql="SELECT distinct login, utilisateurs.identifiant, nom, prenom, mdphache, admin, nbessai, mail FROM $this->table
				INNER JOIN applidroitacces on applidroitacces.id_utilisateur = utilisateurs.identifiant
				INNER JOIN entites on entites.identifiant = applidroitacces.id_entite
				WHERE id_entite IN (SELECT id_entite FROM entites
				INNER JOIN applidroitacces on id_entite = entites.identifiant
				INNER JOIN utilisateurs on utilisateurs.identifiant = id_utilisateur
				WHERE id_utilisateur = ".$adm.")
				ORDER BY nom, prenom";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["identifiant"];
                $nom=$row["nom"];
                $prenom=$row["prenom"];
                $login=$row["login"];
                $mdphache=$row["mdphache"];
				$admin=$row["admin"];
				$nbessai=$row["nbessai"];
				$mail=$row["mail"];

                $rep= new Utilisateur($nom, $prenom, $login, $mdphache,$admin,$nbessai, $mail);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
			}
            return $list;
        }

		public function readAllByAdminExcept($adm)
			{
            $list = [];
            $sql="SELECT distinct login, utilisateurs.identifiant, nom, prenom, mdphache, admin, nbessai, mail FROM $this->table
				INNER JOIN applidroitacces on applidroitacces.id_utilisateur = utilisateurs.identifiant
				INNER JOIN entites on entites.identifiant = applidroitacces.id_entite
				WHERE id_entite IN (SELECT id_entite FROM entites
				INNER JOIN applidroitacces on id_entite = entites.identifiant
				INNER JOIN utilisateurs on utilisateurs.identifiant = id_utilisateur
				WHERE id_utilisateur = ".$adm.")
				AND utilisateurs.admin <> 'super admin'
				ORDER BY nom, prenom";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["identifiant"];
                $nom=$row["nom"];
                $prenom=$row["prenom"];
                $login=$row["login"];
                $mdphache=$row["mdphache"];
				$admin=$row["admin"];
				$nbessai=$row["nbessai"];
				$mail=$row["mail"];

                $rep= new Utilisateur($nom, $prenom, $login, $mdphache,$admin,$nbessai, $mail);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
			}
            return $list;
        }

		public function readAllByAdminExceptAdmin($adm)
			{
            $list = [];
            $sql="SELECT distinct login, utilisateurs.identifiant, nom, prenom, mdphache, admin, nbessai, mail FROM $this->table
				INNER JOIN applidroitacces on applidroitacces.id_utilisateur = utilisateurs.identifiant
				INNER JOIN entites on entites.identifiant = applidroitacces.id_entite
				WHERE id_entite IN (SELECT id_entite FROM entites
				INNER JOIN applidroitacces on id_entite = entites.identifiant
				INNER JOIN utilisateurs on utilisateurs.identifiant = id_utilisateur
				WHERE id_utilisateur = ".$adm.")
				AND utilisateurs.admin <> 'super admin'
				AND utilisateurs.admin <> 'admin'
				ORDER BY nom, prenom";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["identifiant"];
                $nom=$row["nom"];
                $prenom=$row["prenom"];
                $login=$row["login"];
                $mdphache=$row["mdphache"];
				$admin=$row["admin"];
				$nbessai=$row["nbessai"];
				$mail=$row["mail"];

                $rep= new Utilisateur($nom, $prenom, $login, $mdphache,$admin,$nbessai, $mail);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
			}
            return $list;
        }

        public function readAllByAdminFiltre($adm,$ent)
        {
            $list = [];
            $sql="SELECT distinct login, utilisateurs.identifiant, nom, prenom, mdphache, admin, nbessai, mail FROM $this->table
				INNER JOIN applidroitacces on applidroitacces.id_utilisateur = utilisateurs.identifiant
				INNER JOIN entites on entites.identifiant = applidroitacces.id_entite
				WHERE id_entite IN (SELECT id_entite FROM entites
				INNER JOIN applidroitacces on id_entite = entites.identifiant
				INNER JOIN utilisateurs on utilisateurs.identifiant = id_utilisateur
				WHERE id_utilisateur = ".$adm." and id_entite= ".$ent.")
				ORDER BY nom, prenom";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["identifiant"];
                $nom=$row["nom"];
                $prenom=$row["prenom"];
                $login=$row["login"];
                $mdphache=$row["mdphache"];
				$admin=$row["admin"];
				$nbessai=$row["nbessai"];
				$mail=$row["mail"];

                $rep= new Utilisateur($nom, $prenom, $login, $mdphache,$admin,$nbessai, $mail);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
			}
            return $list;
        }

	  public function readAllByAdminExceptFiltre($adm,$ent)
        {
            $list = [];
            $sql="SELECT distinct login, utilisateurs.identifiant, nom, prenom, mdphache, admin, nbessai, mail FROM $this->table
				INNER JOIN applidroitacces on applidroitacces.id_utilisateur = utilisateurs.identifiant
				INNER JOIN entites on entites.identifiant = applidroitacces.id_entite
				WHERE id_entite IN (SELECT id_entite FROM entites
				INNER JOIN applidroitacces on id_entite = entites.identifiant
				INNER JOIN utilisateurs on utilisateurs.identifiant = id_utilisateur
				WHERE id_utilisateur = ".$adm." and id_entite= ".$ent.")
				AND utilisateurs.admin <> 'super admin'
				ORDER BY nom, prenom";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["identifiant"];
                $nom=$row["nom"];
                $prenom=$row["prenom"];
                $login=$row["login"];
                $mdphache=$row["mdphache"];
				$admin=$row["admin"];
				$nbessai=$row["nbessai"];
				$mail=$row["mail"];

                $rep= new Utilisateur($nom, $prenom, $login, $mdphache,$admin,$nbessai, $mail);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
			}
            return $list;
        }

	    function readDeclarant($id)
        {
            $sql = "SELECT nom, prenom FROM utilisateurs WHERE identifiant = '$id'";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            $declarant = $row["nom"]." ".$row["prenom"];

            return $declarant;
        }

        public function readPasswordDb($login)
		{
            //$sql="SELECT mdphache FROM $this->table WHERE $this->key=:login";
            $sql="SELECT mdphache FROM $this->table WHERE login ='$login'";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            //$stmt->bindParam(':login', $login);
            $stmt->execute();
			$row = $stmt->fetch();
            $mdphache=$row["mdphache"];
            return $mdphache;
        }

		/*public function readPasswordDbAdmin($login)
		{
            $sql="SELECT mdphache FROM $this->table WHERE login ='adminSTAVE'";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            //$stmt->bindParam(':login', $login);
            $stmt->execute();
			$row = $stmt->fetch();
            $mdphache=$row["mdphache"];
            return $mdphache;
        }*/

        public function update($objet)
        {
			$sql = "UPDATE $this->table
					SET nom= :nom, prenom = :prenom, login= :login, mdphache= :mdphache, admin= :admin, nbessai= :nbessai, mail= :mail
					WHERE $this->key = :identifiant";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);

			$identifiant = $objet->getIdentifiant();
			$nom = $objet->getNom();
			$prenom = $objet->getPrenom();
			$login=$objet->getLogin();
			$mdphache=$objet->getMdphache();
			$admin=$objet->getAdmin();
			$nbessai=$objet->getNbessai();
			$mail=$objet->getMail();

			$stmt->bindParam(':identifiant', $identifiant);
			$stmt->bindParam(':nom', $nom);
			$stmt->bindParam(':prenom', $prenom);
			$stmt->bindParam(':login', $login);
			$stmt->bindParam(':mdphache', $mdphache);
			$stmt->bindParam(':admin', $admin);
			$stmt->bindParam(':nbessai', $nbessai);
			$stmt->bindParam(':mail', $mail);
			$stmt->execute();
        }

        public function updateEssai($id, $nb)
        {
			$sql = "UPDATE utilisateurs SET nbessai= '$nb' WHERE identifiant = '$id';";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->execute();
        }

        public function delete($id)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }

        public function existNomPrenom($nom,$prenom)
		{
            $req = "SELECT COUNT(*) as nbUtil FROM $this->table WHERE nom = :nom AND prenom = :prenom;";
            $compt= \connexion\connexion\Connexion::getInstance()->prepare($req);
            $compt->bindParam(':nom', $nom);
            $compt->bindParam(':prenom', $prenom);
            $compt->execute();
            $donnee= $compt->fetch();
            $rep=$donnee['nbUtil'];
            return ($rep > 0);
        }

        public function existLogin($login)
		{
            $req = "SELECT COUNT(*) as nbUtil FROM $this->table WHERE login = :login;";
            $compt= \connexion\connexion\Connexion::getInstance()->prepare($req);
            $compt->bindParam(':login', $login);
            $compt->execute();
            $donnee= $compt->fetch();
            $rep=$donnee['nbUtil'];
            return ($rep > 0);
        }

        public function existMail($mail)
		{
            $req = "SELECT COUNT(*) as nbUtil FROM $this->table WHERE mail = :mail;";
            $compt= \connexion\connexion\Connexion::getInstance()->prepare($req);
            $compt->bindParam(':mail', $mail);
            $compt->execute();
            $donnee= $compt->fetch();
            $rep=$donnee['nbUtil'];
            return ($rep > 0);
        }

		public function existNomPrenomNbessai($login)
		{
            $req = "SELECT COUNT(*) as nbUtil FROM $this->table WHERE login = :login AND nbessai < 5;";
            $compt= \connexion\connexion\Connexion::getInstance()->prepare($req);
            $compt->bindParam(':login', $login);
            $compt->execute();
            $donnee= $compt->fetch();
            $rep=$donnee['nbUtil'];
            return ($rep > 0);
        }

		public function readNbessai($login)
		{
            $req = "SELECT nbessai FROM $this->table WHERE login ='$login' AND nbessai < 5;";
            $compt= \connexion\connexion\Connexion::getInstance()->prepare($req);
            //$compt->bindParam(':login', $login);
            $stmt->execute();
            $row = $stmt->fetch();
            $nbessai=$row["nbessai"];
            return $nbessai;
        }
    }
}

namespace DAO\Droit
{
    use DAO\ServiceMunicipal\ServiceMunicipalDAO;
    use metier\droit\Droit;

    class DroitDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "droits");
        }
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (id_utilisateur, id_gestionnaire) values (:id_utilisateur, :id_gestionnaire)";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id_utilisateur = $objet->getId_utilisateur();
            $id_gestionnaire = $objet->getId_gestionnaire();
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->bindParam(':id_gestionnaire', $id_gestionnaire);

            $stmt->execute();

            $id = $this->getLastKey();
            $objet->setIdentifiant($id);
        }

        public function createPush($droit, $utilisateur)
        {
            foreach (explode(',', $droit) as $d){
                $id_utilisateur=$utilisateur;
                $id_gestionnaire=$d;
                $lesdroit= new Droit ($id_utilisateur, $id_gestionnaire);
                $rep= new DroitDAO();
                $rep->create($lesdroit);
            }
        }

        public function read($id)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant = $row["identifiant"];
            $id_formulaire = $row["id_formulaire"];
            $id_gestionnaire = $row["id_gestionnaire"];

            $rep = new \metier\gestionnairedroitacces\Gestionnairedroitacces($id_formulaire, $id_gestionnaire);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function readIdUtil($id)
        {
            $list = [];
            $sql = "SELECT id_gestionnaire FROM $this->table WHERE id_utilisateur= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $id_gestionnaire = $row["id_gestionnaire"];
                $list[].=$id_gestionnaire;
            }
            return $list;
        }

        public function readAll($objet)
        {
            foreach (explode(',', $objet) as $gest){
                $daoG=new ServiceMunicipalDAO();
                $rep=$daoG->readService($gest);
                echo $rep ."<br/>";
            }
        }

		public function readAllSPE($objet)
        {
            foreach (explode(',', $objet) as $gest){
                $daoG=new ServiceMunicipalDAO();
                $rep=$daoG->readServicePoleEntite($gest);
                echo $rep ."<br/>";
            }
        }

		public function readAllServMByUtil($id)
        {
            $list = [];
            $sql = "SELECT distinct id_gestionnaire FROM $this->table WHERE id_utilisateur=".$id;
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $id_gestionnaire = $row["id_gestionnaire"];
                $list[].=$id_gestionnaire;
            }
            return $list;
        }

		public function readAllServMPoleByUtil($id)
        {
            $list = [];
            $sql = "SELECT distinct pole FROM $this->table
				INNER JOIN servicesmunicipaux ON servicesmunicipaux.identifiant = id_gestionnaire
				WHERE id_utilisateur=".$id;
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $pole = $row["pole"];
                $list[].=$pole;
            }
            return $list;
        }

		public function readAllServMEntiteByUtil($id)
        {
            $list = [];
            $sql = "SELECT distinct entite FROM $this->table
				INNER JOIN servicesmunicipaux ON servicesmunicipaux.identifiant = id_gestionnaire
				WHERE id_utilisateur=".$id;
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $entite = $row["entite"];
                $list[].=$entite;
            }
            return $list;
        }

        public function update($objet)
        {
            $sql = "UPDATE $this->table SET id_formulaire= :id_formulaire, id_gestionnaire = :id_gestionnaire WHERE $this->key = :id ;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id = $objet->getIdentifiant();
            $id_formulaire = $objet->getId_formulaire();
            $id_gestionnaire = $objet->getId_gestionnaire();
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_formulaire', $id_formulaire);
            $stmt->bindParam(':id_gestionnaire', $id_gestionnaire);
            $stmt->execute();
        }

        public function updatePush($id_utilisateur, $ancienDroit, $nouveauxDroit)
        {
            foreach (explode(',', $ancienDroit) as $id_gestionnaire){
                $sql= "DELETE FROM $this->table WHERE id_utilisateur= :idutil AND id_gestionnaire= :idserv";
                $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
                $stmt->bindParam(":idutil", $id_utilisateur);
                $stmt->bindParam(":idserv", $id_gestionnaire);
                $stmt->execute();
            }
            foreach (explode(',', $nouveauxDroit) as $service){
                $id_gestionnaire=$service;
                $gestionnaire= new Droit($id_utilisateur, $id_gestionnaire);
                $rep= new DroitDAO();
                $rep->create($gestionnaire);
            }
        }

		public function updatePushEntite($id_utilisateur, $ancienDroit, $nouveauxDroit)
		{
			foreach (explode(',', $ancienDroit) as $id_gestionnaire){
				$sql= "DELETE FROM $this->table WHERE id_utilisateur= :idutil AND id_gestionnaire= :idserv";
				$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
				$stmt->bindParam(":idutil", $id_utilisateur);
				$stmt->bindParam(":idserv", $id_gestionnaire);
				$stmt->execute();
			}
			foreach (explode(',', $nouveauxDroit) as $entite){
			//requete de sélection des services et insertion des nouveaux droits
			$sql = "SELECT * FROM servicesmunicipaux WHERE entite = ".$entite." ORDER BY entite, service asc";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				$identifiant = $row["identifiant"];
				$service = $row["service"];
				$pole = $row["pole"];
				$entite = $row["entite"];
				$gestionnaire= new Droit($id_utilisateur, $identifiant);
				$rep= new DroitDAO();
				$rep->create($gestionnaire);
				}
			}
		}

		public function updatePushPole($id_utilisateur, $ancienDroit, $nouveauxDroit)
        {
            foreach (explode(',', $ancienDroit) as $id_gestionnaire){
                $sql= "DELETE FROM $this->table WHERE id_utilisateur= :idutil AND id_gestionnaire= :idserv";
                $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
                $stmt->bindParam(":idutil", $id_utilisateur);
                $stmt->bindParam(":idserv", $id_gestionnaire);
                $stmt->execute();
            }
            foreach (explode(',', $nouveauxDroit) as $pole){
				//requete de sélection des services et insertion des nouveaux droits
				$sql = "SELECT * FROM servicesmunicipaux WHERE pole = ".$pole." ORDER BY pole, service asc";
				$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch()) {
					$identifiant = $row["identifiant"];
					$service = $row["service"];
					$pole = $row["pole"];
					$entite = $row["entite"];
					$gestionnaire= new Droit($id_utilisateur, $identifiant);
					$rep= new DroitDAO();
					$rep->create($gestionnaire);
				}
            }
        }

        public function deleteDroitUtil($id_utilisateur)
        {
            $sql = "DELETE FROM $this->table WHERE id_utilisateur= :idutil;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idutil', $id_utilisateur);
            $stmt->execute();
        }

		public function deleteDroitUtilAfterUpdate($id_utilisateur)
        {
            $sql = "DELETE FROM $this->table
					WHERE id_utilisateur= :idutil AND id_gestionnaire NOT IN
						(SELECT servicesmunicipaux.identifiant
						FROM servicesmunicipaux
						INNER JOIN applidroitacces ON servicesmunicipaux.entite = applidroitacces.id_entite
						WHERE id_utilisateur= :idutil);";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idutil', $id_utilisateur);
            $stmt->execute();
        }

        public function deleteDroitServ($id_gestionnaire)
        {
            $sql = "DELETE FROM $this->table WHERE id_gestionnaire= :idgest;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idgest', $id_gestionnaire);
            $stmt->execute();
        }

        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }
}

namespace DAO\VariableGlobale
{
	use metier\variableglobale\VariableGlobale;

    class VariableGlobaleDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "variablesglobales");
        }

        public function create($objet)
        {
            $sql= "INSERT INTO $this->table (varnom,varvaleur) values(:varnom, :varvaleur)";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $varnom=$objet->getVarnom();
            $varvaleur=$objet->getVarvaleur();

            $stmt->bindParam(':varnom', $varnom);
            $stmt->bindParam(':varvaleur', $varvaleur);
            $stmt->execute();
            $identifiant=$this->getLastKey();
            $objet->setIdentifiant($identifiant);
        }

        public function read($varnom)
        {
            $sql="SELECT * FROM $this->table WHERE varnom=:varnom";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':varnom', $varnom);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant=$row["identifiant"];
            $varnom=$row["varnom"];
            $varvaleur=$row["varvaleur"];

            $rep= new VariableGlobale($varnom, $varvaleur);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function readAll()
        {
            $list = [];
            $sql="SELECT * FROM $this->table";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["identifiant"];
                $varnom=$row["varnom"];
                $varvaleur=$row["varvaleur"];
                $rep= new VariableGlobale($varnom, $varvaleur);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
			}
            return $list;
        }

        public function update($objet)
        {
			$sql = "UPDATE $this->table SET varnom= :varnom, varvaleur = :varvaleur WHERE $this->key = :id ;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$id = $objet->getIdentifiant();
			$varnom = $objet->getVarnom();
			$varvaleur = $objet->getVarvaleur();

			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':varnom', $varnom);
			$stmt->bindParam(':varvaleur', $varvaleur);

			$stmt->execute();
        }

        public function delete($id)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }
}

namespace DAO\FormulaireCommentaire
{
	use metier\formulairecommentaire\FormulaireCommentaire;

    class FormulaireCommentaireDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("formcom_index", "formulairecommentaire");
        }

        public function create($objet)
        {
            $sql= "INSERT INTO $this->table (formcom_champconcerne,formcom_commentaire, formcom_libelle) values(:formcom_champconcerne, :formcom_commentaire, :formcom_libelle)";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $formcom_champconcerne=$objet->getFormcom_champconcerne();
            $formcom_commentaire=$objet->getFormcom_commentaire();
            $formcom_libelle=$objet->getFormcom_libelle();

            $stmt->bindParam(':formcom_champconcerne', $formcom_champconcerne);
            $stmt->bindParam(':formcom_commentaire', $formcom_commentaire);
            $stmt->bindParam(':formcom_libelle', $formcom_libelle);
            $stmt->execute();
            $identifiant=$this->getLastKey();
            $objet->setIdentifiant($identifiant);
        }

        public function read($formcom_champconcerne)
        {
            $sql="SELECT * FROM $this->table WHERE formcom_champconcerne=:formcom_champconcerne";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':formcom_champconcerne', $formcom_champconcerne);
            $stmt->execute();

            $row = $stmt->fetch();
            if ($row) {
                $identifiant=$row["formcom_index"] ;
                $formcom_champconcerne=$row["formcom_champconcerne"];
                $formcom_commentaire=$row["formcom_commentaire"];
                $formcom_libelle=$row["formcom_libelle"] ;
    
                $rep= new FormulaireCommentaire($formcom_champconcerne, $formcom_commentaire, $formcom_libelle);
                $rep->setIdentifiant($identifiant);
                return $rep;
            }
            return new FormulaireCommentaire();
        }

        public function readAll()
        {
            $list = [];
            $sql="SELECT * FROM $this->table";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["formcom_index"];
                $formcom_champconcerne=$row["formcom_champconcerne"];
                $formcom_commentaire=$row["formcom_commentaire"];
                $formcom_libelle=$row["formcom_libelle"];
                $rep= new FormulaireCommentaire($formcom_champconcerne, $formcom_commentaire, $formcom_libelle);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
			}
            return $list;
        }

        public function update($objet)
        {
			$sql = "UPDATE $this->table SET formcom_champconcerne= :formcom_champconcerne, formcom_commentaire = :formcom_commentaire, formcom_libelle = :formcom_libelle WHERE $this->key = :id ;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$id = $objet->getIdentifiant();
			$formcom_champconcerne = $objet->getFormcom_champconcerne();
			$formcom_commentaire = $objet->getFormcom_commentaire();
			$formcom_libelle = $objet->getFormcom_libelle();

			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':formcom_champconcerne', $formcom_champconcerne);
			$stmt->bindParam(':formcom_commentaire', $formcom_commentaire);
			$stmt->bindParam(':formcom_libelle', $formcom_libelle);

			$stmt->execute();
        }

        public function delete($id)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }
}

namespace DAO\Catdonneeformulaire
{
	use metier\catdonneeformulaire\Catdonneeformulaire;

    class CatdonneeformulaireDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "catdonneeformulaire");
        }

        public function create($objet)
        {
            $sql= "INSERT INTO $this->table (libelle, infobulle) values(:libelle, :infobulle)";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $libelle=$objet->getLibelle();

            $stmt->bindParam(':libelle', $libelle);
            $stmt->bindParam(':infobulle', $infobulle);
            $stmt->execute();
            $identifiant=$this->getLastKey();
            $objet->setIdentifiant($identifiant);
        }

        public function read($libelle)
        {
            $sql="SELECT * FROM $this->table WHERE libelle=:libelle";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':libelle', $libelle);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant=$row["identifiant"];
            $libelle=$row["libelle"];
            $infobulle=$row["infobulle"];

            $rep= new Catdonneeformulaire($libelle,$infobulle);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function readAll()
        {
            $list = [];
            $sql="SELECT * FROM $this->table";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["identifiant"];
                $libelle=$row["libelle"];
                $infobulle=$row["infobulle"];
                $rep= new Catdonneeformulaire($libelle,$infobulle);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
			}
            return $list;
        }

        public function update($objet)
        {
			$sql = "UPDATE $this->table SET libelle = :libelle, infobulle = :infobulle WHERE $this->key = :id ;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$id = $objet->getIdentifiant();
			$libelle = $objet->getLibelle();
			$infobulle = $objet->getInfobulle();

			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':libelle', $libelle);
            $stmt->bindParam(':infobulle', $infobulle);
			$stmt->execute();
        }

        public function delete($id)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }
}

namespace DAO\Catliceiteformulaire
{
	use metier\catliceiteformulaire\Catliceiteformulaire;

    class CatliceiteformulaireDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "catliceiteformulaire");
        }

        public function create($objet)
        {
            $sql= "INSERT INTO $this->table (libelle, infobulle) values(:libelle, :infobulle)";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $libelle=$objet->getLibelle();

            $stmt->bindParam(':libelle', $libelle);
            $stmt->bindParam(':infobulle', $infobulle);
            $stmt->execute();
            $identifiant=$this->getLastKey();
            $objet->setIdentifiant($identifiant);
        }

        public function read($libelle)
        {
            $sql="SELECT * FROM $this->table WHERE libelle=:libelle";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':libelle', $libelle);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant=$row["identifiant"];
            $libelle=$row["libelle"];
            $infobulle=$row["infobulle"];

            $rep= new Catliceiteformulaire($libelle,$infobulle);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

        public function readAll()
        {
            $list = [];
            $sql="SELECT * FROM $this->table";
            $stmt= \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $identifiant= $row["identifiant"];
                $libelle=$row["libelle"];
                $infobulle=$row["infobulle"];
                $rep= new Catliceiteformulaire($libelle,$infobulle);
                $rep->setIdentifiant($identifiant);
                $list[] = $rep;
			}
            return $list;
        }

        public function update($objet)
        {
			$sql = "UPDATE $this->table SET libelle = :libelle, infobulle = :infobulle WHERE $this->key = :id ;";
			$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
			$id = $objet->getIdentifiant();
			$libelle = $objet->getLibelle();
			$infobulle = $objet->getInfobulle();

			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':libelle', $libelle);
            $stmt->bindParam(':infobulle', $infobulle);
			$stmt->execute();
        }

        public function delete($id)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }
}

namespace DAO\Entitepole
{
	use DAO\pole\PoleDAO;
	use DAO\entite\EntiteDAO;
	use DAO\ServiceMunicipal\ServiceMunicipalDAO;
	use metier\entitepole\Entitepole;

    class EntitepoleDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("identifiant", "entitepole");
        }
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (id_pole, id_entite) values (:id_pole, :id_entite)";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id_pole = $objet->getId_pole();
            $id_entite = $objet->getId_entite();
            $stmt->bindParam(':id_pole', $id_pole);
            $stmt->bindParam(':id_entite', $id_entite);
            $stmt->execute();

            $id = $this->getLastKey();
            $objet->setIdentifiant($id);
        }

        public function read($id)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch();
            $identifiant = $row["identifiant"];
            $id_pole = $row["id_pole"];
            $id_entite = $row["id_entite"];

            $rep = new \metier\entitepole\Entitepole($id_pole, $id_entite);
            $rep->setIdentifiant($identifiant);
            return $rep;
        }

	public function readCountPoleEntite($id)
        {
            $sql = "SELECT COUNT(*) as nbPol FROM $this->table WHERE id_entite= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();
            $nbPol=$row["nbPol"];
            return $nbPol;
        }

        public function readIdpolebyentite($id)
        {
            $list = [];
            $sql = "SELECT id_pole FROM $this->table WHERE id_entite= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $id_pole = $row["id_pole"];
                $list[].=$id_pole;
            }
            return $list;
        }

        public function readIdentitebypole($id)
        {
            $list = [];
            $sql = "SELECT id_entite FROM $this->table WHERE id_pole= :id";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $id_entite = $row["id_entite"];
                $list[].=$id_entite;
            }
            return $list;
        }

        public function readAll($objet)
        {
            foreach (explode(',', $objet) as $ent){
                $daoE=new EntiteDAO();
                $rep=$daoE->readEntite($ent);
                echo $rep ."<br/>";
            }
        }

        public function updatePush($id_pole, $ancien, $nouveau)
        {
            foreach (explode(',', $ancien) as $id_entite){
                $sql= "DELETE FROM $this->table WHERE id_pole= :id_pole AND id_entite= :id_entite";
                $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
                $stmt->bindParam(":id_pole", $id_pole);
                $stmt->bindParam(":id_entite", $id_entite);
                $stmt->execute();
            }
           foreach (explode(',', $nouveau) as $ent){
                $id_entite=$ent;
                $entite= new Entitepole($id_pole, $id_entite);
                $rep= new EntitepoleDAO();
                $rep->create($entite);
            }
        }

        public function update($objet)
        {
            $sql = "UPDATE $this->table SET id_pole= :id_pole, id_entite = :id_entite WHERE $this->key = :id ;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $id = $objet->getIdentifiant();
            $id_pole = $objet->getId_pole();
            $id_entite = $objet->getId_entite();
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_pole', $id_pole);
            $stmt->bindParam(':id_entite', $id_entite);
            $stmt->execute();
        }

        public function deleteBypol($id_pole)
        {
            $sql = "DELETE FROM $this->table WHERE id_pole= :id_pole;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_pole', $id_pole);
            $stmt->execute();
        }

        public function deleteByent($id_entite)
        {
            $sql = "DELETE FROM $this->table WHERE id_entite= :id_entite;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id_entite', $id_entite);
            $stmt->execute();
        }

        public function delete($id)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id;";
            $stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }
}


