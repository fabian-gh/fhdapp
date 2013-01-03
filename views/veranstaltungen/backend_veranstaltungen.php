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
	
	//Header einbinden
	require_once '../../layout/backend/header.php';
		
	//Überprüfung ob Formular abgesendet wurde
	if(isset($_POST['veranstaltung_speichern']))
	{
		echo 'Vielen Dank';
		require_once '../../controllers/veranstaltungenController.php';
		
        // Controller-Instanz erstellen und das Data-Objekt übergeben
        $Controller = new VeranstaltungenController();
		$Controller->addDatensatz();
	}
	//Falls kein Formular übergeben wurde, dann leeres Formular anzeigen
	else
	{
		require_once 'backend_formular.php';
		echo '<br><br><br><br>';
				
		require_once 'backend_auswahl.php';
		echo '<br><br><br><br>';
		
		require_once 'backend_eintraege.php';
		echo '<br><br><br><br>';
	}
	
	echo '
		<script type="text/javascript">
			$(function(){ 
				$("#new_formular_button").click(function(){
					hide_all();
					$("#new_formular").slideToggle("fast");
				});
				
				$("#fachbereich_select").change(function(){
					$("#fachbereich_auswahl").submit();
				});
				
				$("#loesch_button").click(function(){
					$("#loesch_form").submit();
				});
				
				function hide_all()
				{
					$(".edit_veranstaltung").hide();
					$(".show_veranstaltung").hide();
				}
					
				'.$jquery_complete.'
			});
		</script>
		';

	require_once '../../layout/backend/footer.php';
	ob_end_flush();
	/* End of file veranstaltungen_edit.php */
	/* Location: ./views/veranstaltungen/veranstaltungen_edit.php */
?>