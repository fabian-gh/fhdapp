$(document).ready(function(){
	// Feiertags-Handling
	$(".hol_text").hide();

	if($("#mon_hol_name").val() != ""){
		$(".mon_hol_text").show();
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

	if($("#mon_hol").change(function(){
		$(".mon_hol_text").toggle().val("");
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


	// Submit-Button Handling
	$("form").submit(function() {
	  	if ($("#start_date").val() == "") {
		    $("#date_error").text("Bitte Startdatum eintragen").show();
		    $("#start_date").focus();
		    return false;
	  	}
	});

});