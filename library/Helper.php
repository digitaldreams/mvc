<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

trait Helper {

    public function printObj($object) {
        echo '<pre>';
        print_r($object);
        echo '</pre>';
    }

    public function getFormValue($fieldName = '', $type = 'string') {
        $retVal = '';
        $value = Yii::app()->request->getPost($fieldName);
        if (empty($value)) {
            $value = Yii::app()->request->getParam($fieldName);
        }
        if (empty($value)) {
            return $retVal;
        }
    }

    public function sanitize($value, $type, $options = '') {
        switch ($type) {
            case 'string':
                $_retVal = trim($value);
                $retVal = filter_var($value, FILTER_SANITIZE_STRING);
                break;
            
            case 'int':
                $retVal = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                $retVal = (int) $retVal;
                break;
            
            case 'double':
                $retVal = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
                $retVal = (double) $retVal;
                break;
            
            case 'array':
                if (is_array($value) && count($value) > 0)
                    $retVal = $value;
                break;

            case 'email':
                $retVal = filter_var($value, FILTER_SANITIZE_EMAIL);
                break;
            
            case 'url':
                $retVal = filter_var($value, FILTER_SANITIZE_URL);
                break;
            
            case 'quote':
                $retVal = filter_var($value, FILTER_SANITIZE_MAGIC_QUOTES);
                break;
            
            case 'special_chars':
                $retVal = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
                break;

            default:
                $retVal = $value;
                break;
        }
        return $retVal;
    }
    
    public function validate($value, $type, $options = '') {
        $retVal=FALSE;
        switch ($type) {
            case 'string':
                $value = trim($value);
                $retVal =(gettype($value)=='string')?TRUE:FALSE;
                break;

            case 'int':
                $retVal =  filter_var($value,FILTER_VALIDATE_INT);
                break;

            case 'double':
                $retVal = filter_var($value, FILTER_VALIDATE_FLOAT);
                break;

            case 'array':
                if (is_array($value) && count($value) > 0)
                    $retVal = TRUE;
                break;

            case 'email':
                $retVal = filter_var($value, FILTER_VALIDATE_EMAIL);
                break;

            case 'url':
                $retVal = filter_var($value, FILTER_VALIDATE_URL);
                break;
            case 'ip':
                $retVal = filter_var($value, FILTER_VALIDATE_IP);
                break;
            case 'regex':
                $retVal = filter_var($value, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $options)));
                break;

            case 'bool':
                $retVal = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                break;

            default:
                $retVal =FALSE;
                break;
        }
        return $retVal;
    }
    

}
