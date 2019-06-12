<?php
require_once SITE_PATH . 'model'. DIRSEP .'Photogallery.php';
require_once SITE_PATH . 'form'. DIRSEP .'Photogallery.php';



Class Controller_PhotoGallery Extends AdminController_Base {

    protected $_controller 			=	'Photogallery';
    protected $_activeTableClass 	=	'PhotogalleryClass';
	protected $_form 				=	'PhotogalleryForm';	
	protected $_sizeThmb			=	700;
	private $_titles			=	'';		
	
    /**
     * Initialization
     *
     * @return void
     */
	public function init() {	
		parent::init();
	//	var_dump($this->_dbTable);
	//	$this->_projects = new PhotogalleryClass($this->registry);

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

	//	$rec=$result['records'];
	//	foreach($rec as $key => $value){
	//			var_dump($rec[$key]->title);
	//	}

		$this->_titles	=	$result['records'][0]->title;
	//	$parent_id		=	$result['records'][0]->projects_id;

		$this->registry['layout']->sets(array(
			'titleMenu' =>$this->_titles ,
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
