<?php
require_once SITE_PATH . 'model'. DIRSEP .'Pages.php';
require_once SITE_PATH . 'form'. DIRSEP .'Pages.php';

Class Controller_Pages Extends AdminController_Base {

    protected $_controller 			=	'pages';
    protected $_activeTableClass	=	"PagesClass";
	protected $_form				=	'PagesForm';	
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
//var_dump($_activeTableClass);		
//var_dump($this->_content.'<br>');
		$result =  $this->_dbTable->paginatorCat(
			$this->_paginatorParams,			
			$offset = $this->_list,
			$limit = 20,
			$this->_lang
		);
//var_dump( $result['records']);
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
