<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class CoreModel{
    public $db;
    const DBNAME='spl';
    const DRIVER='mysql';
    const HOSTNAME='localhost';
    const USERNAME='root';
    const PASSWORD='';
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
}