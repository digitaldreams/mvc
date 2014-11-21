<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class BaseController extends CoreController{
    use Helper;
    public $viewFolder="base";
    public function __construct() {
        if(empty($this->viewFolder)){
            $this->viewFolder=__CLASS__;   
        }
    }
    
    public function index(){
      $this->render('index',array(
           'hello'=>'Hello World' 
        ));   
    }

    public function test(){
        
        $member=new Member();
        $member->fullName='Tuhin Bepari';
        $member->email="digitaldreams40@gmail.com";
        $member->mobile=01925000036;
        $member->country="Bangladesh";
        $member->age=25;
        $member->profession="Student, job holder";
        $member->save();
        $this->printObj($member);
        
        $this->render('hello',array(
           'hello'=>'Hello World' 
        ));
    }
    
}

