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
        $this->path =(isset($_SERVER['PATH_INFO']))?$_SERVER['PATH_INFO']:"";
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
        $config="./config/".$className .".php";
        if (file_exists($config)) {
            require_once $config;
        }elseif (file_exists($lib)) {
            require_once $lib;
        } elseif (file_exists($con)) {
            require_once $con;
        } elseif (file_exists($mod)) {
            require_once $mod;
        } else {
            throw new Exception('Sorry Unable to load '.$className.".php");
        }
    }

    public function run() {
        try{
        $class = $this->controllerName;
        $method = $this->controllerMethod;
         
        if(class_exists($class)){
           $controller = new $class;  
        }elseif(empty ($class)){
        $class=Config::options()['defaultController'];
        $controller=new $class;
        }else{
        throw new Exception('Class Does Not Exist');    
        }
        if(method_exists($controller,$method)){
          $controller->$method();   
        }elseif(method_exists($controller,'index')){
       $controller->index();        
        }else{
            throw new Exception('Method Does Not Exist');
        }
      
        
       
        }  catch (Exception $e){
            echo $e->getMessage();
        }
    }

}