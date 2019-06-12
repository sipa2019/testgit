<?php

 /*Including Configuration File */
include("./config/config.php");

function __autoload($class_name)
{
    $filename = strtolower($class_name) . '.php';
    $file = SITE_PATH . 'classes' . DIRSEP . $filename;
    if (file_exists($file) == false) {
        return false;
    }
    include($file);
}

/*File with Global Variables */
$registry = new Registry;

/*
* connect to DataBase
*/
$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$registry->set('mysqli', $mysqli);


/*
* include Layout
*/
$layout = new Layout($registry);
$registry->set('layout', $layout);
//var_dump($registry['layout']);


/*
* include Router
*/
$router = new Router($registry);
$registry->set('router', $router);

$router->setPath(SITE_PATH . 'controller');

/* Start Router */
$router->delegate();



