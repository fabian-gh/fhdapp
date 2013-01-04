<?PHP
$dummy1  ='
		<div class="veranstaltung_###ID###" style="border-width:1px; border-style:solid;">
		<h3>###NAME###</h3>
		<a class="button" id="veranstaltung_anzeigen_###ID###">Veranstaltung anzeigen</a>
		<a class="button" id="veranstaltung_bearbeiten_###ID###">Veranstaltung bearbeiten</a>
		';
		
		if(isset($_GET['FB']))
			 echo '<a href="?FB='.$_GET["FB"].'&loeschen=###ID###" class="button" id="loesch_button">L&ouml;schen</a>';
		else
			 echo '<a href="&loeschen=###ID###" class="button" id="loesch_button">L&ouml;schen</a>';
		
		echo '
		<div class="show_veranstaltung" id="show_veranstaltung_###ID###" style="display:none;">
			<table id="table_veranstaltung_backend" border="0">
				<thead>
				</thead>
				<tfoot>
				<tr>
				  <td colspan="2">
					<input type="hidden" name="veranstaltung_speichern" id="veranstaltung_speichern" value="###ID###">
				  </td>
				</tr>
			  </tfoot>
			  
			  <tbody>				
				<tr>
				 <td>Datum:</td>
				  <td>
					<div class="datum">###TAG###.###MONAT###.###JAHR###</div>
				  </td>
				</tr>
				
				<tr>
				  <td>Beschreibung:</td>
				  <td>
					<div class="datum">###BESCHREIBUNG###</div>
				  </td>
				</tr>
				
				<tr>
				  <td>Fachbereich:</td>
				  <td>	
				  
						[###FB1###]	Fachbereich 1 - Architektur  						<br>
						[###FB2###]	Fachbereich 2 - Design 								<br>
						[###FB3###]	Fachbereich 3 - Elektrotechnik 						<br>
						[###FB4###]	Fachbereich 4 - Maschinenbau und Verfahrenstechnik 	<br>
						[###FB5###]	Fachbereich 5 - Medien 								<br>
						[###FB6###]	Fachbereich 6 - Sozial- und Kulturwissenschaften 	<br>
						[###FB7###]	Fachbereich 7 - Wirtschaft 							<br>
				  </td>
				</tr>
				
				
				<tr>
				  <td>Modus:</td>
				  <td>
						[###INTERESSENT###]	INTERESSENT	<br>
						[###ERSTI###]		ERSTI		<br>
						[###STUDENT###]		STUDENT		<br>
				  </td>
				</tr>  
						
			  </tbody> 
			</table>
		</div>
		
		
		
		<div class="edit_veranstaltung" id="edit_veranstaltung_###ID###" style="display:none;">
		
			<form action="" method="post">
			<table id="table_veranstaltung_backend" border="0">
				<thead>
				<tr>
				  <th colspan="2">Veranstaltung Bearbeiten</th>
				</tr>
			   </thead>
				<tfoot>
				<tr>
				  <td colspan="2">
					<input type="submit" name="veranstaltung_speichern" id="veranstaltung_speichern" value="Speichern">
					<input type="hidden" name="veranstaltung_speichern" id="veranstaltung_speichern" value="###ID###">
				  </td>
				</tr>
			  </tfoot>
			  
			  <tbody>
			  
				<tr>
				  <td>Name:</td>
				  <td>
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="text" name="veranstaltung_name" id="veranstaltung_name" value="###NAME###" placeholder="Name" size="50" maxlength="30" />
					</div>
				  </td>
				</tr>
				
				<tr>
				 <td>Datum:</td>
				  <td>
				  <div data-role="fieldcontain" class="ui-hide-label">
						<input type="text" name="veranstaltung_datum_tag" id="veranstaltung_datum_tag" value="###TAG###" placeholder="DD" size="5" maxlength="2" />
						<input type="text" name="veranstaltung_datum_monat" id="veranstaltung_datum_monat" value="###MONAT###" placeholder="MM" size="5" maxlength="2" />
						<input type="text" name="veranstaltung_datum_jahr" id="veranstaltung_datum_jahr" value="###JAHR###" placeholder="YYYY" size="10" maxlength="4" />
				  </div>
				  </td>
				</tr>
				
				<tr>
				  <td>Beschreibung:</td>
				  <td>
					<div data-role="fieldcontain" class="ui-hide-label">
					<textarea name="veranstaltung_beschreibung" id="veranstaltung_beschreibung" cols="50" rows="10">###BESCHREIBUNG###</textarea>
					</div>
				  </td>
				</tr>
				
				<tr>
				  <td>Fachbereich:</td>
				  <td>	
				  
						<label><input type="checkbox" name="veranstaltungen_fachbereich_1" 	   ###FB1###/> Fachbereich 1 - Architektur  </label>
						<br><label><input type="checkbox" name="veranstaltungen_fachbereich_2" ###FB2###/> Fachbereich 2 - Design </label>
						<br><label><input type="checkbox" name="veranstaltungen_fachbereich_3" ###FB3###/> Fachbereich 3 - Elektrotechnik </label>
						<br><label><input type="checkbox" name="veranstaltungen_fachbereich_4" ###FB4###/> Fachbereich 4 - Maschinenbau und Verfahrenstechnik </label>
						<br><label><input type="checkbox" name="veranstaltungen_fachbereich_5" ###FB5###/> Fachbereich 5 - Medien </label>
						<br><label><input type="checkbox" name="veranstaltungen_fachbereich_6" ###FB6###/> Fachbereich 6 - Sozial- und Kulturwissenschaften </label>
						<br><label><input type="checkbox" name="veranstaltungen_fachbereich_7" ###FB7###/> Fachbereich 7 - Wirtschaft </label>
				  </td>
				</tr>
				
				<tr>
				  <td>Modus:</td>
				  <td>
						<label><input type="checkbox" name="veranstaltungen_usertypes_1" 	 ###INTERESSENT###/> Interessent </label>
						<br><label><input type="checkbox" name="veranstaltungen_usertypes_2" ###ERSTI###/> Ersti </label>
						<br><label><input type="checkbox" name="veranstaltungen_usertypes_3" ###STUDENT###/> Student </label>
				  </td> 
				</tr>   
						
			  </tbody>  
			</table>
			</form>
		</div>
	</div>';
?>