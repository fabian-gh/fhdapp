<?php

	class StudycoursesController{
	
		//IV
		private $studycoursesModel;
		
		//Konstruktor
		public function __construct(){

			//StudycoursesModell einbinden
			require_once 'models/studiengaengeModel.php';
			
			//StudycourseModell initialisieren
			$this->studycoursesModel = new StudycoursesModel();
		}
		
		
		//IM
		public function insertStudycourse($language_id, $name, $description, $department_id, $semestercount, $graduate_id, $link){
			//Wenn alles ausgefüllt ist und semesteranzahl eine nummer ist
			if(isset($name, $description, $semestercount, $link) AND is_numeric($semestercount)){	
				//Dann schreibe in die Datenbank
				$this->studycoursesModel->insertStudycourse($language_id, $name, $description, $department_id, $semestercount, $graduate_id, $link);
			}
		}
		
		
	}

?>