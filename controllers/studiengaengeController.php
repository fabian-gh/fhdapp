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
		
		//Gibt den zugeh?rigen Namen (Datentyp: STRING) der graduate id zur?ck.
		//?bergabeparameter: $id - graduate id, dessen namen man wissen will
		public function graduateIdToName($id){
			$retVal = $this->studycoursesModel->graduateIdToName($id);
			return $retVal["name"];
		}
		
		//Gibt den zugeh?rigen Namen (Datentyp: STRING) der language id zur?ck.
		//?bergabeparameter: $id - language id, dessen namen man wissen will
		public function languageIdToName($id){
			$retVal = $this->studycoursesModel->languageIdToName($id);
			return $retVal["name"];
		}
		
		//Gibt den zugeh?rigen Namen (Datentyp: STRING) der department id zur?ck.
		//?bergabeparameter: $id - department id, dessen namen man wissen will
		public function departmentIdToName($id){
			$retVal = $this->studycoursesModel->departmentIdToName($id);
			return $retVal["name"];
		}
		
		//Prüft, ob das Formular (backend_insertFormular.php) korrekt ausgefüllt wurde
		//Rückgabe: boolean: ture, wenn alles richtig ausgefüllt wurde
		//Rückgabe: assoziatives-Array: array, indem die falsch ausgefüllten felder existieren(ist z.B. das feld "semestercount" falsch ausgefüllt, existiert im array das feld ["semestercount"])
		//Übergabeparameter ist das "$_POST"  
		public function checkInsertEditFormular($post){
			//Wenn vollTeil(radiobutton) gesetzt und "semestercount" eine zahl(also auch gesetzt) ist
			if(isset($post["vollTeil"]) AND is_numeric($post["semestercount"])){
				//Wenn der rest auch ausgefüllt ist
				if($post["name"]!="" AND $post["description"]!="" AND $post["link"]!=""){
					//Dann gebe ein boolean, ture zurück
					return true;
				}
			}
			//Wenn das return oben nicht erreicht wurde, dann finde heraus was falsch ist und gebe das entsprechende Array zurück
			//=> F E H L E R E R K E N N U N G !!!!
			$retVal = array();
			if($post["name"]=="")
				$retVal["name"] = true;
			if($post["description"]=="")
				$retVal["description"] = true;
			if(!is_numeric($post["semestercount"]))
				$retVal["semestercount"] = true;
			if($post["link"]=="")
				$retVal["link"] = true;
			if(!isset($post["vollTeil"]))
				$retVal["vollTeil"] = true;
			return $retVal;
		}
		
		//Funktion um Werte in die Relation 'studycourses' einzufügen.
		//Und dabei dem Studienkurs die Kategorien zuzuweisen. Also ausfüllen der Zwischentabelle "studycourses_mm_categories"
		public function insertStudycourse($post){				
				//schreibe Studienkurs in die Datenbank
				$this->studycoursesModel->insertStudycourse($post);
				//Fülle Zwischentablle aus
				$this->insertStudCat($post);
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
		
		//Liefert alle Studiengänge alphabetisch geordnet nach dem Studiengangsnamen zurück
		//mit den Attributen: StudiengangsId, StudiengangsName, AbschlussartAbkürzung und ob es Teil-oder Vollzeit ist
		public function selectStudicourses(){
				return $this->studycoursesModel->selectStudicourses();
		}
		
		//Liefert ein Studiengan mit allen Informationen zur?ck
		//?bergabeparameter: $id - id des Studiengangs
		public function selectStudicourse($id){
			return $this->studycoursesModel->selectStudicourse($id);
		}
		
		//Liefert Daten der Tabelle "graduates", "languages" oder "departments" zurück
		//übergabeparameter "$type" muss dabei ein String sein, wobei der String = "department" oder "languages" oder "graduates" sein muss
		//sonst wird nichts zurückgegeben
		//Rückgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownData($type){
			if($type=="languages" OR $type=="departments" OR $type=="graduates")	//nur wenn übergabeparameter stimmt, dann
				return $this->studycoursesModel->selectDropDownData($type);
		}
		
		//L?scht einen Studiengang
		//?bergabeparameter: $id - des zu l?schenden Studiengangs
		public function deleteStudicourse($id){
			$this->studycoursesModel->deleteStudicourse($id);
		}
	
	}

?>