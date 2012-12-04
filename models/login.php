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
     * Connection
     * @var Object
     */
    private $Connection;


    
    /**
     * Konstruktor der den Loginvorgang durchführt
     * @param Object $Data
     */
    public function __construct($post){
        // Eingaben aus dem Formular
        $this->setUsername($post['username']);
        $this->setPassword(md5($post['password']));
        $this->getConnection();
        $this->login();
    }


    /**
     * Function for doing the login
     */
    public function login(){
        try{
            // Abfrage
            $query = $this->Connection->query("SELECT id, username, password 
                                    FROM user 
                                    WHERE username = '".$this->username."'
                                    AND password = '".$this->password."'");
            
            // Abfrage ausführen
            while($row = $query->fetch_assoc()){
                $resultSet[] = $row;
            }
            
            // Wenn Abfrage richtig (nicht leer), dann User-ID in Session speichern
            // und auf Backend-Hauptseite leiten
            if(!empty($resultSet)){
                $_SESSION['user_id'] = $resultSet['id'];
                header('Location: views/index.php');
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
    public function getConnection() {
        $this->Connection = $_SESSION['con'];
    }
}
 
/* End of file login.php */
/* Location: ./models/login.php */