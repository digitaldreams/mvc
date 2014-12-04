<?php

class AjaxController{

    public $request = null;
    public $response = null;
    public $community = null;

    //public $user = null;

    public function __construct() {
        $this->response = new AjaxResponse();
        $this->setRequest();
    }

    public function isUserLoggedIn() {
        
    }

    public function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function setRequest() {
        $this->request = new AjaxRequest;
        $this->request->ip = AppHelper::getUserIp();
        $this->request->url = '';
        $this->request->time = new DateTime();
        $this->request->type = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
        if ($this->request->type == 'GET') {
            $this->request->data = $_GET;
        } elseif ($this->request->type == 'POST') {
            $this->request->data = $_POST;
        }
    }

    public function setCode($code = 200) {
        $this->response->code = $code;
    }

    public function setData($data, $success = true) {
        $this->response->data = $data;
        $this->response->success = $success;
        if ($success) {
            $this->response->code = 200;
        }
    }

    public function setMessage($msg = '', $code = 200) {
        $this->response->message = $msg;
        $this->response->code = $code;
    }

    public function renderJson() {
        echo json_encode($this->response);
        exit();
    }

    public function raiseException(Exception $ex) {
        $this->setData($ex, FALSE);
        $this->setMessage($ex->getMessage());
    }

}

class AjaxRequest {

    public $ip = null;
    public $url = null;
    public $time = null;
    public $type = null;
    public $data = null;

}

class AjaxResponse {

    public $request = null;
    public $success = false;
    public $code = 200;
    public $message = '';
    public $data = null;
    public $redirect_url = '';

}
