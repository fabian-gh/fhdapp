<?PHP

$selected = array('', '', '' ,'', '', '', '', '');
$selected[$FB_GET] = 'Selected';
echo'
<h3>W&auml;hlen Sie den Fachbereich aus f&uuml;r den Sie die Veranstaltungen bearbeiten m&ouml;chten</h3>
<form id="fachbereich_auswahl" action="">
	<select id="fachbereich_select" name="FB" size="1">
		<option value="1" '.$selected[1].'> Fachbereich 1 - Architektur  </option>
		<option value="2" '.$selected[2].'> Fachbereich 2 - Design </option>
		<option value="3" '.$selected[3].'> Fachbereich 3 - Elektrotechnik </option>
		<option value="4" '.$selected[4].'> Fachbereich 4 - Maschinenbau und Verfahrenstechnik </option>
		<option value="5" '.$selected[5].'> Fachbereich 5 - Medien </option>
		<option value="6" '.$selected[6].'> Fachbereich 6 - Sozial- und Kulturwissenschaften </option>
		<option value="7" '.$selected[7].'> Fachbereich 7 - Wirtschaft </option>
	</select>
</form>
';
?>