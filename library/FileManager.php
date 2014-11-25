<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FileManager {
   // use ArrayHelper;
    public $fileName = '';
    public $fileType = '';
    public $path = '';
    public $file = '';
    private $data = array();
    private $headline = array();
    
    private $mimeType='';

    public function __construct($path,$flags) {
        $this->file = new SplFileObject($path, $flags);
        
        $this->file->setFlags(SplFileObject::READ_CSV);
        if($this->file->getExtension()=="csv"){
          $this->readFile();  
        }
     //   
    }
    /**
     *
     * 
     */
    public function createField() {
        
    }
    /**
     * 
     */
    public function getField() {
        
    }
    
    public function getData(){
        return $this->data;
    // $filter=  $this->filterByRegex($this->data,"/ban/i");
    // return $filter;
    }

    /**
     * 
     * @param array $options
     */

    private function doFilter(array $options) {
        
    }
    /**
     * 
     */
    private function validate() {
        
    }
    /**
     * 
     * @return type
     */
    private function readFile() {
        $this->headline = $this->file->fgetcsv();
        $this->file->next();//Move cursor Ahead so we do not want to include Headline in to the data.
        while ($this->file->valid()){
            $assocArray = array_combine($this->headline, $this->file->fgetcsv());
            $this->data[] = $assocArray;
            $this->file->next();
        }
        return $this->data;
    }
    public function readExcel(){
       
        $this->file->setFlags(SplFileObject::READ_AHEAD);
        print_r((string)$this->file->fgetss());
    }

}
