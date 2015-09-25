<?php
namespace Application\Libs;

class Route{
    public   $controller;
    public   $action;
    private  $controller_file_path;
    private  $controller_file_name;
    private  $controller_directory_path;
    private  $controller_prefix;
    private  $controller_default;
    private  $action_default;
    private  $controller_error;
    private  $route_template_name_default;
    private  $is_error = 0;
    private  $error_data;
    private  $controller_property;
    private  $route_template;
    private  $route_template_name;


    /**
     * start
     *
     * Starting this class
     */

    public function start($settings){
        $this->initSettings($settings);
        $this->initRouteTemplate();
        $this->parseUrl();
    }


    /**
     * initRouteTemplate
     *
     * Initialization template for routing. Get controller and action params number in current URI
     */

    private function initRouteTemplate(){
        $this->route_template->default ? : $this->setError('not_init_route_template', __FILE__, __LINE__);

        foreach($this->route_template as $key=>$val){
           (strpos($_SERVER['REQUEST_URI'], $val->url_template) && $key != $this->route_template_name_default) ? $this->route_template_name = $key : false;
        }

        $this->route_template_name ? : $this->route_template_name = $this->route_template_name_default;
    }

    /**
     * parseRequestData
     *
     * Parsing $_SERVER['REQUEST_URI'], find and extract controller/action name
     */

    private function parseUrl(){
        if (strlen($_SERVER['REQUEST_URI']) > 1) {
            $url_parsed = preg_split('/\//', $_SERVER['REQUEST_URI'], 3, PREG_SPLIT_NO_EMPTY);

            $this->setController($url_parsed[$this->route_template->{$this->route_template_name}->controller_param_position]);
            $this->setAction($url_parsed[$this->route_template->{$this->route_template_name}->action_param_position]);
        }
        else{
            $this->setController();
            $this->setAction();
        }
    }


    /**
     * setController
     *
     * This method initialize controller.
     * Taken correctly and formating controller name.
     * Check controller file on exist.
     *
     * @param string $controller
     */

    private function setController($controller = ''){
        $this->controller           = $controller ? $this->getFormatedNameController($controller) : $this->getFormatedNameController($this->controller_default);
        $this->controller_file_name = $this->controller . $this->controller_prefix . '.php';
        $this->controller_file_path = $this->controller_directory_path.$this->controller_file_name;

        file_exists($this->controller_file_path) ? : $this->setError('not_found_controller_file', __FILE__, __LINE__);
    }


    /**
     * setAction
     *
     * Check on exist and set action
     *
     * @param $action
     */

    private function setAction($action = ''){
        $this->action = $action ? $action : $this->action_default;
    }


    /**
     * getFormatedNameController
     *
     * Format input controller
     *
     * @param $controller
     * @return mixed|string
     */

    private function getFormatedNameController($controller){
        $controller = preg_replace("/[^0-9a-zA-Zа-яА-Я]/", " ", $controller);
        $controller = mb_convert_case($controller, 2, "UTF8");
        $controller = preg_replace("/[^0-9a-zA-Zа-яА-Я]/", "", $controller);

        return $controller;
    }


    /**
     * initSettings
     *
     * Check all inbox settings, checking controller files and directories.
     * If found error, call the setError method.
     *
     * @param array $settings - settings array initialized in global settings file (/application/settings/settings.php)
     */

    private function initSettings($settings){
        /** Checking in inner settings array all params on exist **/
        if ($settings) {
            foreach ($settings as $key => $val) {
                $val ? : $this->setError('not_init_settings', __FILE__, __LINE__);
            }
        }

        /** Checking default and error controller files on exist **/
        $need_check_files   = array(
            $settings['controller_directory_path'] . $settings['controller_default'] . $settings['controller_prefix'] .".php",
            $settings['controller_directory_path'] . $settings['controller_error'] . $settings['controller_prefix'] .".php",
            $settings['controller_property_file_path'],
            $settings['route_template_file_path']
        );

        foreach ($need_check_files as $key => $val){
            file_exists($val) ? : $this->setError('not_init_settings', __FILE__, __LINE__);
        }

        $this->controller_property = json_decode(file_get_contents($settings['controller_property_file_path']));
        $this->route_template      = json_decode(file_get_contents($settings['route_template_file_path']));

        if (!$this->controller_property && !$this->route_template) {
            $this->setError('not_init_settings', __FILE__, __LINE__);
        }

        foreach($settings as $key => $val){
            $this->{$key} = $val;
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

    private function setError($error_type_name, $file, $line){
        $this->is_error = 1;
        $this->error_data['error_type'] = $error_type_name;
        $this->error_data['error_file'] = $file;
        $this->error_data['error_line'] = $line;

        $this->errorProcess();
    }


    private function unsetError(){
        $this->is_error = 0;
        $this->error_data = array();
    }


    /**
     * errorProcess
     *
     * Processing all errors and find the correct way to solve the problems
     */

    private function errorProcess(){
        if ($this->is_error) {
            # Происходит перебор возможных типов ошибок роутинга
            switch ($this->error_data['error_type']) {

                case 'not_init_settings': {
                    die("Fatal error: Route :: settings not init, ($this->error_data['error_file']) $this->error_data['error_line'])");
                    break;
                }

                case 'not_init_controller': {
                    die("Fatal error: Route :: controller not init, ($this->error_data['error_file']) $this->error_data['error_line'])");
                    break;
                }

                case 'not_init_route_template': {
                    die("Fatal error: Route :: default route template not init, ($this->error_data['error_file']) $this->error_data['error_line'])");
                    break;
                }

                case 'not_found_controller_file': {
                    $this->unsetError();

                    $this->setController($this->controller_error);
                    $this->setAction($this->action_default);
                    break;
                }

                # Если тип ошибки не определен, вызываем 404
                default: {
                    $this->unsetError();

                    $this->setController($this->controller_error);
                    $this->setAction($this->action_default);
                }
            }
        }
    }
}
