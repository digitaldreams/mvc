<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class System extends CoreModel {

    public $tables = array();
    protected $metaData = array();
    private $primaryKey = '';
    private $currentTable = 'book';

    public function __construct() {
        parent::__construct();
        $this->Tables();
    }

    public function tableName() {
        return 'system';
    }

    public function Tables() {
        $queryObj = $this->db->query('show tables');
        while ($data = $queryObj->fetch(PDO::FETCH_ASSOC)) {
            $value = array_values($data);
            $this->tables[] = $value[0];
        }
        return $this->tables;
    }

    public function tableMetaData($tableName) {
        if (!in_array($tableName, $this->tables)) {
            return FALSE;
        }
        $this->currentTable = $tableName;
        $describe = $this->db->query('describe `' . $tableName . '`');
        while ($data = $describe->fetch(PDO::FETCH_ASSOC)) {
            if ($data['Key'] == 'PRI') {
                $this->primaryKey = $data['Field'];
            }
            $type = $data['Type'];
            if (strpos($type, "(")) {
                $type = substr($type, 0, strpos($type, "("));
            }


            $this->metaData[$data['Field']] = array(
                'type' => $type
            );
        }
        return $this->metaData;
    }

    public function saveFile() {
        $tableName = ucfirst($this->currentTable);
        if ($number = strpos($tableName, "_")) {
            $tableName[$number + 1] = strtoupper($tableName[$number + 1]);
            $tableName = str_replace("_", "", $tableName);
        }
        //chdir("model/");

        $file = new SplFileObject("./model/" . $tableName . ".php", 'w+');
        $string = '<?php ' . "\n"
                . 'class ' . $tableName . ' extends CoreModel{' . "\n"
                . "   public static \$tableName='" . $this->currentTable . "';" . "\n"
                . "   public static \$pk='" . $this->primaryKey . "';" . "\n"
                . "   public function rules() {                               \n
                        return " . var_export($this->metaData, TRUE) . ";
                     }

                     public function tableName(){ \n
                        return '" . $this->currentTable . "';
                      }"
                . '}';
        $file->fwrite($string);
    }

}
