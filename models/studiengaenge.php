<?php
/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Ewest Paul - Kristian
 */

 /**
 * Model
 */
class db_connector{
    
private $language;

function __construct()
{
$this->language='1';
}

 /**
 * Aufbau von DB-connection
 * @return DB-connection
 */
function connect()
{
    $conn = mysql_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd']);
    if(!$conn)
    {
    die('Could not connect to the Server: '.  mysql_error($conn));
    }
    $db = mysql_select_db($_SESSION['db'],$conn);
    if (!$db)
    {
    die('Could not connect to the Database: '.  mysql_error($db));
    }
    return $conn;
}

// main list of  courses
 /**
 * ResultSet mit benötigten Studiengängen + Informationen über akadem. Grad und Zeiten(Teilzeit/Dual)
 * @param Filteroptionen als String (SQL-Teilabfrage)
 * @return ResultSet
 */
function all_courses($filter)
{
$query = "SELECT * FROM `studycourses_view` WHERE language= ".$this->language." ".$filter." ORDER BY name";
return $rs = mysql_query($query,$this->connect());
}



//check amount of graduates of selected course
 /**
 * Liefert Anzahl von akadem. Grade eines Studienganges bzw. einer Gruppe von Studiengängen mit gleicher Bezeichnung
 * @param Studiengangsname/Bezeichnung (String)
 * @return Anzahl (int)
 */
function get_graduate_amount($name)
{
$query = "SELECT count(*) as 'amount' 
FROM (SELECT graduate FROM studycourses_view WHERE name = '".$name."' GROUP BY graduate) tab;";
$rs = mysql_query($query,$this->connect()); 
$row = mysql_fetch_array($rs);
return $row['amount'];
}

//check the graduate of selected course

 /**
 * Liefert Information über dem akadem. Grad eines bestimmten Studienganges
 * @param Studiengangsname/Bezeichnung (String)
 * @return akadem. Grad (String)
 */
function get_graduate_info($name)
{
$query = "SELECT graduate FROM studycourses_view WHERE name = '".$name."' GROUP BY graduate;";  
$rs = mysql_query($query,$this->connect()); 
$row = mysql_fetch_array($rs);
return $row['graduate'];
}

// get a tupel with a course information for the info-page
 /**
 * Liefert einen Tupel mit Informationen / Daten über einen bestimmten Studiengang für die Info-Seite
 * @param Studiengangsname/Bezeichnung (String), akadem. Grad (String)
 * @return Tupel mit Informationen (row)
 */
function get_course_information($name,$graduate)
{
$query = "SELECT e1.name,e2.name as 
'graduate',e3.name as 'department', e1.semestercount, 
e1.description,e1.link FROM studycourses e1 join graduates e2 on e1. 
graduate_id=e2.id join departments e3 on e1.department_id = e3.id 
WHERE e1.id = (SELECT id FROM studycourses_view WHERE name='".$name."' and 
graduate='".$graduate."' and language= ".$this->language." GROUP BY id);";
$rs = mysql_query($query,$this->connect()); 
return $row = mysql_fetch_array($rs);
}
}

/* End of file studiengaenge.php */
/* Location: ./models/studiengaenge.php */

?>