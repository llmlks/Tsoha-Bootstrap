<?php

class User extends BaseModel {
    
    public $username, $password, $id;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    

}