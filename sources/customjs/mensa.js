$(document).ready(function(){
	// Feiertags-Handling
	$(".hol_text").hide();

	if($("#mon_hol_name").val() != ""){
		$(".mon_hol_text").show();
	}

	if($("#tue_hol_name").val() != ""){
		$(".tue_hol_text").show();
	}

	if($("#wed_hol_name").val() != ""){
		$(".wed_hol_text").show();
	}

	if($("#thu_hol_name").val() != ""){
		$(".thu_hol_text").show();
	}

	if($("#fri_hol_name").val() != ""){
		$(".fri_hol_text").show();
	}

	if($("#mon_hol").change(function(){
		$(".mon_hol_text").toggle();
	}))

	if($("#tue_hol").change(function(){
		$(".tue_hol_text").toggle();
	}))

	if($("#wed_hol").change(function(){
		$(".wed_hol_text").toggle();
	}))

	if($("#thu_hol").change(function(){
		$(".thu_hol_text").toggle();
	}))

	if($("#fri_hol").change(function(){
		$(".fri_hol_text").toggle();
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

});