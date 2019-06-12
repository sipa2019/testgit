<?php
	/*
	* localhost 
	*/
define ('BASEURL', 'http://oriecon.com/admin/');

define ('DIRSEP', DIRECTORY_SEPARATOR);

$site_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP)  . DIRSEP;
define ('SITE_PATH', $site_path);
//var_dump('config.php'.SITE_PATH);
$view_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP. 'view' . DIRSEP;
define ('VIEW_PATH', $view_path);

$image_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP. 'assets' . DIRSEP. 'imagesuser'.DIRSEP;
define ('IMAGE_PATH', $image_path);

$real_image_path = '../admin/assets/imagesuser/';
define ('REAL_IMAGE_PATH', $real_image_path);


define (DBHOST, 'localhost');
define (DBUSER, 'oriconco_oleg');
define (DBPASS, '2018oleg2019');
define (DBNAME, 'oriconco_orieco');

//define (LOCALE, 'ru');
$locales = array('ru' => 'RU', 'en' => 'EN');

define (PREFIX, ''); 
define (THUBN, 'th_'); 

?>