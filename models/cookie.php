<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

/**
 * Cookieverarbeitung
 */
class Cookie{

	/**
	 * Name of the cookie
	 * @var String
	 */
	private $name;

	/**
	 * Value of the cookie
	 * @var String
	 */
	private $value;

	/**
	 * Expiration-Time in seconds
	 * @var int
	 */
	private $duration;



	/**
	 * Constructor
	 */
	public function __construct($name, $value, $duration = 604800){
		$this->checkForCookie($name, $value, $duration);
	}


	/**
	 * Check if cookie already exists
	 */
	public function checkForCookie($name, $value, $duration){
		if(!isset($_COOKIE[''.$name.''])){
			setcookie($name, $value, time()+$duration);
		} else{
			$this->setName($name);
			$this->setValue($value);
			$this->setDuration($duration);
		}
	}


	/**
	 * Deletes a Cookie
	 * @param String
	 */
	public function deleteCookie($name){
		setcookie($name, "", time()-$this->duration);
	}



	// =============================================================
	// ==================== Getter & Setter ========================
	// =============================================================

	/**
	 * Sets the cookie name
	 * @param String
	 */
	public  function setName($name){
		$this->name = $name;
	}


	/**
	 * Sets a new Cookie
	 * @param String
	 */
	public  function setvalue($value){
		$this->value = $value;
	}


	/**
	 * Sets a new Cookie
	 * @param String
	 */
	public  function setDuration($duration){
		$this->duration = $duration;
	}


	/**
	 * Returns the name of the cookie
	 * @return String
	 */
	public function getName(){
		return $this->name;
	}


	/**
	 * Returns the value of the cookie
	 * @return String
	 */
	public function getValue(){
		return $this->value;
	}


	/**
	 * Returns the expiration time of the cookie
	 * @return String
	 */
	public function getDuration(){
		return $this->duration;
	}
}


/* End of file cookie.php */
/* Location: ./models/cookie.php */