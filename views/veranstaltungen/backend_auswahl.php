<?PHP

echo'
<h3>W&auml;hlen Sie den Fachbereich aus f&uuml;r den Sie die Veranstaltungen bearbeiten m&ouml;chten</h3>
<form class="fachbereich_auswahl" action="">
<select class="fachbereich_select" name="FB" size="1">
<option type="checkbox" value="veranstaltungen_fachbereich_1"> Fachbereich 1 - Architektur  </option>
<option type="checkbox" value="veranstaltungen_fachbereich_2"> Fachbereich 2 - Design </option>
<option type="checkbox" value="veranstaltungen_fachbereich_3"> Fachbereich 3 - Elektrotechnik </option>
<option type="checkbox" value="veranstaltungen_fachbereich_4"> Fachbereich 4 - Maschinenbau und Verfahrenstechnik </option>
<option type="checkbox" value="veranstaltungen_fachbereich_5"> Fachbereich 5 - Medien </option>
<option type="checkbox" value="veranstaltungen_fachbereich_6"> Fachbereich 6 - Sozial- und Kulturwissenschaften </option>
<option type="checkbox" value="veranstaltungen_fachbereich_7"> Fachbereich 7 - Wirtschaft </option>
</select>
</form>

<script type="text/javascript">
$(function() {	
	$(".fachbereich_select").change(function() {
	  $(".fachbereich_auswahl").submit();
	});
});
</script>
';
?>