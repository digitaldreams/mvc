<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CoreController{
    public function render($viewName,$data){
        extract($data,EXTR_PREFIX_SAME,'data');
        require_once './view/'.$viewName.'.php';
    }
   
}