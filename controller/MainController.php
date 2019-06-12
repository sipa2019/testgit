<?php

require_once SITE_PATH . 'model'. DIRSEP .'Main.php';

/**
 * Class Controller_Main
 *
 *  Controller for index page with cards .
 */


Class MainController  {

    protected $registry;


    function __construct($registry) {
        $this->registry = $registry;
    }

    // -- Start index page
    public function index() {

        $_dbTable		=	new MainClass();
        $records		=	$_dbTable->showPage();

        $this->registry['layout']->sets(array(
            'records' => $records,
        ));



        $this->registry['layout']->view('main');

    }













}