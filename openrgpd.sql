-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: 192.168.2.150    Database: openRGPD
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.41-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `applidroitacces`
--

DROP TABLE IF EXISTS `applidroitacces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applidroitacces` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `id_entite` int(11) NOT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB AUTO_INCREMENT=397 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applidroitacces`
--

LOCK TABLES `applidroitacces` WRITE;
/*!40000 ALTER TABLE `applidroitacces` DISABLE KEYS */;
INSERT INTO `applidroitacces` VALUES (396,1,85);
/*!40000 ALTER TABLE `applidroitacces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catdonneeformulaire`
--

DROP TABLE IF EXISTS `catdonneeformulaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catdonneeformulaire` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(250) DEFAULT NULL,
  `infobulle` longtext,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catdonneeformulaire`
--

LOCK TABLES `catdonneeformulaire` WRITE;
/*!40000 ALTER TABLE `catdonneeformulaire` DISABLE KEYS */;
INSERT INTO `catdonneeformulaire` VALUES (1,'Etat-civil, identité, données d\'identification','Nom, prénom, adresse, photographie, lieu de naissance, autres'),(2,'Vie personnelle','Habitudes de vie, situation familiale, autres'),(3,'Vie professionnelle','CV, situation professionnelle, scolarité, formation, distinction, autres'),(4,'Information d\'ordre économique et financier','Revenus, situation financière (taux d\'endettement), autres'),(5,'Données de connexion','Adresse IP, logs, identifiant de terminaux, identifiant de connexion\r\n, information d\'horodatage, autres'),(6,'Données sensibles','Origines raciales, origines ethniques, opinions philosophiques, opinions politiques, opinions syndicales, opinions religieuses, vie sexuelle, santé des personnes, données génétiques, infractions, condamnations et mesures de sécurité, appréciation sur les difficultés sociales des personnes');
/*!40000 ALTER TABLE `catdonneeformulaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catliceiteformulaire`
--

DROP TABLE IF EXISTS `catliceiteformulaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catliceiteformulaire` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `infobulle` longtext CHARACTER SET utf8mb4,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catliceiteformulaire`
--

LOCK TABLES `catliceiteformulaire` WRITE;
/*!40000 ALTER TABLE `catliceiteformulaire` DISABLE KEYS */;
INSERT INTO `catliceiteformulaire` VALUES (1,'Consentement','Le type de consentement de la personne'),(2,'Contrat','Le traitement est nécessaire à l’exécution d’un contrat (par exemple, pour nous les usagers du service d’eau)'),(3,'Obligation légale','Le traitement est nécessaire à une obligation légale (par exemple les impôts)'),(4,'Intérêts vitaux',' Le traitement est nécessaire à la sauvegarde des intérêts vitaux de la personne (bouton d’alarme dans les ehpads ?)'),(5,'Mission d\'intérêt public','Le traitement est nécessaire à l’exécution d’une mission d’intérêt public'),(6,'Fins légitime du RT','Le traitement est nécessaire aux fins des intérêts légitimes du RT (par exemple, une collectivité qui inspecte la performance d’un délégataire de transport)');
/*!40000 ALTER TABLE `catliceiteformulaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `droits`
--

DROP TABLE IF EXISTS `droits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `droits` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `id_gestionnaire` int(11) NOT NULL,
  PRIMARY KEY (`identifiant`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_gestionnaire` (`id_gestionnaire`),
  CONSTRAINT `droits_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`identifiant`),
  CONSTRAINT `droits_ibfk_2` FOREIGN KEY (`id_gestionnaire`) REFERENCES `servicesmunicipaux` (`identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `droits`
--

LOCK TABLES `droits` WRITE;
/*!40000 ALTER TABLE `droits` DISABLE KEYS */;
/*!40000 ALTER TABLE `droits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entitepole`
--

DROP TABLE IF EXISTS `entitepole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entitepole` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `id_pole` int(11) DEFAULT NULL,
  `id_entite` int(11) DEFAULT NULL,
  PRIMARY KEY (`identifiant`),
  UNIQUE KEY `identifiant_UNIQUE` (`identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entitepole`
--

LOCK TABLES `entitepole` WRITE;
/*!40000 ALTER TABLE `entitepole` DISABLE KEYS */;
/*!40000 ALTER TABLE `entitepole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entites`
--

DROP TABLE IF EXISTS `entites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entites` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `entite` varchar(255) DEFAULT NULL,
  `maildpd` varchar(255) DEFAULT NULL,
  `responsable` varchar(255) DEFAULT NULL,
  `siret` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entites`
--

LOCK TABLES `entites` WRITE;
/*!40000 ALTER TABLE `entites` DISABLE KEYS */;
INSERT INTO `entites` VALUES (85,'Entite 1','admin@openRGPD.fr','Admin Entite 1','12345678912345');
/*!40000 ALTER TABLE `entites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `formu`
--

DROP TABLE IF EXISTS `formu`;
/*!50001 DROP VIEW IF EXISTS `formu`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `formu` AS SELECT
 1 AS `identifiant`,
 1 AS `nomLogiciel`,
 1 AS `origineDonnee`,
 1 AS `validationDPD`,
 1 AS `finaliteTraitement`,
 1 AS `sousFinalite`,
 1 AS `commentaire`,
 1 AS `dateMiseEnOeuvre`,
 1 AS `catDonneeTraitee`,
 1 AS `catPersConcern`,
 1 AS `destiDonnees`,
 1 AS `dureeUtiliteAdmi`,
 1 AS `archivage`,
 1 AS `transfertHorsUE`,
 1 AS `catLiceiteTraitee`,
 1 AS `coRespTraitement`,
 1 AS `representantCoResp`,
 1 AS `sousTraitant`,
 1 AS `delaiEffacement`,
 1 AS `support`,
 1 AS `niveau_identification`,
 1 AS `com_ident`,
 1 AS `niveau_securite`,
 1 AS `com_secu`,
 1 AS `derniereMAJ`,
 1 AS `declarant`,
 1 AS `donneePIA`,
 1 AS `PIA`,
 1 AS `horsRegistre`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `formulaire`
--

DROP TABLE IF EXISTS `formulaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formulaire` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `nomLogiciel` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `origineDonnee` varchar(255) NOT NULL,
  `validationDPD` date NOT NULL,
  `finaliteTraitement` longtext NOT NULL,
  `sousFinalite` longtext NOT NULL,
  `commentaire` longtext NOT NULL,
  `dateMiseEnOeuvre` date NOT NULL,
  `catDonneeTraitee` longtext NOT NULL,
  `catPersConcern` longtext NOT NULL,
  `destiDonnees` longtext NOT NULL,
  `dureeUtiliteAdmi` longtext NOT NULL,
  `archivage` longtext NOT NULL,
  `transfertHorsUE` tinyint(1) NOT NULL,
  `catLiceiteTraitee` longtext NOT NULL,
  `coRespTraitement` varchar(255) NOT NULL,
  `representantCoResp` varchar(255) NOT NULL,
  `sousTraitant` varchar(255) NOT NULL,
  `delaiEffacement` varchar(255) NOT NULL,
  `support` longtext NOT NULL,
  `niveau_identification` int(11) NOT NULL,
  `com_ident` longtext,
  `niveau_securite` int(11) NOT NULL,
  `com_secu` longtext,
  `derniereMAJ` date NOT NULL,
  `declarant` int(11) NOT NULL,
  `donneePIA` tinyint(1) DEFAULT NULL,
  `PIA` longtext,
  `horsRegistre` varchar(45) DEFAULT NULL,
  `planAction` longtext,
  `baseJuridique` longtext,
   `baseJuridiqueLiceite` longtext,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulaire`
--

LOCK TABLES `formulaire` WRITE;
/*!40000 ALTER TABLE `formulaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `formulaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formulairecommentaire`
--

DROP TABLE IF EXISTS `formulairecommentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formulairecommentaire` (
  `formcom_index` int(11) NOT NULL AUTO_INCREMENT,
  `formcom_champconcerne` varchar(200) DEFAULT NULL,
  `formcom_commentaire` varchar(1000) DEFAULT NULL,
  `formcom_libelle` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`formcom_index`),
  UNIQUE KEY `formcom_index_UNIQUE` (`formcom_index`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulairecommentaire`
--

LOCK TABLES `formulairecommentaire` WRITE;
/*!40000 ALTER TABLE `formulairecommentaire` DISABLE KEYS */;
INSERT INTO `formulairecommentaire` VALUES (1,'catDonneeTraitee','Exemple : Nom, prénom, services, droits d\'accès, données de facturation, coordonnées bancaires','Catégorie de données traitées'),(2,'catPersConcern','Les personnes recensées/concernées dans le traitement. Exemple : Agents, Candidats aux marchés publics','Catégorie de personnes concernées'),(3,'commentaire','Précisions sur le traitement, ce champ peut servir à poser des questions à votre délégué à la protection des données','Commentaire sur le traitement'),(4,'servicesMunicipaux','','Service'),(5,'dateMiseEnOeuvre','Date de la première utilisation du traitement (01/01/2010 si non connue)','Date de mise en oeuvre'),(6,'gestionnaire','Gestionnaire des données','Gestionnaire du traitement'),(7,'responsable','Exécutif de votre collectivité. ex : maire, président du CCAS, président du syndicat,...','Responsable du traitement'),(8,'dureeUtiliteAdmi','Durée d\'utilité administrative des données','Durée d\'utilité administrative'),(9,'delaiEffacement','Délai d\'effacement des données','Délai d\'effacement de la donnée'),(10,'consentement','Consentement de la personne quant à  l\'utilisation des données','Consentement de la personne'),(11,'archivage','Délai d’utilité administrative, tri, conservation, destruction','Archivage de la donnée'),(12,'transfertHorsUE','Les données sont-elles transférées hors de l\'UE','Transfert Hors UE'),(13,'donneeCons','Exécution d’un contrat (traitement est nécessaire à l\'exécution d\'un contrat auquel la personne concernée est partie). Le traitement est nécessaire au respect d\'une obligation légale (idéalement texte de loi). Le traitement est nécessaire à l\'exécution d\'une mission d\'intérêt public ou relevant de l\'exercice de l\'autorité publique dont est investi le responsable du traitement','Consentement de la personne'),(14,'coRespTraitement','Éventuelle collectivité ayant codécidé la mise en œuvre de ce traitement','Co-responsable du traitement'),(15,'representantCoResp','Représentant du co-responsable','Représentant du co-responsable'),(16,'sousTraitant','Tout prestataire manipulant la donnée','Sous-traitant'),(17,'niveau_identification','','Niveau d\'identification'),(18,'com_ident','Commentaire identification','Commentaire identification'),(19,'niveau_securite','Niveau de sécurité','Niveau de sécurité'),(20,'com_secu','Commentaire de sécurité','Commentaire de sécurité'),(21,'nomLogiciel','Permet de nommer le traitement concerné','Nom du traitement'),(22,'numeroDeclaration','Prévu pour garder une trace d\'une éventuelle déclaration CNIL (avant la RGPD)','Numero de déclaration'),(23,'validationDPD','Validation du traitement par le DPD','Validation du DPD'),(24,'finaliteTraitement','Objectif principal d’un traitement de données personnelles. Exemples de finalité : gestion des recrutements, gestion des clients, enquête de satisfaction, surveillance des locaux, etc.','Finalité du traitement'),(25,'sousFinalite','Objectif(s) secondaire(s) d\'un traitement de données personnelles - rare','Sous finalité du traitement'),(26,'destiDonnee','Destinataire des données','Destinataire des données'),(27,'origineDonnee','Tiers, autres entités publiques, usagers','Orgines des donnes'),(28,'donneePIA','test','Donnee PIA O/N'),(29,'PIA','test2','Commentaire sur le PIA'),(30,'catLiceiteTraitee','Motifs de licéité du traitement','Licéité du traitement'),(31,'planAction','Plan d\'action du DPD','Plan d\'action du DPD'),(32,'baseJuridique','Base juridique du traitement','Base juridique du traitement');
/*!40000 ALTER TABLE `formulairecommentaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestionnairesdroitacces`
--

DROP TABLE IF EXISTS `gestionnairesdroitacces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gestionnairesdroitacces` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `id_formulaire` int(11) NOT NULL,
  `id_gestionnaire` int(11) DEFAULT NULL,
  PRIMARY KEY (`identifiant`),
  KEY `id_formulaire` (`id_formulaire`),
  KEY `test_idx` (`id_gestionnaire`),
  CONSTRAINT `gestionnairesdroitacces_ibfk_2` FOREIGN KEY (`id_formulaire`) REFERENCES `formulaire` (`identifiant`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestionnairesdroitacces`
--

LOCK TABLES `gestionnairesdroitacces` WRITE;
/*!40000 ALTER TABLE `gestionnairesdroitacces` DISABLE KEYS */;
/*!40000 ALTER TABLE `gestionnairesdroitacces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modele`
--

DROP TABLE IF EXISTS `modele`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modele` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `nomlogiciel` varchar(255) NOT NULL,
  `finaliteTraitement` longtext NOT NULL,
  `sousFinalite` longtext NOT NULL,
  `commentaire` longtext NOT NULL,
  `catDonneeTraitee` longtext NOT NULL,
  `catPersConcern` longtext NOT NULL,
  `destiDonnees` longtext NOT NULL,
  `dureeUtiliteAdmi` longtext NOT NULL,
  `archivage` longtext NOT NULL,
  `transfertHorsUE` longtext NOT NULL,
  `donneeConsentement` varchar(255) NOT NULL,
  `delaiEffacement` varchar(255) NOT NULL,
  `consentement` varchar(255) NOT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modele`
--

LOCK TABLES `modele` WRITE;
/*!40000 ALTER TABLE `modele` DISABLE KEYS */;
/*!40000 ALTER TABLE `modele` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `nom_gestda`
--

DROP TABLE IF EXISTS `nom_gestda`;
/*!50001 DROP VIEW IF EXISTS `nom_gestda`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `nom_gestda` AS SELECT
 1 AS `id_formulaire`,
 1 AS `Gestionnairesdudroitdacces`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `poles`
--

DROP TABLE IF EXISTS `poles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poles` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `pole` varchar(255) NOT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poles`
--

LOCK TABLES `poles` WRITE;
/*!40000 ALTER TABLE `poles` DISABLE KEYS */;
/*!40000 ALTER TABLE `poles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicesmunicipaux`
--

DROP TABLE IF EXISTS `servicesmunicipaux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicesmunicipaux` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `service` varchar(255) NOT NULL,
  `pole` int(11) NOT NULL,
  `entite` int(11) NOT NULL,
  PRIMARY KEY (`identifiant`),
  KEY `pole` (`pole`),
  KEY `jhg_idx` (`entite`),
  CONSTRAINT `entites` FOREIGN KEY (`entite`) REFERENCES `entites` (`identifiant`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `servicesmunicipaux_ibfk_1` FOREIGN KEY (`pole`) REFERENCES `poles` (`identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicesmunicipaux`
--

LOCK TABLES `servicesmunicipaux` WRITE;
/*!40000 ALTER TABLE `servicesmunicipaux` DISABLE KEYS */;
/*!40000 ALTER TABLE `servicesmunicipaux` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateurs` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `login` varchar(25) NOT NULL,
  `mdphache` varchar(255) NOT NULL,
  `admin` varchar(45) NOT NULL,
  `nbessai` int(1) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateurs`
--

LOCK TABLES `utilisateurs` WRITE;
/*!40000 ALTER TABLE `utilisateurs` DISABLE KEYS */;
INSERT INTO `utilisateurs` VALUES (1,'ADMIN','ADMIN','ADMIN','$2y$10$QRUHwkP3qujjz5FgT2M5nuvtwgWl3qvD3KXfaOnAHiFU389L9wmKu','super admin',0,'assistance@openrgpd.fr');
/*!40000 ALTER TABLE `utilisateurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variablesglobales`
--

DROP TABLE IF EXISTS `variablesglobales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variablesglobales` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `varnom` varchar(100) DEFAULT NULL,
  `varvaleur` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`identifiant`),
  UNIQUE KEY `identifiant_UNIQUE` (`identifiant`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variablesglobales`
--

LOCK TABLES `variablesglobales` WRITE;
/*!40000 ALTER TABLE `variablesglobales` DISABLE KEYS */;
INSERT INTO `variablesglobales` VALUES (1,'dpdmail','yohann.plard@saint-ave.fr'),(2,'bandeau','bandeau.png');
/*!40000 ALTER TABLE `variablesglobales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `formu`
--

/*!50001 DROP VIEW IF EXISTS `formu`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `formu` AS select `formulaire`.`identifiant` AS `identifiant`,`formulaire`.`nomLogiciel` AS `nomLogiciel`,`formulaire`.`origineDonnee` AS `origineDonnee`,`formulaire`.`validationDPD` AS `validationDPD`,`formulaire`.`finaliteTraitement` AS `finaliteTraitement`,`formulaire`.`sousFinalite` AS `sousFinalite`,`formulaire`.`commentaire` AS `commentaire`,`formulaire`.`dateMiseEnOeuvre` AS `dateMiseEnOeuvre`,`formulaire`.`catDonneeTraitee` AS `catDonneeTraitee`,`formulaire`.`catPersConcern` AS `catPersConcern`,`formulaire`.`destiDonnees` AS `destiDonnees`,`formulaire`.`dureeUtiliteAdmi` AS `dureeUtiliteAdmi`,`formulaire`.`archivage` AS `archivage`,`formulaire`.`transfertHorsUE` AS `transfertHorsUE`,`formulaire`.`catLiceiteTraitee` AS `catLiceiteTraitee`,`formulaire`.`coRespTraitement` AS `coRespTraitement`,`formulaire`.`representantCoResp` AS `representantCoResp`,`formulaire`.`sousTraitant` AS `sousTraitant`,`formulaire`.`delaiEffacement` AS `delaiEffacement`,`formulaire`.`support` AS `support`,`formulaire`.`niveau_identification` AS `niveau_identification`,`formulaire`.`com_ident` AS `com_ident`,`formulaire`.`niveau_securite` AS `niveau_securite`,`formulaire`.`com_secu` AS `com_secu`,`formulaire`.`derniereMAJ` AS `derniereMAJ`,`formulaire`.`declarant` AS `declarant`,`formulaire`.`donneePIA` AS `donneePIA`,`formulaire`.`PIA` AS `PIA`,`formulaire`.`horsRegistre` AS `horsRegistre` from `formulaire` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `nom_gestda`
--

/*!50001 DROP VIEW IF EXISTS `nom_gestda`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `nom_gestda` AS select `gestionnairesdroitacces`.`id_formulaire` AS `id_formulaire`,group_concat(`servicesmunicipaux`.`service` separator ',') AS `Gestionnairesdudroitdacces` from (`gestionnairesdroitacces` join `servicesmunicipaux` on((`servicesmunicipaux`.`identifiant` = `gestionnairesdroitacces`.`id_gestionnaire`))) group by `gestionnairesdroitacces`.`id_formulaire` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-06 16:16:23
