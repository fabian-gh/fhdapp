<?php

	class AppointmentModel
	{
		private $connection;

		public function __construct()
		{
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
		}

		
		//semester

		//alle semester eines fachbereichs ausgeben
		public function getSemesters($dept)
		{
			try
			{
				$result = $this->connection->query("SELECT * FROM semester WHERE department_id = $dept");
				$resultSet = [];
				while($row = $result->fetch_assoc())
				{
					$resultSet[] = new Semester($row["id"], $row["name"], $row["department_id"]);
				}
				return $resultSet;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		public function insertSemester($language, $name, $department)
		{
			try
			{
				$this->connection->query("INSERT INTO semester(language_id, name, department_id) VALUES($language, '$name', $department)");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		public function updateSemester($id, $language, $name)
		{
			try
			{
				$this->connection->query("UPDATE semester SET language_id = $language, name = '$name' WHERE id = $id");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		//semester entfernen
		public function removeSemester($id)
		{
			try
			{
				$this->connection->query("DELETE FROM semester WHERE id = $id");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		
		//termine

		//alle termine eines semesters ausgeben
		public function getAppointments($semester_id)
		{
			try
			{
				$result = $this->connection->query("SELECT * FROM appointments WHERE semester_id = $semester_id");
				$resultSet = [];
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

		public function insertAppointment($language, $semester, $name, $date_from, $date_to, $interested, $freshman, $student)
		{
			try
			{
				$this->connection->query("INSERT INTO appointments(language_id, semester_id, name, date_from, date_to, interested, freshman, student) VALUES($language, $semester, '$name', '$date_from', '$date_to', $interested, $freshman, $student)");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		public function updateAppointment($id, $language, $name, $date_from, $date_to, $interested, $freshman, $student)
		{
			try
			{
				$this->connection->query("UPDATE appointments SET language_id = $language, name = '$name', date_from = '$date_from', date_to = '$date_to', interested = $interested, freshman = $freshman, student = $student WHERE id = $id");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		//termin entfernen
		public function removeAppointment($id)
		{
			try
			{
				$this->connection->query("DELETE FROM appointments WHERE id = $id");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}		
	}

?>