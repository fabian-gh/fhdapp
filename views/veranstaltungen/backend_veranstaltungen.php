<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Sascha Möller (FM), <sascha.moeller@fh-duesseldorf.de>
 */
	ob_start();
	require_once 'layout/frontend/header.php';
	
	if(isset($_POST['veranstaltung_speichern']))
	{
		echo 'Vielen Dank';
		require_once 'controllers/veranstaltungenController.php';
        // Controller-Instanz erstellen und das Data-Objekt übergeben
        $Controller = new VeranstaltungenController();
		$Controller->addDatensatz();
	}
	else
	{
		echo'  
		<form action="?id=backend_veranstaltungen" method="post">
		
		<table id="table_veranstaltung_backend" border="1">
			<thead>
			<tr>
			  <th colspan="2">Veranstaltung</th>
			</tr>
		   </thead>
			<tfoot>
			<tr>
			  <td colspan="2">
				<input type="submit" name="veranstaltung_speichern" id="veranstaltung_speichern" value="Speichern">
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
					<label><input type="checkbox" name="veranstaltungen_fachbereich_2" /> Fachbereich 2 - Design </label>
					<label><input type="checkbox" name="veranstaltungen_fachbereich_3" /> Fachbereich 3 - Elektrotechnik </label>
					<label><input type="checkbox" name="veranstaltungen_fachbereich_4" /> Fachbereich 4 - Maschinenbau und Verfahrenstechnik </label>
					<label><input type="checkbox" name="veranstaltungen_fachbereich_5" /> Fachbereich 5 - Medien </label>
					<label><input type="checkbox" name="veranstaltungen_fachbereich_6" /> Fachbereich 6 - Sozial- und Kulturwissenschaften </label>
					<label><input type="checkbox" name="veranstaltungen_fachbereich_7" /> Fachbereich 7 - Wirtschaft </label>
			  </td>
			</tr>
			
			<tr>
			  <td>Modus:</td>
			  <td>
				<div data-role="fieldcontain">
				<fieldset data-role="controlgroup">
					
					<label><input type="checkbox" name="veranstaltungen_usertypes_1" /> Interessent </label>
					<label><input type="checkbox" name="veranstaltungen_usertypes_2" /> Ersti </label>
					<label><input type="checkbox" name="veranstaltungen_usertypes_3" /> Student </label>

				</fieldset>
				</div>
			  </td>
			</tr>
			
		  </tbody>
		</table>
		
		</form>
		';
	}
	
	
	require_once 'layout/frontend/footer.php';
	ob_end_flush();
	/* End of file veranstaltungen_edit.php */
	/* Location: ./views/veranstaltungen/veranstaltungen_edit.php */
?>