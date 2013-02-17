<<<<<<< HEAD
<<<<<<< HEAD
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

=======
<?php
	
	echo "<h1>Termine</h1>";
	
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
					for($j = 0; $j < count($temp); $j++)
					{
						$appointment = $temp[$j];
						echo "<tr><td align='left'>{$appointment['name']}</td><td align='right' valign='top'>{$appointmentController->sqlToDate($appointment['date_from'])}<br>{$appointmentController->sqlToDate($appointment['date_to'])}</td></tr>";
					}
				echo "</table></div>";
			}
		echo "</div>";

>>>>>>> origin/daniel16.02
=======
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

>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
?>