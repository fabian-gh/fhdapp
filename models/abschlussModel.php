<?php

	class GradeModel
	{
		private $connection;

		public function __construct()
		{
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
		}

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