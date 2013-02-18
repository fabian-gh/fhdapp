<?php

	class StudycoursesController{
	
		//IV
		private $studycoursesModel;
		
		//Konstruktor
		public function __construct(){

			//StudycoursesModell einbinden
			require_once '../../models/studiengaengeModel.php';
			
			//StudycourseModell initialisieren
			$this->studycoursesModel = new StudycoursesModel();
		}
		
		
		//IM
		
		//Gibt den zugehörigen Namen (Datentyp: STRING) der graduate id zurück.
		//Übergabeparameter: $id - graduate id, dessen namen man wissen will
		public function graduateIdToName($id){
			$retVal = $this->studycoursesModel->graduateIdToName($id);
			return $retVal["name"];
		}
		
		//Gibt den zugehörigen Namen (Datentyp: STRING) der language id zurück.
		//Übergabeparameter: $id - language id, dessen namen man wissen will
		public function languageIdToName($id){
			$retVal = $this->studycoursesModel->languageIdToName($id);
			return $retVal["name"];
		}
		
		//Gibt den zugehörigen Namen (Datentyp: STRING) der department id zurück.
		//Übergabeparameter: $id - department id, dessen namen man wissen will
		public function departmentIdToName($id){
			$retVal = $this->studycoursesModel->departmentIdToName($id);
			return $retVal["name"];
		}
		
		//Prüft, ob das Formular (backend_insertUpdateFormular.php) korrekt ausgefüllt wurde
		//Rückgabe: assoziatives-array: array ist leer, wenn kein Fehler vorliegt
		//Rückgabe: assoziatives-array: ist z.B. das feld "semestercount" falsch ausgefüllt, existiert im array das feld ["semestercount"]
		//Übergabeparameter ist das "$_POST"  
		public function checkInsertEditFormular($post){
				//finde heraus was falsch ist und schreibe es entsprechend in das Array
				//=> F E H L E R E R K E N N U N G !!!!
				$retVal = array();
				if($post["name"]=="" OR strpbrk($post["name"], '";'))
					$retVal["name"] = true;
				if($post["description"]=="")
					$retVal["description"] = true;
				if(!is_numeric($post["semestercount"]))
					$retVal["semestercount"] = true;
				if($post["link"]=="" OR strpbrk($post["link"], '";'))
					$retVal["link"] = true;
				if(!isset($post["vollTeil"]))
					$retVal["vollTeil"] = true;
				return $retVal;
		}
		
		//Funktion um Werte in die Relation 'studycourses' einzufügen.
		//Und dabei dem Studienkurs die Kategorien zuzuweisen. Also ausfüllen der Zwischentabelle "studycourses_mm_categories"
		//Übergabeparameter: $_POST
		//Rückgabewert: Die ID des eingefügten Studiengangs
		public function insertStudycourse($post){
				$this->studycoursesModel->insertStudycourse($post);
				//Fülle Zwischentablle aus
				$lastStudiID = $this->studycoursesModel->insert_id();	//erst die zuletzt eingefügte ID holen
				$this->insertStudCat($lastStudiID, $post);	//Dann Zwsichentabelle ausfüllen
				//Rückgabe
				return $lastStudiID;
		}
				
		//Funktion um Werte in die Relation 'studycourses_mm_categories' einzufügen. 
		private function insertStudCat($lastStudiID, $post){
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
			$categories = $this->selectCategories();	//alle kategorien selektieren
			foreach($categories AS $c){	//für jeden tupel 
				if(isset($post[$c["name"]]))
					$this->studycoursesModel->insertStudCat($lastStudiID, $post[$c["name"]]);
			}
			unset($categories);	//löscht $categories
		}
		
		//Liefert alle Studiengänge alphabetisch geordnet nach dem Studiengangsnamen zurück
		//mit den Attributen: StudiengangsId, StudiengangsName, AbschlussartAbkürzung und ob es Teil-oder Vollzeit ist
		public function selectStudicourses(){
			return $this->studycoursesModel->selectStudicourses();
		}
		
		//Liefert ein Array mit einem Studiengang und dessen categorien zurück
		//Übergabeparameter: $id - id des Studiengangs
		public function selectStudicourse($id){
			$rows = $this->studycoursesModel->selectStudicourse($id);	//Array holen
			$retVal["id"] = $rows[0]["id"];
			$retVal["graduate_id"] = $rows[0]["graduate_id"];
			$retVal["graduate_name"] = $rows[0]["graduate_name"];
			$retVal["name"] = $rows[0]["name"];
			$retVal["department_id"] = $rows[0]["department_id"];
			$retVal["semestercount"] = $rows[0]["semestercount"];
			$retVal["description"] = $rows[0]["description"];
			$retVal["language_id"] = $rows[0]["language_id"];
			$retVal["link"] = $rows[0]["link"];			
			//switch case im foreach ist abhängig von der Datenbank (Relation "categories" und deren ids und namen)
			foreach($rows as $r){	//"uneffiziente" schleife
				switch($r["category_id"]){
					case 3:	//Teilzeit
						$retVal["vollTeil"] = $r["category_id"];	//Array-feld "vollTeil" erstellen
						break;
					case 4:	//Vollzeit
						$retVal["vollTeil"] = $r["category_id"];	//Array-feld "vollTeil" erstellen
						break;
					case 5:	//Dual
						$retVal["dual"] = $r["category_id"];	//Array-feld "dual" erstellen
						break;
					case 6:	//Design
						$retVal["Design"] = $r["category_id"];	//Array-feld "Design" erstellen
						break;
					case 7:	//Ingenieur
						$retVal["Ingenieur"] = $r["category_id"];	//Array-feld "Ingenieur" erstellen
						break;
					case 8:	//Informatik
						$retVal["Informatik"] = $r["category_id"];	//Array-feld "Informatik" erstellen
						break;
					case 9:	//Medien
						$retVal["Medien"] = $r["category_id"];	//Array-feld "Medien" erstellen
						break;
					case 10:	//Sozial
						$retVal["Sozial"] = $r["category_id"];	//Array-feld "Sozial" erstellen
						break;
					case 11:	//Kultur
						$retVal["Kultur"] = $r["category_id"];	//Array-feld "Kultur" erstellen
						break;
					case 12:	//Wirtschaft
						$retVal["Wirtschaft"] = $r["category_id"];	//Array-feld "Wirtschaft" erstellen
						break;
				}
			}
			return $retVal;
		}
		
		//Liefert Daten der Tabelle "graduates" zurück
		//Rückgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownDataGraduates(){
			return $this->studycoursesModel->selectDropDownDataGraduates();
		}
		
		//Liefert Daten der Tabelle "languages" zurück
		//Rückgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownDataLanguages(){
			return $this->studycoursesModel->selectDropDownDataLanguages();
		}
		
		//Liefert Daten der Tabelle "departments" zurück
		//Rückgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownDataDepartments(){
			return $this->studycoursesModel->selectDropDownDataDepartments();
		}
		
		//Liefert nur die Kategorien aus der Tabelle "categories" zurück
		//Rückgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectCategories(){
			return $this->studycoursesModel->selectCategories();
		}
		
		//Löscht einen Studiengang komplett aus der Datenbank
		//Übergabeparameter: $id - des zu löschenden Studiengangs "studycourses_mm_categories"
		private function deleteFromStudicourseCategories($id){
			$this->studycoursesModel->deleteFromStudicourseCategories($id);	//Löscht aus der Zwischentabelle "studycourses_mm_categories"
		}
		
		//Löscht einen Studiengang nur aus der Zwischentabelle 
		//Übergabeparameter: $id - des zu löschenden Studiengangs
		public function deleteStudicourse($id){
			$this->studycoursesModel->deleteFromStudicourseCategories($id);	//Löscht aus der Zwischentabelle "studycourses_mm_categories"
			$this->studycoursesModel->deleteFromStudicourseTags($id);	//Löscht aus der Zwischentabelle "studycourses_mm_tags"
			$this->studycoursesModel->deleteFromStudicourse($id);	//Löscht aus der Tabelle "studycourses"
		}
	
		//Updatet einen Studiengang
		//Übergabeparameter: $post - das $post array muss folgende felder enthalten: "id", "language_id", "name", "description", department_id", "semestercount", "graduate_id", "link"
		public function updateStudycourse($post){
			$this->studycoursesModel->updateStudycourse($post);
			$this->deleteFromStudicourseCategories($post["id"]);	//Tupel des Studiengangs aus der Zwischentabelle löschen
			$this->insertStudCat($post["id"], $post);	//Neue Tupel in die Zwischentabelle einfügen
		}
	
	}

?>