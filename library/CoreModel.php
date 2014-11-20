<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class CoreModel implements Model{
    public $db;
    const DBNAME='spl';
    const DRIVER='mysql';
    const HOSTNAME='localhost';
    const USERNAME='root';
    const PASSWORD='';
    protected $errors=array();
    private $properties=array();
    public function __construct() {
        $this->db=new PDO(self::DRIVER.":dbname=".self::DBNAME.";host=".self::HOSTNAME,self::USERNAME,self::PASSWORD); 
    }
    /**
     * 
     */
    abstract public function tableName();
    /**
     * 
     */
    abstract public function primaryKey();
    /**
     * 
     */
    public function findAll(){
        
    }
    /**
     * 
     * @param type $pk
     */
    public function findByPk($pk){
        
    }
    /**
     * 
     */
    public function findByAttributes(array $array){
        
    } 
    /**
     * 
     */
    public function updateByPk($pk,$data){
        
    }
     /**
     * 
     */
    public function deleteByPk($pk){
        
    }
     /**
     * 
     */
    public function deleteAll($cond){
        
    }
    /**
     * 
     */
    public function save(){
        $this->properties=get_object_vars($this);
        
    }
    
    public function saveFromArray(){
        property_exists($this,$property);
    }
    public function __call($name, $arguments) {
        
    }
    public function __get($name) {
        
    }
    public function __set($name,$value) {
        if(ctype_alnum($name)&& (ctype_digit($name[0])==FALSE)){
            $this->$name=$this->db->quote($value);
        }
    }
    /**
     * rules take a nested array for each validation work
     * first eleement of course a property name 
     * second element is type of validation
     * third element is an set of option that pass to validation method
    */
    public function rules(array $rules){
        return array();
    }
    public function validate(){
        //validation should not apply
       if(empty($this->properties) && cout($this->properties)){
           return TRUE; 
       } 
       
    }
    public function getErrors(){
        return $this->errors;
    }
    
}