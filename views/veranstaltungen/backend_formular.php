<?php

/**
 * FHD-App
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Sascha Möller (FM), <sascha.moeller@fh-duesseldorf.de>
 */
 
class Formular{

	private $NAME = 		null;
	private $ID = 			null;
	private $TAG = 			null;
	private $MONAT = 		null;
	private $JAHR = 		null;
	private $STUNDEN = 		null;
	private $MINUTEN = 		null;
	private $BESCHREIBUNG = null;
	private $FB1 = 			null;
	private $FB2 = 			null;
	private $FB3 = 			null;
	private $FB4 = 			null;
	private $FB5 = 			null;
	private $FB6 = 			null;
	private $FB7 = 			null;
	private $INTERESSENT =	null;
	private $STUDENT =	 	null;
	private $ERSTI = 		null;
	

	public function __construct(){
        // Konstruktor
    }
	
	public function getEmptyForm()
	{
		//Alle Variablen auf null setzen bis auf die ID
		$this->setALL(null, 'new', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
		$this->replaceALL();
		
		$RESULT =
		'
		<div class="veranstaltung_'.$this->ID.'" style="border-width:1px; border-style:solid;">
		
		<a class="button" id="veranstaltung_anzeigen_'.$this->ID.'">Neuen Eintrag erstellen</a>
		';
		
		$RESULT .= $this->EVENTFORM;
		$RESULT .= '</div>';
		return $RESULT;
	}
	
	public function getEventContainer($FB_GET)
	{
		$RESULT =
		'
		<div class="veranstaltung_'.$this->ID.'" style="border-width:1px; border-style:solid;">
			<h3>'.$this->NAME.'</h3>
		
			<a class="button" id="veranstaltung_anzeigen_'.$this->ID.'"		>Veranstaltung anzeigen	</a>
			<a class="button" id="veranstaltung_bearbeiten_'.$this->ID.'"	>Veranstaltung bearbeiten</a>
			<a href="?FB='.$FB_GET.'&amp;loeschen='.$this->ID.'" class="button" id="loesch_button">L&ouml;schen</a>
		';
		
		$RESULT .= $this->getEventResult();
		$RESULT .= $this->getEventForm();
		
		$RESULT .= '</div>';
		return $RESULT;
	}
	
	public function getEventForm()
	{
		return $this->EVENTFORM;	
	}
	
	public function getEventResult()
	{
		return $this->EVENTRESULT;
	}
	
	public function getJquery()
	{
		$JQUERY = 
				'
				$("#veranstaltung_anzeigen_'.$this->ID.'").click(function(){
					$(".form_veranstaltung_new").hide();
					$("#form_veranstaltung_'.$this->ID.'").hide();
					$("#show_veranstaltung_'.$this->ID.'").slideToggle("fast");
				});
	
				$("#veranstaltung_bearbeiten_'.$this->ID.'").click(function(){
					$(".form_veranstaltung_new").hide();
					$("#show_veranstaltung_'.$this->ID.'").hide();
					$("#form_veranstaltung_'.$this->ID.'").slideToggle("fast");
				});
				';
		return $JQUERY;
	}
	
	public function getJqueryEmptyForm()
	{
		$JQUERY = 
				'
				$("#veranstaltung_anzeigen_'.$this->ID.'").click(function(){
						$("#form_veranstaltung_'.$this->ID.'").slideToggle("fast");
				});
				';
		return $JQUERY;
	}
	
	public function setALL($NAME, $ID, $TAG, $MONAT, $JAHR, $STUNDEN, $MINUTEN, $BESCHREIBUNG, $FB1, $FB2, $FB3, $FB4, $FB5, $FB6, $FB7, $INTERESSENT, $ERSTI, $STUDENT)
	{
		$this->NAME = 			$NAME;
		$this->ID = 			$ID;
		$this->TAG = 			$TAG;
		$this->MONAT = 			$MONAT;
		$this->JAHR = 			$JAHR;
		$this->STUNDEN = 		$STUNDEN;
		$this->MINUTEN = 		$MINUTEN;
		$this->BESCHREIBUNG = 	$BESCHREIBUNG;
		$this->FB1 = 			$FB1;
		$this->FB2 = 			$FB2;
		$this->FB3 = 			$FB3;
		$this->FB4 = 			$FB4;
		$this->FB5 = 			$FB5;
		$this->FB6 = 			$FB6;
		$this->FB7 = 			$FB7;
		$this->INTERESSENT = 	$INTERESSENT;
		$this->STUDENT = 		$STUDENT;
		$this->ERSTI = 			$ERSTI;
		
		$this->replaceALL();
	}	

	public function replaceALL()
	{	
		$this->EVENTFORM =  str_replace ('###NAME###'				,$this->NAME  			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###ID###'					,$this->ID    			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###TAG###'				,$this->TAG   			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###MONAT###'				,$this->MONAT 			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###JAHR###'				,$this->JAHR 			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###STUNDEN###'			,$this->STUNDEN			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###MINUTEN###'			,$this->MINUTEN			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###BESCHREIBUNG###'		,$this->BESCHREIBUNG	,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###FB1###'				,$this->FB1		  		,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###FB2###'				,$this->FB2		  		,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###FB3###'				,$this->FB3		  		,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###FB4###'				,$this->FB4		  		,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###FB5###'				,$this->FB5		  		,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###FB6###'				,$this->FB6		  		,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###FB7###'				,$this->FB7		  		,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###INTERESSENT###'		,$this->INTERESSENT		,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###ERSTI###'				,$this->ERSTI			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###STUDENT###'			,$this->STUDENT			,$this->EVENTFORM );
		
		
		$this->EVENTRESULT =  str_replace ('###NAME###'				,$this->NAME  			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###ID###'				,$this->ID    			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###TAG###'				,$this->TAG   			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###MONAT###'			,$this->MONAT 			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###JAHR###'				,$this->JAHR 			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###STUNDEN###'			,$this->STUNDEN			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###MINUTEN###'			,$this->MINUTEN			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###BESCHREIBUNG###'		,$this->BESCHREIBUNG	,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###FB1###'				,$this->FB1		  		,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###FB2###'				,$this->FB2		  		,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###FB3###'				,$this->FB3		  		,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###FB4###'				,$this->FB4		  		,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###FB5###'				,$this->FB5		  		,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###FB6###'				,$this->FB6		  		,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###FB7###'				,$this->FB7		  		,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###INTERESSENT###'		,$this->INTERESSENT		,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###ERSTI###'			,$this->ERSTI			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###STUDENT###'			,$this->STUDENT			,$this->EVENTRESULT );
		
	}
	
	public function getNAME(){
		return $this->NAME;
	}

	public function setNAME($NAME){
		$this->NAME = $NAME;
	}

	public function getID(){
		return $this->ID;
	}

	public function setID($ID){
		$this->ID = $ID;
	}

	public function getTAG(){
		return $this->TAG;
	}

	public function setTAG($TAG){
		$this->TAG = $TAG;
	}

	public function getMONAT(){
		return $this->MONAT;
	}

	public function setMONAT($MONAT){
		$this->MONAT = $MONAT;
	}

	public function getJAHR(){
		return $this->JAHR;
	}

	public function setJAHR($JAHR){
		$this->JAHR = $JAHR;
	}

	public function getSTUNDEN(){
		return $this->STUNDEN;
	}

	public function setSTUNDEN($STUNDEN){
		$this->STUNDEN = $STUNDEN;
	}

	public function getMINUTEN(){
		return $this->MINUTEN;
	}

	public function setMINUTEN($MINUTEN){
		$this->MINUTEN = $MINUTEN;
	}

	public function getBESCHREIBUNG(){
		return $this->BESCHREIBUNG;
	}

	public function setBESCHREIBUNG($BESCHREIBUNG){
		$this->BESCHREIBUNG = $BESCHREIBUNG;
	}

	public function getFB1(){
		return $this->FB1;
	}

	public function setFB1($FB1){
		$this->FB1 = $FB1;
	}

	public function getFB2(){
		return $this->FB2;
	}

	public function setFB2($FB2){
		$this->FB2 = $FB2;
	}

	public function getFB3(){
		return $this->FB3;
	}

	public function setFB3($FB3){
		$this->FB3 = $FB3;
	}

	public function getFB4(){
		return $this->FB4;
	}

	public function setFB4($FB4){
		$this->FB4 = $FB4;
	}

	public function getFB5(){
		return $this->FB5;
	}

	public function setFB5($FB5){
		$this->FB5 = $FB5;
	}

	public function getFB6(){
		return $this->FB6;
	}

	public function setFB6($FB6){
		$this->FB6 = $FB6;
	}

	public function getFB7(){
		return $this->FB7;
	}

	public function setFB7($FB7){
		$this->FB7 = $FB7;
	}

	public function getINTERESSENT(){
		return $this->INTERESSENT;
	}

	public function setINTERESSENT($INTERESSENT){
		$this->INTERESSENT = $INTERESSENT;
	}

	public function getSTUDENT(){
		return $this->STUDENT;
	}

	public function setSTUDENT($STUDENT){
		$this->STUDENT = $STUDENT;
	}

	public function getERSTI(){
		return $this->ERSTI;
	}

	public function setERSTI($ERSTI){
		$this->ERSTI = $ERSTI;
	}
	
	private $EVENTFORM =
	'<div class="veranstaltung" id="form_veranstaltung_###ID###" style="display:none;">
		<form action="" method="post">
			<table id="table_veranstaltung_backend" border="0" width="100%">
				
			<thead>
				<tr>
				  <th colspan="2">Veranstaltung Bearbeiten</th>
				</tr>
			</thead>
				
			<tfoot>
					<tr>
					<td colspan="2">
						<input type="submit" name="veranstaltung_speichern" id="veranstaltung_speichern" value="Speichern" />
						<input type="hidden" name="veranstaltung_id" id="veranstaltung_id" value="###ID###">
					</td>
					</tr>
			</tfoot>
			  
			<tbody>
				<tr>
					<td>Name:</td>
					<td>
						<div class="div_veranstaltung_name" id="div_veranstaltung_name_###ID###">
							<input type="text" name="veranstaltung_name" id="veranstaltung_name" value="###NAME###" placeholder="Name" size="50" maxlength="30" />
						</div>
					</td>
				</tr>
				
				<tr>
					<td>Datum:</td>
					<td>
						<div class="div_veranstaltung_datum" id="div_veranstaltung_datum_###ID###">
							<input type="text" name="veranstaltung_datum_tag" 	id="veranstaltung_datum_tag" 	value="###TAG###" 	placeholder="DD" 	size="5" 	maxlength="2" />
							<input type="text" name="veranstaltung_datum_monat" id="veranstaltung_datum_monat" 	value="###MONAT###" placeholder="MM" 	size="5" 	maxlength="2" />
							<input type="text" name="veranstaltung_datum_jahr" 	id="veranstaltung_datum_jahr" 	value="###JAHR###" 	placeholder="YYYY" 	size="10"	maxlength="4" />
						</div>
					</td>
				</tr>
				
				<tr>
					<td>Uhrzeit:</td>
					<td>
						<div class="div_veranstaltung_uhrzeit" id="div_veranstaltung_uhrzeit_###ID###">
							<input type="text" name="veranstaltung_uhrzeit_stunden" id="veranstaltung_uhrzeit_stunden" value="###STUNDEN###" placeholder="HH" size="5" maxlength="2" />
							<input type="text" name="veranstaltung_uhrzeit_minuten" id="veranstaltung_uhrzeit_minuten" value="###MINUTEN###" placeholder="MM" size="5" maxlength="2" />
						</div>
					</td>
				</tr>
				
				<tr>
					<td>Beschreibung:</td>
					<td>
						<div class="div_veranstaltung_beschreibung" id="div_veranstaltung_beschreibung_###ID###">
							<textarea name="veranstaltung_beschreibung" id="veranstaltung_beschreibung" cols="50" rows="10">###BESCHREIBUNG###</textarea>
						</div>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<div class="div_veranstaltung_fachbereiche" id="div_veranstaltung_fachbereiche_###ID###">
							<fieldset>
								<legend>Fachbereich:</legend>
								
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_1"	name="veranstaltungen_fachbereich_1" ###FB1### />
								<label for="veranstaltungen_fachbereich_1">Fachbereich 1 - Architektur							</label>  
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_2"	name="veranstaltungen_fachbereich_2" ###FB2### />
								<label for="veranstaltungen_fachbereich_2">Fachbereich 2 - Design								</label>
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_3"	name="veranstaltungen_fachbereich_3" ###FB3### />
								<label for="veranstaltungen_fachbereich_3">Fachbereich 3 - Elektrotechnik						</label>
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_4"	name="veranstaltungen_fachbereich_4" ###FB4### />
								<label for="veranstaltungen_fachbereich_4">Fachbereich 4 - Maschinenbau und Verfahrenstechnik	</label>
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_5"	name="veranstaltungen_fachbereich_5" ###FB5### />
								<label for="veranstaltungen_fachbereich_5">Fachbereich 5 - Medien								</label>
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_6"	name="veranstaltungen_fachbereich_6" ###FB6### />
								<label for="veranstaltungen_fachbereich_6">Fachbereich 6 - Sozial- und Kulturwissenschaften		</label>
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_7"	name="veranstaltungen_fachbereich_7" ###FB7### />
								<label for="veranstaltungen_fachbereich_7">Fachbereich 7 - Wirtschaft 							</label>
								
								<br/>
							</fieldset>
						</div>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<div class="div_veranstaltung_usertype" id="div_veranstaltung_usertype_###ID###">
							<fieldset>
								<legend>Modus:</legend>
								
								<br/>
								<input type="checkbox" id="veranstaltungen_usertypes_1"	name="veranstaltungen_usertypes_1" ###INTERESSENT### />
								<label for="veranstaltungen_usertypes_1">Interessent	</label>
								
								<br/>
								<input type="checkbox" id="veranstaltungen_usertypes_2"	name="veranstaltungen_usertypes_2" ###ERSTI###		 />
								<label for="veranstaltungen_usertypes_2">Ersti			</label>
								
								<br/>
								<input type="checkbox" id="veranstaltungen_usertypes_3"	name="veranstaltungen_usertypes_3" ###STUDENT###	 />
								<label for="veranstaltungen_usertypes_3">Student		</label>
								
								<br/>
							</fieldset>
						</div>
					</td> 
				</tr>   
						
			 </tbody>  
		</table>
		</form>
	</div>
	';
	
	private $EVENTRESULT =
	'<div class="veranstaltung" id="show_veranstaltung_###ID###" style="display:none;">
		<table id="table_veranstaltung_backend" border="0" width="100%">
			<thead>
			</thead>
			
			<tfoot>
			</tfoot>
			  
			 <tbody>				
				<tr>
					<td>Datum:</td>
					<td>
						<div class="div_veranstaltung_show_datum">###TAG###.###MONAT###.###JAHR###</div>
					</td>
				</tr>
				
				<tr>
					<td>Uhrzeit:</td>
					<td>
						<div class="div_veranstaltung_show_uhrzeit">###STUNDEN###:###MINUTEN###</div>
					</td>
				</tr>
				
				<tr>
					<td>Beschreibung:</td>
					<td>
						<div class="div_veranstaltung_show_beschreibung">###BESCHREIBUNG###</div>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<div class="div_veranstaltung_show_fachbereiche" id="div_veranstaltung_fachbereiche_###ID###">
							<fieldset>
								<legend>Fachbereich:</legend>
								
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_1"	name="veranstaltungen_fachbereich_1" ###FB1### disabled="disabled" />
								<label for="veranstaltungen_fachbereich_1">Fachbereich 1 - Architektur							</label>  
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_2"	name="veranstaltungen_fachbereich_2" ###FB2### disabled="disabled" />
								<label for="veranstaltungen_fachbereich_2">Fachbereich 2 - Design								</label>  
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_3"	name="veranstaltungen_fachbereich_3" ###FB3### disabled="disabled" />
								<label for="veranstaltungen_fachbereich_3">Fachbereich 3 - Elektrotechnik						</label>
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_4"	name="veranstaltungen_fachbereich_4" ###FB4### disabled="disabled" />
								<label for="veranstaltungen_fachbereich_4">Fachbereich 4 - Maschinenbau und Verfahrenstechnik	</label>
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_5"	name="veranstaltungen_fachbereich_5" ###FB5### disabled="disabled" />
								<label for="veranstaltungen_fachbereich_5">Fachbereich 5 - Medien								</label>
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_6"	name="veranstaltungen_fachbereich_6" ###FB6### disabled="disabled" />
								<label for="veranstaltungen_fachbereich_6">Fachbereich 6 - Sozial- und Kulturwissenschaften		</label>
									
								<br/>
								<input type="checkbox" id="veranstaltungen_fachbereich_7"	name="veranstaltungen_fachbereich_7" ###FB7### disabled="disabled" />
								<label for="veranstaltungen_fachbereich_7">Fachbereich 7 - Wirtschaft 							</label>
								
								<br/>
							</fieldset>
						</div>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<div class="div_veranstaltung_show_usertype" id="div_veranstaltung_usertype_###ID###">
							<fieldset>
								<legend>Modus:</legend>
								
								<br/> 
								<input type="checkbox" id="veranstaltungen_usertypes_1"	name="veranstaltungen_usertypes_1" ###INTERESSENT### disabled="disabled" />
								<label for="veranstaltungen_usertypes_1">Interessent	</label>
								
								<br/>
								<input type="checkbox" id="veranstaltungen_usertypes_2"	name="veranstaltungen_usertypes_2" ###ERSTI###		 disabled="disabled" />
								<label for="veranstaltungen_usertypes_2">Ersti			</label>
								
								<br/>
								<input type="checkbox" id="veranstaltungen_usertypes_3"	name="veranstaltungen_usertypes_3" ###STUDENT###	 disabled="disabled" />
								<label for="veranstaltungen_usertypes_3">Student		</label>
								
								<br/>
							</fieldset>
						</div>
					</td>
				</tr>  
						
			 </tbody> 
		</table>
	</div>
	';
}
 
/* End of file backend_formular.php */
/* Location: ./views/backend_formular.php */