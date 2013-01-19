$(document).ready(function(){

	//Datepicker formating
	$("#start_date").click(function() {
		$("#start_date").datepicker({ dateFormat: "dd.mm.yy", firstDay: 1, 
									  dayNames: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"],
									  dayNamesMin: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
									  monthNames: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"] });
	});


	//Flip-Switch Handling
	$('.south').hide();
	$("#flip-2").on('slidestop', function(){
		if($('.south').is(':hidden')){
			$('.south').toggle();
		}
	});

});