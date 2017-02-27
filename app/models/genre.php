<?php

class Genre extends BaseModel {
    
    public $id, $genrename;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    // Function to find all data objects in table Genre  
    public static function find_all() {
        
        $query = DB::connection()->prepare('SELECT * FROM Genre');
        $query->execute();
        
        $rows = $query->fetchAll();
        $genres = array();
        
        foreach ($rows as $row) {
            $genres[] = new Genre(array('id' => $row['id'], 'genrename' => 
                $row['genrename']));
        }
        
        return $genres;
    }
    
    // Function to store a new data object in table Genre  
    public static function save() {
        
        $query = DB::connection()->prepare('INSERT INTO Genre (genrename) '
                . 'VALUES :genrename RETURNING id');
        $query->execute(array('genrename' => $this->genrename));
        
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
    
    // Function to delete a data object from table Genre  
    public static function delete() {

        $query = DB::connection()->prepare('DELETE FROM Genre WHERE id = :id');

        $query->execute(array('id' => $this->id));
    }
    
    // Function to validate string length of genre's name  
    public static function validate_name($string, $min, $max) {
        parent::validate_string_length($string, 2, 50);
    }
}
