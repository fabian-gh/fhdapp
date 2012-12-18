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
		public function insertStudycourse($post){
			//Wenn alles ausgefüllt ist und semesteranzahl eine nummer ist
			if(isset($post["name"], $post["description"], $post["semestercount"], $post["link"]) AND is_numeric($post["semestercount"])){	
				//Dann schreibe in die Datenbank
				$this->studycoursesModel->insertStudycourse($post);
			}
		}
		
		
	}

?>