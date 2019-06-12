<?php
Class Layout {

    private $registry;
    private $vars = array();

    /**
     * Initialize Registry
     *
     * @param  $registry
     */
    function __construct($registry) {
        $this->registry = $registry;
    }



    /**
     * Set layout value attribute
     *
     * @param  $varname - name of attribute
     * @param  $value - value of attribute
     * @param  $overwrite - bool
     *
     * @return bool
     */
    function set($varname, $value, $overwrite=false) {

        if (isset($this->vars[$varname]) == true AND $overwrite == false) {
            trigger_error ('Unable to set var `' . $varname . '`. Already set, and overwrite not allowed.', E_USER_NOTICE);
            return false;
        }
        $this->vars[$varname] = $value;
        return true;
    }


    function sets($arr_varname, $overwrite=false) {

        if (!is_array($arr_varname) || count($arr_varname) <1) {
            trigger_error ('Data is not array.', E_USER_NOTICE);
            return false;
        }
        foreach ($arr_varname as $key => $value) {
            $this->set($key, $value, $overwrite=false);
        }

        return true;
    }


    /**
     * Remove layout value
     *
     * @param  $varname - name of attribute
     * @param  $overwrite - bool
     *
     * @return bool
     */
    function remove($varname) {

        unset($this->vars[$varname]);
        return true;
    }

    /**
     * Render layout with values
     *
     * @param  $name - name of layout
     *
     * @return void
     */
    function view($tamplate='main',$name='main') {

        $path = SITE_PATH . 'layout' . DIRSEP . $tamplate . '.phtml';

        if (file_exists($path) == false) {
            trigger_error ('Template `' . $name . '` does not exist.', E_USER_NOTICE);
            return false;
        }
        // Load variables
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }
        include_once ($path);
	}
}
?>