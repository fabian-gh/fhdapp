<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

class MensaController{

	/**
	 * Cookieobject
	 * @var Object
	 */
	private $Cookie



	/**
	 * Constructor
	 * @param String $name
	 * @param String $value
	 * @param int $duration
	 */
	public function __construct($name, $value, $duration){
		require_once '../models/cooke.php';
		$this->Cookie = new Cookie($name, $value, $duration);
	}


	/**
	 * Returns cookiename
	 */
	public function getCookieName(){
		$this->Cookie->getName();
	}


	/**
	 * Returns cookievalue
	 */
	public function getCookieValue(){
		$this->Cookie->getValue();
	}


	/**
	 * Returns cookieduration
	 */
	public function getCookieDuration(){
		$this->Cookie->getDuration();
	}

	/**
	 * Deletes the cookie
	 * @param String $name
	 */
	public function deleteCookie($name){
		$this->Cookie->deleteCookie($name);
	}
}

 
/* End of file mensaController.php */
/* Location: ./controllers/mensaController.php */