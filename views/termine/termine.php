<?php

	require_once 'controllers/termineController.php';
    $appointmentController = new AppointmentController();
    $dept = $appointmentController->getDepartmentFromStudycourse($_GET['course']);

    $semestersWithAppointments = $appointmentController->semestersWithAppointmentsForUsertype($dept, $_GET['eis']);

    if(count($semestersWithAppointments) == 0)
    	echo 'Es sind keine Termine vorhanden.';
    else
		echo "<div data-role='collapsible-set' data-iconpos='right' data-collapsed-icon='arrow-r' data-expanded-icon='arrow-d' data-theme='a'>";
			for($i = 0; $i < count($semestersWithAppointments); $i++)
			{
				//header mit namen erstellen, ersten ausklappen
				$name = $semestersWithAppointments[$i]->name;
				if($i == 0)
					echo "<div data-role='collapsible' data-collapsed='false'><h3>$name</h3><table class='appointment'>";
				else
					echo "<div data-role='collapsible'><h3>$name</h3><table class='appointment'>";
				
				//termine in block einfügen
				$temp = $semestersWithAppointments[$i]->appointments;
				if($temp != null)
					for($i = 0; $i < count($temp); $i++)
					{
						$appointment = $temp[$i];
						echo "<tr><td align='left'>{$appointment['name']}</td><td align='right' valign='top'>{$appointmentController->sqlToDate($appointment['date_from'])}<br>{$appointmentController->sqlToDate($appointment['date_to'])}</td></tr>";
					}
				echo "</table></div>";
			}
		echo "</div>";

?>