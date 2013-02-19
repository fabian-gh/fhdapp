$(document).ready(function(){
	// Feiertags-Handling
	$(".hol_text").hide();

	// wenn die feiertagsbezeichnung nicht leer
	if($("#mon_hol_name").val() != ""){
		// dann zeige das Textfeld
		$(".mon_hol_text").show();
		// und verstecke die restlichen Eingabefelder des Tages
		$(".mon_col").hide();
	}

	if($("#tue_hol_name").val() != ""){
		$(".tue_hol_text").show();
		$(".tue_col").hide();
	}

	if($("#wed_hol_name").val() != ""){
		$(".wed_hol_text").show();
		$(".wed_col").hide();
	}

	if($("#thu_hol_name").val() != ""){
		$(".thu_hol_text").show();
		$(".thu_col").hide();
	}

	if($("#fri_hol_name").val() != ""){
		$(".fri_hol_text").show();
		$(".fri_col").hide();
	}

	// wenn Feiertags-Checkbox angeklickt wird
	if($("#mon_hol").change(function(){
		// setze die Bezeichnung bei jedem verstecken auf leer
		$(".mon_hol_text").toggle().val("");
		// und zeige bzw. verstecke die Eingabefelder des Tages
		$(".mon_col").toggle();
	}))

	if($("#tue_hol").change(function(){
		$(".tue_hol_text").toggle().val("");
		$(".tue_col").toggle();
	}))

	if($("#wed_hol").change(function(){
		$(".wed_hol_text").toggle().val("");
		$(".wed_col").toggle();
	}))

	if($("#thu_hol").change(function(){
		$(".thu_hol_text").toggle().val("");
		$(".thu_col").toggle();
	}))

	if($("#fri_hol").change(function(){
		$(".fri_hol_text").toggle().val("");
		$(".fri_col").toggle();
	}))


	// Essen der Mensa Süd zu Beginn verstecken, da CAmpus Nord Standardwert
	$(".south").hide();

	// Datepicker-Formatierung
	$("#start_date").click(function() {
		$("#start_date").datepicker({ dateFormat: "dd.mm.yy", firstDay: 1, 
									  dayNames: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"],
									  dayNamesMin: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
									  monthNames: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"] });
	});


	// Radio Button control
	// wenn Campus Süd angeklickt wird
	$("#radio-south").click(function() {
		// und die Mahlzeiten des Campus´ Süd versteckt sind
		if($(".south").is(":hidden")){
			// dann zeige diese
			$(".south").show();
		}
	});

	// wenn Campus Nord angeklickt wird
	$("#radio-north").click(function() {
		// verstecke die Süd-Mahlzeiten wieder
		$(".south").hide();
	});


	// Submit-Button Handling
	$("form").submit(function() {
		// wenn das Startdatum leer
	  	if ($("#start_date").val() == "") {
	  		// zeige im span-Tag hinter dem Startdatum die Fehlermeldung
		    $("#date_error").text("Bitte Startdatum eintragen").show();
		    // und setze den Fokus auf das Startdatumsfeld
		    $("#start_date").focus();
		    // brich das Senden ab und verbleibe auf der Seite
		    // mit true würde der Submit dennoch fortgesetzt werden
		    return false;
	  	}
	});

});