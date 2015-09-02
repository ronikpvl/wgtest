<?php
class Routing{
    private  $is_error = 0;
    private  $error_type = 0;
    private  $current_url;
    public   $controller;
    public   $action;
    public   $include_path_controller;
    public   $settings;

    /*
     * __construct
     *
     * $settings (array) - settings array initialized in global settings file (/engine/settings/settings.php)
     */

    function __construct($settings) {
        $this->initSettings($settings);
        $this->parseRequestData();

        echo "<pre>";
        print_r($this);
    }


    /*
     * initSettings
     *
     * Check all inbox settings, checking controller files and directories.
     * If found error, call the setError method.
     *
     *
     * $settings (array) - settings array initialized in global settings file (/engine/settings/settings.php)
     */

    private function initSettings($settings){
        $this->current_url = $_GET['url'];

        $default_controller_file_name = $settings['path_directory_controller'] . $settings['default_controller'] .".php";
        $error_controller_file_name   = $settings['path_directory_controller'] . $settings['error_controller'] .".php";

        if ($settings['path_directory_controller'] && $settings['default_controller'] && file_exists($error_controller_file_name) && file_exists($default_controller_file_name)) {
            $this->settings = $settings;
        }
        else{
            $this->setError('not_init_settings');
        }
    }


    /*
     * setError
     *
     * Setting the error flag and error type name.
     * If inbox value is empty, call exit(), stop the script.
     *
     * $error_type_name (string) - error type name;
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


    /*
     * parseRequestData
     *
     * Parsing $_GET['url'], find and extract controller/action name
     * If $_GET['url'] empty setting default controller
     */

    private function parseRequestData(){
        if ($this->is_error == 0) {
            if ($this->current_url) {
                list($this->controller, $this->action) = explode("/", $_GET['url'], 2);
            }

            $this->initController();
        }
    }


    /*
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
                    break;
                }

                # Если тип ошибки не определен, вызываем 404
                default: {
                    $this->controller = $this->settings['error_controller'];
                }
            }
        }
    }


    /*
     *
     */

    private function initController(){
        if (!$this->current_url || !$this->controller){
            $this->controller = $this->settings['default_controller'];
        }

        if (!file_exists($this->settings['path_directory_controller'] . $this->controller . ".php")){
            $this->setError("not_found_controller_file");
        }
    }
}
