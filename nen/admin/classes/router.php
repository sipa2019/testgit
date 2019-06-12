<?php
Class Router {

	private $registry;
	private $path;
	private $args = array();
	const _controller404 = "404";
	const _action404 = "index";		
	const _prefix = PREFIX;			
	
    /**
     * Initialize Registry
     *
     * @param  $registry
     */
	function __construct($registry) {
		$this->registry = $registry;
	}
	
    /**
     * Set path of Controller
     *
     * @param  $path
     *
     * @return setting path
     */
	function setPath($path) {
/*----------------------------------*/	
/* for out project */	
		//$path = DIRSEP.trim($path, '/\\');
		
/* for local project  */		
		$path = trim($path, '/\\');
/*----------------------------------*/

		
		$path .= DIRSEP;
		if (is_dir($path) == false) {
			throw new Exception ('Invalid controller path: `' . $path . '`');
		}

		$this->path = $path;
	}
	
    /**
     * Set Controller /Action
     *
     * @param
     *
     * @return void
     */
	public function delegate() {
				
		$result = $this->getController();

		$controller	= $result['controller'];
		$action 	= $result['action'];
			
//var_dump('controller='.$result['controller']);
//var_dump('action='.$result['action']);	
				
				
		$args 	= (isset($result['args']) && $result['args']) ? $result['args'] : null;				

		$file = $this->path . self::_prefix . ucfirst($controller) . "Controller" . '.php';

		// Файл доступен?			
        if (file_exists($file) == false) {
			$controller = self::_controller404;
			$action = self::_action404;
			$file = $this->path . self::_prefix . ucfirst(self::_controller404) . "Controller" . '.php';
			if (file_exists($file) == false) {		
				trigger_error ('Page `' . $file . '` does not exist.', E_USER_NOTICE);
				return false;
			}
		}
		include_once ($file);
		
		// Создаём экземпляр контроллера
		$class = 'Controller_' . self::_prefix . $controller;
		$controller = new $class($this->registry, $args);
		// Действие доступно?
		if (is_callable(array($controller, $action)) == false) {
			$controller = self::_controller404;
			$action = self::_action404;
			if (is_callable(array($controller, $action)) == false) {
				trigger_error ('Action `' . $controller . '/' .$action . '` does not exist.', E_USER_NOTICE);
				return false;
			}
		}
		// Выполняем действие
		$controller->$action($args);
	}
	
    /**
     * Get Controller && Action && request from url
     *
     * @param bool withCPU / withoutCPU
     *
     * @return void
     */	
	private function getController($withCPU = false) {
		

		if (!isset($_SESSION['consultant'])){
			//var_dump('2323232323'.$_SESSION['consultant']);
			return array(
				'controller' 	=> 'login',
				'action' 		=> 'index',				
			);
			
		}

			
		$data = $this->parseUrl();

		//if (1==count($data) && isset($_SESSION['consultant']['title']) ) { //!!!!!для Домена
		if (0==count($data) && isset($_SESSION['consultant']['title'])) {  //!!!!!!для LocalHost
 			return array(
				'controller' 	=> 'login',
				'action' 		=> 'logout',				
			);
		}
		
		
		if (0==count($data)) {
			//var_dump('89898989898'.$_SESSION['consultant']);
			return array(
				'controller' => 'index',
				'action' => 'index',				
			);
		}
		
		if ($withCPU == false) {
		
			return array(		
				'controller' => $data[1],
				'action' => isset($data[2]) ? $data[2] : 'index',
				'args' => isset($data['args']) ? $data['args'] : NULL,
			);
		}
		return false;
	}
	
    /**
	* Get arrayRequest from URI
	*
	* @param $_SERVER
	*
	* @return array
	*/
    private function parseUrl() {

		$partUrl = array();

		if ($_SERVER['REQUEST_URI'] != '/') {
			$url_path = parse_url($_SERVER['REQUEST_URI']);
			$partUrl = explode('/', trim($url_path['path'], ' /'));
			if (isset($url_path['query']) && $url_path['query']) {
				parse_str($url_path['query'], $partUrl['args']);
			}
		}

		return $partUrl;
	}
	
    /**
	* Get Url
	*
	* @param array
	*
	* @return string url
	*/
	function url_admin($params) {
//var_dump('BASEURL='.BASEURL);
		$control = (isset($params['controller']) && $params['controller']) ? $params['controller'] : 'index';
		$action = (isset($params['action']) && $params['action'])?$params['action']:'index';		
		$alink = BASEURL. $control. '/' .$action;
//var_dump('$alink='.$alink);		
		$sepurl = '/' ."?";
		if (isset($params['model']) && $params['model']) {
			$alink .= $sepurl.'model='.$params['model'];
			$sepurl = "&";
		}
		if (isset($params['cid']) && $params['cid']) {
			$alink .= $sepurl.'cid='.$params['cid'];
			$sepurl = "&";
		}
		if (isset($params['parent_id']) && $params['parent_id']) {
			$alink .= $sepurl.'parent_id='.$params['parent_id'];
			$sepurl = "&";
		}		
		if (isset($params['current'])) {
			$alink .= $sepurl.'current='.$params['current'];
			$sepurl = "&";
		}

		if ( (isset($params['assort']['list']) && $params['assort']['list']) ||
			(isset($params['list']) && $params['list']) ) {
				$list = $params['assort']['list']?$params['assort']['list']:$params['list'];
				$alink .= $sepurl.'list='.$list;
				$sepurl = "&";			
		}
		if (	(isset($params['assort']['sort']) && $params['assort']['sort']) || 
			(isset($params['sort']) && $params['sort']) ) {
				$sort = $params['assort']['sort']?$params['assort']['sort']:$params['sort'];			
				$alink .= $sepurl.'sort='.$sort;
				$sepurl = "&";			
		}		
		if (	(isset($params['assort']['by']) && $params['assort']['by']) || 
			(isset($params['by']) && $params['by']) ) {	
				$by = $params['assort']['by']?$params['assort']['by']:$params['by'];				
				$alink .= $sepurl.'by='.$by;
				$sepurl = "&";			
		}			
		if (isset($params['lang']) && $params['lang']) {
			$alink .= $sepurl.'lang='.$params['lang'];
			$sepurl = "&";			
		}		
		return $alink;	
	}	
}
?>