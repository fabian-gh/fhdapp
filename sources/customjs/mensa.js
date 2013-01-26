$(document).ready(function(){
	// Essen der Mensa Süd zu Beginn verstecken
	$(".south").hide();

	//Datepicker formating
	$("#start_date").click(function() {
		$("#start_date").datepicker({ dateFormat: "dd.mm.yy", firstDay: 1, 
									  dayNames: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"],
									  dayNamesMin: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
									  monthNames: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"] });
	});


	// Radio Button control
	$("#radio-south").click(function() {
		if($(".south").is(":hidden")){
			$(".south").show();
		}
	});

	$("#radio-north").click(function() {
		$(".south").hide();
	});

});