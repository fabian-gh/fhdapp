<?php

/**
 * FHD-App
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Sascha Möller (FM), <sascha.moeller@fh-duesseldorf.de>
 */
 
class Veranstaltungen{

	private $connection;
	
	public function __construct(){
		//Konstruktor
		$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
	}
		
	//Backend
	//Methode die eine neue Veranstaltung mit allen Beziehungen zu Fachbereichen und Benutzern erstellt
	public function addDatensatz()
	{
		//$lang = $_POST['veranstaltung_language'];
		$lang = 1; // 1 für Deutsch
		$name = $_POST['veranstaltung_name'];
		$datum = $_POST['veranstaltung_datum_jahr'].'-'.$_POST['veranstaltung_datum_monat'].'-'.$_POST['veranstaltung_datum_tag'];
		$uhrzeit = $_POST['veranstaltung_uhrzeit_stunden'].'-'.$_POST['veranstaltung_uhrzeit_minuten'];
		$beschreibung = $_POST['veranstaltung_beschreibung'];
	
		//Die Veranstaltung wird erstellt
		try
		{
			$this->connection->query("INSERT INTO events (language_id,name,date,description) VALUES ('".$lang."', '".$name."', '".$datum." ".$uhrzeit.":00', '".$beschreibung."');");
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
		
		//Automatisch zugewissene ID von der eingetragnen Veranstaltung
		$event_id = $this->connection->insert_id;
		
		//Beziehung zu Fachbereichen herstellen und in die Datenbank eintragen
		if(isset($_POST['veranstaltungen_fachbereich_1']))
		{
			$this->connection->query("INSERT INTO events_mm_departments (department_id,event_id) VALUES (1,'".$event_id."')");
		}
		if(isset($_POST['veranstaltungen_fachbereich_2']))
		{
			$this->connection->query("INSERT INTO events_mm_departments (department_id,event_id) VALUES (2,'".$event_id."')");
		}
		if(isset($_POST['veranstaltungen_fachbereich_3']))
		{
			$this->connection->query("INSERT INTO events_mm_departments (department_id,event_id) VALUES (3,'".$event_id."')");
		}
		if(isset($_POST['veranstaltungen_fachbereich_4']))
		{
			$this->connection->query("INSERT INTO events_mm_departments (department_id,event_id) VALUES (4,'".$event_id."')");
		}
		if(isset($_POST['veranstaltungen_fachbereich_5']))
		{
			$this->connection->query("INSERT INTO events_mm_departments (department_id,event_id) VALUES (5,'".$event_id."')");
		}
		if(isset($_POST['veranstaltungen_fachbereich_6']))
		{
			$this->connection->query("INSERT INTO events_mm_departments (department_id,event_id) VALUES (6,'".$event_id."')");
		}
		if(isset($_POST['veranstaltungen_fachbereich_7']))
		{
			$this->connection->query("INSERT INTO events_mm_departments (department_id,event_id) VALUES (7,'".$event_id."')");
		}
		
		//Beziehung zu Benutzern herstellen und in die Datenbank eintragen
		if(isset($_POST['veranstaltungen_usertypes_1']))
		{
			$this->connection->query("INSERT INTO events_mm_usertypes (usertype_id, event_id) VALUES (1,'".$event_id."')");
		}
		if(isset($_POST['veranstaltungen_usertypes_2']))
		{
			$this->connection->query("INSERT INTO events_mm_usertypes (usertype_id, event_id) VALUES (2,'".$event_id."')");
		}
		if(isset($_POST['veranstaltungen_usertypes_3']))
		{
			$this->connection->query("INSERT INTO events_mm_usertypes (usertype_id, event_id) VALUES (3,'".$event_id."')");
		}
	}
	
	//Methode die eine Veranstaltung komplett aus der Datenbank mit allen Beziehungen löscht
	public function deleteDatensatz($event_id)
	{
		//Beziehungen zwischen Veranstaltung und Benutzer löschen
		$delete_statement = '	DELETE 
								FROM events_mm_usertypes 
								WHERE event_id = '.$event_id;
		$this->connection->query($request);
		
		//Beziehungen zwischen Veranstaltung und Fachbereich löschen
		$delete_statement = '	DELETE 
								FROM events_mm_departments 
								WHERE event_id = '.$event_id;
		$this->connection->query($request);
		
		//Die Veranstaltung löschen
		$delete_statement = '	DELETE 
								FROM events 
								WHERE id = '.$event_id;
		$this->connection->query($request);
	}
	
	//Backend
	//Methode die Veranstaltung aus der Datenbank laed,
	//Unter Auswahl des Fachbereiches
	//Ohne auf Benutzertyp zu achten
	public function createStatementEventsWithDepartmentsWihoutUsertype($department){
		$statement = "
				SELECT 
				events.id,events.language_id,events.name,events.date,events.description
				
				FROM EVENTS ,events_mm_departments,departments,languages
				
				WHERE events.id = events_mm_departments.event_id 
				AND events.language_id = languages.id 
				AND events_mm_departments.department_id = departments.id
				AND events_mm_departments.department_id = ".$department."";
				;

		return $this->getInformation($statement);
	}
	
	//Backend
	//Methode die alle Fachbereiche zu einem Event auszulesen
	public function createStatementDepartmentsFromEvents($event_id)
	{
		$statement = '	SELECT *
						FROM events_mm_usertypes
						WHERE event_id = '.$event_id;
		return $this->getInformation($statement); 
	}
	
	//Backend
	//Methode die alle Benutzer zu einem Event auszulesen
	public function createStatementUsertypesFromEvents($event_id)
	{
		$statement = '	SELECT *
						FROM events_mm_departments
						WHERE event_id = '.$event_id;
						
		return $this->getInformation($statement);
	}
	
	
	public function createStatement($usertype,$department){
				
	$request = "SELECT events.id,events.language_id,events.name,events.date,events.description
				FROM events,events_mm_departments,events_mm_usertypes,departments,languages,usertypes
				WHERE events.id = events_mm_departments.event_id AND events.language_id = languages.id AND
				events_mm_departments.department_id = departments.id AND events_mm_usertypes.usertype_id = usertypes.id
				AND events_mm_usertypes.event_id = events.id AND events_mm_usertypes.usertype_id = ".$usertype."
				AND events_mm_departments.department_id = ".$department."";
				;

	return $this->getInformation($request);
	}

	//Methode die SQL-Statements ausführt
	public function getInformation($request)
	{
		$result = $this->connection->query($request);
		if( $result->num_rows > 0)
		{
				while($temp = $result->fetch_assoc())
				{
					$resultSet[] = $temp;
				}
				return $resultSet;
		}
		else
		{
				//echo "Es ist kein Datensatz vorhanden";
				return null;
		}
		
		/*try
		{
			$result = $this->connection->query("SELECT * FROM events");
			
			while($row = $result->fetch_assoc())
			{
				$resultSet[] = ($row['name'].';'.$row['date'].';'.$row['description']);
			}
			return $resultSet;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}*/
	}
}
 
/* End of file veranstaltungen.php */
/* Location: ./models/veranstaltungen.php */