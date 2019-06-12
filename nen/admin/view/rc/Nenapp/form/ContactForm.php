<?php

require_once '../core/classes/validate.php';

Class ContactForm Extends Validate {

	public function isValid($data, $rules=array()) {	

		/*foreach ($data as $key => $value) {
			$data[$key]	= htmlspecialchars(stripslashes($data[$key])); 
			
		}*/
		$result = $this->validateSpecsimbols($data);

		$rules = array(
			'name' 		=> array('Required'),
			'email'		=> array('Email'),
			'message'	=> array('Required'),
		);
	
		return parent::isValid($data, $rules);
	}	
}


?>

