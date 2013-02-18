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
		
		//Gibt den zugeh�rigen Namen (Datentyp: STRING) der graduate id zur�ck.
		//�bergabeparameter: $id - graduate id, dessen namen man wissen will
		public function graduateIdToName($id){
			$retVal = $this->studycoursesModel->graduateIdToName($id);
			return $retVal["name"];
		}
		
		//Gibt den zugeh�rigen Namen (Datentyp: STRING) der language id zur�ck.
		//�bergabeparameter: $id - language id, dessen namen man wissen will
		public function languageIdToName($id){
			$retVal = $this->studycoursesModel->languageIdToName($id);
			return $retVal["name"];
		}
		
		//Gibt den zugeh�rigen Namen (Datentyp: STRING) der department id zur�ck.
		//�bergabeparameter: $id - department id, dessen namen man wissen will
		public function departmentIdToName($id){
			$retVal = $this->studycoursesModel->departmentIdToName($id);
			return $retVal["name"];
		}
		
		//Pr�ft, ob das Formular (backend_insertUpdateFormular.php) korrekt ausgef�llt wurde
		//R�ckgabe: assoziatives-array: array ist leer, wenn kein Fehler vorliegt
		//R�ckgabe: assoziatives-array: ist z.B. das feld "semestercount" falsch ausgef�llt, existiert im array das feld ["semestercount"]
		//�bergabeparameter ist das "$_POST"  
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
		
		//Funktion um Werte in die Relation 'studycourses' einzuf�gen.
		//Und dabei dem Studienkurs die Kategorien zuzuweisen. Also ausf�llen der Zwischentabelle "studycourses_mm_categories"
		//�bergabeparameter: $_POST
		//R�ckgabewert: Die ID des eingef�gten Studiengangs
		public function insertStudycourse($post){
				$this->studycoursesModel->insertStudycourse($post);
				//F�lle Zwischentablle aus
				$lastStudiID = $this->studycoursesModel->insert_id();	//erst die zuletzt eingef�gte ID holen
				$this->insertStudCat($lastStudiID, $post);	//Dann Zwsichentabelle ausf�llen
				//R�ckgabe
				return $lastStudiID;
		}
				
		//Funktion um Werte in die Relation 'studycourses_mm_categories' einzuf�gen. 
		private function insertStudCat($lastStudiID, $post){
			$this->studycoursesModel->insertStudCat($lastStudiID, $post["vollTeil"]);	//StudiId und vollzeitTeilzeit ID verbinden
			//StudiId und Master oder Bachelor ID verbinden
			$a = $this->studycoursesModel->selectGradAbb($post["graduate_id"]);	//Selectiert die abbreviation f�r den bestimmten graduate
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
			unset($a);	//l�scht $a
			//StudiId und dualstudiumsID verbinden
			if(isset($post["dual"])){
				$this->studycoursesModel->insertStudCat($lastStudiID, $post["dual"]);
			}
			$categories = $this->selectCategories();	//alle kategorien selektieren
			foreach($categories AS $c){	//f�r jeden tupel 
				if(isset($post[$c["name"]]))
					$this->studycoursesModel->insertStudCat($lastStudiID, $post[$c["name"]]);
			}
			unset($categories);	//l�scht $categories
		}
		
		//Liefert alle Studieng�nge alphabetisch geordnet nach dem Studiengangsnamen zur�ck
		//mit den Attributen: StudiengangsId, StudiengangsName, AbschlussartAbk�rzung und ob es Teil-oder Vollzeit ist
		public function selectStudicourses(){
			return $this->studycoursesModel->selectStudicourses();
		}
		
		//Liefert ein Array mit einem Studiengang und dessen categorien zur�ck
		//�bergabeparameter: $id - id des Studiengangs
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
			//switch case im foreach ist abh�ngig von der Datenbank (Relation "categories" und deren ids und namen)
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
		
		//Liefert Daten der Tabelle "graduates" zur�ck
		//R�ckgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownDataGraduates(){
			return $this->studycoursesModel->selectDropDownDataGraduates();
		}
		
		//Liefert Daten der Tabelle "languages" zur�ck
		//R�ckgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownDataLanguages(){
			return $this->studycoursesModel->selectDropDownDataLanguages();
		}
		
		//Liefert Daten der Tabelle "departments" zur�ck
		//R�ckgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownDataDepartments(){
			return $this->studycoursesModel->selectDropDownDataDepartments();
		}
		
		//Liefert nur die Kategorien aus der Tabelle "categories" zur�ck
		//R�ckgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectCategories(){
			return $this->studycoursesModel->selectCategories();
		}
		
		//L�scht einen Studiengang komplett aus der Datenbank
		//�bergabeparameter: $id - des zu l�schenden Studiengangs "studycourses_mm_categories"
		private function deleteFromStudicourseCategories($id){
			$this->studycoursesModel->deleteFromStudicourseCategories($id);	//L�scht aus der Zwischentabelle "studycourses_mm_categories"
		}
		
		//L�scht einen Studiengang nur aus der Zwischentabelle 
		//�bergabeparameter: $id - des zu l�schenden Studiengangs
		public function deleteStudicourse($id){
			$this->studycoursesModel->deleteFromStudicourseCategories($id);	//L�scht aus der Zwischentabelle "studycourses_mm_categories"
			$this->studycoursesModel->deleteFromStudicourseTags($id);	//L�scht aus der Zwischentabelle "studycourses_mm_tags"
			$this->studycoursesModel->deleteFromStudicourse($id);	//L�scht aus der Tabelle "studycourses"
		}
	
		//Updatet einen Studiengang
		//�bergabeparameter: $post - das $post array muss folgende felder enthalten: "id", "language_id", "name", "description", department_id", "semestercount", "graduate_id", "link"
		public function updateStudycourse($post){
			$this->studycoursesModel->updateStudycourse($post);
			$this->deleteFromStudicourseCategories($post["id"]);	//Tupel des Studiengangs aus der Zwischentabelle l�schen
			$this->insertStudCat($post["id"], $post);	//Neue Tupel in die Zwischentabelle einf�gen
		}
	
	}

?>