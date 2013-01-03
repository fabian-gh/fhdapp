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
		
		//Pr�ft, ob das Formular (backend_insertFormular.php) korrekt ausgef�llt wurde
		//R�ckgabe: boolean: ture, wenn alles richtig ausgef�llt wurde
		//R�ckgabe: assoziatives-Array: array, indem die falsch ausgef�llten felder existieren(ist z.B. das feld "semestercount" falsch ausgef�llt, existiert im array das feld ["semestercount"])
		//�bergabeparameter ist das "$_POST"  
		public function checkInsertEditFormular($post){
			//Wenn vollTeil(radiobutton) gesetzt und "semestercount" eine zahl(also auch gesetzt) ist
			if(isset($post["vollTeil"]) AND is_numeric($post["semestercount"])){
				//Wenn der rest auch ausgef�llt ist
				if($post["name"]!="" AND $post["description"]!="" AND $post["link"]!=""){
					//Dann gebe ein boolean, ture zur�ck
					return true;
				}
			}
			//Wenn das return oben nicht erreicht wurde, dann finde heraus was falsch ist und gebe das entsprechende Array zur�ck
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
		
		//Funktion um Werte in die Relation 'studycourses' einzuf�gen.
		//Und dabei dem Studienkurs die Kategorien zuzuweisen. Also ausf�llen der Zwischentabelle "studycourses_mm_categories"
		//�bergabeparameter: $_POST
		//R�ckgabewert: Die ID des eingef�gten Studiengangs
		public function insertStudycourse($post){				
				//schreibe Studienkurs in die Datenbank
				$this->studycoursesModel->insertStudycourse($post);
				//F�lle Zwischentablle aus
				$lastStudiID = $this->studycoursesModel->insert_id();	//erst die zuletzt eingef�gte ID	holen
				$this->insertStudCat($post, $lastStudiID);	//Dann Zwsichentabelle ausf�llen
				//R�ckgabe
				return $lastStudiID;
		}
				
		//Funktion um Werte in die Relation 'studycourses_mm_categories' einzuf�gen. 
		private function insertStudCat($post, $lastStudiID){
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
		
		//Liefert Daten der Tabelle "graduates", "languages" oder "departments" zur�ck
		//�bergabeparameter "$type" muss dabei ein String sein, wobei der String = "department" oder "languages" oder "graduates" sein muss
		//sonst wird nichts zur�ckgegeben
		//R�ckgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownData($type){
			if($type=="languages" OR $type=="departments" OR $type=="graduates")	//nur wenn �bergabeparameter stimmt, dann
				return $this->studycoursesModel->selectDropDownData($type);
		}
		
		//L�scht einen Studiengang
		//�bergabeparameter: $id - des zu l�schenden Studiengangs
		public function deleteStudicourse($id){
			$this->studycoursesModel->deleteStudicourse($id);
		}
	
		//Updatet einen Studiengang
		//�bergabeparameter: $post - das $post array muss folgende felder enthalten: "id", "language_id", "name", "description", department_id", "semestercount", "graduate_id", "link"
		public function updateStudycourse($post){
			$this->studycoursesModel->updateStudycourse($post);
		}
	
	}

?>