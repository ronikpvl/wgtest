<?php
/**
 * Created by PhpStorm.
 * User: info_000
 * Date: 06.09.2015
 * Time: 11:27
 */

class Controller{
    private $is_setting_error = 0;
    private $is_routing_error = 0;
    private $settings;
    private $is_error = 0;
    private $error_type;
    public  $controller;
    public  $action;
    public  $property;

    function __construct($routing, $settings){
        $this->initSettings($settings);
        $this->initRouting($routing);

        $this->initControllerProperty();

        echo "<pre>";
        print_r($this);
    }

    function initControllerProperty(){
        $property_file  = file_get_contents($this->settings['controller_property_file_path']);
        $this->property = json_decode($property_file);
    }

    function initRouting($routing){
        if ($routing){
            if (!$routing->controller){
                $this->controller = $this->settings['controller_default'];
            }
            else{
                $this->controller = $routing->controller;
            }

            if (!$routing->action){
                $this->action = $this->settings['action_default'];
            }
            else{
                $this->action = $routing->action;
            }

            $controller_path = $this->settings['controller_directory_path'] . $this->controller . ".php";

            if (!file_exists($controller_path)) {
                $this->is_routing_error = 1;
            }
        }
        else{
            $this->is_routing_error = 1;
        }

        if ($this->is_routing_error == 1){
            $this->setError("not_init_routing");
        }
    }



    /**
     * initSettings
     *
     * Check all inbox settings, checking controller files and directories.
     * If found error, call the setError method.
     *
     * @param array $settings - settings array initialized in global settings file (/engine/settings/settings.php)
     */

    private function initSettings($settings){
        /** Checking in inner settings array all params on exist **/
        if ($settings) {
            foreach ($settings as $key => $val) {
                if (!$val) {
                    $this->is_setting_error = 1;
                }
            }
        }
        else{
            $this->is_setting_error = 1;
        }

        /** Checking default and error controller files on exist **/
        if ($this->is_setting_error == 0) {
            $controller_default_file_name  = $settings['controller_directory_path'] . $settings['controller_default'] . ".php";
            $controller_error_file_name    = $settings['controller_directory_path'] . $settings['controller_error'] . ".php";
            $controller_property_file_name = $settings['controller_property_file_path'];

            if (!file_exists($controller_default_file_name)) {
                $this->is_setting_error = 1;
            }

            if (!file_exists($controller_error_file_name)) {
                $this->is_setting_error = 1;
            }

            if (!file_exists($controller_property_file_name)) {
                $this->is_setting_error = 1;
            }
       }

        if ($this->is_setting_error == 0) {
            $this->settings = $settings;
        }
        else{
            $this->setError('not_init_settings');
        }
    }



    /**
     * setError
     *
     * Setting the error flag and error type name.
     * If inbox value is empty, call exit(), stop the script.
     *
     * @param string $error_type_name - error type name;
     */

    private function setError($error_type_name){
        $this->is_error   = 1;
        $this->error_type = $error_type_name;

        $this->errorProcess();
    }



    /**
     * errorProcess
     *
     * Processing all errors and find the correct way to solve the problems
     */

    private function errorProcess(){
        if ($this->is_error) {
            # Происходит перебор возможных типов ошибок роутинга
            switch ($this->error_type) {

                case 'not_init_settings': {
                    die("Fatal error: Controller settings not init");
                    break;
                }

                case 'not_init_routing': {
                    die("Fatal error: Controller routing not init");
                    break;
                }

                case 'not_found_controller_file': {
                    $this->controller = $this->settings['error_controller'];
                    $this->action     = "";
                    break;
                }

                # Если тип ошибки не определен, вызываем 404
                default: {
                    $this->controller = $this->settings['error_controller'];
                    $this->action     = "";
                }
            }
        }
    }
}