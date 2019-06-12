<?php
Abstract Class AdminController_Base {
	
	const DATA_STACK_ERROR = "DATA_STACK_ERROR";
	const DATA_STACK_SUCCESS = "DATA_STACK_SUCCESS";	
	const DATA_STACK_ERROR_RELATION = "DATA_STACK_RELATION";	
	
	protected $registry;
    protected $_dbTable;	
	protected $_formValid;
	
    protected $_controller = null;
    protected $_activeTableClass = null;
    protected $_content = VIEW_PATH;	
    protected $_form = null;		
    protected $_image = null;	
	protected $_sizeThmb = null;	
	
	protected $_cid;
	protected $_sort;
	protected $_by;
	protected $_list;
	
	function __construct($registry) {

		$this->registry = $registry;
		$this->translate = $this->registry['translator'];
		$this->registry['layout']->set('translate', $this->translate);	// for partials
	}
	
    /**
     * Initialization
     *
     * @return void
     */	
	public function init() {
	
		$this->_cid	= (isset($_GET['cid']) && $_GET['cid']) ? $_GET['cid'] :'';
		$this->_lang	= (isset($_GET['lang']) && $_GET['lang']) ? $_GET['lang'] :LOCALE;		
		$this->_sort	= ($_GET['sort'] && $_GET['sort'])?$_GET['sort']:null;
		$this->_by	= ($_GET['by'] && $_GET['by'])?$_GET['by']:null;		
		$this->_list	= ($_GET['list'] && $_GET['list'])?$_GET['list']:1;
		$this->parent_id	= ($_GET['parent_id'] && $_GET['parent_id'])?$_GET['parent_id']:"";
		$this->model	= ($_GET['model'] && $_GET['model'])?$_GET['model']:"";	

		$this->_paginatorParams = array(
			'sort' => $this->_sort,
			'by' => $this->_by,
			'list' => $this->_list			
		);		
		$this->_parent = array_merge( array(
			'parent_id' => $this->parent_id,
			'model' => $this->model),
			$this->_paginatorParams		
		);			
//var_dump('$this->_activeTableClass****'.$this->_activeTableClass);

		if ($this->_activeTableClass) {
			$this->_dbTable = new $this->_activeTableClass($this->registry);
//var_dump($this->_dbTable);
//die;			
		}
		if ($this->_translateTableClass) {
			$this->_dbTableTrans = new $this->_translateTableClass($this->registry);
		}		
		if ($this->_form) {
			$this->_formValid = new $this->_form($this->registry);
					
		}
		if ($this->_formTranslate) {
			$this->_formValidTranslate = new $this->_formTranslate($this->registry);		
		}		
		
		$this->_content .= $this->_controller.DIRSEP;

		$this->registry['layout']->set('page', $this->_controller);	
		$this->registry['layout']->set('assort', $this->_paginatorParams);		
	}
	
	abstract function index();
	
	
    /**
     * Update record
     *
     * @return void
     */	
    public function edit ()
    {
		//var_dump('editbasecontroller');
		//die;
		$this->registry['layout']->set('titleMenu', $this->translate->translate('Edit record'));	
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){	

			$data = $this->_dbTable->setToArray();
			//var_dump($data);
			//die;
			$data['lang']=$this->_lang;
			
			
			$errors = ($this->_formValid) ? $this->_formValid->isValid($data) : "";	

			if (!$errors && isset($data['image'])) {
				$result = $this->registry['image']->uploadImage($this->_sizeThmb);
				
				if (!$result['success']) {
					$errors['image'] = array("File" => $result['message']);
				} else {
					$data['image'] = $result['image'];
					//if (isset($_POST['old_image']) && $_POST['old_image']) {
					//	$this->registry['image']->deleteImage($_POST['old_image']);
					//}
				}
			}			
			
			if ($errors){
				var_dump('error');
				echo json_encode(array(
					'success' => false,
					'message' => $this->translate->message('Correct error and try again'),
					'errors'  => $errors,				
				));
				exit;	
			}		

			$this->registry['notify']->gotoListing($this->translate->message(
				("DATA_STACK_SUCCESS"==$this->_dbTable->updateRecord($data))?
					"Record successfully updated":
					"Error writing:".$this->_activeTableClass
			));
			
			echo json_encode(array(
						'success' => true,
						'returnto'=> $this->registry['router']->
							url_admin($params = array(
								'controller' => $this->_controller,
								'action' => 'index',
								'parent_id' => $this->_parent['parent_id'],
								'model' => $this->_parent['model'],
								'assort' => $this->_paginatorParams,
								'lang'	=> $this->_lang							
							))
						)
			);
			exit;		
		}
		
		$view ='index.phtml';		
		if ($this->_cid) {
			$_POST 	= $this->_dbTable->setPOST($this->_cid);	
			$_POST['old_image'] = (isset($_POST['image']) && $_POST['image'])?$_POST['image']:'';
			if (isset($_POST['image']) && $_POST['image']) {
				$filename = IMAGE_PATH.THUBN.$_POST['image'];
				if (file_exists($filename)) {
					$_POST['image'] = THUBN.$_POST['image'];
				}
			}
			$view ='new.phtml';
		}
	
		$this->registry['layout']->set('content', $this->_content.$view);				
		$this->registry['layout']->view();			

	
	}
	
    /**
     * Update record
     *
     * @return void
     */	
    public function ccopy ()
    {
	
		$this->registry['layout']->set('titleMenu', $this->translate->translate('Edit record'));
			
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){	

			$data = $this->_dbTable->setToArray();
			$data['lang']=$this->_lang;
		

			$errors = ($this->_formValid) ? $this->_formValid->isValid($data) : "";	

			if (!$errors && isset($data['image'])) {
				$result = $this->registry['image']->uploadImage($this->_sizeThmb);
				
				if (!$result['success']) {
					$errors['image'] = array("File" => $result['message']);
				} else {
					$data['image'] = $result['image'];
					//if (isset($_POST['old_image']) && $_POST['old_image']) {
						//$this->registry['image']->deleteImage($_POST['old_image']);
					//}
				}
			}else{
				
				if (!$errors && isset($_POST['old_image'])) {
					$data['image']= $_POST['old_image'];
				}
			}
			
			if ($errors){
				echo json_encode(array(
					'success' => false,
					'message' => $this->translate->message('Correct error and try again'),
					'errors'  => $errors,				
				));
				exit;	
			}		

			$this->registry['notify']->gotoListing($this->translate->message(
				("DATA_STACK_SUCCESS"==$this->_dbTable->copyRecord($data))?
					"Record successfully updated":
					"Error writing:".$this->_activeTableClass
			));
			
			echo json_encode(array(
						'success' => true,
						'returnto'=> $this->registry['router']->
							url_admin($params = array(
								'controller' => $this->_controller,
								'action' => 'index',
								'parent_id' => $this->_parent['parent_id'],
								'model' => $this->_parent['model'],
								'assort' => $this->_paginatorParams,
									'lang'	=> $this->_lang							
							))
						)
			);
			exit;		
		}
		
		$view ='index.phtml';		
		if ($this->_cid) {
			
			$_POST 	= $this->_dbTable->setPOST($this->_cid);
				//var_dump($_POST);
			$_POST['old_image'] = (isset($_POST['image']) && $_POST['image'])?$_POST['image']:'';
			//var_dump($_POST['old_image']);
			if (isset($_POST['image']) && $_POST['image']) {
				$filename = REAL_IMAGE_PATH.THUBN.$_POST['image'];
				if (file_exists($filename)) {
					$_POST['image'] = THUBN.$_POST['image'];
				}
			}
			//$_POST['image']=$_POST['old_image'];

			$view ='new.phtml';
		}
	
		$this->registry['layout']->set('content', $this->_content.$view);				
		$this->registry['layout']->view();			

	
	}
	
 
	
	
	
	
    /**
     * Create a new record
     *
     * @return void
     */	
	public function news()
    {
		$this->registry['layout']->set('titleMenu', $this->translate->translate('New record'));	
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){	

			$data = $this->_dbTable->setToArray();
			$data['lang']=$this->_lang;
			
			$errors = ($this->_formValid) ? $this->_formValid->isValid($data) : "";	
			if (!$errors && isset($data['image'])) {
				$result = $this->registry['image']->uploadImage($this->_sizeThmb);
		
				if (!$result['success']) {
					$errors['image'] = array("File" => $result['message']);
				} else {
					$data['image'] = $result['image'];
				}
			}

			if ($errors){
				$json = json_encode(array(
					'success' => false,
					'message' =>  $this->translate->message('Correct error and try again'),
					'errors'  => $errors,				
				));
				echo $json;
				exit;
			}		
			
			unset($data['id']);
		
			$this->registry['notify']->gotoListing($this->translate->message(
				("DATA_STACK_SUCCESS"==$this->_dbTable->insertRecord($data))?
					"Record created successfully":
					"Error writing:".$this->_activeTableClass
			));
			
			echo json_encode(array(
						'success' => true,
						'returnto'=> $this->registry['router']->
							url_admin($params = array(
								'controller' => $this->_controller,
								'action' => 'index',
								'parent_id' => $this->_parent['parent_id'],
								'model' => $this->_parent['model'],								
								'assort' => $this->_paginatorParams,
								'lang'	=> $this->_lang
							))
						)
			);
			exit;			
		}
		
		$_POST 	= $this->_dbTable->setPOST();	
		$this->registry['layout']->set('content', $this->_content.'new.phtml');			
		$this->registry['layout']->view();			
	}

    /**
     * Translation record
     *
     * @return void
     */	
    public function translat ()
    {
		
		$this->registry['layout']->set('titleMenu', $this->translate->translate('Translate record')." - ".$this->_lang);	
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){	

			$data = $this->_dbTableTrans->setToArray();
			$errors = ($this->_formValidTranslate) ? $this->_formValidTranslate->isValid($data) : "";	
			if ($errors){
				echo json_encode(array(
					'success' => false,
					'message' => $this->translate->message('Correct error and try again'),
					'errors'  => $errors,				
				));
				exit;	
			}		
			
			$this->registry['notify']->gotoListing($this->translate->message(
				("DATA_STACK_SUCCESS"==$this->_dbTableTrans->saveRecord($data))?
					"Record successfully updated":
					"Error writing:".$this->_translateTableClass
			));
			
			echo json_encode(array(
						'success' => true,
						'returnto'=> $this->registry['router']->
							url_admin($params = array(
								'controller' => $this->_controller,
								'action' => 'index',
								'parent_id' => $this->_parent['parent_id'],
								'model' => $this->_parent['model'],								
								'assort' => $this->_paginatorParams,
							))
						)
			);
			exit;		
		}
		
		$_POST 	= $this->_dbTableTrans->setPOST($this->_cid, $this->_lang);	
	
		$this->registry['layout']->set('content', $this->_content.'translat.phtml');				
		$this->registry['layout']->view();			

	
	}
	
	public function measure() {
	
		$this->registry['layout']->set('titleMenu', $this->translate->translate('Measurment')." - ".$this->_lang);		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){	

			$data = $this->_dbTable->toMeasurementsProduct();

			$this->registry['notify']->gotoListing($this->translate->message(
				("DATA_STACK_SUCCESS"==$this->_dbTable->saveMeasurementsRecord($data))?
					"Record successfully updated":
					"Error writing:".$this->_activeTableClass
			));
			
			echo json_encode(array(
						'success' => true,
						'returnto'=> $this->registry['router']->
							url_admin($params = array(
								'controller' => $this->_controller,
								'action' => 'index',
								'assort' => $this->_paginatorParams,
							))
						)
			);
			exit;		
		}
	
	
		$_POST 	= $this->_dbTable->getMeasurementsProduct($this->_cid);	

		$this->registry['layout']->set('content', $this->_content.'measure.phtml');				
		$this->registry['layout']->view();
	}
	
    /**
     * Delete current record
     *
     * @return void
     */		
	public function delete() {	
		
		self::init();			
		if ($this->_cid) {
			$stack = $this->_dbTable->deleteRecord($this->_cid);	
			$this->registry['notify']->gotoListing(
				("DATA_STACK_SUCCESS"==$stack)?
				$this->translate->message('Record successfully deleted'):
				$this->translate->message('Error deleted:'.$stack)
			);				
		}
		
		$url = $this->registry['router']->
			url_admin($params = array(
				'controller' => $this->_controller,
				'action' => 'index',
				'parent_id' => $this->_parent['parent_id'],
				'model' => $this->_parent['model'],								
				'assort' => $this->_paginatorParams,
				'lang'	=> $this->_lang
		));

		header("HTTP/1.1 303 Moved Permanently");
		header('Location: ' . $url);	
		die(); 
    }

    /**
     * Edit field is_action up-down
     *
     * @return void
     */	
	public function show() {	

		self::init();			
		$currentStatus	= isset($_GET['current']) ? $_GET['current'] : 0;		
		if ($this->_cid) {
			$stack = $this->_dbTable->showRecord($this->_cid, $currentStatus);	
			$this->registry['notify']->gotoListing(
				("DATA_STACK_SUCCESS"==$stack)?
				$this->translate->message('Record successfully updated'):
				$this->translate->message('Error updated:'.$stack)
			);				
		}
		$url = $this->registry['router']->
			url_admin($params = array(
				'controller' => $this->_controller,
				'action' => 'index',
				'parent_id' => $this->_parent['parent_id'],
				'model' => $this->_parent['model'],								
				'assort' => $this->_paginatorParams,
				'lang'	=> $this->_lang
		));

		header("HTTP/1.1 303 Moved Permanently");
		header('Location: ' . $url);	
		die(); 
    }	

    /**
     * Edit field is_top up-down
     *
     * @return void
     */		
	public function top() {	
		
		self::init();			
		$currentStatus	= isset($_GET['current']) ? $_GET['current'] : 0;		
	
		if ($this->_cid) {
			$stack = $this->_dbTable->topRecord($this->_cid, $currentStatus);	
			$this->registry['notify']->gotoListing(
				("DATA_STACK_SUCCESS"==$stack)?
				$this->translate->message('Record successfully updated'):
				$this->translate->message('Error updated:'.$stack)
			);				
		}
		$url = $this->registry['router']->
			url_admin($params = array(
				'controller' => $this->_controller,
				'action' => 'index',
				'parent_id' => $this->_parent['parent_id'],
				'model' => $this->_parent['model'],								
				'assort' => $this->_paginatorParams,
		));
		header("HTTP/1.1 303 Moved Permanently");
		header('Location: ' . $url);	
		die(); 
    }	

/*
	* Update field active
	*
	* @param int Id
	* @param int current status
	* @param string nameDB
	*
	* @return  string result
	*/
    public function showPage () {
		
		self::init();
		$currentStatus	= isset($_GET['current']) ? $_GET['current'] : 'no';
		$is_active = ('no'==$currentStatus) ? 'yes' : 'no';

		if ($this->_cid) {
			$stack = $this->_dbTable->showPage($this->_cid, $currentStatus, $is_active);	
			$this->registry['notify']->gotoListing(
				("DATA_STACK_SUCCESS"==$stack)?
				$this->translate->message('Record successfully updated'):
				$this->translate->message('Error updated:'.$stack)
			);				
		}
		$url = $this->registry['router']->
			url_admin($params = array(
				'controller' => $this->_controller,
				'action' => 'index',
				'parent_id' => $this->_parent['parent_id'],
				'model' => $this->_parent['model'],								
				'assort' => $this->_paginatorParams,
				'lang'	=> $this->_lang
		));

		header("HTTP/1.1 303 Moved Permanently");
		header('Location: ' . $url);	
		die(); 
	
    }	

/*
	* Update record
	*
	* @param array data
	* @param string nameDB
	*
	* @return  string result
	*/	
    public function update ( $data, $nameDB = null ) {
		var_dump($this->_dbTable);
		$nameDB = (!$nameDB) ? $this->_dbTable : $nameDB;
		return $this->updateRow($data, $nameDB);	
    }	
	






}
?>