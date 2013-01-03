<?PHP
		echo'
		<div class="veranstaltung_new" style="border-width:1px; border-style:solid;">
		
		<a class="button" id="new_formular_button">Neuen Eintrag erstellen</a>
		
		<div id="new_formular" style="display:none;">
		<form action="" method="post">
		
		<table id="table_veranstaltung_backend" border="0">
			<thead>
			<tr>
			  <th colspan="2">Veranstaltung erstellen</th>
			</tr>
		   </thead>
			<tfoot>
			<tr>
			  <td colspan="2">
				<input type="submit" name="veranstaltung_speichern" id="veranstaltung_speichern" value="Speichern">
				<input type="hidden" name="veranstaltung_speichern" id="veranstaltung_speichern" value="_new">
			  </td>
			</tr>
		  </tfoot>
		  
		  <tbody>
		  
			<tr>
			  <td>Name:</td>
			  <td>
				<div data-role="fieldcontain" class="ui-hide-label">
					<input type="text" name="veranstaltung_name" id="veranstaltung_name" value="" placeholder="Name" size="50" maxlength="30" />
				</div>
			  </td>
			</tr>
			
			<tr>
			 <td>Datum:</td>
			  <td>
			  <div data-role="fieldcontain" class="ui-hide-label">
					<input type="text" name="veranstaltung_datum_tag" id="veranstaltung_datum_tag" value="" placeholder="DD" size="5" maxlength="2" />
					<input type="text" name="veranstaltung_datum_monat" id="veranstaltung_datum_monat" value="" placeholder="MM" size="5" maxlength="2" />
					<input type="text" name="veranstaltung_datum_jahr" id="veranstaltung_datum_jahr" value="" placeholder="YYYY" size="10" maxlength="4" />
			  </div>
			  </td>
			</tr>
			
			<tr>
			  <td>Beschreibung:</td>
			  <td>
				<div data-role="fieldcontain" class="ui-hide-label">
				<textarea name="veranstaltung_beschreibung" id="veranstaltung_beschreibung" cols="50" rows="10"></textarea>
				</div>
			  </td>
			</tr>
			
			<tr>
			  <td>Fachbereich:</td>
			  <td>	
			  
					<label><input type="checkbox" name="veranstaltungen_fachbereich_1" /> Fachbereich 1 - Architektur  </label>
					<br><label><input type="checkbox" name="veranstaltungen_fachbereich_2" /> Fachbereich 2 - Design </label>
					<br><label><input type="checkbox" name="veranstaltungen_fachbereich_3" /> Fachbereich 3 - Elektrotechnik </label>
					<br><label><input type="checkbox" name="veranstaltungen_fachbereich_4" /> Fachbereich 4 - Maschinenbau und Verfahrenstechnik </label>
					<br><label><input type="checkbox" name="veranstaltungen_fachbereich_5" /> Fachbereich 5 - Medien </label>
					<br><label><input type="checkbox" name="veranstaltungen_fachbereich_6" /> Fachbereich 6 - Sozial- und Kulturwissenschaften </label>
					<br><label><input type="checkbox" name="veranstaltungen_fachbereich_7" /> Fachbereich 7 - Wirtschaft </label>
			  </td>
			</tr>
			
			<tr>
			  <td>Modus:</td>
			  <td>
					<label><input type="checkbox" name="veranstaltungen_usertypes_1" /> Interessent </label>
					<br><label><input type="checkbox" name="veranstaltungen_usertypes_2" /> Ersti </label>
					<br><label><input type="checkbox" name="veranstaltungen_usertypes_3" /> Student </label>
			  </td>
			</tr>
			
		  </tbody>
		</table>
		
		</form>
		</div>
		</div>
		';
?>