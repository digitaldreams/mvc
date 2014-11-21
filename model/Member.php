<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Member extends CoreModel{
    public static $tableName='member';
    public function rules() {
        
    }

    public function tableName(){
        return 'member';
    }
    public function primaryKey(){
        return 'member_id';
    }
}