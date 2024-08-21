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