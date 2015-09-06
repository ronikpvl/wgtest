<?php
/**
 * Created by PhpStorm.
 * User: info_000
 * Date: 04.09.2015
 * Time: 1:17
 */

class Data{
    protected $get;
    protected $post;
    protected $url_params;

    function __construct(){
        $this->initGetData();
        $this->initPostData();
    }

    private function initGetData(){
        $this->parseUrlParams();

        if ($_GET){
            foreach($_GET as $key=>$val){
                $this->get[$key] = $this->clearData($val);
            }
        }
    }

    private function initPostData(){
        if ($_POST){
            foreach($_POST as $key=>$val){
                $this->post[$key] = $this->clearData($val);
            }
        }
    }

    private function parseUrlParams(){
        $url_parse_array = parse_url($_SERVER['REQUEST_URI']);

        if ($url_parse_array['path']){
            $uri_params = preg_split("/\//", $url_parse_array['path'], -1, PREG_SPLIT_NO_EMPTY);

            if ($uri_params){
                foreach($uri_params as $key=>$val){
                    if (!in_array($key, array(0,1))){
                        $this->get['url_params'][] = $this->clearData($val);
                    }
                }
            }
        }
    }

    private function clearData($data){
        if ($data){
            // Если нужно удалить все тэги
            $data=strip_tags($data);

            $data = htmlspecialchars(trim($data), ENT_QUOTES);

            // если рез-тат будет использоватся в sql запросе
            //$data = mysql_real_escape_string($data);

            $data = str_replace("\\n", "\n", $data);
            $data = str_replace("\\r","\r", $data);


            return $data;
        }
    }
}