<?php session_start();

ini_set('display_errors','On'); 
error_reporting(E_ALL);
Error_Reporting(E_ALL & ~E_NOTICE);

include ("./config/config.php");

require_once SITE_PATH . 'model'. DIRSEP .'Galleries.php';


function __autoload($class_name) {

	$filename = strtolower($class_name) . '.php';
	$file = SITE_PATH . 'classes' . DIRSEP . $filename;
	if (file_exists($file) == false) {
		return false;
	}
	include ($file);
}

//unset($_SESSION['consultant']);

$lang	=	isset($_GET['lang']) && $_GET['lang'] ? $_GET['lang'] :'ru';
define (LOCALE, $lang);

$registry = new Registry;

/*
* connect to dBase
*/
$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$registry->set('mysqli', $mysqli); 

/*
* include Layout
*/
$layout = new Layout($registry);
$registry->set('layout', $layout);
/*
* include Translator
*/
$translator = new Translator($registry, $lang);
$registry->set('translator', $translator);
/*
* include Router
*/
$router = new Router($registry);
$registry->set('router', $router);
/*
* include Notify
*/
$notify = new NotifyNote($registry);
$registry->set('notify', $notify);
/*
* include Image
*/
$image = new Image($registry);
$registry->set('image', $image);
/*
* include Helper
*/
$helper = new Helper($registry);
$registry->set('helper', $helper);
/*
* include Sessvar
*/
$sessvar = new Sessvar($registry, $locales);
$registry->set('sessvar', $sessvar);
$sessvar->setCurrentLocale();
//var_dump('admin/index.php='.SITE_PATH);	


$menuGallery = new GalleriesClass($registry);
$registry->set('menuGallery', $menuGallery);

$router->setPath(SITE_PATH . 'controller');
$router->delegate();
//}


?>