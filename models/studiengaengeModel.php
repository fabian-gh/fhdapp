<?php

	class StudycoursesModel{
	
		//IV
		private $connection;
		
		//Construct
		public function __construct(){
			//Instanz der Datenbankverbindung in connection abspeichern
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);	
		}
		
		//Funktion um Werte in die Relation 'studycourses' einzuf�gen. 
		public function insertStudycourse($post){
			try{
				//Einf�gen der Werte in die "studicourses" Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses(language_id, name, description, department_id, semestercount, graduate_id, link) VALUES(".$post["language_id"].", '".$post["name"]."', '".$post["description"]."', ".$post["department_id"].", ".$post["semestercount"].", ".$post["graduate_id"].", '".$post["link"]."')");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		//Funktion um Werte in die Relation 'studycourses_mm_categories' einzuf�gen. 
		//Dabei muss die ID von der Categorie (id_cat) �bergeben werden und die ID vom Studiengang($studID)
		public function insertStudCat($studID, $id_cat){
			try{
				//Einf�gen der Werte in die "studycourses_mm_categories" Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses_mm_categories(studycourse_id, category_id) VALUES($studID, $id_cat)");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		//R�ckgabe der zuletzt erstellten ID durch AUTO_INCREMENT
		public function insert_id(){
			return $this->connection->insert_id;
		}
		
		
		//Liefert Daten der Tabelle "graduates", "languages" oder "departments" zur�ck
		//R�ckgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectData($type){
			try{
				switch($type){
					case "graduates":	//Liefert Fachbereiche zur�ck (departments)
						$query = "SELECT id, CONCAT(abbreviation,' - ',name) AS name FROM graduates ORDER BY 'id' ASC;";
						break;
					case "languages":	//Liefert Sprachen zur�ck (languages)
						$query = "SELECT id, name FROM languages ORDER BY 'id' ASC;";
						break;
					case "departments":	//Liefert Fachbereiche zur�ck (departments)
						$query = "SELECT id, CONCAT(id,' - ',name) AS name FROM departments ORDER BY 'id' ASC;";
						break;	
				}
				
				//Selectieren der Werte und einspeichern in $result
				$result = $this->connection->query($query);
				while($row = $result->fetch_assoc()){	//eine Zeile in $row speichern und solange $row existiert, das hei�t, solange zeilen da sind
					$retVal[] = $row;	//dem array $retVal die Zeile $row hinzuf�gen
				}
				return $retVal;
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		//Liefert abbreviation einer bestimmten ID zur�ck
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