<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class CoreModel implements Model {

    use Helper;

    /**
     * Table name of database.
     */
    public static $tableName;

    /**
     * Primary key of define table.
     * @var primary key 
     */
    public static $pk;

    /**
     * will return how many row affected for this query;
     *
     * @var int
     */
    public $count;

    /**
     * this will hold the property name and its value as an associative array for insert value to table.
     * @var type 
     */
    public $properties = array();

    /**
     * Hold database connection and will be used various places to communicate with DB.
     * @var PDO OBJECT
     */
    protected $db;

    /**
     * Hold the sql query string. This will be build inside various method.
     * @var SQL query 
     */
    protected $sql = '';

    /**
     * What type of query it is like SELECT,DELETE,UPDATE,ALTER
     * @var type 
     */
    protected $type = '';

    /**
     * hold the placeholders of prepare statement.
     * This prevent most of SQL INJECTION.Because it seperate value from the original sql query.
     * @var array 
     */
    protected $placeHolder = array();

    /**
     * If any validation or other type of error occur then this will hold that errors and display via  getErrors() method.
     * @var type 
     */
    protected $errors = array();

    const TYPE_SELECT = 'select';
    const TYPE_DELETE = 'delete';
    const TYPE_UPDATE = 'update';
    const TYPE_ALTER = 'alter';

    public function __construct() {
        try {
            $dbInfo = Config::options(); //database information define in config options method.
            $this->db = new PDO(
                    $dbInfo['dbDriver'] . ":dbname=" . $dbInfo['dbName']
                    . ";host=" . $dbInfo['dbHost'], $dbInfo['dbUser'], $dbInfo['dbpass']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * All child calss have must define this
     */
    abstract public function tableName();

    /**
     * Return all the records of database table.
     */
    public function findAll() {
        $this->select();
        return $this->execute();
    }

    /**
     * Return an PDO instance so that any method of PDO can be access directly by this method.
     * @return DB connection
     */
    public static function db() {
        return static::model()->db;
    }

    public function status() {
        echo $this->sql;
        print_r($this->placeHolder);
    }

    /**
     * Define the select string without SELECT ... FROM table name.
     * if empty then it will select everyting which is SELECT * FROM table Name.
     * @param string $selectString
     */
    public function select($selectString = '') {
        $select = '';
        $this->type = self::TYPE_SELECT;
        if (empty($selectString)) {
            $select = "SELECT * FROM `" . static::$tableName . "` ";
        } else {
            $select = "SELECT " . $selectString . " FROM `" . static::$tableName . "` ";
        }
        $this->sql = $select;
    }

    public function join() {
        
    }

    /**
     * 
     * @param type $pk
     */
    protected function processQuery($statement) {
        
    }

    protected function statement() {
        
    }

    /**
     * Build the where condition and append that where string to sql property.Also it build placehoder array so that execute() method can use it and run safe query
     * 
     * @param array $array
     */
    public function where(array $array = array(), $operator = 'and') {
        $where = '';
        $counter = 0;
        foreach ($array as $key => $value) {
            $this->placeHolder[":$key"] = $value;
            if ($counter > 0) {
                $where.=" $operator `$key`=:$key";
            } else {
                $where.="`$key`=:$key";
            }
            $counter++;
        }
        // $where = trim($where, $operator);
        $this->sql.=" WHERE " . $where;
    }

    /**
     * Any method of this class can be access with this static method.
     * Like ClassName::model()->findAll().
     * Here do not need to create an object of that class.
     * @return \class
     */
    public static function model() {
        //here __CLASS__ or self does not work because these will return coreModel class name but this is an abstract class so php will generate an error.
        //get_called_class() will return the class name where model is called.It may be the child.
        $class = get_called_class();
        return new $class;
    }

    /**
     * Is a vital part.It execute the query which is build by prepare method.
     * @return string
     */
    public function execute() {
        $exec = $this->db->prepare($this->sql);
        $exec->execute($this->placeHolder);
        $this->placeHolder = array(); //make placeHolder array empty SO that placeholder property is ready for another action.
        $return = '';
        $this->count = $exec->rowCount();
        switch ($this->type) {
            case self::TYPE_SELECT:
                $return = $exec->fetchAll(PDO::FETCH_OBJ);
                break;
            case self::TYPE_DELETE:
                $return = $this->count;
                break;
            case self::TYPE_UPDATE:
                break;
            case self::TYPE_ALTER:
                break;
            default :
                $return = '';
                break;
        }
        return $return;
    }

    /**
     * 
     * @param type $pk
     * @return type
     */
    public function findByPk($pk) {
        $retObj = '';
        $this->select();
        $this->where(array(static::$pk => $pk));
        $retObj = $this->execute();
        if ($this->count == 1) {
            return $retObj[0]; //return only object not an index of return array.
        }
        return $retObj;
    }

    /**
     * Find data from table by an associative array.Where key name will be field name.
     */
    public function findByAttributes(array $array) {
        $this->select();
        $this->where($array);
        return $this->execute();
    }

    /**
     * Core method for any kind of update like updateByPk(),updateByAttributes();
     * There are two kind of update data.One is by assigning value to the object like we do in save
     * Another is by giving an associative array where key will be the field name.
     * @param array $array
     * @param type $data
     * @return type
     */
    public function update(array $array, $data = array()) {
        $this->sql = 'UPDATE `' . static::$tableName . '` SET ';
        $properties = (!empty($data) && count($data) > 0) ? $data : $this->properties;
        foreach ($properties as $key => $value) {
            $this->sql.="`$key`=" . $this->db->quote($value); //PDO quote is wrap the value within signle quotes 'value'
        }
        $this->sql = trim($this->sql, ",");
        $this->where($array);
        return $this->execute();
    }

    /**
     * 
     */
    public function updateByPk($pk, $data = array()) {
        $response = $this->update(array(static::$pk => $pk), $data);
        return $response;
    }

    public function updateByAttributes(array $condition, $data = array()) {
        $response = $this->update($condition, $data);
        return $response;
    }

    /**
     * 
     */
    private function delete(array $array) {
        $this->sql = "DELETE FROM `" . static::$tableName . "`";
        $this->where($array);
        $retObj = $this->execute();
        return $retObj;
    }

    public function deleteByPk($pk) {
        return $this->delete(array(static::$pk => $pk));
    }

    /**
     * 
     */
    public function deleteAll($cond) {
        return $this->delete($cond);
    }

    /**
     * 
     */

    /**
     * 
     */
    public function save() {
        $this->insert($this->properties);
        if (!empty($this->errors)) {
            return FALSE;
        }
        $exec = $this->db->prepare($this->sql);
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

    /**
     * 
     */
    public function saveFromArray() {
        property_exists($this, $property);
    }

    public function __call($name, $arguments) {
        echo $name;
    }

    /**
     * 
     * @param type $name
     */
    public function __get($name) {
        
    }

    /**
     * This will be used to save() method.It takes and associative array.Where key will be the field name and value its value.
     * It check the all validation rules and if all of them are success then create necessary sql and placeholder
     * @param type $array
     */
    protected function insert($array) {
        $sql = "INSERT INTO `" . static::$tableName . "` ";
        $sqlkeys = '(';
        $sqlValues = 'VALUES(';
        foreach ($array as $key => $value) {
            $sqlkeys.="`" . $key . "`,";
            $sqlValues.=":" . $key . ",";
            $type = $this->rules()[$key]['type'];
            $this->placeHolderArray[":$key"] = $value;

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
        $this->sql = $sql;
    }

    /**
     * 
     *  Check if property name is valid php label.
     * @param type $name
     * @param type $value
     */
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

    /**
     * 
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

}
