<?php
class Routing{
    public   $controller = "";
    public   $action     = "";



    /**
     * __construct
     *
     * @param array $settings - settings array initialized in global settings file (/engine/settings/settings.php)
     */

    function __construct($settings) {
        $this->initController();
    }



    /**
     * parseRequestData
     *
     * Parsing $_GET['url'], find and extract controller/action name
     */

    private function initController(){
        if (strlen($_SERVER['REQUEST_URI']) > 1) {
            list($this->controller, $this->action, ) = preg_split("/\//", $_SERVER['REQUEST_URI'], 3, PREG_SPLIT_NO_EMPTY);
        }
    }
}
