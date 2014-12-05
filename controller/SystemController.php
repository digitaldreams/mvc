<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SystemController extends CoreController {

    public function __construct() {
        $this->viewFolder = 'system';
        $this->template = 'default';
    }

    public function index(){
 //       echo '<pre>';
        $system=new System();
        $system->tableMetaData('book');
      $system->saveFile();
        
      //  print_r($system->tableMetaData('member'));
        $this->render('index', array(
        ));
    }

    public function model() {
        
    }

}
