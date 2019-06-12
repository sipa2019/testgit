<?php
	/*
	* localhost 
	*/
define ('BASEURL', 'http://mvcorieco/admin/');

define ('DIRSEP', DIRECTORY_SEPARATOR);

$site_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP)  . DIRSEP;
define ('SITE_PATH', $site_path);

$view_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP. 'view' . DIRSEP;
define ('VIEW_PATH', $view_path);

$image_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP. 'assets' . DIRSEP. 'imagesuser'.DIRSEP;
define ('IMAGE_PATH', $image_path);

$real_image_path = '../admin/assets/imagesuser/';
define ('REAL_IMAGE_PATH', $real_image_path);


define (DBHOST, 'localhost');
define (DBUSER, 'root');
define (DBPASS, '');
define (DBNAME, 'orieco');

//define (LOCALE, 'ru');
$locales = array('ru' => 'RU', 'en' => 'EN');

define (PREFIX, ''); 
define (THUBN, 'th_'); 

?>