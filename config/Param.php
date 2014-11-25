<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Param {

    public function __construct() {
      
    }

    public static function params() {
        return [
            'adminEmail' => 'digitaldreams40@gmail.com',
            'mobile' => '01925000036'
        ];
    }

    public function __get($name) {
        return $this->params()[$name];
    }

    public function __set($name, $value) {
        if (isset($this->params()[$name])) {
            $this->$name = $value;
        }
    }
    
    public function __toString() {
       return '';
    }
    public function hello(){
        return 'Hello World';
    }
    public function multiply($num1,$num2){
        return $num1*$num2;
    }

}
