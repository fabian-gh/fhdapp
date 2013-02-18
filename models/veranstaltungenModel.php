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
	public function addEvent($EVENT_ID)
	{
		//$lang = $_POST['veranstaltung_language'];
		$LANG 			= 1; // 1 für Deutsch
		$NAME 			= $_POST['veranstaltung_name'];
		$DATUM 			= $_POST['veranstaltung_datum_jahr'].'-'.$_POST['veranstaltung_datum_monat'].'-'.$_POST['veranstaltung_datum_tag'];
		$UHRZEIT 		= $_POST['veranstaltung_uhrzeit_stunden'].'-'.$_POST['veranstaltung_uhrzeit_minuten'];
		$BESCHREIBUNG 	= $_POST['veranstaltung_beschreibung'];
	
		//Die Veranstaltung wird erstellt
		try
		{
			$this->connection->query("
									INSERT INTO events 
									(id,language_id,name,date,description) 
									VALUES 
									(	
										'".$EVENT_ID."',
										'".$LANG."', 
										'".$NAME."', 
										'".$DATUM." ".$UHRZEIT.":00',
										'".$BESCHREIBUNG."');
									");
		}
		catch(Exception $e)
		{
			return false;
		}
				
		//Automatisch zugewissene ID von der eingetragnen Veranstaltung zwischenspeichern
		$EVENT_ID = $this->connection->insert_id;
		
		//Verbindung zwischen Fachbereich und Veranstaltung erstellen
		if($this->addRelationshipEventDepartment($EVENT_ID) == false)
		{
			$this->deleteEvent($EVENT_ID);
			return false;
		}
		
		//Verbindung zwischen Fachbereich und Usertype erstellen
		if($this->addRelationshipEventUsertype($EVENT_ID) == false)
		{
			$this->deleteEvent($EVENT_ID);
			return false;
		}
		return true;
	}
	
	//Backend
	//Methode die die Beziehungen zwischen Fachbereichen und Veranstaltungen 
	//in die Datenbank eintraegt
	public function addRelationshipEventDepartment($EVENT_ID)
	{	
		$DEPARTMENTS = $this->createStatementDepartments();
		//Fachbereiche bestimmen die zur Veranstaltung gehören
		$VALUES = '';
		$ERSTER_EINTRAG = true;
		
		//So oft durchlaufen wie es Fachbereiche gibt
		for($i=0; $i < count($DEPARTMENTS);$i++)
		{
			if(isset($_POST['veranstaltungen_fachbereich_'.$DEPARTMENTS[$i]['id']]))
			{
				if($ERSTER_EINTRAG == true)
				{
					$ERSTER_EINTRAG = false;
					$VALUES .= 	'
							(
								'.$DEPARTMENTS[$i]['id'].',
								'.$EVENT_ID.'
							)';
				}
				else
				{
					$VALUES .= 	',
							(
								'.$DEPARTMENTS[$i]['id'].',
								'.$EVENT_ID.'
							)';
				}
			}
		}
		
		//Beziehung zu Fachbereichen in die Datenbank eintragen
		if($ERSTER_EINTRAG != true)
		{
			try
			{
				$this->connection->query('
											INSERT INTO events_mm_departments 
											(department_id,event_id) 
											VALUES
											'.$VALUES.'
										');
			}
			catch(Exception $e)
			{
				return false;
			}
			return true;
		}
		return false;
	}
	
	//Backend
	//Methode die die Beziehungen zwischen UserTypes und Veranstaltungen 
	//in die Datenbank eintraegt
	public function addRelationshipEventUsertype($EVENT_ID)
	{
		$USERTYPES = $this->createStatementUsertypes();
		//Usertypes bestimmen die zur Veranstaltung gehören
		$VALUES = '';
		$ERSTER_EINTRAG = true;
		
		for($i=0; $i < count($USERTYPES);$i++)
		{
			if(isset($_POST['veranstaltungen_usertypes_'.$USERTYPES[$i]['id']]))
			{
				if($ERSTER_EINTRAG == true)
				{
					$ERSTER_EINTRAG = false;
					$VALUES .= 	'
							(
								'.$USERTYPES[$i]['id'].',
								'.$EVENT_ID.'
							)';
				}
				else
				{
					$VALUES .= 	'
							,(
								'.$USERTYPES[$i]['id'].',
								'.$EVENT_ID.'
							)';
				}
			}
		}
		
		//Beziehung zu Usertypes in die Datenbank eintragen
		if($ERSTER_EINTRAG != true)
		{
			try
			{
				$this->connection->query('
											INSERT INTO events_mm_usertypes 
											(usertype_id, event_id)
											VALUES
											'.$VALUES.'
										');
			}
			catch(Exception $e)
			{
				return false;
			}
			return true;
		}
		return false;
	}
	
	//Backend
	//Methode die eine Veranstaltung komplett aus der Datenbank mit allen Beziehungen löscht
	public function deleteEvent($event_id)
	{
		try
		{
			//Beziehungen zwischen Veranstaltung und Benutzer löschen
			$DELETE_STATEMENT = '	DELETE 
									FROM events_mm_usertypes 
									WHERE event_id = '.$event_id;
			$this->connection->query($DELETE_STATEMENT);
			
			//Beziehungen zwischen Veranstaltung und Fachbereich löschen
			$DELETE_STATEMENT = '	DELETE 
									FROM events_mm_departments 
									WHERE event_id = '.$event_id;
			$this->connection->query($DELETE_STATEMENT);
			
			//Die Veranstaltung löschen
			$DELETE_STATEMENT = '	DELETE 
									FROM events 
									WHERE id = '.$event_id;
			$this->connection->query($DELETE_STATEMENT);
		}
		catch(Exception $e)
		{
			return false;
		}
		return true;
	}
	
	//Backend
	//Methode die alle Veranstaltungen ausliest, die älter vorm heutigen Datum liegen
	public function getOldEvents()
	{
		$STATEMENT = "
				SELECT events.id
				
				FROM events , events_mm_departments, departments, languages
				
				WHERE events.id = events_mm_departments.event_id 
				AND events.language_id = languages.id 
				AND events_mm_departments.department_id = departments.id
				AND events.date < NOW()
				ORDER BY events.date
				";
				
		return $this->getInformation($STATEMENT);
	}
	
	//Backend
	//Methode die Veranstaltung aus der Datenbank laed,
	//Unter Auswahl des Fachbereiches
	//Ohne auf Benutzertyp zu achten
	public function createStatementEventsWithDepartmentsWihoutUsertype($department){
		$STATEMENT = "
				SELECT 
				events.id,events.language_id,events.name,events.date,events.description				
				
				FROM events , events_mm_departments, departments, languages
				
				WHERE events.id = events_mm_departments.event_id 
				AND events.language_id = languages.id 
				AND events_mm_departments.department_id = departments.id
				AND events_mm_departments.department_id = ".$department."
				AND events.date >= NOW()
				
				ORDER BY events.date
				";

		return $this->getInformation($STATEMENT);
	}
	
	//Backend
	//Methode die alle Fachbereiche zu einem Event auszulesen
	public function createStatementDepartmentsFromEvents($event_id)
	{
		$STATEMENT = '	SELECT *
						FROM events_mm_departments
						WHERE event_id = '.$event_id.'
						ORDER BY department_id';
		return $this->getInformation($STATEMENT); 
	}
	
	//Backend
	//Methode die alle Benutzer zu einem Event auszulesen
	public function createStatementUsertypesFromEvents($event_id)
	{
		$STATEMENT = '	SELECT *
						FROM events_mm_usertypes
						WHERE event_id = '.$event_id.'
						ORDER BY usertype_id';
		return $this->getInformation($STATEMENT);
	}
	
	//Backend
	//Methode die alle Fachbereiche auszuliest
	public function createStatementDepartments()
	{
		$STATEMENT = '	SELECT id,name
						FROM departments
						ORDER BY id;
					';
						
		return $this->getInformation($STATEMENT);
	}
	
	//Backend
	//Methode die alle Benutzer auszuliest
	public function createStatementUsertypes()
	{
		$STATEMENT = '	SELECT *
						FROM usertypes
						ORDER BY id;
					';
						
		return $this->getInformation($STATEMENT);
	}
	/**
	* Frontend
	* Methode die die passende Fachbereich-ID für den entsprechnenden Studiengang ausliest
	* @param $course Studiengang aus der Adresszeile
	* @return Fachbereich ID
	**/
	public function getStudycourseInformation ($course)
	{
		$statement = "	SELECT department_id
						FROM studycourses
						WHERE name = '$course'
						LIMIT 1";
		return $this->getInformation($statement);
	}
	/**
	* Frontend
	* Methode die den Benutzertyp zu einer Zahl wandelt
	* @param $usertype Benutzertyp aus der Adresszeile
	* @return Zahl für Benutzertyp
	**/
	public function getUsertypeInformation($usertype)
	{
	switch($usertype)
		{
			case 'i': $usertype = 1; break;
			case 'e': $usertype = 2; break;
			case 's': $usertype = 3; break;
		}
		
	return $usertype;
	}
	/**
	* Frontend
	* Methode die alle Einträge/Informationen aus Veranstaltungen ausliest
	* @param $usertype Benutzertyp(Interessent,Erstsemester,Student
	* @param $department Fachbereichs-ID
	* @return SQL-Ergebnis_Relation
	**/
	public function createStatement($usertype,$department){
	
	$usertype= $this->getUsertypeInformation($usertype);
	
	$request = "SELECT events.id,events.language_id,events.name,events.date,events.description
	
				FROM events,events_mm_departments,events_mm_usertypes,departments,languages,usertypes
				
				WHERE events.id = events_mm_departments.event_id AND events.language_id = languages.id AND
				events_mm_departments.department_id = departments.id AND events_mm_usertypes.usertype_id = usertypes.id
				AND events_mm_usertypes.event_id = events.id AND events_mm_usertypes.usertype_id = ".$usertype."
				AND events_mm_departments.department_id = ".$department." AND events.date >= NOW()
				
				ORDER BY events.date";

	return $this->getInformation($request);
	}

	/**
	* Frontend/Backend
	* Methode die SQL-Statements ausführt
	* @param $request SQL-Statements
	* @return SQL-Ergebnis_Relation in ein Array
	**/
	public function getInformation($request)
	{
		try
		{
			$result = $this->connection->query($request);
			if( $result->num_rows > 0)
			{		
					while($temp = $result->fetch_assoc())
					{
						//Ins Array speichern
						$resultSet[] = $temp;
					}
					return $resultSet;
			}
			else
			{
					return null;
			}
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
}
 
/* End of file veranstaltungen.php */
/* Location: ./models/veranstaltungen.php */