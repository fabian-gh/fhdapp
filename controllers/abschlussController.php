<?php

	class GradeController
	{
		public function __construct()
		{
			//appointmentModel instanziieren
			require_once __DIR__.'../../models/abschlussModel.php';
			$this->gradeModel = new GradeModel();
		}

		public function getGrades($course)
		{
			return $this->gradeModel->getGrades($course);
		}
	}

?>