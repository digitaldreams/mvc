<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class CoreController implements Controller{
     public static $tableName;
     public $viewFolder='';



     public function render($viewName,$data){
        extract($data,EXTR_PREFIX_SAME,'data');
        require_once '/view/'.  $this->viewFolder."/".$viewName.'.php';
    }
   
   
}