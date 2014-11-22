<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Param {

    public function __construct($name) {
        if (is_array($name) && count($name) > 0) {
            foreach ($name as $key => $property) {
                if (isset($this->params()[$property])) {
                    $value = $this->params()[$property];
                    $this->$property = $value;
                }
            }
        }
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

}
