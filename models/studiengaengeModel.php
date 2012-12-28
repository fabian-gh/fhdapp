<?php

	class StudycoursesModel{
	
		//IV
		private $connection;
		
		//Construct
		public function __construct(){
			//Instanz der Datenbankverbindung in connection abspeichern
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);	
		}
		
		//Funktion um Werte in die Relation 'studycourses' einzufügen. 
		public function insertStudycourse($post){
			try{
				//Einfügen der Werte in die "studicourses" Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses(language_id, name, description, department_id, semestercount, graduate_id, link) VALUES(".$post["language_id"].", '".$post["name"]."', '".$post["description"]."', ".$post["department_id"].", ".$post["semestercount"].", ".$post["graduate_id"].", '".$post["link"]."')");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		//Funktion um Werte in die Relation 'studycourses_mm_categories' einzufügen. 
		//Dabei muss die ID von der Categorie (id_cat) übergeben werden und die ID vom Studiengang($studID)
		public function insertStudCat($studID, $id_cat){
			try{
				//Einfügen der Werte in die "studycourses_mm_categories" Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses_mm_categories(studycourse_id, category_id) VALUES($studID, $id_cat)");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		//Rückgabe der zuletzt erstellten ID durch AUTO_INCREMENT
		public function insert_id(){
			return $this->connection->insert_id;
		}
		
		//Liefert alle Studiengänge alphabetisch geordnet nach dem Studiengangsnamen zurück
		//mit den Attributen: StudiengangsId, StudiengangsName, AbschlussartAbkürzung und ob es Teil-oder Vollzeit ist
		public function selectStudicourses(){
			$result = $this->connection->query("SELECT s.id AS id, s.name AS studyName, g.name AS graduateName, c.category AS categoryName
												FROM `studycourses` s
												JOIN `graduates` g 
												ON s.graduate_id = g.id
												JOIN `studycourses_mm_categories` sm
												ON s.id = sm.studycourse_id
												JOIN `categories` c
												ON c.id = sm.category_id
												WHERE c.id = 4 OR c.id = 3
												ORDER BY s.name, g.name, c.category ASC;");
			while($row= $result->fetch_assoc()){	//eine Zeile in $row speichern und solange $row existiert, das heißt, solange zeilen da sind
				$retVal[] = $row;	//dem array $retVal die Zeile $row hinzufügen
			}
			return $retVal;
		}
		
		
		//Liefert Daten der Tabelle "graduates", "languages" oder "departments" zurück
		//Rückgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownData($type){
			try{
				switch($type){
					case "graduates":	//Liefert Fachbereiche zurück (departments)
						$query = "SELECT id, CONCAT(abbreviation,' - ',name) AS name FROM graduates ORDER BY 'id' ASC;";
						break;
					case "languages":	//Liefert Sprachen zurück (languages)
						$query = "SELECT id, name FROM languages ORDER BY 'id' ASC;";
						break;
					case "departments":	//Liefert Fachbereiche zurück (departments)
						$query = "SELECT id, CONCAT(id,' - ',name) AS name FROM departments ORDER BY 'id' ASC;";
						break;	
				}
				
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
		
		//Liefert abbreviation einer bestimmten ID zurück
		public function selectGradAbb($id){
			try{		
				//Selectieren des Wertes und einspeichern in $retVal
				$retVal = $this->connection->query("SELECT abbreviation FROM graduates WHERE id=".$id." ORDER BY 'id' ASC;");
				return $retVal->fetch_assoc();
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
	}

?>