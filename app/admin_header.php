<!DOCTYPE html>
<html>
<head>
<meta content="text/html" charset="utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="bootstrap/css/screen.css" rel="stylesheet">
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/js/jquery-1.12.4.js"></script>
<script src="bootstrap/js/jquery-ui.js"></script>
<link href="bootstrap/css/jquery-ui.css" rel="stylesheet">
<link href="bootstrap/css/style.css" rel="stylesheet">
<!-- multiselect  -->
<script src="bootstrap/js/appelsumo.js"></script>
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- <script src="bootstrap/js/jquery.js"></script> entre en conflit avec datepicker  -->

<script src="bootstrap/js/jquery.sumoselect.min.js"></script>
<link href="bootstrap/css/sumoselect.css" rel="stylesheet">
<link href="bootstrap/css/screen.css" rel="stylesheet">
<script type="text/javascript" src="LD/ld_xhr.js"></script>
   
<title>Administration utilisateurs</title>

<SCRIPT LANGUAGE="JavaScript">
function confirmation() {
	return confirm("Effectuer la suppression) ?");
}
function confirmationModele() {
	return confirm("Effectuer la copie) ?");
}
</SCRIPT> 

<!-- datapicker -->
<script type="text/javascript"> 
	$(document).ready({
		$( "#datepicker" ).datepicker({
			altField: "#datepicker",
			closeText: 'Fermer',
			firstDay: 1 ,
			dateFormat: 'yy-mm-dd'
		});
		$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] ); 
	});   
</script>
<!-- Multiselect -->
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

</head>
<body>

<div id="container">
<a href="visu.php" id="header"></a>
</div> <!-- container -->

