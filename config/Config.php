<?php


class Config{
    public static function options(){
        return [
          'appsName'=>'Standard PHP Library',
          'rootUrl'=>'http://localhost/mvc',
          'defaultController'=>'BaseController',
          'errorController'=>'errorController',
          'dbName'=>'spl',
          'dbUser'=>'root',
          'dbpass'=>'',
          'dbDriver'=>'mysql',
          'dbHost'=>'localhost',
          'dbOptions'=>'',
          
        ];
    }
    
   
    /**
     * Make controller alias name which will be used in url for readablility.Alias as index and controller name as value
     * @return type 
     */
    public static function Alias(){
        return [
            'root'=>'BaseController',
            'system'=>'SystemController',
            'home'=>'BaseController/index',
            'app'=>'Application'
        ];
    }
}