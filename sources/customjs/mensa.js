$(document).ready(function(){

	// Kalenderwochenhandling
	$("#calenderweek").focusout(function(){
		
		var cw = $("#calenderweek").val();
		if(cw<=0 || cw>52){
			$("#cw_error").html("Ungültige Eingabe").addClass("error");
			$("#calenderweek").addClass("error");
			$("#calenderweek").val("");
		} 

		if(cw>0 && cw<=52){
			$("#cw_error").html("").removeClass("error");
			$("#calenderweek").removeClass("error");
		}
	})

	//Startdatumshandling
	 $("#start_date").click(function() {
        $("#start_date").datepicker({ dateFormat: "dd.mm.yy" });
    });

});