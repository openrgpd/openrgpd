<?php
/*A AJOUTER EN DEBUT DES PAGES*/
include("admin_header.php");
include ("connexion/Daos.php");

use DAO\Formulaire\FormulaireDAO;
use DAO\Catliceiteformulaire\CatliceiteformulaireDAO;
use metier\catliceiteformulaire\Catliceiteformulaire;
use DAO\VariableGlobale\VariableGlobaleDAO;

session_start();
include("connexion/check_admin.php");
include("admin_menu.php");

/*FIN BLOC A AJOUTER EN DEBUT DES PAGES*/
?>

<div class="container">
<a href="admin_all.php">Menu général</a> / Informations formulaire
</div>

<div class="centrer">
<h1 class="centrer">Modifier les catégories de données du formulaire</h1></div>
<div class="container">
<div class="row">
<div class="col-lg-12">

<?php
/***************************Ajout d'une catégorie****************************/
?>
<div class="container">
<div class="well">
<div class="row">
<div class="col-lg-12">
    <form method="POST" action="">
		<fieldset>		
		<h3>Ajouter une case à cocher: </h3>
		<div class="form-row">
    			<div class="col-md-4 mb-3">
      			<label for="ajoutLibelle">Libellé :</label>
      			<input type="text" class="form-control" name="ajoutLibelle" required>
    			</div>
    			<div class="col-md-4 mb-3">
      			<label for="ajoutInfobulle">Infobulle :</label>
      			<input type="text" class="form-control" name="ajoutInfobulle" required>
			</div>
    			<div class="col-md-4 mb-3">
				<p><input type="submit" class="btn btn-success btn-lg" value="Valider" name="valider"/></p>
			</div>
		</div>
		</fieldset>
	</form>
</div>
</div>
</div>
<?php
// partie validation ajout à la table catliceiteformulaire
if (isset($_POST["valider"])) {
    	if ((!empty($_POST['ajoutLibelle'])) && (!empty($_POST['ajoutInfobulle']))){
	  	//partie création du champ cac
		$libelle=htmlspecialchars($_POST['ajoutLibelle']);
		$infobulle=htmlspecialchars($_POST['ajoutInfobulle']);
		$objet= new Catliceiteformulaire($libelle,$infobulle);
		$daoCd= new CatliceiteformulaireDAO();
		$rep=$daoCd->create($objet);

	  	$message='Catégorie correctement ajoutée';
        	echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
		echo '<script type="text/javascript">window.location="admin_categorie_liceite.php"</script>';
		Exit();
    	} else {  
        	$message='Vous n\'avez pas rempli un des champs';
        	echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
	  	Exit();
    	} 
}
?>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-12">

<form method="POST" action="">
<fieldset>
<h4>Modifier les catégories de données</h4>
<?php

/***************************Modification/Suppression de la catégorie****************************/

echo "<table>
	<tr><th class='col-md-4'>Catégories de données</th><th class='col-md-4'>Infobulles</th><th class='col-md-1'>Modification</th><th class='col-md-1'>Suppression</th></tr>";
        	$cat = new CatliceiteformulaireDAO();
        	$readAll = $cat->readAll();
		foreach ($readAll as $key => $cd) {
			$id = $cd->getIdentifiant();
			$cdLibelle = $cd->getLibelle();
			$cdInfobulle = $cd->getInfobulle();

			echo "<td><textarea name='libelle".$id."' class='form-control' rows='1' cols='30'>".$cdLibelle."</textarea></td>";
			echo "<td><textarea name='infobulle".$id."' class='form-control' rows='1' cols='30'>".$cdInfobulle."</textarea></td>";
			echo "<td><button name='btnmodif' type='submit' class='btn btn-info2 btn-sm' value='$id'>Modifier</button></td>";
			echo "<td><button name='validerSupp' type='submit' class='btn btn-danger btn-sm' value='$id' onclick='return confirmation();'>Supprimer</button></td></tr>";
		}
		echo "</table>";
?>

</fieldset></form></div></div>

<?php 
// partie modification de la table catliceiteformulaire
if (isset($_POST["btnmodif"])) {
	$id= $_POST["btnmodif"]; 
	if (!empty($_POST['libelle'.$id])) {
		//partie libellé et infobulle
		$libelle=htmlspecialchars($_POST['libelle'.$id]);
		$infobulle=htmlspecialchars($_POST['infobulle'.$id]);
		$objet= new Catliceiteformulaire($libelle,$infobulle);
		$objet->setIdentifiant($id);
		$daoCd= new CatliceiteformulaireDAO();
		$rep=$daoCd->update($objet);

      	$message="Modifications effectuées";
      	echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
		echo '<script type="text/javascript">window.location="admin_categorie_liceite.php"</script>';
		Exit();
	} else {
	      $message="Un des champs est vide";
      	echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
		echo '<script type="text/javascript">window.location="admin_categorie_liceite.php"</script>';
		Exit();
	}
}

//partie suppression d'un champ de la table catliceiteformulaire
if (isset($_POST["validerSupp"])){   
	$id= $_POST["validerSupp"];
	//supprimer
	$daoCac= new CatliceiteformulaireDAO();
	$daoCac->delete($id);
      $message="Catégorie supprimée";
      echo '<script type="text/javascript">window.alert("' .$message.'");</script>';
	echo '<script type="text/javascript">window.location="admin_categorie_liceite.php"</script>';
	Exit();
}


?>
<?php
include("footer.php");
?>