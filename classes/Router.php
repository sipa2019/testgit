<?php
Class Router {

    private $registry;
    private $path;
    private $args = array();


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
     * param  $path
     *
     */
    function setPath($path) {
        /*-------------// for local project  /---------------------*/
        $path = trim($path, '/\\');
        /*----------------------------------*/
      $path .= DIRSEP;
       //  var_dump($path);
       // die;
        if (is_dir($path) == false) {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        $this->path = $path;
    }

    /**
     * Set Controller / Action
     *
     * action = Controllers method
     * Start controller's action
     */
    public function delegate() {

        $controller	= 'main'; // Default controller
       $action 	= 'index'; // Default action


        $route = explode("/", $_SERVER['REQUEST_URI']);


        // Define Controller
        if($route[1] != '') {
            $controller = ucfirst($route[1]);


        }
        if (isset($route[2]) && $route[2] != ''){
            $action = $route[2];
        }


        /**
         *  For Bigger project should use this , instead of previous . Almost done, only right action should define for start
         */

  /*
  $route = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) );

        $i =  count($route)-1;

        while ($i>0) {

            if ($route[$i] != ''){
                if(is_file($this->path. ucfirst($route[$i]). "Controller.php") || !empty($_GET)) {
                    $controller = ucfirst($route[$i]);
                    $modelName = ucfirst($route[$i]);
                    echo  $controller;
                    echo $modelName;
                    break;
                } else {
                    $action = $route[$i];
                }
            }
            $i--;
        }
    */




        $file = $this->path . ucfirst($controller) . "Controller" . '.php'; // Set name of Controller for including

        include ($file);



        // Creating controller bean
        $class =  $controller . 'Controller';
        $controller = new $class($this->registry);

        // Start controller's action
        $controller->$action();
    }

}

?>