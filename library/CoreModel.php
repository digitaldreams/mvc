<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class CoreModel implements Model {

    use Helper;
    
    protected $db;
    protected $sql;
    protected $placeHolderArray=array();
    public static $tableName;
    public static $pk;

    const DBNAME = 'spl';
    const DRIVER = 'mysql';
    const HOSTNAME = 'localhost';
    const USERNAME = 'root';
    const PASSWORD = '';

    protected $errors = array();
    public $properties = array();

    public function __construct() {
        $this->db = new PDO(self::DRIVER .":dbname=" .self::DBNAME . ";host=" . self::HOSTNAME, self::USERNAME, self::PASSWORD);
    }

    /**
     * 
     */
    abstract public function tableName();

    /**
     * 
     */
    public function findAll() {
        
    }

    /**
     * 
     * @param type $pk
     */
    protected function processQuery($statement){
        
    }
    protected function statement(){
        
    }
    
    /**
     * 
     * @param array $array
     */
    protected function where(array $array){
        
    }
    /**
     * 
     * @param type $pk
     * @return type
     */
    public function findByPk($pk) {
        $retObj='';
       $this->sql="SELECT * FROM `".static::$tableName."` WHERE `".static::$pk."`=:pk";
        $exec=  $this->db->prepare($this->sql);
        $exec->bindParam(":pk",$pk,PDO::PARAM_INT);
        $exec->execute();
        $retObj=$exec->fetch(PDO::FETCH_OBJ);
       return $retObj;
    }

    /**
     * 
     */
    public function findByAttributes(array $array) {
        
    }

    /**
     * 
     */
    public function updateByPk($pk, $data) {
        
    }

    /**
     * 
     */
    public function deleteByPk($pk) {
        
    }

    /**
     * 
     */
    public function deleteAll($cond) {
        
    }

    /**
     * 
     */
    public function save() {
        $this->insert($this->properties);
        if(!empty($this->errors)){
            return FALSE;
        }
    $exec=  $this->db->prepare($this->sql);
    $exec->execute($this->placeHolderArray);
    
        }

    public function errorMessage() {
        return [
            'string' => 'Sorry value is not srting ',
            'email' => 'Please give a valid email address',
            'int' => 'Integer Number required ',
            'bool' => 'Boolean value required',
        ];
    }

    public function saveFromArray() {
        property_exists($this, $property);
    }

    public function __call($name, $arguments) {
        
    }

    public function __get($name) {
        
    }

    protected function insert($array) {
        $sql = "INSERT INTO `" . static::$tableName . "` ";
        $sqlkeys = '(';
        $sqlValues = 'VALUES(';
        foreach ($array as $key => $value) {
            $sqlkeys.="`" . $key . "`,";
            $sqlValues.=":" . $key . ",";
            $type = $this->rules()[$key]['type'];
            $this->placeHolderArray[":$key"]=$value;

            if ($this->validate($value, $type) == FALSE) {
                $this->errors[$key] = $this->errorMessage()[$type];
            }
        }
        $sqlkeys = trim($sqlkeys, ",");
        $sqlValues = trim($sqlValues, ",");
        $sqlkeys.=") ";
        $sqlValues.=") ";
        $sql.=$sqlkeys;
        $sql.=$sqlValues;
        $this->sql=$sql;
    }

    public function __set($name, $value) {
        if (ctype_alnum($name) && (ctype_digit($name[0]) == FALSE)) {
            $this->$name = $this->db->quote($value);
            $this->properties[$name] = $value;
        }
    }

    /**
     * rules take a nested array for each validation work
     * first eleement of course a property name 
     * second element is type of validation
     * third element is an set of option that pass to validation method
     */
    public function rules() {
        return array();
    }

    public function getErrors() {
        return $this->errors;
    }

}
