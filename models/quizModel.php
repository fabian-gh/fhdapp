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
				$result = $this->connection->query("SELECT * FROM tags");
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

		public function getList($params) //bsp AND (b.tag_id = 7 OR b.tag_id = 1 OR b.tag_id = 2)
		{
			try
			{
				$result = $this->connection->query("SELECT a.name , SUM(b.rating) rating
													FROM studycourses a, studycourses_mm_tags b
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