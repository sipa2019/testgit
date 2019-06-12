<?php
require_once SITE_PATH . 'model'. DIRSEP .'Services.php';
require_once SITE_PATH . 'form'. DIRSEP .'Services.php';

Class Controller_Services Extends AdminController_Base {

    protected $_controller 			=	'Services';
    protected $_activeTableClass 	=	"ServicesClass";
	protected $_form				=	'ServicesForm';	
	protected $_sizeThmb			=	700;		
	
    /**
     * Initialization
     *
     * @return void
     */
	public function init() {	
		parent::init();
	}

    /**
     * Render a index page.
     *
     * @return Response
     */
	public function index() {

		self::init();

		$result =  $this->_dbTable->paginatorCat(
			$this->_paginatorParams,			
			$offset = $this->_list, 
			$limit = 20,
			$this->_lang
		);

		$this->registry['layout']->sets(array(
			'titleMenu' => $this->translate->translate('Pages'),
			'content' => $this->_content.'index.phtml',
			'records' => $result['records'],
			'paginator' => $result['paginator'],
		));	
		$this->registry['layout']->view();	
	}

    /**
     * Render a page by create new record.
     *
     * @return Response
     */
	public function news() {
	
		self::init();
		$this->registry['layout']->sets(array(
			'action' => 'news',
		));	
	
		parent::news();
					
	}
	
	
	public function edit() {
		self::init();		
		$this->registry['layout']->sets(array(
			'action' => 'edit',
		));		
		parent::edit();	
	}
	

public function ccopy() {
		self::init();		
		$this->registry['layout']->sets(array(
			'action' => 'ccopy',
		));		
		parent::ccopy();	
	}



	public function delete() {
		parent::delete();	
	}	

	public function show() {
		parent::show();	
	}	

	public function top() {
		parent::top();	
	}	
}


?>
