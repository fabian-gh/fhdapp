<?php

	/**
 	 * Logik für die Wahl des Abschlusses
	**/
	class GradeController
	{
		
		/**
		 * Erstellt den Controller und bindet das Model ein
		**/
		public function __construct()
		{
			//appointmentModel instanziieren
			require_once __DIR__.'../../models/abschlussModel.php';
			$this->gradeModel = new GradeModel();
		}

		/**
		 * @param string Name des Studienganges, wessen Abschlussarten herausgefunden werden soll
		 *
		 * @return array Array mit allen Abschlussarten eines Studienganges
		**/
		public function getGrades($course)
		{
			return $this->gradeModel->getGrades($course);
		}
	}

?>