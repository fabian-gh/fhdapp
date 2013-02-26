<?php

	/**
	 * Schnittstelle zwischen Controller und Datenbank für Termine
	**/
	class AppointmentModel
	{
		private $connection;

		/**
		 * Erstellt das Model und stelt Verbindung zur Datenbank her
		**/
		public function __construct()
		{
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
		}

		
		//semester

		/**
		 * @param int $dept ID des Fachbereichs
		 *
		 * @return array Gibt ein Array mit allen Semestern eines bestimmten Fachbereiches zurück.
		**/
		public function getSemesters($dept)
		{
			try
			{
				$result = $this->connection->query("SELECT * FROM semester
														WHERE department_id = $dept");
				$resultSet = array();
				if($result != null)
					while($row = $result->fetch_assoc())
					{
						$resultSet[] = new Semester($row["id"], $row["name"]);
					}
				return $resultSet;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		/**
		 * @param int $dept ID des Fachbereichs
		 * @param char $eis Buchstabe der Zielgruppe (i = Interessent, e = Erstsemester, s = Student)
		 *
		 * @return array Gibt ein Array mit allen Semesterblöcken inklusive ihrer Termine eines bestimmten Fachbereiches und einer bestimmten Zielgruppe zurück.
		 * Leere Blöcke, bzw. Blöcke, in denen keine treffenden Termine vorhanden sind, werden nicht zurückgegeben.
		**/
		public function getSemestersForUsertype($dept, $eis)
		{
			try
			{
				//aus der getvariable die where-klausel der nutzergruppe bestimmen
				switch($eis)
				{
					case 'i': $eis = "appointments.interested = 1"; break;
					case 'e': $eis = "appointments.freshman = 1"; break;
					case 's': $eis = "appointments.student = 1"; break;
				}

				$result = $this->connection->query("SELECT semester.id, semester.name
														FROM semester, appointments
														WHERE semester.department_id = $dept && appointments.semester_id = semester.id && $eis
														GROUP BY semester.id");
				$resultSet = array();
				if($result != null)
					while($row = $result->fetch_assoc())
					{
						$resultSet[] = new Semester($row["id"], $row["name"]);
					}
				return $resultSet;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		/**
		 * Fügt ein neues Semester ein
		 *
		 * @param int $language ID der Sprache
		 * @param string $name Name des Semesters
		 * @param int $department ID des Fachbereichs
		**/
		public function insertSemester($language, $name, $department)
		{
			try
			{
				$this->connection->query("INSERT INTO semester(language_id, name, department_id)
											VALUES($language, '$name', $department)");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		/**
		 * Speichert Änderungen eines Semesters
		 *
		 * @param int $id ID des zu ändernen Semesters
		 * @param int $language neue ID der Sprache
		 * @param string $name neuer Name des Semesters
		**/
		public function updateSemester($id, $language, $name)
		{
			try
			{
				$this->connection->query("UPDATE semester
											SET language_id = $language, name = '$name'
											WHERE id = $id");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		/**
		 * Löscht ein Semester und alle zugehörigen Termine (zu Ändern in der Datenbank))
		 *
		 * @param int $id ID des zu löschenden Semesters
		**/
		public function removeSemester($id)
		{
			try
			{
				$this->connection->query("DELETE FROM semester
											WHERE id = $id");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		
		//termine

		/**
		 * @param int $semester_id ID des Semesters
		 *
		 * @return array Gibt ein Array mit allen Terminen eines bestimmten Semesters zurück.
		**/
		public function getAppointments($semester_id)
		{
			try
			{
				$result = $this->connection->query("SELECT * FROM appointments
														WHERE semester_id = $semester_id
														ORDER BY date_from");
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
		 * @param int $semester_id ID des Semesters
		 * @param char $eis Buchstabe der Zielgruppe (i = Interessent, e = Erstsemester, s = Student)
		 *
		 * @return array Gibt ein Array mit allen Terminen eines bestimmten Semesters für eine bestimmte Zielgruppe zurück.
		**/
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
														WHERE semester_id = $semester_id && $eis
														ORDER BY date_from");
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
		 * Fügt einen neuen Termin ein
		 *
		 * @param int $language ID der Sprache
		 * @param int $semester ID des Semesters
		 * @param string $name Name des Termins
		 * @param date $date_from Startdatum (YYYY-MM-TT)
		 * @param date $date_to Enddatum (YYYY-MM-TT)
		 * @param bool $interested für Interessenten?
		 * @param bool $freshman für Erstsemester?
		 * @param bool $student für Stundenten?
		**/
		public function insertAppointment($language, $semester, $name, $date_from, $date_to, $interested, $freshman, $student)
		{
			try
			{
				$this->connection->query("INSERT INTO appointments(language_id, semester_id, name, date_from, date_to, interested, freshman, student)
											VALUES($language, $semester, '$name', '$date_from', '$date_to', $interested, $freshman, $student)");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		/**
		 * Speichert Änderungen eines Termins
		 *
		 * @param int $id ID des zu ändernen Termins
		 * @param int $language neue ID der Sprache
		 * @param string $name neuer Name des Termins
		 * @param date $date_from neues Startdatum (YYYY-MM-TT)
		 * @param date $date_to neues Enddatum (YYYY-MM-TT)
		 * @param bool $interested für Interessenten?
		 * @param bool $freshman für Erstsemester?
		 * @param bool $student für Stundenten?
		**/
		public function updateAppointment($id, $language, $name, $date_from, $date_to, $interested, $freshman, $student)
		{
			try
			{
				$this->connection->query("UPDATE appointments
											SET language_id = $language, name = '$name', date_from = '$date_from', date_to = '$date_to', interested = $interested, freshman = $freshman, student = $student
											WHERE id = $id");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		/**
		 * Löscht einen Termin
		 *
		 * @param int $id ID des zu löschenden Termins
		**/
		public function removeAppointment($id)
		{
			try
			{
				$this->connection->query("DELETE FROM appointments
											WHERE id = $id");
				
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}


		//zusatz

		/**
		 * @return array Gibt ein Array mit allen Fachbereichen (ID, Name) zurück
		**/
		public function getDepartments()
		{
			try
			{
				$result = $this->connection->query("SELECT id, name
														FROM departments");
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
		 * @param string $name Name des Studienganges
		 *
		 * @return array Gibt ein Array mit dem Fachbereich des bestimmten Studienganges zurück
		**/
		public function getDepartmentFromStudycourse($name)
		{
			try
			{
				$result = $this->connection->query("SELECT department_id
														FROM studycourses
														WHERE name = '$name'
														LIMIT 1");
				if($result != null)
					return $result->fetch_assoc();
				else
					return null;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}
	}

?>