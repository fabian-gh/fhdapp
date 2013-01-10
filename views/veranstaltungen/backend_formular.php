<?php

/**
 * FHD-App
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Sascha Möller (FM), <sascha.moeller@fh-duesseldorf.de>
 */
 
class Formular{

	

	private $NAME 			= null;
	private $ID				= null;
	private $TAG 			= null;
	private $MONAT 			= null;
	private $JAHR 			= null;
	private $STUNDEN 		= null;
	private $MINUTEN 		= null;
	private $BESCHREIBUNG 	= null;
	private $FB 			= null;
	private $USER 			= null;

	private $Controller;
	//Fachbereiche aus der DB geladen
	private $FACHBEREICHE	= null;
	//Fachbereiche aus der DB geladen
	private $USERTYPES		= null;
	
	public function __construct($Controller){
        // Konstruktor
		$this->Controller = $Controller;
		$this->FACHBEREICHE = $this->Controller->getDepartments();
		$this->USERTYPES = $this->Controller->getUsertypes();
		
		$this->createDepartmentsInput();
		$this->createUsertypesInput();
    }
	
	//Methode die Fachbereiche läd und dazu die INPUTS für die Formulare erstellt
	private function createDepartmentsInput()
	{		
		if($this->FACHBEREICHE != null)
		{	
			$INPUT_FORM = '';
			$INPUT_RESULT = '';
			for($i=0; $i<count($this->FACHBEREICHE); $i++) 
			{
				$INPUT_FORM .=
					'
									<br/>
									<input type="checkbox" class="veranstaltung_checkbox_fachbereich_###ID###"	id="veranstaltungen_fachbereich_'.$this->FACHBEREICHE[$i]['id'].'_###ID###"	name="veranstaltungen_fachbereich_'.$this->FACHBEREICHE[$i]['id'].'" ###FB'.$this->FACHBEREICHE[$i]['id'].'### />
									<label for="veranstaltungen_fachbereich_'.$this->FACHBEREICHE[$i]['id'].'_###ID###">'.$this->FACHBEREICHE[$i]['name'].'</label> 
					';
				$INPUT_RESULT .= 
					'
									<br/>
									<input type="checkbox" class="veranstaltung_checkbox" 	id="veranstaltungen_fachbereich_'.$this->FACHBEREICHE[$i]['id'].'"	name="veranstaltungen_fachbereich_'.$this->FACHBEREICHE[$i]['id'].'" ###FB'.$this->FACHBEREICHE[$i]['id'].'### disabled="disabled" />
									<label for="veranstaltungen_fachbereich_'.$this->FACHBEREICHE[$i]['id'].'_###ID###">'.$this->FACHBEREICHE[$i]['name'].'</label>
					';
			}
			
			if($INPUT_FORM != '')
				$INPUT_FORM .= '<br/><br/>
								<a class="button" id="select_fachbereich_all_###ID###">Alle markieren</a>
								<a class="button" id="select_fachbereich_none_###ID###">Auswahl entfernen</a>
							';
			
			$this->EVENTFORM 	=  str_replace ('###INPUT_FB###'			,$INPUT_FORM			,$this->EVENTFORM 	);
			$this->EVENTRESULT 	=  str_replace ('###INPUT_FB###'			,$INPUT_RESULT			,$this->EVENTRESULT );
		}
		else
		{
			$this->EVENTFORM 	=  str_replace ('Fehler mit der Datenbank. Fachbereiche konnten nicht geladen werden'			,$INPUT_FORM			,$this->EVENTFORM 	);
			$this->EVENTRESULT 	=  str_replace ('Fehler mit der Datenbank. Fachbereiche konnten nicht geladen werden'			,$INPUT_RESULT			,$this->EVENTRESULT );
		}
	}
	
	//Methode die Usertypes läd und dazu die INPUTS für die Formulare erstellt
	private function createUsertypesInput()
	{
		if($this->USERTYPES != null)
		{	
			$INPUT_FORM = '';
			$INPUT_RESULT = '';
			for($i=0; $i<count($this->USERTYPES); $i++) 
			{
				$INPUT_FORM .=
					'
									<br/>
									<input type="checkbox" class="veranstaltung_checkbox_usertype_###ID###"	id="veranstaltungen_usertypes_'.$this->USERTYPES[$i]['id'].'_###ID###"	name="veranstaltungen_usertypes_'.$this->USERTYPES[$i]['id'].'" ###USER'.$this->USERTYPES[$i]['id'].'### />
									<label for="veranstaltungen_usertypes_'.$this->USERTYPES[$i]['id'].'_###ID###">'.$this->USERTYPES[$i]['name'].'	</label>
					';
				$INPUT_RESULT .= 
					'
									<br/> 
									<input type="checkbox" class="veranstaltung_checkbox"	id="veranstaltungen_usertypes_'.$this->USERTYPES[$i]['id'].'"	name="veranstaltungen_usertypes_'.$this->USERTYPES[$i]['id'].'" ###USER'.$this->USERTYPES[$i]['id'].'### disabled="disabled" />
									<label for="veranstaltungen_usertypes_'.$this->USERTYPES[$i]['id'].'_###ID###">'.$this->USERTYPES[$i]['name'].'	</label>
					';
			}
			if($INPUT_FORM != '')
				$INPUT_FORM .= '<br/><br/>
								<a class="button" id="select_usertype_all_###ID###">Alle markieren</a>
								<a class="button" id="select_usertype_none_###ID###">Auswahl entfernen</a>
							';
			$this->EVENTFORM 	=  str_replace ('###INPUT_UT###'			,$INPUT_FORM			,$this->EVENTFORM 	);
			$this->EVENTRESULT 	=  str_replace ('###INPUT_UT###'			,$INPUT_RESULT			,$this->EVENTRESULT );
		}
		else
		{
			$this->EVENTFORM 	=  str_replace ('Fehler mit der Datenbank. Fachbereiche konnten nicht geladen werden'			,$INPUT_FORM			,$this->EVENTFORM 	);
			$this->EVENTRESULT 	=  str_replace ('Fehler mit der Datenbank. Fachbereiche konnten nicht geladen werden'			,$INPUT_RESULT			,$this->EVENTRESULT );
		}
	}
	
	public function getEmptyForm($FB_GET)
	{
		//Alle Variablen auf null setzen bis auf die ID
		$this->setALL(null, 'new', null, null, null, null, null, null, null, null);
		$this->replaceALL();
		$this->EVENTFORM 	=  str_replace ('###FB_GET###'			,$FB_GET			,$this->EVENTFORM );
		
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
		$this->EVENTFORM 	=  str_replace ('###FB_GET###'			,$FB_GET			,$this->EVENTFORM );
		
		$RESULT =
		'
		<div class="veranstaltung_'.$this->ID.'" style="border-width:1px; border-style:solid;">
			<h3>'.$this->NAME.'</h3>
		
			<a class="button" id="veranstaltung_anzeigen_'.$this->ID.'"		>Veranstaltung anzeigen	</a>
			<a class="button" id="veranstaltung_bearbeiten_'.$this->ID.'"	>Veranstaltung bearbeiten</a>
			<a class="button" id="loesch_button_'.$this->ID.'">L&ouml;schen</a>
			<form action="?FB='.$FB_GET.'" id="veranstaltung_loeschen_'.$this->ID.'" method="post">
				<input type="hidden" name="loeschen_id" id="loeschen_hidden_'.$this->ID.'" value="'.$this->ID.'"/>
			</form>
		';
		
		$RESULT .= $this->getEventResult();
		$RESULT .= $this->getEventForm();
		
		$RESULT .= '</div>';
		return $RESULT;
	}
	
	private function getEventForm()
	{
		return $this->EVENTFORM;	
	}
	
	private function getEventResult()
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
				
				$("#loesch_button_'.$this->ID.'").click(function(){
					MESSAGE = "Veranstaltung wird geloescht!";
					if(confirm(MESSAGE))
						$("#veranstaltung_loeschen_'.$this->ID.'").submit();
				});
				';
		$JQUERY .= $this->getJqueryforAll();
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
		$JQUERY .= $this->getJqueryforAll();
		return $JQUERY;
	}
	
	private function getJqueryforAll()
	{	
	
		$JQUERY =
				'
				//Methode um Formular zu ueberpruefen
				$("#veranstaltung_form_'.$this->ID.'").submit(function(){
					return checkFormular("'.$this->ID.'");
				});
				
				//Methode um allen Checkboxen von Fachbereich das Haekchen zu setzen
				$("#select_fachbereich_all_'.$this->ID.'").click(function(){
					setSelected("veranstaltung_checkbox_fachbereich_'.$this->ID.'");
				});
				
				//Methode um allen Checkboxen von Fachbereich das Haekchen zu entfernen
				$("#select_fachbereich_none_'.$this->ID.'").click(function(){
					setUnselected("veranstaltung_checkbox_fachbereich_'.$this->ID.'");
				});
				
				//Methode um allen Checkboxen von Usertype das Haekchen zu setzen
				$("#select_usertype_all_'.$this->ID.'").click(function(){
					setSelected("veranstaltung_checkbox_usertype_'.$this->ID.'");
				});
				
				//Methode um allen Checkboxen von Usertype das Haekchen zu entfernen
				$("#select_usertype_none_'.$this->ID.'").click(function(){
					setUnselected("veranstaltung_checkbox_usertype_'.$this->ID.'");
				});
					
		';
		
		return $JQUERY;
	}
	
	public function setALL($NAME, $ID, $TAG, $MONAT, $JAHR, $STUNDEN, $MINUTEN, $BESCHREIBUNG, $FB, $USER)
	{
		$this->NAME			= $NAME;
		$this->ID 			= $ID;
		$this->TAG 			= $TAG;
		$this->MONAT	 	= $MONAT;
		$this->JAHR 		= $JAHR;
		$this->STUNDEN 		= $STUNDEN;
		$this->MINUTEN 		= $MINUTEN;
		$this->BESCHREIBUNG = $BESCHREIBUNG;
		$this->FB 			= $FB;
		$this->USER 		= $USER;
		
		$this->replaceALL();
	}	

	private function replaceALL()
	{	
		$this->EVENTFORM =  str_replace ('###NAME###'				,$this->NAME  			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###ID###'					,$this->ID    			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###TAG###'				,$this->TAG   			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###MONAT###'				,$this->MONAT 			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###JAHR###'				,$this->JAHR 			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###STUNDEN###'			,$this->STUNDEN			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###MINUTEN###'			,$this->MINUTEN			,$this->EVENTFORM );
		$this->EVENTFORM =  str_replace ('###BESCHREIBUNG###'		,$this->BESCHREIBUNG	,$this->EVENTFORM );
		
		$this->EVENTRESULT =  str_replace ('###NAME###'				,$this->NAME  			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###ID###'				,$this->ID    			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###TAG###'				,$this->TAG   			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###MONAT###'			,$this->MONAT 			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###JAHR###'				,$this->JAHR 			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###STUNDEN###'			,$this->STUNDEN			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###MINUTEN###'			,$this->MINUTEN			,$this->EVENTRESULT );
		$this->EVENTRESULT =  str_replace ('###BESCHREIBUNG###'		,$this->BESCHREIBUNG	,$this->EVENTRESULT );
		
		//Schleife die alle Fachbereiche durchläuft
		for($i=0; $i<count($this->FACHBEREICHE); $i++)
		{
			$checked = false;
			for($k=0; $k<count($this->FB); $k++)
			{
				if($this->FACHBEREICHE[$i]['id'] == $this->FB[$k]['department_id'])
				{
					$checked = true;
					$this->EVENTRESULT =  	str_replace ('###FB'.$this->FACHBEREICHE[$i]['id'].'###'				,'checked'  		,$this->EVENTRESULT );
					$this->EVENTFORM =  	str_replace ('###FB'.$this->FACHBEREICHE[$i]['id'].'###'				,'checked'			,$this->EVENTFORM );
				}
			}
			if($checked == false)
			{
				$this->EVENTRESULT =  	str_replace ('###FB'.$this->FACHBEREICHE[$i]['id'].'###'				,''  		,$this->EVENTRESULT );
				$this->EVENTFORM =  	str_replace ('###FB'.$this->FACHBEREICHE[$i]['id'].'###'				,''			,$this->EVENTFORM );
			}
			
		}
		
		//Schleife die alle Usertypes durchläuft
		for($i=0; $i<count($this->USERTYPES); $i++)
		{
			$checked = false;
			for($k=0; $k<count($this->USER); $k++)
			{
				if($this->USERTYPES[$i]['id'] == $this->USER[$k]['usertype_id'])
				{
					$checked = true;
					$this->EVENTRESULT =  	str_replace ('###USER'.$this->USERTYPES[$i]['id'].'###'				,'checked'  		,$this->EVENTRESULT );
					$this->EVENTFORM =  	str_replace ('###USER'.$this->USERTYPES[$i]['id'].'###'				,'checked'			,$this->EVENTFORM );
				}
			}
			if($checked == false)
			{
				$this->EVENTRESULT =  	str_replace ('###USER'.$this->USERTYPES[$i]['id'].'###'				,''  		,$this->EVENTRESULT );
				$this->EVENTFORM =  	str_replace ('###USER'.$this->USERTYPES[$i]['id'].'###'				,''			,$this->EVENTFORM );
			}
			
		}
	}
	
	private $EVENTFORM =
	'<div class="veranstaltung" id="form_veranstaltung_###ID###" style="display:none;">
		<form action="?FB=###FB_GET###"	class="veranstaltung_form" id="veranstaltung_form_###ID###" method="post">
			<table class="table_veranstaltung_backend" id="table_veranstaltung_show_###ID###" border="0" width="100%">
				
			<thead>
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
						<div class="div_veranstaltung_form_name" id="div_veranstaltung_form_name_###ID###">
							<input type="text" class="veranstaltung_name"	name="veranstaltung_name" id="veranstaltung_name_###ID###" value="###NAME###" placeholder="Name" size="50" maxlength="30" />
						</div>
					</td>
				</tr>
				
				<tr>
					<td>Datum:</td>
					<td>
						<div class="div_veranstaltung_form_datum" id="div_veranstaltung_form_datum_###ID###">
							<input type="text" class="veranstaltung_datum_tag"		name="veranstaltung_datum_tag" 		id="veranstaltung_datum_tag_###ID###" 		value="###TAG###" 	placeholder="DD" 	size="5" 	maxlength="2" />
							<input type="text" class="veranstaltung_datum_monat"	name="veranstaltung_datum_monat" 	id="veranstaltung_datum_monat_###ID###" 	value="###MONAT###" placeholder="MM" 	size="5" 	maxlength="2" />
							<input type="text" class="veranstaltung_datum_jahr"		name="veranstaltung_datum_jahr" 	id="veranstaltung_datum_jahr_###ID###" 		value="###JAHR###" 	placeholder="YYYY" 	size="10"	maxlength="4" />
						</div>
					</td>
				</tr>
				
				<tr>
					<td>Uhrzeit:</td>
					<td>
						<div class="div_veranstaltung_form_uhrzeit" id="div_veranstaltung_form_uhrzeit_###ID###">
							<input type="text" class="veranstaltung_uhrzeit_stunden"	name="veranstaltung_uhrzeit_stunden" id="veranstaltung_uhrzeit_stunden_###ID###" value="###STUNDEN###" placeholder="HH" size="5" maxlength="2" />
							<input type="text" class="veranstaltung_uhrzeit_stunden"	name="veranstaltung_uhrzeit_minuten" id="veranstaltung_uhrzeit_minuten_###ID###" value="###MINUTEN###" placeholder="MM" size="5" maxlength="2" />
						</div>
					</td>
				</tr>
				
				<tr>
					<td>Beschreibung:</td>
					<td>
						<div class="div_veranstaltung_form_beschreibung" id="div_veranstaltung_form_beschreibung_###ID###">
							<textarea class="veranstaltung_beschreibung"	name="veranstaltung_beschreibung" id="veranstaltung_beschreibung_###ID###" cols="50" rows="10">###BESCHREIBUNG###</textarea>
						</div>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<div class="div_veranstaltung_form_fachbereiche" id="div_veranstaltung_form_fachbereiche_###ID###">
							<fieldset id="fieldset_veranstaltung_form_fachbereich_###ID###" >
								<legend>Fachbereich:</legend>
								
								###INPUT_FB###
							
							</fieldset>
						</div>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<div class="div_veranstaltung_form_usertype" id="div_veranstaltung_form_usertype_###ID###">
							<fieldset id="fieldset_veranstaltung_form_usertype_###ID###">
								<legend>Modus:</legend>
								
								###INPUT_UT###
								
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
		<table class="table_veranstaltung_backend" id="table_veranstaltung_show_###ID###" border="0" width="100%">
			<thead>
			</thead>
			
			<tfoot>
			</tfoot>
			  
			 <tbody>				
				<tr>
					<td>Datum:</td>
					<td>
						<div class="div_veranstaltung_show_datum" id="div_veranstaltung_show_datum_###ID###">###TAG###.###MONAT###.###JAHR###</div>
					</td>
				</tr>
				
				<tr>
					<td>Uhrzeit:</td>
					<td>
						<div class="div_veranstaltung_show_uhrzeit" id="div_veranstaltung_show_uhrzeit_###ID###">###STUNDEN###:###MINUTEN###</div>
					</td>
				</tr>
				
				<tr>
					<td>Beschreibung:</td>
					<td>
						<div class="div_veranstaltung_show_beschreibung" id="div_veranstaltung_show_beschreibung_###ID###">###BESCHREIBUNG###</div>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<div class="div_veranstaltung_show_fachbereiche" id="div_veranstaltung_show_fachbereiche_###ID###">
							<fieldset>
								<legend>Fachbereich:</legend>
								
								###INPUT_FB###
								
							</fieldset>
						</div>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<div class="div_veranstaltung_show_usertype" id="div_veranstaltung_show_usertype_###ID###">
							<fieldset>
								<legend>Modus:</legend>
								
								###INPUT_UT###
								
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