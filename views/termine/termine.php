<?php

	require_once 'controllers/termineController.php';
    $appointmentController = new AppointmentController();
    $dept = 1;//$appointmentController->getDepartmentFromStudycourse($_GET['course']);
    $semestersWithAppointments = $appointmentController->semestersWithAppointmentsForUsertype($dept, $_GET['eis']);

	echo "<div data-role='collapsible-set' data-iconpos='right' data-collapsed-icon='arrow-r' data-expanded-icon='arrow-d' data-theme='a'>";
		for($i = 0; $i < count($semestersWithAppointments); $i++)
		{
			//header mit namen erstellen, ersten ausklappen
			$name = $semestersWithAppointments[$i]->name;
			if($i == 0)
				echo "<div data-role='collapsible' data-collapsed='false'><h3>$name</h3><table width='100%'>";
			else
				echo "<div data-role='collapsible'><h3>$name</h3><table width='100%'>";
			
			//termine in block einfügen
			$temp = $semestersWithAppointments[$i]->appointments;
			if($temp != null)
				foreach($temp as $appointment)
				{
					echo "<tr><td>{$appointment['name']}</td><td>{$appointmentController->sqlToDate($appointment['date_from'])}</td></tr>
					<tr><td/><td>{$appointmentController->sqlToDate($appointment['date_to'])}</td></tr>";
				}
			echo "</table></div>";
		}
	echo "</div>";

?>