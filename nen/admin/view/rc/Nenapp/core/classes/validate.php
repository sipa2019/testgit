<?php 
Abstract Class Validate {

    protected $_messages = array();
    protected $_errors = array();	
	protected $registry;
    protected $_image;	
    protected $_translate;	

	
	/**
	* Get the validation result
	*
	* @return array
	*/
	public function isValid($data, $attribute) {		

		if (!$attribute) {
			return array();
		}

		foreach ($attribute as $field => $rules) {
			if (array_key_exists($field, $data)) {
		
				foreach ($rules as $rule){
					$method = "validate".$rule;
					if(method_exists($this, $method)) {
						$this->_errors = $this->$method($field, $data); 
					}
				}
			}
		}
		
		return $this->_errors;
	}
	
    /**
     * Validate Required
     *
     * @return result
     */	
    protected function validateRequired($field,$data)
    {
		$result = $this->checkRequired(isset($data[$field])?$data[$field]:null);
		if (!$result) {
			$this->_errors[$field] = array("Not Empty" => $this->translate->translate('Not Empty'));	
		}
		
		return $this->_errors;
    }	
	
    /**
     * Validate Image
     *
     * @return result
     */	
    protected function validateImage($field,$data)	
	{
		if (isset($data['image'])){
			$result = $this->_image->isValid();
			if (!$result['success']) {
				$this->_errors[$field] = array("File" => $result['message']);					
			}
		}
		return $this->_errors;		
	}
	
    /**
     * Check Required 
     *
     * @return result
     */		
    protected function checkRequired($value)
    {
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && empty($value)) {
            return false;
        } elseif (is_array($value) && count($value) < 1) {
            return false;
        }		
        return true;
    }
	
	
		
	/**
	 * 
	 * Проверка поля на целое цисло
	 * @param string
	 */
	function validateInteger($field,$data){

		$result	=	 filter_var($data['phone'],  FILTER_SANITIZE_NUMBER_INT);
		if (!$result) {
			$this->_errors[$field] = array("Phone" => $this->translate->message('Please enter your phone'));	
		}
		
		return $this->_errors;
	}
	
	
	/**
	 * 
	 * Проверка поля на цисло c плавающей точкой
	 * @param string
	 */
	function validatefloat($field,$data){
		
		
		return filter_var($data['cislo'], FILTER_VALIDATE_FLOAT);
	}
	
	
	/**
	 * Валидация URL
	 * @param string
	 */
	function validateurl($field,$data){

		return filter_var($data['url'], FILTER_VALIDATE_URL);
	}
	
	
	/**
	 * 
	 * Валидация email-адреса
	 * @param string
	 */
	function validateEmail($field,$data){
		
		$result	=	filter_var($data['email'], FILTER_VALIDATE_EMAIL);
		
		if (!$result) {
			$this->_errors[$field] = array("Email" => 'Please enter your email');	
		}
		
		return $this->_errors;
		
	}
	
	
	/**
	 * 
	 * Валидация IP-адреса
	 * @param string
	 */
	function validateIp($field,$data){
		
		
		return filter_var($data['ip'], FILTER_VALIDATE_IP);
	}
	
	
	
	
	/**
	 * Только буквы латинского алфавита
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */		
	function validateAlpha($field,$data)
	{
		return ( ! preg_match("/^([a-z])+$/i", $data['slovo'])) ? FALSE : TRUE;
	}
	
	
	
	/**
	 * Проверка капчи
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */	
	function validateCaptcha($field,$data,$name){
		
		return (!empty($_SESSION[$name]) && $_SESSION[$name] == $data['captcha'])? TRUE: FALSE;
	}
	
	
	/**
	 * Проверка даты
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	function validateDate($field,$data){
		
		$stamp = strtotime( $data['data'] );

		if (!is_numeric($stamp)){
			
			return FALSE;
		}
		
		$month = date( 'm', $stamp );
		$day   = date( 'd', $stamp );
		$year  = date( 'Y', $stamp );
		
		return checkdate($month, $day, $year); 
	}
	
	function validateSpecsimbols($data){
		foreach ($data as $key => $value) {
			$data[$key]	= htmlspecialchars(stripslashes($data[$key])); 
			
		}
	return $data;	
	}
	
	function validateFilter($arr){
		foreach ($arr as $key => $value) {
   						$data[$key]=filter_var($value, FILTER_SANITIZE_STRING);
				}	
	return $data;	
	}
	
	function validateIsIdentical($arr){
		
		$arr['password'] === $arr['password-confirmation'] ? $data	=	true : $data	=	false;
		
		if (!$data) {
			$this->_errors['password-confirmation'] = array("password-confirmation" => $this->translate->message('Please enter Identical Password'));	
		}
		
	return $this->_errors;	
	}
}
?>