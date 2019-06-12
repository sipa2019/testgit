<?php 
class GalleriesForm Extends Validate {

    protected $data;	
    protected $_formData;		
    protected $_image;				



     public function isValid($data, $rules=array()) {	

		$rules = array(
			'title' => array('Required'),
			'image' => array('Image')	
		);
	
		return parent::isValid($data, $rules);
	}
}	
?>