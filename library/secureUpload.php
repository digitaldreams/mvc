<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class secureUpload {

    private $upload;
    public $error;
    public $customError=array();
    public $extensions = array();
    private $mimeType = array('image/jpeg');
    private $path;
    private $maxSize = 10248576; //equal to one 1MB;

    public function __construct($file, $path = __DIR__) {
        $this->setInfo($file);
        $this->path = $path;
        if (isset($this->upload->tmp_name) && !is_uploaded_file($this->upload->tmp_name)) {
            $this->error = 'Sorry upload could not be possible.';
        }
    }

    private function setInfo($file) {
        if (is_array($file) && count($file)> 4) {
            $this->upload = (object) $file;
            $file=new finfo(FILEINFO_MIME_TYPE);
            $this->upload->mimetype=$file->file($this->upload->tmp_name);
        }  else {
            $this->customError[]='Unknown upload file ';    
            exit();
        }
    }

    public function save() {
        $this->checkServerSettings();
        if (is_object($this->upload) && $this->upload->error == 0 && in_array($this->upload->mimetype,$this->mimeType) && empty($this->customError)){
            $fileNewName=  $this->renameFile($this->upload->name);
            move_uploaded_file($this->upload->tmp_name, $this->path . "/" .$fileNewName);
            chmod($this->path."/".$fileNewName,0744);
        } else {
            return $this->customError;
        }
    }

    private function checkServerSettings() {
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->upload->size || $uploadSize < $this->upload->size) {
            $size = max(1, $this->maxSize / 1024 / 1024) . 'M';
            $this->customError[]="increase post_max_size and upload_max_filesize to $size'";
        }
        
        
    }

    private function toBytes($str) {
        $val = trim($str);
        $last = strtolower($str[strlen($str) - 1]);
        switch ($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }
    public static function downloadFile($file) { // $file = include path 
        if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }

    }
    private function renameFile($file){
       $ext=  explode('.',$file);
       if(count($ext)>2){
           $this->customError[]='multiple dot is not allowed';
       };
       $ext=  array_pop($ext);
    return $name="uploaderName_id_".time().".".$ext;
    }
    
    public static function getRemoteMimeType($url) {
        
    $buffer = file_get_contents($url);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimetype=$finfo->buffer($buffer);
    if(!$mimetype){
      return FALSE;
    }
      $path=  pathinfo($url);
    $fileNewName="OnlineFile_".time().".".$path['extension'];
       $fp=fopen($fileNewName,'w+'); //a file does not exist
       fwrite($fp,$buffer);//give file handler anes not exist
       fclose($fp);
    
}

}
