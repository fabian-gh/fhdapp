<?php
/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Ewest Paul - Kristian
 */


class db_connector{
    
private $server;
private $username;
private $password;
private $dbname;


function __construct()
{
    //db config
    include 'config/db.php';
    $this->server= $db['hostname'];
    $this->username= $db['username'];
    $this->password= $db['password'];
    $this->dbname= $db['database'];
}

function connect()
{
$conn = mysql_connect($this->server,  $this->username,  $this->password);
    if(!$conn)
    {
    die('Could not connect to the Server: '.  mysql_error($conn));
    }
$db = mysql_select_db($this->dbname,$conn);
    if (!$db)
    {
    die('Could not connect to the Database: '.  mysql_error($db));
    }
    return $conn;
}

// main list of  courses
function all_courses($filter)
{
$query = "SELECT distinct e1.name, e1.time as 'time1', e2.time as 'time2' , 
e1.graduate as 'grad1', e2.graduate as 'grad2' 
FROM studycourses_view e1 join studycourses_view e2 on e1.name = e2.name 
and e1.graduate!= e2.graduate ".$filter."GROUP BY e1.name
UNION 
SELECT e1.name, e1.time as 'time1', e2.time as 'time2', 
e1.graduate  as 'grad1', e2.graduate as 'grad2' 
FROM studycourses_view e1 join studycourses_view e2 on e1.name=e2.name 
and e1.name not in (SELECT a1.name FROM studycourses_view a1, 
studycourses_view a2 where a1.name = a2.name and a1.graduate!=a2.graduate) ".$filter."
GROUP BY e1.name ORDER BY name";
return $rs = mysql_query($query,$this->connect());
}

//check amount of graduates of selected course
function get_graduate_amount($name)
{
$query = "SELECT count(*) as 'amount' 
FROM (SELECT graduate FROM studycourses_view WHERE name = '".$name."' GROUP BY graduate) tab;";
$rs = mysql_query($query,$this->connect()); 
$row = mysql_fetch_array($rs);
return $row['amount'];
}

//check the graduate of selected course
function get_graduate_info($name)
{
$query = "SELECT graduate FROM studycourses_view WHERE name = '".$name."' GROUP BY graduate;";  
$rs = mysql_query($query,$this->connect()); 
$row = mysql_fetch_array($rs);
return $row['graduate'];
}

// get a tupel with a course information for the info-page
function get_course_information($name,$graduate)
{
$query = "SELECT e1.name,e2.name as 
'graduate',e3.name as 'department', e1.semestercount, 
e1.description,e1.link FROM studycourses e1 join graduates e2 on e1. 
graduate_id=e2.id join departments e3 on e1.department_id = e3.id 
WHERE e1.id = (SELECT id FROM studycourses_view WHERE name='".$name."' and 
graduate='".$graduate."' GROUP BY id);";
$rs = mysql_query($query,$this->connect()); 
return $row = mysql_fetch_array($rs);
}
}

/* End of file studiengaenge.php */
/* Location: ./models/studiengaenge.php */

?>