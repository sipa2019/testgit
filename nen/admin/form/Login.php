<?php 
class LoginForm Extends Validate {

	protected $data;
	protected $rules;

	public function isValid($data, $rules=array()) {
	
		$data['login']	= htmlspecialchars(stripslashes($data['login'])); 
		$data['password']= htmlspecialchars(stripslashes($data['password'])); 
		$rules = array(
			'login' => array('Required'),
			'password' => array('Required')		
		);
		return parent::isValid($data, $rules);
	}
}	
?>