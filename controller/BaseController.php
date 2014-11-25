<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BaseController extends CoreController {

    use Helper;

    public $viewFolder = "base";

    public function __construct() {
        if (empty($this->viewFolder)) {
            $this->viewFolder = __CLASS__;
        }
    }

    public function index() {
        $this->template = 'default';
        $this->render('index', array(
            'hello' => 'Hello World'
        ));
    }

    public function test() {
        $this->template = 'default';
        $member = new Member();
        /*
          $member->fullName="Najmul Islam";
          $member->email="najmulislam@gmail.com";
          $member->mobile=1717219548;
          $member->country="BD";
          $member->age=24;
          $member->profession="Student";
          $member->save();
          $this->printObj($member->getErrors());
         * 
         */
        // $this->printObj($member->findByPk(3));
        echo Application::param()->multiply(3, 9);
        $this->render('hello', array(
            'hello' => 'Hello World'
        ));
    }

    public function file() {
        $this->pagetitle = 'Testing File Management';
        $this->template = 'default';
        $ahelp = new ArrayHelper();
        // $filePath='batchSave.csv';
        $filePath = Config::options()['rootUrl'] . "/assets/batchSave.csv";
        $file = new FileManager($filePath, 'r');
        $data = $file->getData();
        $retData = $ahelp->filterByRegex($data, '/^([a-c].*)/', 'match', TRUE);

        $this->printObj($retData);


        $this->render('file', array('file' => $file));
    }

}
