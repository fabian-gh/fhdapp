<?php
/**
*	Dateiname: "studiengaengeModel.php"
*	Zweck:	Diese Datei ist die Geschäftslogiksebene im MVC-Muster.	
*			Hier werden die Daten der Datenbank verwaltet. Diese Datei ist unabhängig von der Präsentation und Steuerung.
*	Benutzt von: "../../controllers/studiengaengeControllerBackend.php"
*	Autor Name: Okan Köse
*	Autor E-Mail: okan.koese@gmx.de	
**/

	class StudycoursesModel{
	
		//----- Instanzvariablen -----
		private $connection;
		
		
		
		//----- Instanzmethoden -----
		
		/**
		*	Konstruktor der Klasse "StudycoursesModel".
		*	Stellt die Datenbankverbindung her
		*/
		public function __construct(){
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);	//Instanz der Datenbankverbindung in connection abspeichern
		}
		
		
		
		/**
		*	Gibt den Namen einer bestimmten Abschlussbeschreibung zurück
		*
		*	@param int	-	Die ID der jeweiligen Abschlussbeschreibung.
		*	@return string	-	Der Namen der jeweiligen Abschlussbeschreibung.
		*/
		public function graduateIdToName($id){
			return $this->connection->query("SELECT name FROM graduates WHERE id=".$id.";")->fetch_assoc();
		}
				
		
		
		
		/**
		*	Gibt den Namen einer bestimmten Sprache zurück.
		*
		*	@param int	-	Die ID der jeweiligen Sprache.
		*	@return string	-	Der Name der jeweiligen Sprache.
		*/
		public function languageIdToName($id){
			return $this->connection->query("SELECT name FROM languages WHERE id=".$id.";")->fetch_assoc();;
		}
		
		
		
		
		/**
		*	Gibt den Namen eines bestimmten Fachbereiches zurück.
		*
		*	@param int	-	Die ID des jeweiligen Fachbereiches.
		*	@return string	-	Der Name des jeweiligen Fachbereiches.
		*/
		public function departmentIdToName($id){
			return $this->connection->query("SELECT name FROM departments WHERE id=".$id.";")->fetch_assoc();;
		}
		
		
		
		
		/**
		*	Fügt einen neuen Studiengang in die Datenbank ein.
		*
		*	@param	array	-	Assoziatives Array mit den Daten des Studiengangs, die eingefügt werden sollen (z.B. die "$_POST"-Variable nach dem Abschicken des Formulars aus der "backend_insertUpdateFormular.php").
		**/
		public function insertStudycourse($post){
			try{
				$post["name"] = mysql_real_escape_string($post["name"]);	//Injections ausschließen durch escape von Zeichen
				$post["description"] = mysql_real_escape_string($post["description"]);	//Injections ausschließen durch escape von Zeichen
				$post["link"] = mysql_real_escape_string($post["link"]);	//Injections ausschließen durch escape von Zeichen
				//Einfügen der Werte in die "studicourses" Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses(language_id, name, description, department_id, semestercount, graduate_id, link) VALUES(".$post["language_id"].", '".$post["name"]."', '".$post["description"]."', ".$post["department_id"].", ".$post["semestercount"].", ".$post["graduate_id"].", '".$post["link"]."')");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		
		
		
		/**
		*	Fügt ein Tupel in die Zwischentabelle "studycourses_mm_categories" ein.
		*	
		*	@param int	-	ID des Studiengangs
		*	@param int	-	ID der Kategorie
		**/	
		public function insertStudCat($studID, $id_cat){
			try{
				//Einfügen der Werte in die "studycourses_mm_categories" Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses_mm_categories(studycourse_id, category_id) VALUES($studID, $id_cat)");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		/**
		*	Liefert die ID, die für eine AUTO_INCREMENT Spalte durch eine vorherige Abfrage (meist INSERT) erzeugt wurde.
		*	
		*	@return int	-	ID der zuletzt erstellten id durch ein AUTO_INCREMENT.
		**/
		public function insert_id(){
			return $this->connection->insert_id;
		}
		
		
		
		/**
		*	Selektiert alle Studiengänge alphabetisch geordnet nach dem Studiengangsnamen aus der Datenbank und gibt diese zurück.
		*
		*	@return array	-	Assoziatives Array mit den Indexen ["id"], ["study_name"], ["graduate_name"], ["language_name"].
		**/
		public function selectStudicourses(){
			$result = $this->connection->query("SELECT DISTINCT s.id AS id, s.name AS study_name, g.name AS graduate_name, l.name AS language_name
												FROM `studycourses` s
												JOIN `graduates` g 
												ON s.graduate_id = g.id
												JOIN `languages` l 
												ON s.language_id = l.id
												JOIN `studycourses_mm_categories` sm
												ON s.id = sm.studycourse_id
												ORDER BY s.name ASC, g.name ASC, l.id ASC;");
			$retVal = array();
			while($row= $result->fetch_assoc()){	//eine Zeile in $row speichern und solange $row existiert, das heißt, solange zeilen da sind
				$retVal[] = $row;	//dem array $retVal die Zeile $row hinzufügen
			}
			return $retVal;
		}
		
		
		
		
		/**
		*	Selektiert einen Studiengang aus der Datenbank und gibt diesen zurück.	
		*
		*	@param	int	-	ID des zu selektierenden Studiengangs.
		*	@return array	-	Assoziatives Array mit den Indexen ["graduate_name"], ["id"], ["graduate_id"], ["name"], ["department_id"], ["semestercount"], ["description"], ["language_id"], ["link"], alle ["category_id"]'s.
		**/
		public function selectStudicourse($id){
			$result = $this->connection->query("SELECT g.name AS graduate_name, s.id AS id ,s.graduate_id AS graduate_id, s.name AS name, s.department_id AS department_id, s.semestercount AS semestercount, s.description AS description, s.language_id AS language_id ,s.link AS link, c.id AS category_id
												FROM studycourses s 
												JOIN graduates g ON g.id = s.graduate_id
												JOIN studycourses_mm_categories smmc ON s.id = smmc.studycourse_id
												JOIN categories c ON smmc.category_id = c.id
												WHERE s.id=".$id.";");		
			while($row= $result->fetch_assoc()){	//eine Zeile in $row speichern und solange $row existiert, das heißt, solange zeilen da sind
				$retVal[] = $row;	//dem array $retVal die Zeile $row hinzufügen
			}
			return $retVal;
		}
		
		
		/**
		*	Selektiert die Datensätze der Tabelle "graduates" und gibt diese zurück.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectDropDownDataGraduates(){
			return $this->executeQueryAndFetchAssoc("SELECT id, CONCAT(abbreviation,' - ',name) AS name FROM graduates ORDER BY 'id' ASC;");
		}
		
		
		
		/**
		*	Selektiert die Datensätze der Tabelle "languages" und gibt diese zurück.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectDropDownDataLanguages(){
			return $this->executeQueryAndFetchAssoc("SELECT id, name FROM languages ORDER BY 'id' ASC;");
		}

		
		
		
		/**
		*	Selektiert die Datensätze der Tabelle "departments" und gibt diese zurück.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectDropDownDataDepartments(){
			return $this->executeQueryAndFetchAssoc("SELECT id, CONCAT(id,' - ',name) AS name FROM departments ORDER BY 'id' ASC;");
		}
		
		
		
		
		/**
		*	Selektiert die Datensätze bei denen die id > 5 ist aus der Tabelle "categories" und gibt diese zurück.
		*
		*	@return array	-	Zweidimensionales assoziatives Array mit Indexen [["id"]["name"]].
		**/
		public function selectCategories(){
			return $this->executeQueryAndFetchAssoc("SELECT id, category AS name FROM categories WHERE id>5 ORDER BY 'id' ASC;");
		}
		
		
		
		/**
		*	Führt eine SELECT-Abfrage aus und speichert die Zeilen in ein assoziatives Array (Fetch a result row as an associative array).
		*
		*	@param	string	-	Die SELECT-Abfrage, die ausgeführt werden soll.
		*	@return array	-	Das (evtl. zweidimensionale) assoziative Array.
		**/
		private function executeQueryAndFetchAssoc($query){
			try{
				//Selectieren der Werte und einspeichern in $result
				$result = $this->connection->query($query);
				while($row = $result->fetch_assoc()){	//eine Zeile in $row speichern und solange $row existiert, das heißt, solange zeilen da sind
					$retVal[] = $row;	//dem array $retVal die Zeile $row hinzufügen
				}
				return $retVal;
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
	
				
		
		
		
		/**
		*	Löscht die Werte eines bestimmten Studiengangs aus der Zwischentabelle "studycourses_mm_categories"
		*
		*	@param	int	-	ID des Studiengangs, dessen Werte aus der Zwischentabelle "studycourses_mm_categories" gelöscht werden sollen.
		**/
		public function deleteFromStudicourseCategories($id){
			try{
				//Lösche den Studiengang aus der Zwischentabelle "studycourses_mm_categories".
				$this->connection->query("DELETE FROM studycourses_mm_categories WHERE studycourse_id=".$id.";");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		
		/**
		*	Löscht die Werte eines bestimmten Studiengangs aus der Zwischentabelle "studycourses_mm_tags".
		*
		*	@param	int	-	ID des Studiengangs, dessen Werte aus der Zwischentabelle "studycourses_mm_tags" gelöscht werden sollen.
		**/
		public function deleteFromStudicourseTags($id){
			try{
				//Lösche den Studiengang aus der Zwischentabelle "studycourses_mm_tags"
				$this->connection->query("DELETE FROM studycourses_mm_tags WHERE studycourse_id=".$id.";");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		
		
		/**
		*	Löscht den Studiengang aus der Tabelle "studycourses".
		*
		*	@param	int	-	ID des zu löschenden Studiengangs.
		**/
		public function deleteFromStudicourse($id){
			try{
				//Lösche den Studiengang aus der Tabelle "studycourses"
				$this->connection->query("DELETE FROM studycourses WHERE id=".$id.";");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		
		
		
		/**
		*	Aktualisiert einen Studiengang in der Tabelle "studycourses".
		*
		*	@param	array	-	Assoziatives Array mit den Daten des Studiengangs, die aktualisiert werden sollen (z.B. die "$_POST"-Variable nach dem Abschicken des Formulars aus der "backend_insertUpdateFormular.php").
		**/
		public function updateStudycourse($post){
			try{
				$post["name"] = mysql_real_escape_string($post["name"]);	//Injections ausschließen durch escape von Zeichen
				$post["description"] = mysql_real_escape_string($post["description"]);	//Injections ausschließen durch escape von Zeichen
				$post["link"] = mysql_real_escape_string($post["link"]);	//Injections ausschließen durch escape von Zeichen
				$this->connection->query("UPDATE studycourses
										SET language_id = ".$post["language_id"].", 
											name = '".$post["name"]."', 
											description = '".$post["description"]."', 
											department_id = ".$post["department_id"].", 
											semestercount = ".$post["semestercount"].", 
											graduate_id = ".$post["graduate_id"].", 
											link = '".$post["link"]."' 
										WHERE id = ".$post["id"].";");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
	}
	
?>