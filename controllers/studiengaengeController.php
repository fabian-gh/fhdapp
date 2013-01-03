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
		//Übergabeparameter: $_POST
		//Rückgabewert: Die ID des eingefügten Studiengangs
		public function insertStudycourse($post){				
				//schreibe Studienkurs in die Datenbank
				$this->studycoursesModel->insertStudycourse($post);
				//Fülle Zwischentablle aus
				$lastStudiID = $this->studycoursesModel->insert_id();	//erst die zuletzt eingefügte ID	holen
				$this->insertStudCat($post, $lastStudiID);	//Dann Zwsichentabelle ausfüllen
				//Rückgabe
				return $lastStudiID;
		}
				
		//Funktion um Werte in die Relation 'studycourses_mm_categories' einzufügen. 
		private function insertStudCat($post, $lastStudiID){
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
					case 6:	//ingenieurwissenschaftlich
						$retVal["ingenieurwissenschaftlich"] = $r["category_id"];	//Array-feld "ingenieurwissenschaftlich" erstellen
						break;
					case 7:	//gestalterisch
						$retVal["gestalterisch"] = $r["category_id"];	//Array-feld "gestalterisch" erstellen
						break;
					case 8:	//gesellschaftlich
						$retVal["gesellschaftlich"] = $r["category_id"];	//Array-feld "gesellschaftlich" erstellen
						break;
					case 9:	//wirtschaftlich
						$retVal["wirtschaftlich"] = $r["category_id"];	//Array-feld "wirtschaftlich" erstellen
						break;
				}
			}
			return $retVal;
		}
		
		//Liefert Daten der Tabelle "graduates", "languages" oder "departments" zurück
		//übergabeparameter "$type" muss dabei ein String sein, wobei der String = "department" oder "languages" oder "graduates" sein muss
		//sonst wird nichts zurückgegeben
		//Rückgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownData($type){
			if($type=="languages" OR $type=="departments" OR $type=="graduates")	//nur wenn übergabeparameter stimmt, dann
				return $this->studycoursesModel->selectDropDownData($type);
		}
		
		//Löscht einen Studiengang
		//Übergabeparameter: $id - des zu löschenden Studiengangs
		public function deleteStudicourse($id){
			$this->studycoursesModel->deleteStudicourse($id);
		}
	
		//Updatet einen Studiengang
		//Übergabeparameter: $post - das $post array muss folgende felder enthalten: "id", "language_id", "name", "description", department_id", "semestercount", "graduate_id", "link"
		public function updateStudycourse($post){
			$this->studycoursesModel->updateStudycourse($post);
		}
	
	}

?>