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

    public function Magic() {
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
        $member = new Member();
        $member->fullName = "friday show";
        $member->email = "matenyshow@gmail.com";
        $member->mobile = 98754252;
        $member->country = "Bangladesh";
        $member->age = 36;
        $member->profession = "Acfor";
        $member->save();
    }

    public function query() {
        $this->template = 'default';

        $member = new Member();
        /**
          $member->select('fullName');
          $member->where(array('email' => 'tutor@gmail.com','age'=>27));

          print_r($member->execute());
         * 
         */
        // $result = $member->findByAttributes(array('email' => 'tutor@gmail.com', 'age' => 27));
        //  print_r($result);
        // echo '<hr>';
        // print_r($member->findByPk(2));
        // $member->status();
        // Member::model()->findByPk(2);
        // echo '<pre>';
        //print_r($member->findAll());
        // $member->deleteByPk(7);
        $member->fullName = "My aweful MVC Framework";
        //  $member->updateByPk(6);
        $member->updateByAttributes(array('email' => 'tutor@gmail.com'));
        //$member->status();
        echo $good;
    }

    public function book() {
        
    }

}
