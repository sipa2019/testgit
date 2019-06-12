<?php 
class PhotoProjectsForm Extends Validate {

    protected $data;	
    protected $_formData;		
    protected $_image;				



     public function isValid($data, $rules=array()) {	

		$rules = array(
			'image' => array('Image')	
		);
	
		return parent::isValid($data, $rules);
	}
}	
?>