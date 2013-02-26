<?php
/**
*	Dateiname: "studiengaengeControllerBackend.php"
*	Zweck:	Diese Datei ist die Steuerungsebene im MVC-Muster.
*			Der Controller steuert die Methoden des Models und ruft diese gezielt auf. 
*			Somit ist das Model (die Geschäftslogik) von der View (Präsentationsebene) gekapselt.
*	Benutzt von: "../../controllers/studiengaengeControllerBackend.php"
*	Autor Name: Okan Köse
*	Autor E-Mail: okan.koese@gmx.de	
**/

	class StudycoursesController{
	
		//----- Instanzvariablen -----
		private $studycoursesModel;	//"$studycoursesModel" um ein Model-Objekt abzuspeichern (siehe Konstruktor)
		
		
		
		//----- Instanzmethoden -----
		
		/**
		*	Konstruktor der Klasse "StudycoursesController".
		*	Bindet die "studiengaengeModel.php" ein und initialisiert ein Objekt der Klasse "StudycoursesModel".
		*/
		public function __construct(){
			require_once '../../models/studiengaengeModel.php';	//StudycoursesModell einbinden
			$this->studycoursesModel = new StudycoursesModel();	//StudycourseModell initialisieren
		}
		
		/**
		*	Gibt den Namen einer Abschlussbeschreibung zurück.
		*
		*	@param int	-	Die ID der jeweiligen Abschlussbeschreibung.
		*	@return string	-	Der Namen der jeweiligen Abschlussbeschreibung.
		*/
		public function graduateIdToName($id){
			$retVal = $this->studycoursesModel->graduateIdToName($id);
			return $retVal["name"];
		}
		
		/**
		*	Gibt den Namen einer Sprache zurück.
		*
		*	@param int	-	Die ID der jeweiligen Sprache.
		*	@return string	-	Der Name der jeweiligen Sprache.
		*/
		public function languageIdToName($id){
			$retVal = $this->studycoursesModel->languageIdToName($id);
			return $retVal["name"];
		}
		
		/**
		*	Gibt den Namen eines Fachbereiches zurück.
		*
		*	@param int	-	Die ID des jeweiligen Fachbereiches.
		*	@return string	-	Der Name des jeweiligen Fachbereiches.
		*/
		public function departmentIdToName($id){
			$retVal = $this->studycoursesModel->departmentIdToName($id);
			return $retVal["name"];
		}
		
		/**
		*	Überprüft das Formular aus der "backend_insertUpdateFormular.php".
		*	Dabei wird geprüft, ob die vom Benutzer auszufüllenden Felder korrekt ausgefüllt wurden.
		*	Die geprüften Felder sind:
		*		- Name des Studiengangs	-	Darf nicht leer sein. Nur Leerzeichen zählen als leer.
		*		- Semesteranzahl	-	Darf nicht leer sein und muss aus Ziffern bestehen.
		*		- Wird angeboten als	-	Studiengang muss mindestens als Vollzeit-, Teilzeit-, oder Dualer-Studiengang angeboten werden.
		*		- Kategorien	-	Studiengang muss mindestens einer Kategorie zugehören.
		*		- Studiengangsbeschreibung	-	Darf nicht leer sein. Nur Leerzeichen zählen als leer.
		*		- Link für weitere Informationen	-	Darf nicht leer sein. Nur Leerzeichen zählen als leer.
		*	
		*	@param array	-	Assoziatives Array mit den Namen der Formular-Eingabefelder als Index (z.B. die "$_POST"-Variable nach dem Abschicken des Formulars aus der "backend_insertUpdateFormular.php") .
		*	@return array	-	Assoziatives Array mit den fehlerhaften Eingabefeldernamen als Index.	-	Sonst ein leeres Array(, also wenn keine Fehlerhafte Eingabe).
		**/
		public function checkInsertEditFormular($post){
				//finde heraus was falsch ist und schreibe es entsprechend in das Array "$retVal"
				//=> F E H L E R E R K E N N U N G !!!!
				$retVal = array();
				$trimmedString = trim($post["name"]);
				if($trimmedString=="")
					$retVal["name"] = true;
				$trimmedString = trim($post["description"]);
				if($trimmedString=="")
					$retVal["description"] = true;
				if(!is_numeric($post["semestercount"]))
					$retVal["semestercount"] = true;
				$trimmedString = trim($post["link"]);
				if($trimmedString=="")
					$retVal["link"] = true;
				if(!isset($post["vollzeit"]) AND !isset($post["teilzeit"]) AND !isset($post["dual"]))
					$retVal["angebotenAls"] = true;
				$retVal["categories"] = true;	//Voraussetzten, dass es ein Fehler gibt, also keine Kategorie gewählt wurde
				$categories = $this->selectCategories();	//alle kategorien selektieren
				foreach($categories AS $c){	//für jede Kategorie 
					if(isset($post[$c["name"]]))	//Wenn die jeweilige Kategorie existiert, dann
						unset($retVal["categories"]);	//Index "categories" aus "$retVal" löschen
				}
				unset($trimmedString);
				unset($categories);
				return $retVal;
		}
		
		/**
		*	Fügt einen neuen Studiengang mit dessen Daten ein.
		*	Dafür wird eine Methode aufgerufen, um in die Tabelle mit allen Studiengänge einzufügen und um in die Zwischentabelle (Studiengänge und Kategorien) einzufügen.
		*
		*	@param	array	-	Assoziatives Array mit den Daten des Studiengangs, die eingefügt werden sollen (z.B. die "$_POST"-Variable nach dem Abschicken des Formulars aus der "backend_insertUpdateFormular.php").
		*	@return	int	-	Gibt die ID des abgespeicherten Studiengangs zurück .
		**/
		public function insertStudycourse($post){
				$this->studycoursesModel->insertStudycourse($post);
				//Fülle Zwischentablle aus
				$lastStudiID = $this->studycoursesModel->insert_id();	//erst die zuletzt eingefügte ID holen
				$this->insertStudCat($lastStudiID, $post);	//Dann Zwsichentabelle ausfüllen
				//Rückgabe
				return $lastStudiID;
		}
				
		/**
		*	Entscheidet, welche Daten in die Zwischentabelle (Studiengänge und Kategorien) eingefügt werden sollen und ruft
		*	je nach dem eine Methode des Models auf, um die Daten einzufügen.
		*	Prüft ob einer der Kategorien im einzufügenden Studiengang vorkommt. Falls ja, dann soll ein Eintrag in der Zwischentabelle erstell werden, sonst nicht.
		*	
		*	@param array	-	Assoziatives Array mit den Daten des Studiengangs, die eingefügt werden sollen (z.B. die "$_POST"-Variable nach dem Abschicken des Formulars aus der "backend_insertUpdateFormular.php").
		**/
		private function insertStudCat($lastStudiID, $post){
			//--Volzeit-, Teilzeit-, und dualer-Studiengang verbinden
			if(isset($post["vollzeit"]))	//Wenn Vollzeitstudiengang
				$this->studycoursesModel->insertStudCat($lastStudiID, 4);	//StudiId und Vollzeit-ID verbinden. value(4) ist die ID für "Vollzeit" (Siehe Datenbank)
			if(isset($post["teilzeit"]))	//Wenn Teilzeitstudiengang
				$this->studycoursesModel->insertStudCat($lastStudiID, 3);	//StudiId und Teilzeit-ID verbinden	value(3) ist die ID für "Teilzeit" (Siehe Datenbank)
			if(isset($post["dual"])){	//Wenn dualer Studiengang
				$this->studycoursesModel->insertStudCat($lastStudiID, 5);	//StudiId und dual-ID verbinden.	value(5) ist die ID für "Dual" (Siehe Datenbank)
			}
			
			//--StudiId mit Master-, oder Bachelor-ID verbinden
			$a = $this->studycoursesModel->graduateIdToName($post["graduate_id"]);	//Speicher der Abschlussbeschreibung in "$a"
			$a = $a["name"][0];	//Speichert nur den ersten Character der Abschlussbeschreibung in "$a"
			switch($a){	
				case "B":	//Bachelor
						$this->studycoursesModel->insertStudCat($lastStudiID, 1);	//value(1) ist die ID für "Bachelor" (Siehe Datenbank)
					break;
				case "M":	//Master
						$this->studycoursesModel->insertStudCat($lastStudiID, 2);	//value(2) ist die ID für "Master" (Siehe Datenbank)
					break;
			}			
			unset($a);	//löscht die Varbiable "$a"

			//--Kategorien verbinden
			$categories = $this->selectCategories();	//alle kategorien selektieren
			foreach($categories AS $c){	//für jeden tupel 
				if(isset($post[$c["name"]]))
					$this->studycoursesModel->insertStudCat($lastStudiID, $post[$c["name"]]);
			}
			unset($categories);	//löscht $categories
		}
		
		/**
		*	Fügt einem String das Prefix "http://" hinzu, falls die ersten 7 Characters nicht dem Muster "http://" entschsprechen.
		*	
		*	@param string	-	Den zu bearbeitenden String.
		*	@return string	-	Der bearbeitete String.
		**/
		public function addHttp($link){
			$firstSevenCharsFromLink = substr($link,0,7);
			if($firstSevenCharsFromLink!="http://")
			$link = "http://".$link;
			return $link;
		}
		

		/**
		*	Gibt alle Studiengänge alphabetisch geordnet nach dem Studiengangsnamen zurück.
		*
		*	@return array	-	Assoziatives Array mit den Indexen ["id"], ["study_name"], ["graduate_name"], ["language_name"].
		**/
		public function selectStudicourses(){
			return $this->studycoursesModel->selectStudicourses();
		}
				
		/**
		*	Gibt einen Studiengang zurück.
		*	Dafür wird ein Studiengang vom Model aus der Datenbank gelesen und zusammengesetzt in einem assoziativen-Array zurückgegeben.	
		*
		*	@param	int	-	ID des Studiengangs.
		*	@return array	-	Assoziatives Array mit den Indexen ["graduate_name"], ["id"], ["graduate_id"], ["name"], ["department_id"], ["semestercount"], ["description"], ["language_id"], ["link"], alle ["category_id"]'s.
		**/
		public function selectStudicourse($id){
			/* 
			In "$rows" ist nun ein Studiengang abgespeichert. "$rows" ist ein mehrdimensionales-Array, indem mehrfach der eine Studiengang abgespeichert ist.
			Diese mehrfacheinträge unterscheiden sich ledeglich in der "category_id". Deswegen soll das Array "$rows" auf ein assoziatives-Array reduziert werden.
			Dazu wird das Array "$retVal" erstellt und in dieses Array werden alle Daten eingespeichert und für jede Kategorie ein eigenes assoziatives Feld erstellt.
			*/
			
			$rows = $this->studycoursesModel->selectStudicourse($id);	//Studiengang holen und in "$rows" abspeichern
			
			/** Sich nicht  Ändernde Daten abspeichern **/
			$retVal["id"] = $rows[0]["id"];
			$retVal["graduate_id"] = $rows[0]["graduate_id"];
			$retVal["graduate_name"] = $rows[0]["graduate_name"];
			$retVal["name"] = $rows[0]["name"];
			$retVal["department_id"] = $rows[0]["department_id"];
			$retVal["semestercount"] = $rows[0]["semestercount"];
			$retVal["description"] = $rows[0]["description"];
			$retVal["language_id"] = $rows[0]["language_id"];
			$retVal["link"] = $rows[0]["link"];		

			/** Die einzelnen ["category_id"]-Felder erstellen, je nachdem, was der Studiengang enthält  **/
			foreach($rows as $r){	
				switch($r["category_id"]){	//Cases im Switch sind abhängig von der Datenbank (siehe Relation "categories" und deren ids und namen)
					case 3:	//Teilzeit
						$retVal["teilzeit"] = $r["category_id"];	//Array-feld "teilzeit" erstellen
						break;
					case 4: //Vollzeit
						$retVal["vollzeit"] = $r["category_id"];	//Arrayfeld "vollzeit" erstellen
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
		
		/**
		*	Liefert Daten der Tabelle "graduates" zurück.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectDropDownDataGraduates(){
			return $this->studycoursesModel->selectDropDownDataGraduates();
		}
		
		/**
		*	Liefert Daten der Tabelle "languages" zurück.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectDropDownDataLanguages(){
			return $this->studycoursesModel->selectDropDownDataLanguages();
		}
		
		/**
		*	Liefert Daten der Tabelle "departments" zurück.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectDropDownDataDepartments(){
			return $this->studycoursesModel->selectDropDownDataDepartments();
		}
		
		/**
		*	Gibt alle Kategorien aus der Relation "categories" zurück, wobei
		*	die ersten fünf einträge mit der id 1-5 nicht beachtet werden.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectCategories(){
			return $this->studycoursesModel->selectCategories();
		}
		
		/**
		*	Löscht den Studiengang und dessen Werte in allen Zwischentabellen.
		*
		*	@param	int	-	ID des zu löschenden Studiengangs.
		**/
		public function deleteStudicourse($id){
			$this->studycoursesModel->deleteFromStudicourseCategories($id);	//Löscht aus der Zwischentabelle "studycourses_mm_categories"
			$this->studycoursesModel->deleteFromStudicourseTags($id);	//Löscht aus der Zwischentabelle "studycourses_mm_tags"
			$this->studycoursesModel->deleteFromStudicourse($id);	//Löscht aus der Tabelle "studycourses"
		}
	
		/**
		*	Bearbeitet/Ändert einen Studiengang.
		*	Dazu wird der Studiengang aktualisiert und dessen Werte in der Zwischentabelle gelöscht und neu eingefügt.
		*
		*	@param	array	-	Assoziatives Array mit den Daten des Studiengangs, die aktualisiert werden sollen (z.B. die "$_POST"-Variable nach dem Abschicken des Formulars aus der "backend_insertUpdateFormular.php").
		**/
		public function updateStudycourse($post){
			$this->studycoursesModel->updateStudycourse($post);
			$this->studycoursesModel->deleteFromStudicourseCategories($post["id"]);	//Löscht aus der Zwischentabelle "studycourses_mm_categories"
			$this->insertStudCat($post["id"], $post);	//Neue Tupel in die Zwischentabelle einfügen
		}
	
	}

?>