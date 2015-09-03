<?php
class Routing{
    private  $is_error = 0;
    private  $error_type = 0;
    public   $controller;
    public   $action;
    public   $include_path_controller;
    public   $settings;



    /**
     * __construct
     *
     * @param $settings - settings array initialized in global settings file (/engine/settings/settings.php)
     */

    function __construct($settings) {
        $this->initSettings($settings);
        $this->initController();
    }



    /**
     * initSettings
     *
     * Check all inbox settings, checking controller files and directories.
     * If found error, call the setError method.
     *
     * @param $settings - settings array initialized in global settings file (/engine/settings/settings.php)
     */

    private function initSettings($settings){
        $control_sum = 0;

        /** Checking in inner settings array all params on exist **/
        if ($settings) {
            foreach ($settings as $key => $val) {
                if (is_string($settings['path_directory_controller'])) {
                    $control_sum += 1;
                }
            }
        }

        /** Checking default controller files on exist **/
        if ($control_sum === count($settings)) {
            $default_controller_file_name = $settings['path_directory_controller'] . $settings['default_controller'] . ".php";
            $error_controller_file_name   = $settings['path_directory_controller'] . $settings['error_controller'] . ".php";

            if (!file_exists($error_controller_file_name) || !file_exists($default_controller_file_name)) {
                $control_sum -= 2;
            }
        }

        if ($control_sum === count($settings)) {
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
     * @param $error_type_name - error type name;
     */

    private function setError($error_type_name){
        if (!$error_type_name){
            $this->is_error   = 1;
            $this->error_type = "empty_error_type_name";
        }
        else{
            $this->is_error   = 1;
            $this->error_type = $error_type_name;
        }

        $this->errorProcess();
    }



    /**
     * parseRequestData
     *
     * Parsing $_GET['url'], find and extract controller/action name
     * If $_GET['url'] empty setting default controller
     */

    private function initController(){
        if ($this->is_error === 0) {
            if (strlen($_SERVER['REQUEST_URI']) > 1) {
                list($this->controller, $this->action, $tmp) = preg_split("/\//", $_SERVER['REQUEST_URI'], 3, PREG_SPLIT_NO_EMPTY);
            }
            else {
                $this->controller = $this->settings['default_controller'];
            }

            $this->checkController();
        }
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

                # Если не пришли настройки для текущего класса, вызываем 404
                case 'not_init_settings':
                case 'empty_error_type_name':{
                    die("Fatal engine error: Problems whith routing.");
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



    /**
     * checkController
     *
     * Checking current controller param and script on exist
     */

    private function checkController(){
        if (!file_exists($this->settings['path_directory_controller'] . $this->controller . ".php") || !$this->controller){
            $this->setError("not_found_controller_file");
        }
    }
}
