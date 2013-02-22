<?php

	/**
	 * Schnittstelle zwischen Controller und Datenbank für die Wahl des Abschlusses
	**/
	class GradeModel
	{
		private $connection;

		/**
		 * Erstellt das Model und stelt Verbindung zur Datenbank her
		**/
		public function __construct()
		{
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
		}

		/**
		 * @param string Name des Studienganges, wessen Abschlussarten herausgefunden werden soll
		 *
		 * @return array Array mit allen Abschlussarten eines Studienganges
		**/
		public function getGrades($course)
		{
			$result = $this->connection->query("SELECT graduates.name
												FROM studycourses, graduates
												WHERE studycourses.name = '$course'
													AND graduates.id = studycourses.graduate_id");
			$resultSet = array();
			
			while($row = $result->fetch_assoc())
			{
				$resultSet[] = $row;
			}

			return $resultSet;
		}
	}
	
?>