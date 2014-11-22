<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Member extends CoreModel{
    public static $tableName='member';
    public static $pk='member_id';
    public function rules() {
        return [
            'fullName'=>['type'=>'string'],
            'email'=>['type'=>'email'],
            'mobile'=>['type'=>'int'],
            'country'=>['type'=>'string'],
            'age'=>['type'=>'int'],
            'profession'=>['type'=>'string'],
        ];
        
    }

    public function tableName(){
        return 'member';
    }
    
}