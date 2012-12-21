<?php

	require_once 'controllers/termineController.php';
    $appointmentController = new AppointmentController();
    $semestersWithAppointments = $appointmentController->semestersWithAppointments($_GET['dept']);

	echo "<div data-role='collapsible-set'>";
		for($i = 0; $i < count($semestersWithAppointments); $i++)
		{
			//header mit namen erstellen, ersten ausklappen
			$name = $semestersWithAppointments[$i]->name;
			if($i == 0)
				echo "<div data-role='collapsible' data-theme='a' data-collapsed='false'><h3>$name</h3><table>";
			else
				echo "<div data-role='collapsible' data-theme='a'><h3>$name</h3><table>";
			
			//termine in block einfügen
			$temp = $semestersWithAppointments[$i]->appointments;
			if($temp != null)
				foreach($temp as $appointment)
				{
					echo "<tr><td>{$appointment['name']}</td><td>{$appointment['date_from']}</td><td>{$appointment['date_to']}</td></tr>";
				}
			echo "</table></div>";
		}
	echo "</div>";

?>