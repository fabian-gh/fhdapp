<?PHP
		require_once 'backend_datenbank_eintraege_dummy.php';
				 
		$jquery_complete = ' ';
		$jquery_dummy = '
						$("#veranstaltung_anzeigen_###ID###").click(function(){
								$(".new_formular").hide();
								$("#edit_veranstaltung_###ID###").hide();
								$("#show_veranstaltung_###ID###").slideToggle("fast");
							});
									
							
						$("#veranstaltung_bearbeiten_###ID###").click(function(){
								$(".new_formular").hide();	
								$("#show_veranstaltung_###ID###").hide();
								$("#edit_veranstaltung_###ID###").slideToggle("fast");
							});
						';
						
		//Datenbank-Abfrage alle Veranstaltungen für aktuellen Fachbereich laden
		$ERGEBNIS =  $Controller->getInformationEventsWithDepartmentsWihoutUsertype($FB_GET);
		
		
		if($ERGEBNIS != null)
		{
			//Veranstaltungen durchlaufen und darstellen
			for($i=0; $i<count($ERGEBNIS); $i++) 
				{
				$NAME = $ERGEBNIS[$i]['name'];
				$ID = $ERGEBNIS[$i]['id'];
				$DATUM = new DateTime($ERGEBNIS[$i]['date']);
				$BESCHREIBUNG = $ERGEBNIS[$i]['description'];			
				
				//DATUM SPLITTEN
				
				$TAG = 		date_format($DATUM, 'd');
				$MONAT = 	date_format($DATUM, 'm');
				$JAHR = 	date_format($DATUM, 'Y');
				$STUNDEN = 	date_format($DATUM, 'H');
				$MINUTEN =	date_format($DATUM, 'i');
				
				//Datenbank-Abfrage für Veranstaltungen um alle zugehörigen Fachbereiche zu laden
				//$ERGEBNIS =  $Controller->getInformationVeranstaltungen($FB_GET);
				
				$FB1			= '  ';  	
				$FB2			= '  ';  	
				$FB3			= '  ';  	
				$FB4			= '  ';  	
				$FB5			= '  ';  	
				$FB6			= '  ';  	
				$FB7			= 'X';  	
				$INTERESSENT	= '  ';	
				$STUDENT		= '  ';	
				$ERSTI			= '  ';	
				
				$dummy = $dummy1;		//Normales Formular kopieren
				$dummy =  str_replace ('###NAME###'			,$NAME  			,$dummy );
				$dummy =  str_replace ('###ID###'			,$ID    			,$dummy );
				$dummy =  str_replace ('###TAG###'			,$TAG   			,$dummy );
				$dummy =  str_replace ('###MONAT###'		,$MONAT 			,$dummy );
				$dummy =  str_replace ('###JAHR###'			,$JAHR 				,$dummy );
				$dummy =  str_replace ('###STUNDEN###'		,$STUNDEN			,$dummy );
				$dummy =  str_replace ('###MINUTEN###'		,$MINUTEN			,$dummy );
				$dummy =  str_replace ('###BESCHREIBUNG###'	,$BESCHREIBUNG		,$dummy );
				$dummy =  str_replace ('###FB1###'			,$FB1		  		,$dummy );
				$dummy =  str_replace ('###FB2###'			,$FB2		  		,$dummy );
				$dummy =  str_replace ('###FB3###'			,$FB3		  		,$dummy );
				$dummy =  str_replace ('###FB4###'			,$FB4		  		,$dummy );
				$dummy =  str_replace ('###FB5###'			,$FB5		  		,$dummy );
				$dummy =  str_replace ('###FB6###'			,$FB6		  		,$dummy );
				$dummy =  str_replace ('###FB7###'			,$FB7		  		,$dummy );
				$dummy =  str_replace ('###INTERESSENT###'	,$INTERESSENT		,$dummy );
				$dummy =  str_replace ('###STUDENT###'		,$STUDENT			,$dummy );
				$dummy =  str_replace ('###ERSTI###'		,$ERSTI				,$dummy );
				
				echo $dummy;
				echo '<br><br><br><br>';
				
				$jquery_complete = $jquery_complete . str_replace ('###ID###'	,$ID	,$jquery_dummy );
			}
		}
		else
		{
			echo "Kein Datensatz vorhanden!";
		}
?>