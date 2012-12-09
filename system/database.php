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

class Database{
    
    /**
     * Hostname
     * @var String
     */
    private $hostname;
    
    /**
     * Datenbank
     * @var String 
     */
    private $database;
    
    /**
     * Benutzername
     * @var String 
     */
    private $username;
    
    /**
     * Passwort
     * @var String 
     */
    private $password;
    
    
    /**
     * Datenbank-Connection aufbauen und dauerhaft in Session speichern
     */
    public function __construct(){
        // DB-Zugangsdaten einbinden
        require_once 'config/db.php';
        
        $this->setHostname($db['hostname']);
        $this->setDatabase($db['database']);
        $this->setUsername($db['username']);
        $this->setPassword($db['password']);
        
        //Connection in Session speichern
        $_SESSION['connection'] = new mysqli($this->hostname, $this->username, $this->password, $this->database);
    }
    
    
    // =========================================================================
    // ======================= Getter & Setter =================================
    // =========================================================================
    
    /**
     * Hostnamen setzen
     * @param String $host
     */
    public function setHostname($host){
        $this->hostname = $host;
    }
    
    
    /**
     * Datenbank setzen
     * @param String $db
     */
    public function setDatabase($db){
        $this->database = $db;
    }
    
    
    /**
     * Benutzernamen setzen
     * @param String $user
     */
    public function setUsername($user){
        $this->username = $user;
    }
    
    
    /**
     * Passwort setzen
     * @param String $pw
     */
    public function setPassword($pw){
        $this->password = $pw;
    }
    

    /**
     * Hostnamen zurückliefern
     * @return String
     */
    public function getHostname(){
        return $_SESSION['host'];
    }
    
    
    /**
     * Datenbank zurückliefern
     * @return String
     */
    public function getDatabase(){
        return $_SESSION['db'];
    }
    
    
    /**
     * Usernamen zurückliefern
     * @return String
     */
    public function getUsername(){
        return $_SESSION['user'];
    }
    
    
    /**
     * Passwort zurückliefern
     * @return String
     */
    public function getPassword(){
        return $_SESSION['pwd'];
    }
}

/* End of file database.php */
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

class Database{
    
    /**
     * Hostname
     * @var String
     */
    private $hostname;
    
    /**
     * Datenbank
     * @var String 
     */
    private $database;
    
    /**
     * Benutzername
     * @var String 
     */
    private $username;
    
    /**
     * Passwort
     * @var String 
     */
    private $password;
    
    
    /**
     * Datenbank-Connection aufbauen und dauerhaft in Session speichern
     */
    public function __construct(){
        // DB-Zugangsdaten einbinden
        require_once 'config/db.php';
        
        $this->setHostname($db['hostname']);
        $this->setDatabase($db['database']);
        $this->setUsername($db['username']);
        $this->setPassword($db['password']);

        // Verbindungsdaten in Session speichern
        $_SESSION['host'] = $this->getHostname();
        $_SESSION['db'] = $this->getDatabase();
        $_SESSION['user'] = $this->getUsername();
        $_SESSION['pwd'] = $this->getPassword();
    }
    
    
    // =========================================================================
    // ======================= Getter & Setter =================================
    // =========================================================================
    
    /**
     * Hostnamen setzen
     * @param String $host
     */
    public function setHostname($host){
        $this->hostname = $host;
    }
    
    
    /**
     * Datenbank setzen
     * @param String $db
     */
    public function setDatabase($db){
        $this->database = $db;
    }
    
    
    /**
     * Benutzernamen setzen
     * @param String $user
     */
    public function setUsername($user){
        $this->username = $user;
    }
    
    
    /**
     * Passwort setzen
     * @param String $pw
     */
    public function setPassword($pw){
        $this->password = $pw;
    }
    

    /**
     * Hostnamen zurückliefern
     * @return String
     */
    public function getHostname(){
        return $this->hostname;
    }
    
    
    /**
     * Datenbank zurückliefern
     * @return String
     */
    public function getDatabase(){
        return $this->database;
    }
    
    
    /**
     * Usernamen zurückliefern
     * @return String
     */
    public function getUsername(){
        return $this->username;
    }
    
    
    /**
     * Passwort zurückliefern
     * @return String
     */
    public function getPassword(){
        return $this->password;
    }
}

/* End of file database.php */
>>>>>>> origin/mensa
/* Location: ./system/database.php */