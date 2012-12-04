<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */
	ob_start();
	require_once 'layout/frontend/header.php';
	
	if(isset($_GET['veranstaltung_speichern']))
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
		<form action="" method="get">
		
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
				<input name="veranstaltung_name" id="veranstaltung_name" type="text" size="50" maxlength="30">
			  </td>
			</tr>
			
			<tr>
			 <td>Datum:</td>
			  <td>
			  <input name="veranstaltung_datum_tag" id="veranstaltung_datum_tag" type="text" size="5" maxlength="2">
			  <input name="veranstaltung_datum_monat" id="veranstaltung_datum_monat" type="text" size="5" maxlength="2">
			  <input name="veranstaltung_datum_jahr" id="veranstaltung_datum_jahr" type="text" size="10" maxlength="4">
			  (DD-MM-YYYY)
			  </td>
			</tr>
			
			<tr>
			  <td>Beschreibung:</td>
			  <td>
			  <textarea name="veranstaltung_beschreibung" id="veranstaltung_beschreibung" cols="50" rows="10"></textarea>
			  </td>
			</tr>
			
			<tr>
			  <td>Fachbereich:</td>
			  <td>
				<input type="checkbox" name="veranstaltungen_fachbereich_1" value="checked" /> Fachbereich 1 - Architektur <br/>
				<input type="checkbox" name="veranstaltungen_fachbereich_2" value="checked" /> Fachbereich 2 - Design <br/>
				<input type="checkbox" name="veranstaltungen_fachbereich_3" value="checked" /> Fachbereich 3 - Elektrotechnik <br/>
				<input type="checkbox" name="veranstaltungen_fachbereich_4" value="checked" /> Fachbereich 4 - Maschinenbau und Verfahrenstechnik <br/>
				<input type="checkbox" name="veranstaltungen_fachbereich_5" value="checked" /> Fachbereich 5 - Medien <br/>
				<input type="checkbox" name="veranstaltungen_fachbereich_6" value="checked" /> Fachbereich 6 - Sozial- und Kulturwissenschaften <br/>
				<input type="checkbox" name="veranstaltungen_fachbereich_7" value="checked" /> Fachbereich 7 - Wirtschaft <br/>
			  </td>
			</tr>
			
			<tr>
			  <td>Modus:</td>
			  <td>
				<input type="checkbox" name="veranstaltungen_usertypes_1" value="checked" /> Interessent <br/>
				<input type="checkbox" name="veranstaltungen_usertypes_2" value="checked" /> Ersti <br/>
				<input type="checkbox" name="veranstaltungen_usertypes_3" value="checked" /> Student <br/>
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