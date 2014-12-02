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
      
        $this->render('hello', array(
            'hello' => 'Hello World'
        ));
    }
    
    public function Magic(){
       echo Application::param()->multiply(3, 9);  
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
        $queue = $ahelp->priority($retData, "/(gmail|.com)/");
        //$this->printObj($queue);


        $this->render('file', array('file' => $file));
    }

    public function save() {
        $member=new Member();
        $member->fullName = "MVC tutorial";
        $member->email = "tutor@gmail.com";
        $member->mobile = 1925000036;
        $member->country = "Bangladesh";
        $member->age = 27;
        $member->profession = "Teacher";
        $member->save();
    }

}
