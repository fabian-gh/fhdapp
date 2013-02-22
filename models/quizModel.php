<?php

	/**
	 * Schnittstelle zwischen Controller und Datenbank für's Quiz
	**/
	class QuizModel
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
		 * @return array Gibt ein Array mit allen Tags zurück.
		**/
		public function getTags()
		{
			try
			{
				$result = $this->connection->query("SELECT * FROM quiztags");
				$resultSet = array();
				if($result != null)
					while($row = $result->fetch_assoc())
					{
						$resultSet[] = $row;
					}
				return $resultSet;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		/**
		 * @param string $params String zusammengesetzt aus den Tags, welche angewählt sind (Bsp.: AND (b.tag_id = 7 OR b.tag_id = 1 OR b.tag_id = 2))
		 *
		 * @return array Gibt ein Array mit den Studiengängen, die zu den Tags passen, zurück. Sortiert nach der Relevanz.
		**/
		public function getList($params)
		{
			try
			{
				//jeder studiengang hat zu bestimmten tags eine bewertung / wichtung
				//diese werden aufsummiert, heißt je mehr tags zu einem studiengang passen, desto größer die gesamtwertung
				//damit ein studiengang, der mehrmals in der db vorliegt (da bachelor und master), nicht doppelt bewertet wird, muss vorausgesetzt werden,
				//dass nur eines der tupel in der studycourses_mm_tags referenziert wird
				$result = $this->connection->query("SELECT a.name , SUM(b.rating) rating
													FROM studycourses a, studycourses_mm_quiztags b
													WHERE a.id = b.studycourse_id $params
													GROUP BY (a.id)
													ORDER BY rating DESC");
				$resultSet = array();
				if($result != null)
					while($row = $result->fetch_assoc())
					{
						$resultSet[] = $row;
					}
				return $resultSet;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}
	}

?>