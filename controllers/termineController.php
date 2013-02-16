<?php

	class AppointmentController
	{

		private $appointmentModel;

		public function __construct()
		{
			//appointmentModel instanziieren
			require_once __DIR__.'../../models/termineModel.php';
			$this->appointmentModel = new AppointmentModel();
		}
				

		//semester

		//array aller semester mit ihren terminen eines bestimmten fachbereichs ausgeben
		public function semestersWithAppointments($dept)
		{
			$allSemesters = $this->appointmentModel->getSemesters($dept);

			//den semesterblöcken jeweils die termine hinzufügen
			for($i = 0; $i < count($allSemesters); $i++)
			{
				$ownAppointments = $this->appointmentModel->getAppointments($allSemesters[$i]->id);
				for($j = 0; $j < count($ownAppointments); $j++)
				{
					$allSemesters[$i]->addAppointment($ownAppointments[$j]);
				}
			}
			return $allSemesters;
		}

		//array aller semester mit ihren terminen eines bestimmten fachbereichs und einer bestimmten nutzergruppe ausgeben
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

		//semester abspeichern
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

		//semester entfernen
		public function removeSemester($params)
		{
			$this->appointmentModel->removeSemester($params['id']);
		}


		//termine

		//termin abspeichern
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

		//termin entfernen
		public function removeAppointment($params)
		{
			$this->appointmentModel->removeAppointment($params['appointment']);
		}


		//zusatz

		//tt.mm.jjjj in jjjj-mm-tt umwandeln
		public function dateToSql($date)
		{
			$parts = explode('.', $date);
			return "$parts[2]-$parts[1]-$parts[0]";
		}

		//jjjj-mm-tt in tt.mm.jjjj umwandeln
		public function sqlToDate($date)
		{
			$parts = explode('-', $date);
			return "$parts[2].$parts[1].$parts[0]";
		}

		//alle fachbereiche ausgeben
		public function getDepartments()
		{
			return $this->appointmentModel->getDepartments();
		}

		//fachbereich eines studienganges herausfinden
		public function getDepartmentFromStudycourse($name)
		{
			$temp = $this->appointmentModel->getDepartmentFromStudycourse($name);
			return $temp['department_id'];
		}
	}

	class Semester
	{
		public $id;
		public $name;
		public $appointments;
		
		public function __construct($id, $name)
		{
			$this->id = $id;
			$this->name = $name;
		}

		//termin hinzufügen (der klasse, nicht der datenbank)
		public function addAppointment($appointment)
		{
			$this->appointments[] = $appointment;
		}
	}
	
?>