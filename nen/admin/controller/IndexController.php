<?php
Class Controller_Index Extends AdminController_Base   {

    protected $_controller = 'index';
	
    /**
     * Initialization
     *
     * @return void
     */	
	public function init() {	
		parent::init();
	}
	
    /**
     * undefined page
     *
     * @return void
     */		
	function index() {
var_dump($this->_content.'index.phtml');
		self::init();
		$this->registry['layout']->sets(array(
			'content' => $this->_content.'index.phtml'
		));				
		$this->registry['layout']->view('admin');	
			
	}
}


?>
