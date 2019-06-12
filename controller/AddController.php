<?php

require_once SITE_PATH . 'model'. DIRSEP .'Main.php';

/**
 * Class Controller_Add
 *
 * Controller for form /add
 * 2 method's :
 * 1) index for displaying page
 * 2) add for adding info to database from for
 *
 */
Class AddController  {

    protected $registry;


    function __construct($registry) {

        $this->registry = $registry;

    }
    public function index() {

        $this->registry['layout']->view('addProd');

    }

    public function add()
    {
        $_dbTable = new MainClass();
$arr=$_POST;
        /*$name = $_POST['name'];
        $price = $_POST['price'];
        $sku = $_POST['sku'];
        $weight = $_POST['weight'];
        $size = $_POST['size'];
        $type = $_POST['type'];
        $height = $_POST['height'];
        $width = $_POST['width'];
        $length = $_POST['length'];*/

        require_once "classes/abstract/CardFactory.php";

        $product = CardFactory::build($arr);
        $_dbTable->baseUpdate($product);
    }

    public function DeletePicturs() {


        if(isset($_POST['picturs'])) {

            $stack			=	true;
            $_dbTable		=	new MainClass();
            $arr			=	$_POST['picturs'];

            foreach ($arr as $value) {

                $stack	=	$_dbTable->deleteRecord($value);
            }

            $answer	=	true;

        }else{

            $answer	=	false;
            $stack	=	false;

        }
        $json = json_encode(array(
            'stack'				=>	$stack,
            'success' 			=>  $answer
        ));
        echo $json;
        exit;

    }

}