<?php
/**
*	Dateiname: "studiengaengeControllerBackend.php"
*	Zweck:	Diese Datei ist die Steuerungsebene im MVC-Muster.
*			Der Controller steuert die Methoden des Models und ruft diese gezielt auf. 
*			Somit ist das Model (die Gesch�ftslogik) von der View (Pr�sentationsebene) gekapselt.
*	Benutzt von: "../../controllers/studiengaengeControllerBackend.php"
*	Autor Name: Okan K�se
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
		*	Gibt den Namen einer Abschlussbeschreibung zur�ck.
		*
		*	@param int	-	Die ID der jeweiligen Abschlussbeschreibung.
		*	@return string	-	Der Namen der jeweiligen Abschlussbeschreibung.
		*/
		public function graduateIdToName($id){
			$retVal = $this->studycoursesModel->graduateIdToName($id);
			return $retVal["name"];
		}
		
		/**
		*	Gibt den Namen einer Sprache zur�ck.
		*
		*	@param int	-	Die ID der jeweiligen Sprache.
		*	@return string	-	Der Name der jeweiligen Sprache.
		*/
		public function languageIdToName($id){
			$retVal = $this->studycoursesModel->languageIdToName($id);
			return $retVal["name"];
		}
		
		/**
		*	Gibt den Namen eines Fachbereiches zur�ck.
		*
		*	@param int	-	Die ID des jeweiligen Fachbereiches.
		*	@return string	-	Der Name des jeweiligen Fachbereiches.
		*/
		public function departmentIdToName($id){
			$retVal = $this->studycoursesModel->departmentIdToName($id);
			return $retVal["name"];
		}
		
		/**
		*	�berpr�ft das Formular aus der "backend_insertUpdateFormular.php".
		*	Dabei wird gepr�ft, ob die vom Benutzer auszuf�llenden Felder korrekt ausgef�llt wurden.
		*	Die gepr�ften Felder sind:
		*		- Name des Studiengangs	-	Darf nicht leer sein. Nur Leerzeichen z�hlen als leer.
		*		- Semesteranzahl	-	Darf nicht leer sein und muss aus Ziffern bestehen.
		*		- Wird angeboten als	-	Studiengang muss mindestens als Vollzeit-, Teilzeit-, oder Dualer-Studiengang angeboten werden.
		*		- Kategorien	-	Studiengang muss mindestens einer Kategorie zugeh�ren.
		*		- Studiengangsbeschreibung	-	Darf nicht leer sein. Nur Leerzeichen z�hlen als leer.
		*		- Link f�r weitere Informationen	-	Darf nicht leer sein. Nur Leerzeichen z�hlen als leer.
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
				$retVal["categories"] = true;	//Voraussetzten, dass es ein Fehler gibt, also keine Kategorie gew�hlt wurde
				$categories = $this->selectCategories();	//alle kategorien selektieren
				foreach($categories AS $c){	//f�r jede Kategorie 
					if(isset($post[$c["name"]]))	//Wenn die jeweilige Kategorie existiert, dann
						unset($retVal["categories"]);	//Index "categories" aus "$retVal" l�schen
				}
				unset($trimmedString);
				unset($categories);
				return $retVal;
		}
		
		/**
		*	F�gt einen neuen Studiengang mit dessen Daten ein.
		*	Daf�r wird eine Methode aufgerufen, um in die Tabelle mit allen Studieng�nge einzuf�gen und um in die Zwischentabelle (Studieng�nge und Kategorien) einzuf�gen.
		*
		*	@param	array	-	Assoziatives Array mit den Daten des Studiengangs, die eingef�gt werden sollen (z.B. die "$_POST"-Variable nach dem Abschicken des Formulars aus der "backend_insertUpdateFormular.php").
		*	@return	int	-	Gibt die ID des abgespeicherten Studiengangs zur�ck .
		**/
		public function insertStudycourse($post){
				$this->studycoursesModel->insertStudycourse($post);
				//F�lle Zwischentablle aus
				$lastStudiID = $this->studycoursesModel->insert_id();	//erst die zuletzt eingef�gte ID holen
				$this->insertStudCat($lastStudiID, $post);	//Dann Zwsichentabelle ausf�llen
				//R�ckgabe
				return $lastStudiID;
		}
				
		/**
		*	Entscheidet, welche Daten in die Zwischentabelle (Studieng�nge und Kategorien) eingef�gt werden sollen und ruft
		*	je nach dem eine Methode des Models auf, um die Daten einzuf�gen.
		*	Pr�ft ob einer der Kategorien im einzuf�genden Studiengang vorkommt. Falls ja, dann soll ein Eintrag in der Zwischentabelle erstell werden, sonst nicht.
		*	
		*	@param array	-	Assoziatives Array mit den Daten des Studiengangs, die eingef�gt werden sollen (z.B. die "$_POST"-Variable nach dem Abschicken des Formulars aus der "backend_insertUpdateFormular.php").
		**/
		private function insertStudCat($lastStudiID, $post){
			//--Volzeit-, Teilzeit-, und dualer-Studiengang verbinden
			if(isset($post["vollzeit"]))	//Wenn Vollzeitstudiengang
				$this->studycoursesModel->insertStudCat($lastStudiID, 4);	//StudiId und Vollzeit-ID verbinden. value(4) ist die ID f�r "Vollzeit" (Siehe Datenbank)
			if(isset($post["teilzeit"]))	//Wenn Teilzeitstudiengang
				$this->studycoursesModel->insertStudCat($lastStudiID, 3);	//StudiId und Teilzeit-ID verbinden	value(3) ist die ID f�r "Teilzeit" (Siehe Datenbank)
			if(isset($post["dual"])){	//Wenn dualer Studiengang
				$this->studycoursesModel->insertStudCat($lastStudiID, 5);	//StudiId und dual-ID verbinden.	value(5) ist die ID f�r "Dual" (Siehe Datenbank)
			}
			
			//--StudiId mit Master-, oder Bachelor-ID verbinden
			$a = $this->studycoursesModel->graduateIdToName($post["graduate_id"]);	//Speicher der Abschlussbeschreibung in "$a"
			$a = $a["name"][0];	//Speichert nur den ersten Character der Abschlussbeschreibung in "$a"
			switch($a){	
				case "B":	//Bachelor
						$this->studycoursesModel->insertStudCat($lastStudiID, 1);	//value(1) ist die ID f�r "Bachelor" (Siehe Datenbank)
					break;
				case "M":	//Master
						$this->studycoursesModel->insertStudCat($lastStudiID, 2);	//value(2) ist die ID f�r "Master" (Siehe Datenbank)
					break;
			}			
			unset($a);	//l�scht die Varbiable "$a"

			//--Kategorien verbinden
			$categories = $this->selectCategories();	//alle kategorien selektieren
			foreach($categories AS $c){	//f�r jeden tupel 
				if(isset($post[$c["name"]]))
					$this->studycoursesModel->insertStudCat($lastStudiID, $post[$c["name"]]);
			}
			unset($categories);	//l�scht $categories
		}
		
		/**
		*	F�gt einem String das Prefix "http://" hinzu, falls die ersten 7 Characters nicht dem Muster "http://" entschsprechen.
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
		*	Gibt alle Studieng�nge alphabetisch geordnet nach dem Studiengangsnamen zur�ck.
		*
		*	@return array	-	Assoziatives Array mit den Indexen ["id"], ["study_name"], ["graduate_name"], ["language_name"].
		**/
		public function selectStudicourses(){
			return $this->studycoursesModel->selectStudicourses();
		}
				
		/**
		*	Gibt einen Studiengang zur�ck.
		*	Daf�r wird ein Studiengang vom Model aus der Datenbank gelesen und zusammengesetzt in einem assoziativen-Array zur�ckgegeben.	
		*
		*	@param	int	-	ID des Studiengangs.
		*	@return array	-	Assoziatives Array mit den Indexen ["graduate_name"], ["id"], ["graduate_id"], ["name"], ["department_id"], ["semestercount"], ["description"], ["language_id"], ["link"], alle ["category_id"]'s.
		**/
		public function selectStudicourse($id){
			/* 
			In "$rows" ist nun ein Studiengang abgespeichert. "$rows" ist ein mehrdimensionales-Array, indem mehrfach der eine Studiengang abgespeichert ist.
			Diese mehrfacheintr�ge unterscheiden sich ledeglich in der "category_id". Deswegen soll das Array "$rows" auf ein assoziatives-Array reduziert werden.
			Dazu wird das Array "$retVal" erstellt und in dieses Array werden alle Daten eingespeichert und f�r jede Kategorie ein eigenes assoziatives Feld erstellt.
			*/
			
			$rows = $this->studycoursesModel->selectStudicourse($id);	//Studiengang holen und in "$rows" abspeichern
			
			/** Sich nicht  �ndernde Daten abspeichern **/
			$retVal["id"] = $rows[0]["id"];
			$retVal["graduate_id"] = $rows[0]["graduate_id"];
			$retVal["graduate_name"] = $rows[0]["graduate_name"];
			$retVal["name"] = $rows[0]["name"];
			$retVal["department_id"] = $rows[0]["department_id"];
			$retVal["semestercount"] = $rows[0]["semestercount"];
			$retVal["description"] = $rows[0]["description"];
			$retVal["language_id"] = $rows[0]["language_id"];
			$retVal["link"] = $rows[0]["link"];		

			/** Die einzelnen ["category_id"]-Felder erstellen, je nachdem, was der Studiengang enth�lt  **/
			foreach($rows as $r){	
				switch($r["category_id"]){	//Cases im Switch sind abh�ngig von der Datenbank (siehe Relation "categories" und deren ids und namen)
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
		*	Liefert Daten der Tabelle "graduates" zur�ck.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectDropDownDataGraduates(){
			return $this->studycoursesModel->selectDropDownDataGraduates();
		}
		
		/**
		*	Liefert Daten der Tabelle "languages" zur�ck.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectDropDownDataLanguages(){
			return $this->studycoursesModel->selectDropDownDataLanguages();
		}
		
		/**
		*	Liefert Daten der Tabelle "departments" zur�ck.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectDropDownDataDepartments(){
			return $this->studycoursesModel->selectDropDownDataDepartments();
		}
		
		/**
		*	Gibt alle Kategorien aus der Relation "categories" zur�ck, wobei
		*	die ersten f�nf eintr�ge mit der id 1-5 nicht beachtet werden.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectCategories(){
			return $this->studycoursesModel->selectCategories();
		}
		
		/**
		*	L�scht den Studiengang und dessen Werte in allen Zwischentabellen.
		*
		*	@param	int	-	ID des zu l�schenden Studiengangs.
		**/
		public function deleteStudicourse($id){
			$this->studycoursesModel->deleteFromStudicourseCategories($id);	//L�scht aus der Zwischentabelle "studycourses_mm_categories"
			$this->studycoursesModel->deleteFromStudicourseTags($id);	//L�scht aus der Zwischentabelle "studycourses_mm_tags"
			$this->studycoursesModel->deleteFromStudicourse($id);	//L�scht aus der Tabelle "studycourses"
		}
	
		/**
		*	Bearbeitet/�ndert einen Studiengang.
		*	Dazu wird der Studiengang aktualisiert und dessen Werte in der Zwischentabelle gel�scht und neu eingef�gt.
		*
		*	@param	array	-	Assoziatives Array mit den Daten des Studiengangs, die aktualisiert werden sollen (z.B. die "$_POST"-Variable nach dem Abschicken des Formulars aus der "backend_insertUpdateFormular.php").
		**/
		public function updateStudycourse($post){
			$this->studycoursesModel->updateStudycourse($post);
			$this->studycoursesModel->deleteFromStudicourseCategories($post["id"]);	//L�scht aus der Zwischentabelle "studycourses_mm_categories"
			$this->insertStudCat($post["id"], $post);	//Neue Tupel in die Zwischentabelle einf�gen
		}
	
	}

?>