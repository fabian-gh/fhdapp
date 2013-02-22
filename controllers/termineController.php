<?php

	/**
	 * Logik für Termine
	**/
	class AppointmentController
	{
		private $appointmentModel;

		/**
		 * Erstellt den Controller und bindet das Model für Termine ein
		**/
		public function __construct()
		{
			//appointmentModel instanziieren
			require_once __DIR__.'../../models/termineModel.php';
			$this->appointmentModel = new AppointmentModel();
		}
				

		//semester

		/**
		 * @param int $dept ID des Fachbereichs
		 *
		 * @return array Gibt ein Array mit allen Semesterblöcken (Instanzen der Klasse Semester) inklusive ihrer Termine eines bestimmten Fachbereiches zurück.
		**/
		public function semestersWithAppointments($dept)
		{
			//semesterblöcke aus db laden
			$allSemesters = $this->appointmentModel->getSemesters($dept);

			//den semesterblöcken jeweils die termine hinzufügen
			for($i = 0; $i < count($allSemesters); $i++)
			{
				//termine des semesters aus db laden
				$ownAppointments = $this->appointmentModel->getAppointments($allSemesters[$i]->id);
				for($j = 0; $j < count($ownAppointments); $j++)
				{
					$allSemesters[$i]->addAppointment($ownAppointments[$j]);
				}
			}
			return $allSemesters;
		}

		/**
		 * @param int $dept ID des Fachbereichs
		 * @param char $eis Buchstabe der Zielgruppe (i = Interessent, e = Erstsemester, s = Student)
		 *
		 * @return array Gibt ein Array mit allen Semesterblöcken inklusive ihrer Termine eines bestimmten Fachbereiches und einer bestimmten Zielgruppe zurück.
		 * Leere Blöcke, bzw. Blöcke, in denen keine treffenden Termine vorhanden sind, werden nicht zurückgegeben.
		**/
		public function semestersWithAppointmentsForUsertype($dept, $eis)
		{
			$allSemesters = $this->appointmentModel->getSemestersForUsertype($dept, $eis);

			//den semesterblöcken jeweils die termine hinzufügen
			for($i = 0; $i < count($allSemesters); $i++)
			{
				$ownAppointments = $this->appointmentModel->getAppointmentsForUsertype($allSemesters[$i]->id, $eis);
				for($j = 0; $j < count($ownAppointments); $j++)
				{
					$allSemesters[$i]->addAppointment($ownAppointments[$j]);
				}
			}
			return $allSemesters;
		}

		/**
		 * Speichert Änderungen eines Semesters oder fügt ein neues Semester ein
		 *
		 * @param array $params Array mit den entsprechenden neuen Werten (falls keine ID ($params['id']) vorhanden, dann wird ein neuer Eintrag erstellt)
		**/
		public function saveSemester($params)
		{
			if($params['type'] == 'summer')
				$name = "SS".$params['from'];
			else
				$name = "WS".$params['from']."/".($params['from']+1);

			//update
			if(isset($params['id']))
			{
				$this->appointmentModel->updateSemester($params['id'], 1, $name);
			}
			//insert
			else
			{
				$this->appointmentModel->insertSemester(1, $name, $params['dept']);
			}
		}

		/**
		 * Löscht ein Semester und alle zugehörigen Termine (zu Ändern in der Datenbank))
		 *
		 * @param array $params Array mit den Attributen des Semesters (nur die ID wird benötigt, ganzes Array, damit Code einheitlicher)
		**/
		public function removeSemester($params)
		{
			$this->appointmentModel->removeSemester($params['id']);
		}


		//termine

		/**
		 * Speichert Änderungen eines Termines oder fügt einen neuen ein
		 *
		 * @param array $params Array mit den entsprechenden neuen Werten (falls keine ID ($params['appointment']) vorhanden, dann wird ein neuer Eintrag erstellt)
		**/
		public function saveAppointment($params)
		{
			$date_from = $this->dateToSql($params['date_from']);
			$date_to = $this->dateToSql($params['date_to']);
			$interested = (isset($params['interested'])) ? 1 : 0;
			$freshman = (isset($params['freshman'])) ? 1 : 0;
			$student = (isset($params['student'])) ? 1 : 0;

			//update
			if(isset($params['appointment']))
			{
				$this->appointmentModel->updateAppointment($params['appointment'], 1, $params['name'], $date_from, $date_to, $interested, $freshman, $student);
			}
			//insert
			else
			{
				$this->appointmentModel->insertAppointment(1, $params['semester'], $params['name'], $date_from, $date_to, $interested, $freshman, $student);
			}	
		}

		/**
		 * Löscht einen Termin
		 *
		 * @param array $params Array mit den Attributen des Termines (nur die ID wird benötigt, ganzes Array, damit Code einheitlicher)
		**/
		public function removeAppointment($params)
		{
			$this->appointmentModel->removeAppointment($params['appointment']);
		}


		//zusätzliche Funktionen

		/**
		 * Wandelt Datumsformat um
		 * @param date $date tt.mm.jjjj
		 *
		 * @return date jjjj-mm-tt (Format für MySQL)
		**/
		public function dateToSql($date)
		{
			$parts = explode('.', $date);
			return "$parts[2]-$parts[1]-$parts[0]";
		}

		/**
		 * Wandelt Datumsformat um
		 * @param date $date jjjj-mm-tt (Format für MySQL)
		 *
		 * @return date tt.mm.jjjj
		**/
		public function sqlToDate($date)
		{
			$parts = explode('-', $date);
			return "$parts[2].$parts[1].$parts[0]";
		}

		/**
		 * @return array Gibt ein Array mit allen Fachbereichen (ID, Name) zurück
		**/
		public function getDepartments()
		{
			return $this->appointmentModel->getDepartments();
		}

		/**
		 * @param string $name Name des Studienganges, wessen Fachbereich bestimmt werden soll
		 *
		 * @return array Gibt ID des Fachbereiches des bestimmten Studienganges zurück
		**/
		public function getDepartmentFromStudycourse($name)
		{
			$temp = $this->appointmentModel->getDepartmentFromStudycourse($name);
			return $temp['department_id'];
		}
	}

	/**
	 * Datenstruktur für einen Semesterblock
	**/
	class Semester
	{
		public $id;
		public $name;
		public $appointments;
		
		/**
		 * Erstellt ein Objekt der Klasse Semester
		 *
		 * @param int $id ID des Semesters
		 * @param string $name Bezeichnung des Semesters
		**/
		public function __construct($id, $name)
		{
			$this->id = $id;
			$this->name = $name;
		}

		/**
		 * Fügt der Instanz einen Termin hinzu
		 *
		 * @param int $appointment ID des Termins
		**/
		public function addAppointment($appointment)
		{
			$this->appointments[] = $appointment;
		}
	}
	
?>