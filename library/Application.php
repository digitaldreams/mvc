<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application {

    public $controllerName;
    public $controllerMethod;
    private $controllerArgument = array();
    private $path;

    public function __construct() {
        $this->init();
        $this->setQuery();
    }

    public function index() {
        
    }

    public function init() {
        $hostName = $_SERVER['SERVER_NAME'];
        $pathName = $_SERVER['REQUEST_URI'];
        $fullPath = $hostName . $pathName;
        $this->path = $_SERVER['PATH_INFO'];
        $pathArr = explode('/', trim($this->path, "/"));
        if (isset($pathArr[0])) {
            $this->controllerName = $pathArr[0];
        }
        if (isset($pathArr[1])) {
            $this->controllerMethod = $pathArr[1];
        }
    }

    private function setQuery() {
        $queryString = $_SERVER['QUERY_STRING'];
        $queryString = trim($queryString, "=,&");
        if (!empty($queryString) && strpos($queryString, "=")) {
            if (strpos($queryString, "&") != FALSE) {
                $argumentsArr = explode("&", $queryString);
                foreach ($argumentsArr as $key => $value) {
                    $arguments = explode("=", $value);
                    if (count($arguments) == 2)
                        $this->controllerArgument[$arguments[0]] = $arguments[1];
                }
            } else {
                $arguments = explode("=", $queryString);
                if (count($arguments) == 2)
                    $this->controllerArgument[$arguments[0]] = $arguments[1];
            }
        }
    }

    public function getQuery() {
        return $this->controllerArgument;
    }

    public static function autoload($className) {
        $lib = "./library/" . $className . ".php";
        $con = "./controller/" . $className . ".php";
        $mod = "./model/" . $className . ".php";
        if (file_exists($lib)) {
            require_once $lib;
            return TRUE;
        } elseif (file_exists($con)) {
            require_once $con;
            return TRUE;
        } elseif (file_exists($mod)) {
            require_once $mod;
            return TRUE;
        } else {
            throw new Exception('Clsas Not found');
        }
    }

    public function run() {
        try{
        $class = $this->controllerName;
        $method = $this->controllerMethod;
          $controller = new $class;
        if(method_exists($controller,$method)){
          $controller->$method();   
        }else{
            throw new Exception('Method Does Not Exist');
        }
      
        
       
        }  catch (Exception $e){
            echo $e->getMessage();
        }
    }

}
