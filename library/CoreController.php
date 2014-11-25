<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class CoreController implements Controller {

    public $viewFolder = '';
    public $pagetitle = '';
    public $template = '';

    public function render($viewName, $data) {
        $layoutHeader = "template/" . $this->template . "/header.php";
        $layoutFooter = "template/" . $this->template . "/footer.php";
        if (file_exists($layoutHeader)) {
            require_once $layoutHeader;
        }
        extract($data, EXTR_PREFIX_SAME, 'data');
        require_once '/view/' . $this->viewFolder . "/" . $viewName . '.php';
        if (file_exists($layoutFooter)) {
            require_once $layoutFooter;
        }
    }

}
