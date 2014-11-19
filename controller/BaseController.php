<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class BaseController extends CoreController{
    public function __construct() {
        
    }

    public function test(){
        $member=new Member();
        $this->render('hello',array(
           'hello'=>'Hello World' 
        ));
    }
    
}

