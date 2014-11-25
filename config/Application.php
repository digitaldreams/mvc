<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'config/config.php';

class Application {

    public static $controllerName;
    public static $controllerMethod;
    private $path;
    

    public function __construct() {
        $this->init();
    }

    public function index() {
        
    }
    
    public static function __callStatic($name,$arguments) {
         $class=new $name();
         return $class;
         
    }

    
    public function init() {
        $hostName = $_SERVER['SERVER_NAME'];
        $pathName = $_SERVER['REQUEST_URI'];
        $fullPath = $hostName . $pathName;
        $this->path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : "";
        $pathArr = explode('/', trim($this->path, "/"));
        if (isset($pathArr[0])) {
            static::$controllerName = $pathArr[0];
        }
        if (isset($pathArr[1])) {
            static::$controllerMethod = $pathArr[1];
        }
    }

    private static function getAlias($name) {
        $alias = Config::Alias();
        $className = '';
        if (isset($alias[$name]) && !empty($alias[$name])) {
            $className = $alias[$name];
        }
        static::$controllerName = $className;
        return $className;
    }
   
    public static function autoload($className) {
     
        $alias = Config::Alias();
        if (isset($alias[$className]) && !empty($alias[$className])) {
            $className = $alias[$className];
        }
        $lib = "./library/" . $className . ".php";
        $con = "./controller/" . $className . ".php";
        $mod = "./model/" . $className . ".php";
        $config = "./config/" . $className . ".php";
        if (file_exists($config)) {
            require_once $config;
        } elseif (file_exists($lib)) {
            require_once $lib;
        } elseif (file_exists($con)) {
            require_once $con;
        } elseif (file_exists($mod)) {
            require_once $mod;
        } else {
            throw new Exception('Sorry Unable to load ' . $className . ".php");
        }
    }

    public function run() {
        try {
            static::getAlias(static::$controllerName);
            $class = static::$controllerName;
            $method = static::$controllerMethod;

            if (class_exists($class)) {
                $controller = new $class;
            } elseif (empty($class)) {
                $class = Config::options()['defaultController'];
                $controller = new $class;
            } else {
                throw new Exception('Class Does Not Exist');
            }
            if (method_exists($controller, $method)) {
                $controller->$method();
            } elseif (method_exists($controller, 'index')) {
                $controller->index();
            } else {
                throw new Exception('Method Does Not Exist');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}
