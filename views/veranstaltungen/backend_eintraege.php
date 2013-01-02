<?PHP
		
		//require_once '../../controllers/veranstaltungenController.php';
		//$Controller = new VeranstaltungenController();
		//$ergebnis =  $Controller->getInformation(1,1);	
		 
		require_once 'backend_dummy_formular.php';
				 
		$jquery_complete = ' ';
		$jquery_dummy = '
						$("#veranstaltung_anzeigen_###ID###").click(function(){
								$(".new_formular").hide();
								$("#edit_veranstaltung_###ID###").hide();
								$("#show_veranstaltung_###ID###").slideToggle("fast")();
							});
									
							
						$("#veranstaltung_bearbeiten_###ID###").click(function(){
								$(".new_formular").hide();	
								$("#show_veranstaltung_###ID###").hide();
								$("#edit_veranstaltung_###ID###").slideToggle("fast")();
							});
						';
		
		//foreach($ergebnis as $details)
		//{
		for($i = 0 ;$i < 5;$i++)
		{
			$dummy = $dummy1;
			
			$NAME  			= 'TEST';
			$ID    			=  $i;
			$TAG   			= '17';
			$MONAT 			= '06';
			$JAHR 			= '2012';
			$BESCHREIBUNG	= 'MEIN GEBURTSTAG';
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
			
			
			$dummy =  str_replace ('###NAME###'			,$NAME  			,$dummy );
			$dummy =  str_replace ('###ID###'			,$ID    			,$dummy );
			$dummy =  str_replace ('###TAG###'			,$TAG   			,$dummy );
			$dummy =  str_replace ('###MONAT###'		,$MONAT 			,$dummy );
			$dummy =  str_replace ('###JAHR###'			,$JAHR 				,$dummy );
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
		//}
?>