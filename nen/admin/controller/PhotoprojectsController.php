<?php
require_once SITE_PATH . 'model'. DIRSEP .'Photoprojects.php';
require_once SITE_PATH . 'form'. DIRSEP .'Photoprojects.php';

require_once SITE_PATH . 'model'. DIRSEP .'Projects.php';

Class Controller_PhotoProjects Extends AdminController_Base {

    protected $_controller 			=	'Photoprojects';
    protected $_activeTableClass 	=	'PhotoprojectsClass';
	protected $_form 				=	'PhotoprojectsForm';	
	protected $_sizeThmb			=	700;		
	
    /**
     * Initialization
     *
     * @return void
     */
	public function init() {	
		parent::init();
		$this->_projects = new ProjectsClass($this->registry);

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
			$limit = 50,
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
											'listProjects' => $this->_projects->listProjects($this->_lang),
											'action' => 'news',
										));	
	
		parent::news();
					
	}
	
	
	public function edit() {
		self::init();
	//	var_dump('******'.$this->_cid);		
		$this->registry['layout']->sets(array(
											'listProjects' => $this->_projects->listProjects($this->_lang),
											'action' => 'edit',
										));		
		parent::edit();	
	}
	

	public function ccopy() {
		self::init();		
		$this->registry['layout']->sets(array(
											'listProjects' => $this->_projects->listProjects($this->_lang),
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
