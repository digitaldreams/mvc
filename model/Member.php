<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Member extends CoreModel{
    public function rules(array $rules) {
        $rules=array();
        return parent::rules($rules);
    }

    public function tableName(){
        return 'member';
    }
    public function primaryKey(){
        return 'member_id';
    }
}