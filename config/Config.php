<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Config{
    public static function options(){
        return [
          'appsName'=>'Standard PHP Library',
          'rootUrl'=>'http://localhost/mvc',
          'defaultController'=>'BaseController',
          'errorController'=>'errorController',
          'dbName'=>'',
          'dbUser'=>'',
          'dbpass'=>'',
          'dbHost'=>'',
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
            'home'=>'BaseController/index',
            'app'=>'Application'
        ];
    }
}