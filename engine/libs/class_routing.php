<?php
class Routing{
    private  $url_parse;
    private  $is_error = 0;
    private  $error_type = 0;
    public   $controller;
    public   $action;
    public   $include_path_controller;
    public   $settings;


    // Конструктор инициализирует все необходимые для работы
    function __construct($settings) {
        // Инициализация настроек,
        // В случае если настройки не найдены, ставим флаг ошибки, вызываем обработчик ошибок
        if ($settings){
            $this->settings = $settings;
        }
        else{
            $this->is_error = 1;
            $this->error_type = "not_found_settings";

            // Обработчик ошибок
            $this->errorProcess();
        }

        // Проводим роутинг согласно пришедшим данным
        $this->parseRequestData();
    }

    // Метод парсит входящий урл и поочередно вызывает дочерние методы для формирования обьекта с данными
    public function parseRequestData(){
        $this->url_parse = explode("/", $_GET['url']);

        $this->getController();
        $this->getAction();
    }

    // Получение контроллера
    private function getController(){
        if ($this->url_parse){
            $this->controller = $this->url_parse[0];

            $this->getPathController();
        }
    }

    // Получение экшона
    private function getAction(){
        if ($this->url_parse){
            $this->action = $this->url_parse[1];
        }
    }

    // Составляется полный путь до скрипта контроллера
    private function getPathController(){
        // Полный путь до контроллера для подключения
        $this->include_path_controller = $this->settings['path_controller']."/".$this->controller.".php";

        // Валидация составленного пути
        $this->validatePathController();
    }

    // Происходит валидация пути до скрипта контроллера
    private function validatePathController(){
        // Если запрашиваемый файл не найден, ставим флаг ошибки, вызываем обработчик ошибок
        if (!file_exists($_SERVER['DOCUMENT_ROOT'].$this->include_path_controller)){
            $this->is_error = 1;
            $this->error_type = "not_found_controller_file";

            $this->errorProcess();
        }
        // Если файл существут, ошибок нет, обнуляем флаг ошибки
        else{
            $this->is_error = 0;
            $this->error_type = "";
        }
    }

    // Метод обрабатывает ошибки роутинга
    private function errorProcess(){

        // Происходит перебор возможных типов ошибок роутинга
        switch ($this->error_type) {

            // Если не пришли настройки для текущего класса, вызываем 404
            case 'not_found_settings': {
                $this->controller = '404';
                $this->getPathController();
                break;
            }

            // Если контроллер не определен , вызываем 404
            case 'not_found_settings': {
                $this->controller = '404';
                $this->getPathController();
                break;
            }

            // Если контроллер не определен , вызываем 404
            case 'not_found_controller_file': {
                $this->controller = '404';
                $this->getPathController();
                break;
            }

            // Если тип ошибки не определен, вызываем 404
            default: {
                $this->controller = '404';
                $this->getPathController();
            }
        }

    }
}
