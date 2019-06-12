<?php session_start();
require_once SITE_PATH . 'model'. DIRSEP .'Admin.php';
require_once SITE_PATH . 'form'. DIRSEP .'Login.php';

Class Controller_Login {

    protected $_activeTableClass 	=	"AdminClass";
    protected $_form 				=	'LoginForm';			
    protected $_dbTable;	
	
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
			
		$this->_dbTable = new $this->_activeTableClass($this->registry);
		$this->_formValid = new $this->_form($this->registry);			
	}
	
    /**
     * Login administrator
     *
     * @return void
     */	
	public function index() {

		self::init();
		
		if ($_SERVER['REQUEST_METHOD'] != 'POST'){
		
			$_POST 	= $this->_dbTable->setPOST();	
			$this->registry['layout']->view('login');					
		} else {
			$data = $this->_dbTable->setToArray();
			$errors = $this->_formValid->isValid($data);	

			if (!$errors) {
				$record = $this->_dbTable->getAuth($data['login'], $data['password']);
				
				if (!$record) {
					$errors['login'] = array("Not Exists" => $this->translate->message('Not Exists'));
				}
			}
			
			if ($errors){
				$json = json_encode(array(
					'success' => false,
					'message' => $this->translate->message('Not true Login or Password')
				));
				echo $json;
				exit;
			}		
			
			unset($_SESSION['consultant']);
			$_SESSION['consultant']['id'] 		= $record->id;			
			$_SESSION['consultant']['title'] 	= $record->login;
			
			//var_dump($_SESSION['consultant']);
			$json = json_encode(array(
						'success' => true,
						'returnto'=> $this->registry['router']->url_admin($params = array(
											'controller' => 'index',
											'action' => 'index', 
														))
									)
								);
			echo $json;
			exit;
		}
	
	}
	
    /**
     * Logout
     *
     * @return void
     */	
	public function logout() {
		
	unset($_SESSION['consultant']);

		$url = $this->registry['router']->url_admin( $params = array('controller' => 'login', 'action' => 'index'));
		
		header('Location: ' . $url, true, '303');
		die();						
	}
}


?>