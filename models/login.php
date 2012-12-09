<<<<<<< HEAD
<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

class Login{
    
    /**
     * Benutzername
     * @var String 
     */
    private $username;
    
    /**
     * Passwort (MD5)
     * @var String 
     */
    private $password;
    
    /**
     * Konstruktor der den Loginvorgang durchführt
     */
    public function __construct(){
        
        // Eingaben aus dem Formular
        $this->setUsername($_POST['username']);
        $this->setPassword(md5($_POST['password']));
        
        try{
            // Abfrage
            $query = $_SESSION['connection']->query("SELECT username, password 
                                    FROM user
                                    WHERE username = '".$this->username."'
                                    AND password = '".$this->password."'");
            
            // Abfrage ausführen
            while($row = $query->fetch_assoc()){
                $resultSet[] = $row;
            }
            
            
            // Wenn Abfrage richtig (nicht leer), dann Text "Eingeloggt" ausgeben
            if(!empty($resultSet)){

                //terminezeugs
                require_once 'controllers/termineController.php';
                $appointmentController = new AppointmentController();
                $semestersWithAppointments = $appointmentController->semestersWithAppointments();
                require_once 'views/termine/termine.php';


            } else {
                // ansonsten "Login falsch" ausgeben
                echo 'Login falsch';
            }
            
        } catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    
    /**
     * Username setzen
     * @param String $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * Passwort setzen
     * @param String $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }


}

 
/* End of file login.php */
=======
<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

class Login{
    
    /**
     * Benutzername
     * @var String 
     */
    private $username;
    
    /**
     * Passwort (MD5)
     * @var String 
     */
    private $password;

    /**
     * DB-Connection
     * @var Object
     */
    private $Connection;


    
    /**
     * Konstruktor der den Loginvorgang durchführt
     * @param Object $Data
     */
    public function __construct($con, $post){
        // Eingaben aus dem Formular
        $this->setUsername($post['username']);
        $this->setPassword(md5($post['password']));
        $this->setConnection($con);
        $this->login();
    }


    /**
     * Function for doing the login
     */
    public function login(){
        try{
            // Abfrage ausführen
            $query = $this->Connection->query("SELECT id, username, password 
                                                FROM user 
                                                WHERE username = '".$this->username."'
                                                AND password = '".$this->password."'");
            
            // Abfrage fetchen
            while($row = $query->fetch_assoc()){
                $resultSet[] = $row;
            }
            
            // Wenn Abfrage richtig (nicht leer), dann User-ID in Session speichern
            // und auf Backend-Hauptseite leiten
            if(!empty($resultSet)){
                $_SESSION['user_id'] = $resultSet[0]['id'];
                header('Location: login.php');
            } else {
                // ansonsten auf Login-Seite leiten
                $_SESSION['loginfailure'] = 'Login falsch!';
                header('Location: login.php');
            }
            
        } catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    
    // =========================================================================
    // ======================= Getter & Setter =================================
    // =========================================================================


    /**
     * Username setzen
     * @param String $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * Passwort setzen
     * @param String $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Connection setzen
     * @param String $password
     */
    public function setConnection($con) {
        $this->Connection = $con;
    }
}
 
/* End of file login.php */
>>>>>>> origin/mensa
/* Location: ./models/login.php */