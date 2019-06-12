<?php 
Abstract Class Validate {

    protected $_messages = array();
    protected $_errors = array();	
	protected $registry;
    protected $_image;	
    protected $_translate;	

	function __construct($registry) {
	
		$this->registry = $registry;
		$this->translate = $this->registry['translator'];		
		$this->_image = $this->registry['image'];
	}		

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
}
?>