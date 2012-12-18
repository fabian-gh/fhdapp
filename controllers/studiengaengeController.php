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
		
		
		//Funktion um Werte in die Relation 'studycourses' einzufügen.
		//Und dabei dem Studienkurs die Kategorien zuweisen. Also ausfüllen der Zwischentabelle
		public function insertStudycourse($post){
			//Wenn alles ausgefüllt ist und semesteranzahl eine nummer ist
			if(	isset($post["name"], $post["description"], $post["semestercount"], $post["link"], $post["vollTeil"]) AND is_numeric($post["semestercount"])){	
				//Dann schreibe in die Datenbank
				
				$this->studycoursesModel->insertStudycourse($post);
				$this->insertStudCat($post);
			}
		}
		
		
		//Funktion um Werte in die Relation 'studycourses_mm_categories' einzufügen. 
		private function insertStudCat($post){
			$lastStudiID = $this->studycoursesModel->insert_id();	//Die zuletzt eingefügte ID		
			$this->studycoursesModel->insertStudCat($lastStudiID, $post["vollTeil"]);	//StudiId und vollzeitTeilzeit ID verbinden
			
			//StudiId und Master oder Bachelor ID verbinden
			$a = $this->studycoursesModel->selectGradAbb($post["graduate_id"]);	//Selectiert die abbreviation für den bestimmten graduate
			$a = $a["abbreviation"][0];	//speichert nur den ersten Character in $a
			switch($a){	
				case "B":	//Bachelor
						$this->studycoursesModel->insertStudCat($lastStudiID, 1);	//value(1) je nach Datenbank
					break;
				case "M":	//Master
						$this->studycoursesModel->insertStudCat($lastStudiID, 2);	//value(2) je nach Datenbank
					break;
				default:
					echo "DEFAULT CASE";
					break;
			}			
			unset($a);	//löscht $a
			
			//StudiId und dualstudiumsID verbinden
			if(isset($post["dual"])){
				$this->studycoursesModel->insertStudCat($lastStudiID, $post["dual"]);
			}
			
			//StudiId und ingenieurwissenschaftlich ID verbinden
			if(isset($post["ingenieurwissenschaftlich"])){
				$this->studycoursesModel->insertStudCat($lastStudiID, $post["ingenieurwissenschaftlich"]);
			}
			
			//StudiId und gestalterisch ID verbinden
			if(isset($post["gestalterisch"])){
				$this->studycoursesModel->insertStudCat($lastStudiID, $post["gestalterisch"]);
			}
			
			//StudiId und gesellschaftlich ID verbinden
			if(isset($post["gesellschaftlich"])){
				$this->studycoursesModel->insertStudCat($lastStudiID, $post["gesellschaftlich"]);
			}
			
			//StudiId und wirtschaftlich ID verbinden
			if(isset($post["wirtschaftlich"])){
				$this->studycoursesModel->insertStudCat($lastStudiID, $post["wirtschaftlich"]);
			}

		}
		
		
		//Liefert Daten der Tabelle "graduates", "languages" oder "departments" zurück
		//übergabeparameter "$type" muss dabei ein String sein, wobei der String = "department" oder "languages" oder "graduates" sein muss
		//sonst wird nichts zurückgegeben
		//Rückgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectData($type){
			if($type=="languages" OR $type=="departments" OR $type=="graduates")	//nur wenn übergabeparameter stimmt, dann
				return $this->studycoursesModel->selectData($type);
		}
		
		
	}

?>