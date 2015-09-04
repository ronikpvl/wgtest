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

    function __construct(){
        $this->initGetData();
        $this->initPostData();

        //echo "<pre>";
        //print_r($this);
    }

    private function initGetData(){
        $this->parseUrlParams();

        if ($_GET){
            foreach($_GET as $key=>$val){
                $this->get[$key] = $val;
            }
        }
    }

    private function initPostData(){
        if ($_POST){
            foreach($_POST as $key=>$val){
                $this->post[$key] = $val;
            }
        }
    }

    private function parseUrlParams(){


        $uri_params = preg_split("/\//", $_SERVER['REQUEST_URI'], -1, PREG_SPLIT_NO_EMPTY);

        print_r($uri_params);
    }
}