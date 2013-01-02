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

		//alle semester für eine bestimmte nutzergruppe ausgeben(nur die semester, welche termine für den bestimmten nutzer haben)
		public function getSemestersForUsertype($dept, $eis)
		{
			try
			{
				//aus der getvariable die whereklausel der nutzergruppe bestimmen
				switch($eis)
				{
					case 'i': $eis = "appointments.interested = 1"; break;
					case 'e': $eis = "appointments.freshman = 1"; break;
					case 's': $eis = "appointments.student = 1"; break;
				}

				$result = $this->connection->query("SELECT semester.id, semester.name, semester.department_id, count(*) FROM semester, appointments
														WHERE semester.department_id = $dept
														&& appointments.semester_id = semester.id
														&& $eis
														GROUP BY semester.id");
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

		//alle termine eines semesters und einer bestimmten Nutzergruppe ausgeben
		public function getAppointmentsForUsertype($semester_id, $eis)
		{
			try
			{
				//aus der getvariable die whereklausel der nutzergruppe bestimmen
				switch($eis)
				{
					case 'i': $eis = "interested = 1"; break;
					case 'e': $eis = "freshman = 1"; break;
					case 's': $eis = "student = 1"; break;
				}

				$result = $this->connection->query("SELECT * FROM appointments
														WHERE semester_id = $semester_id
														&& $eis");
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