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
			if(isset($name, $description, $semestercount, $link)){	//Wenn alles ausgefüllt ist
				$this->studycoursesModel->insertStudycourse($language_id, $name, $description, $department_id, $semestercount, $graduate_id, $link);
			}
		}
		
		
	}

?>