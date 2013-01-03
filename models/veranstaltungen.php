<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Sascha M�ller (FM), <sascha.moeller@fh-duesseldorf.de>
 */
 
class Veranstaltungen{

	private $connection;
	
	public function __construct(){
		//Konstruktor
		$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
	}
	
	public function addDatensatz()
	{
		//$lang = $_POST['veranstaltung_language'];
		$lang = 1; // 1 f�r Deutsch
		$name = $_POST['veranstaltung_name'];
		$datum = $_POST['veranstaltung_datum_jahr'].'-'.$_POST['veranstaltung_datum_monat'].'-'.$_POST['veranstaltung_datum_tag'];
		$beschreibung = $_POST['veranstaltung_beschreibung'];
		
		try
		{
			$this->connection->query("INSERT INTO events (language_id,name,date,description) VALUES ('".$lang."', '".$name."', '".$datum." 00:00:00', '".$beschreibung."');");
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
		
		
		if($_POST['veranstaltungen_fachbereich_1'])
		{
		//$this->connection->query("INSERT INTO events_mm_departments (event_id,department_id) VALUES ();
		}
		if($_POST['veranstaltungen_fachbereich_2'])
		{
		}
		if($_POST['veranstaltungen_fachbereich_3'])
		{
		}
		if($_POST['veranstaltungen_fachbereich_4'])
		{
		}
		if($_POST['veranstaltungen_fachbereich_5'])
		{
		}
		if($_POST['veranstaltungen_fachbereich_6'])
		{
		}
		if($_POST['veranstaltungen_fachbereich_7'])
		{
		}
		
		
	}
	
	public function getInformation($usertype, $fachbereich)
	{
		try
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
		}
	}
}
 
/* End of file veranstaltungen.php */
/* Location: ./models/veranstaltungen.php */
