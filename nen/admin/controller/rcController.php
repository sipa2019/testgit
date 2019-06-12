<?php
require_once SITE_PATH . 'model'. DIRSEP .'rc.php';


Class Controller_rc Extends AdminController_Base {

    protected $_controller 			=	'rc';
    protected $_activeTableClass	=	"RcClass";
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
//var_dump('11111111');
//die;		
//var_dump($this->_content.'<br>');
		$result =  $this->_dbTable->paginatorCat(
			$this->_paginatorParams,			
			$offset = $this->_list,
			$limit = 20,
			$this->_lang
		);
//var_dump( $result['records']);
//die;
//var_dump('******'.$this->_content.'index.phtml');
		$this->registry['layout']->sets(array(
			'titleMenu' => $this->translate->translate('Poddomeni'),
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
//var_dump('editcontroller111');
//die;
		self::init();		
		$this->registry['layout']->sets(array(
			'action' => 'edit',
		));		
		self::editSection('main');
		self::editSection('aboutUs');
			
	}
	
	public function editSection($section) {
	$data = $this->_dbTable->setToArraySection($section);
			
			$data['lang']=$this->_lang;
			$data['section']=$section;
			//var_dump($data);
			//die;
			$this->_dbTable->updateRecord($data);
			//go
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
