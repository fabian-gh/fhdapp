$(document).ready(function(){

	//Datepicker formating
	$("#start_date").click(function() {
		$("#start_date").datepicker({ dateFormat: "dd.mm.yy", firstDay: 1, 
									  dayNames: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"],
									  dayNamesMin: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
									  monthNames: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"] });
	});


	// Radio Button control
	$('.south').hide();
	$("#radio-south").click(function() {
		$(".south").toggle();
	});

});