<?php
/*A AJOUTER EN DEBUT DES PAGES*/
include("admin_header.php");
include ("connexion/Daos.php");

use DAO\Formulaire\FormulaireDAO;
use DAO\FormulaireCommentaire\FormulaireCommentaireDAO;
use DAO\VariableGlobale\VariableGlobaleDAO;

session_start();
include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/
?>

<?php 
// modifications des infobulles
if (isset($_POST["valider"])) {
	$inf = new FormulaireCommentaireDAO();
    $readAll = $inf->readAll();
	$i=1;
	foreach ($readAll as $key => $fc) {
		$fmId = $fc->getIdentifiant();
		$fmChamp = $fc->getFormcom_champconcerne();
		$fmCom = $fc->getFormcom_commentaire();
		$sql = "UPDATE formulairecommentaire SET  formcom_commentaire = '".addslashes($_POST[$fmChamp])."' WHERE formcom_champconcerne = '$fmChamp'";
		$stmt = \connexion\connexion\Connexion::getInstance()->prepare($sql);
		$stmt->execute();
		$i++;
	}

	$message='Infobulles modifiées avec succès';
	//echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
	//echo '<script type="text/javascript">window.location="admin_tableau.php"</script>';
} 

?>

<div class="container">
<a href="admin_all.php">Menu général</a> / Informations formulaire
</div>

<div class="centrer">
<h1 class="centrer">Modifier les informations des formulaires (infobulles)</h1></div>
<div class="container">
<div class="row">
<div class="col-lg-12">

<form method="POST" action="">
<fieldset>
<h4>Modifier les infobulles</h4>
<?php
echo "<table>
	<tr><th class='col-md-3'>Champs de la table</th><th class='col-md-9'>Informations</th>";

        $inf = new FormulaireCommentaireDAO();
        $readAll = $inf->readAll();
		foreach ($readAll as $key => $fc) {
			$fmId = $fc->getIdentifiant();
			$fmChamp = $fc->getFormcom_champconcerne();
			$fmLibelle = $fc->getFormcom_libelle();
			$fmCom = $fc->getFormcom_commentaire();
                	echo "<tr><td>".$fmLibelle."</td>";
			echo "<td><textarea name='".$fmChamp."' class='form-control' rows='1' cols='60'>".$fmCom."</textarea>";
		}
		echo "</table>";
?>

<p><input type="submit" class="btn btn-success btn-lg" value="Valider les modifications" name="valider"/></p>
</fieldset></form></div></div>

<?php
include("footer.php");
?>